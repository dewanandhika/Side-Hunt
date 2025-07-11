<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\chat;
use App\Models\Pekerjaan;
use App\Models\Pelamar;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function update_lamaran($idLamaran, $sender, $receiver)
    {
        $Lamaran = Pelamar::where('id', $idLamaran)->first();
        $job = Pekerjaan::where('id', $Lamaran->job_id)->first();
        $chat = new chat();
        $chat->sender = $sender;
        $chat->receiver = $receiver;
        $chat->pekerjaan_id = $job->id;
        $chat->Lamaran_status = $Lamaran->status;
        return $chat->save();
    }





    public function Lamaran($idPekerjaan)
    {
        $find_lamaran = Pelamar::where('job_id', $idPekerjaan)
            ->where('user_id', session('account')['id'])->first();
        $id_Target = Pekerjaan::where('id', $find_lamaran->job_id);
        if (!in_array($find_lamaran->status, ['Gagal', 'selesai', 'ditolak'])) {
            return redirect('/Chat/' . $id_Target->pembuat);
        } else {
            return redirect('/Chat/' . $id_Target->pembuat)->with('fail', ['Chat Terkait Pekerjaan ini tidak ada!', 'Pekerjaan sudah selesai atau lamaran anda gagal!']);
        }
    }

    public function index($id_target)
    {
        $session_account_id = session('account')['id'];
        $user = Users::where('id', $id_target)->first();
        $subQuery = DB::table('chats')
            ->select('sender as user_id')
            ->where(function ($q) use ($session_account_id) {
                $q->where('receiver', $session_account_id)
                    ->orWhere('sender', $session_account_id);
            })
            ->union(
                DB::table('chats')
                    ->select('receiver as user_id')
                    ->where(function ($q) use ($session_account_id) {
                        $q->where('receiver', $session_account_id)
                            ->orWhere('sender', $session_account_id);
                    })
            );
        $results =  DB::table(DB::raw('(SELECT *, 
                ROW_NUMBER() OVER (PARTITION BY counterpart_id ORDER BY created_at DESC) AS rn
                FROM (
                    SELECT 
                        CASE 
                            WHEN sender = 4 THEN receiver
                            ELSE sender
                        END AS counterpart_id,
                        chats.*
                    FROM chats
                    WHERE sender = ' . $session_account_id . ' OR receiver = ' . $session_account_id . '
                ) AS combined_chats
            ) AS ranked_chats'))
            ->leftJoin('users', 'ranked_chats.counterpart_id', '=', 'users.id')
            ->where('rn', 1)
            ->select(
                'ranked_chats.*',
                'users.id AS id_from_user',
                'users.nama AS nama_user',
                'users.avatar_url AS avatar_url',
            )
            ->get();
            

            
            // dd($results);

        // Query utama: join subquery ke users
        $to_text = DB::query()
                    ->fromSub($subQuery, 'a')
                    ->join('users as b', 'a.user_id', '=', 'b.id')
                    ->select('a.*', 'b.*')
                    ->get();
                // dd($to_text);
                // dd(session('account')['id']);

                $all_chats = DB::table('chats as c')
                    ->selectRaw('
                c.id AS id_chat,
                c.*,
                a.*,
                d.contents AS content_references,
                c.created_at AS sent
            ')
            ->leftJoin('pekerjaans as a', 'a.id', '=', 'c.pekerjaan_id')
            ->leftJoin('chats as d', 'd.chat_references', '=', 'c.id')
            ->where(function ($query) use ($session_account_id, $id_target) {
                $query->where(function ($q) use ($session_account_id, $id_target) {
                    $q->where('c.sender', $session_account_id)
                        ->where('c.receiver', $id_target);
                })->orWhere(function ($q) use ($session_account_id, $id_target) {
                    $q->where('c.receiver', $session_account_id)
                        ->where('c.sender', $id_target);
                });
            })
            ->get();
        $target = $id_target;
        $all = $results;
        // dd('id gw: '.session('account')['id'],'id lawan: '.$id_target,$all_chats);
        // dd($all);


        return view('Dewa.need_auth.chat', compact('to_text', 'all_chats', 'target', 'all','user'));
    }

    public function store(Request $request)
    {
        // dd($request);
        // return response()->json([
        //     'success' => true,
        //     'data' => $request->all(),
        // ]);
        // return response()->json([
        //             'success' => 'masuk',
        //         ]);
        // return response()->json($request->file('file_json'));
        $chat = new chat();
        $chat->sender = session('account')['id'];
        $chat->receiver = $request->receiver;
        // return response()->json([
        //     'success' => true,
        //     'data' => [$request->has('contents'),$request->input('contents'),$request->file('file_json')]
        // ]);
        try {
            if (($request->contents != null) || ($request->file('file_json') != null)) {
                $chat->contents = $request->has('contents') ? $request->input('contents') : null;
                $chat->file_json = null;

                if ($request->hasFile('file_json')) {
                    $file = $request->file('file_json');
                    $filename = session('account')['id'] . $file->getClientOriginalName();
                    $filePath = $file->storeAs('chat_file', $filename, 'public');
                    $chat->file_json = 'storage/' . $filePath;
                    $chat->extension = $file->getClientOriginalExtension();
                    $chat->nama_file = $file->getClientOriginalName();
                }

                $chat->chat_references = null;
                $chat->body_chat_references = null;
                if ($request->chat_reference != null) {
                    $chat->chat_references = $request->chat_reference;
                    $chat->body_chat_references = $request->body_chat_references;
                }

                if ($chat->save()) {
                    return response()->json([
                        'success' => true,
                        'data' => $chat
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'data' => "Terjadi kesalahan dalam menyimpan pesan"
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'data' => "Tidak ada pesan yang perlu dikirim"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => $e->getMessage()
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\chat;
use App\Models\Pekerjaan;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function lamaran_diterima($idLamaran)
    {

        $Lamaran = Pelamar::where('id', $idLamaran)->first();
        $job = Pekerjaan::where('id', $Lamaran->job_id)->first();
        $chat = new chat();
        $chat->sender = $job->pembuat;
        $chat->receiver = session('account')['id'];
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
        $subQuery = DB::table('chats')
            ->select('sender as user_id')
            ->where(function ($q) {
                $q->where('receiver', 5)
                    ->orWhere('sender', 5);
            })
            ->union(
                DB::table('chats')
                    ->select('receiver as user_id')
                    ->where(function ($q) {
                        $q->where('receiver', 5)
                            ->orWhere('sender', 5);
                    })
            );

        // Query utama: join subquery ke users
        $to_text = DB::query()
            ->fromSub($subQuery, 'a')
            ->join('users as b', 'a.user_id', '=', 'b.id')
            ->select('a.*', 'b.*')
            ->get();
        // dd($to_text);

        $all_chats = Chat::from('chats as c')
            ->leftJoin('pekerjaans as a', 'a.id', '=', 'c.pekerjaan_id')
            ->leftJoin('chats as d', 'd.chat_references', '=', 'c.id')
            ->select('c.*', 'a.*', 'd.contents as content_references', DB::raw('c.created_at as sent'))
            ->where(function ($query) use ($id_target) {
                $query->where('c.sender', session('account')['id'])
                    ->where('c.receiver', $id_target);
            })
            ->orWhere(function ($query) use ($id_target) {
                $query->where('c.receiver', session('account')['id'])
                    ->where('c.sender', $id_target);
            })
            ->get();
        $target = $id_target;
        // dd($all_chats);


        return view('Dewa.need_auth.chat', compact('to_text', 'all_chats', 'target'));
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
            if(($request->contents!=null)||($request->file('file_json')!=null)){
                $chat->contents = $request->contents==null?null:$request->contents;
                $chat->file_json = $request->file('file_json')==null?null:json_encode($request->file('file_json'));
                $chat->chat_references = $request->chat_references==null?null:$request->chat_references;
                if ($chat->save()) {
                    return response()->json([
                        'success' => true,
                        'data'=>$chat
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'data'=>"terjadi kesalahan dalam menyimpan pesan"
                    ]);
                }
            }
            else{
                return response()->json([
                        'success' => false,
                        'data'=>"tidak ada pesan yang perlu dikirim"
                    ]);
            }
    }
}

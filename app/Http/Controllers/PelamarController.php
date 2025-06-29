<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\Notify_Applications;
use App\Models\Pekerjaan;
use App\Models\Pelamar;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Expr\Cast\Object_;

class PelamarController extends Controller
{
    public function store($idPekerjaan)
    {
        // dd($idPekerjaan);
        $cekJob = Pekerjaan::where('id',$idPekerjaan)->first();
        // dd($cekJob);
        if($cekJob!=null){

            $cek = Pelamar::where('user_id', session('account')['id'])
                ->where('job_id', $idPekerjaan)
                ->first();
            // dd($cek);
            if ($cek == null){
                $data = null;
                $data['user_id'] = session('account')['id'];
                $data['job_id'] = $idPekerjaan;
                $save_attemp_job = Pelamar::create($data);
                // dd($save_attemp_job);
                if ($save_attemp_job) {
                    return response()->json([
                        'success' => true,
                    ]);
                } else {
                    return response()->json([
                        'success' => 'Server sedang bermasalah, mohon tunggu beberapa saat',
                    ]);
                }
            } else {
                return response()->json([
                    'success' => true,
                ]);
            }
        }
        else{
            return response()->json([
                    'success' => 'Pekerjaan ini Tidak Ada atau ada yang salah dengan data anda',
                ]);
        }
    }

    public function tolak(Request $request) {}

    public function Profile_Pelamar($idPelamar)
    {
        // dD()
        $cek = (new PekerjaanController())->is_own_pelamar((Pelamar::findOrFail($idPelamar)['id']));
        if ($cek) {
            $data = Pelamar::join('users', 'pelamars.user_id', '=', 'users.id')
                ->select('users.*')
                ->get();
            $nama_halaman = 'Profil Pelamar';
            $active_navbar = 'Pekerjaan';
            return view('Dewa.pekerjaan.show_profile_pelamar', compact('data', 'nama_halaman', 'active_navbar'));
        } else {
            return redirect()->back()->with('fail', ['Akses Ditolak', 'Ini bukan Halaman yang bisa anda akses']);
        }
    }

    public function interview_pelamar(Request $request)
    {
        $request->validate([
            'tanggal_interview' => 'required|date|max:20',
            'link_interview'    => 'required|string|max:500',
            'pesan_interview'   => 'nullable|string|max:300',
            'id'                => 'required|string|max:10',
        ], [
            // tanggal_interview
            'tanggal_interview.required' => 'Tanggal Interview wajib diisi.',
            'tanggal_interview.date'   => 'Tanggal Interview harus berupa tanggal.',
            'tanggal_interview.max'      => 'Tanggal Interview maksimal 20 karakter.',

            // link_interview
            'link_interview.required' => 'Link Interview wajib diisi.',
            'link_interview.string'   => 'Link Interview harus berupa teks.',
            'link_interview.max'      => 'Link Interview maksimal 500 karakter.',

            // pesan_interview
            'pesan_interview.string' => 'Pesan Interview harus berupa teks.',
            'pesan_interview.max'    => 'Pesan Interview maksimal 300 karakter.',

            // id
            'id.required' => 'ID kosong.',
            'id.max'      => 'ID maksimal 10 karakter.',
        ]);

        $find = Pelamar::findOrFail($request->id);
        // dd($find);
        if ($find) {
            $find->jadwal_interview = $request->tanggal_interview;
            $find->link_Interview = $request->link_interview;
            $find->status = 'interview';
            // dd($find);;
            if ($find->save()) {
                $user = Users::where('id',$find->user_id)->first();
                $Pekerjaan = Pekerjaan::where('id', $find->job_id)->first();
                $email = ($user->email);
                Mail::to($email)->send(new Notify_Applications([$find,$user,$Pekerjaan,session('account')],'interview'));
                return redirect('/daftar-Pelamar/all')->with('success', ['Selamat!', 'Interview Sudah kami kabarkan kepada user']);
            } else {
                return redirect()->back()->with('fail', ['Gagal!', 'Ada yang salah, coba beberapa saat lagi!']);
            }
        }
    }

    public function terima(Request $request){
        $find = Pelamar::findOrFail($request->id);
        if($find){
            $find->jadwal_interview = 'done';
            $find->link_Interview = null;
            $find->status = $request->status;
            if ($find->save()) {
                $user = Users::where('id',$find->user_id)->first();
                $Pekerjaan = Pekerjaan::where('id', $find->job_id)->first();
                $email = ($user->email);
                Mail::to($email)->send(new Notify_Applications([$find,$user,$Pekerjaan,session('account')],'Menunggu Pekerjaan'));
                return redirect('/daftar-Pelamar/all')->with('success', ['Selamat!', 'Interview Sudah kami kabarkan kepada user']);
            } else {
                return redirect()->back()->with('fail', ['Gagal!', 'Ada yang salah, coba beberapa saat lagi!']);
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Ui\Presets\React;


class UsersController extends Controller
{
    

    public function Login_Account(Request $req){
        // dd('.asuk');
        // dd($req);
        $credentials = $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // dd($credentials);

        $user = Users::where('email',$req->email)->first();
        if($user){
            if($user && Hash::check($req->password,$user->password)){
                // if(Auth::attempt($credentials)){
                    session(['account' => $user]);
                    // dd(session('account'));
    
                    // dd('masuk');
                    return redirect('/Index')->with('success','Login Berhasil');
                // }
                // else{
                //     return back()->withErrors([
                //         'message' => '0, Email atau password salah',
                //     ])->withInput();
                // }
            }
            else{
                return back()->withErrors([
                    'message' => '0, Password salah',
                ])->withInput();
            }
        }
        else{
            return back()->withErrors([
                    'message' => '0, Tidak ada akun yang terdaftar dengan email ini',
                ])->withInput();

        }
    }
    public function logout(){
        if(session('account')!=null){
            Auth::logout();        
            session()->invalidate();  
            session()->regenerateToken(); 
            return redirect('/Login')->with('success','Logout Berhasil');
        }
        else{
            $allert = 'Logout Gagal|Anda tidak dalam sesi yang aktif';
            return back()->with('alert',$allert);
        }
        
    }

    public function create(Request $req){
        $credentials = $req->validate([
            'email' => 'required|email',
            'password' => 'required',
            'password-retype' => 'required',
            'nama-depan'=>'required',
            'nama-belakang'=>'required',
        ]);

        $user = Users::where('email',$req->email)->first();

        if($user){
            return back()->withErrors([
                'message' => '0, Email sudah terdaftar',
            ])->withInput();
        }
        else if($req->password!=$req['password-retype']){
            return back()->withErrors([
                'message' => '0, Password belum sama dengan Password Retype',
            ])->withInput();
        }
        else if(!$this->cek_password($req->password)){
            return back()->withErrors([
                'message' => '0, Password belum memenuhi kriteria',
            ])->withInput();
        }
        else{
            $user = new Users();
            $user->email = $req->email;
            $user->password = Hash::make($req->password);
            $user->nama = $req['nama-depan'].' '.$req['nama-belakang'];
            if($user->save()){
                return back()->withErrors([
                'message' => '1, Akun berhasil didaftarkan, silahkan login',
                ])->withInput();
            }
        }
        



    }


    function cek_password($password){
        return strlen($password) >= 8 &&
           preg_match('/[0-9]/', $password) &&
           preg_match('/[A-Z]/', $password) &&
           preg_match('/[a-z]/', $password);
    }

    
}

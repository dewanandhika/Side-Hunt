<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use App\Models\SideJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index(){
        $jobs = Pekerjaan::latest()->paginate(10);
        $peta = Pekerjaan::all();
        $active_navbar = 'Beranda';
        $nama_halaman = 'Beranda';


        // return view('pekerjaan.list', compact('sidejob'));

        return view('index',compact('jobs','peta','active_navbar','nama_halaman'));
    }

    public function Register(){
        if(session('account')==null){
            $active_navbar = 'Register';
            $nama_halaman = 'Register';
            return view('register',compact('active_navbar','nama_halaman'));
        }
        else{
                return redirect('/Index')->with('success', 'Anda Sedang Login|Logout terlebih dahulu');

        }
    }

    public function Login(){
        if(session('account')!=null){
            return redirect('/Index')->with('success', 'Anda Sudah Login|Logout terlebih dahulu');
        }
        else{
            $active_navbar = 'Login';
            $nama_halaman = 'Login';
            return view('Login',compact('active_navbar', 'nama_halaman'));
        }
    }

    
}

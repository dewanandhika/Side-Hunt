<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

class PelamarController extends Controller
{
    public function store($idPekerjaan){
        $data = null;
        $data['user_id'] = session('account')['id'];
        $data['job_id'] = $idPekerjaan;
        $save_attemp_job = Pelamar::create($data);
        // dd($save_attemp_job);
        if($save_attemp_job){
            return response()->json([
                'success'=>true,
            ]);
        }
        else{
            return response()->json([
                'success'=>false,
            ]);
        }
    }
}

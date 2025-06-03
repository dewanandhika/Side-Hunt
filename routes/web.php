<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SideJobController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PekerjaanController;

    Route::middleware(['properlink'])->group(function () {
    });
    
    
    
    Route::get('/',function(){
        return redirect('/Index');
     }) ;

    Route::get('/Logout',[UsersController::class,'logout']);
    
    //Auth
    Route::get('/Login',[HomeController::class,'Login']);
    Route::get('/Register',[HomeController::class,'Register']);
    Route::get('/Index', [HomeController::class, 'index'])->name('home');
    Route::post('/Login_account',[UsersController::class,'Login_Account']);
    Route::post('/Register_account',action: [UsersController::class,'create']);
    

    Route::resource('kerja',PekerjaanController::class);


    //Only Admin
    Route::middleware(['role:user, mitra'])->group(function () {

    });
    

    //Only Mitra
    Route::middleware(['role:mitra'])->group(function () {

    });








// // Route::get('/tes', [App\Http\Controllers\HomeController::class, 'index2'])->name('home');
// // Route::get('/cari', [SideJobController::class, 'cari'])->name('sidejob.cari');
// Route::get('/job/{id}', [SideJobController::class, 'show'])->name('sidejob.detail');
// // Route::resource('/Users',[UsersController::class]);

// //NON AUTH
//     Route::get('/cari', [SideJobController::class, 'cari']);


// Route::middleware(['auth'])->group(function () {
//     Route::get('/user/lamaran', [UsersController::class, 'pelamaran'])->name('user.history');
//     Route::get('/sidejob', [SideJobController::class, 'index'])->name('sidejob.index');
//     Route::get('/sidejob/create', [SideJobController::class, 'create'])->name('sidejob.create');
//     Route::post('/sidejob/create/store', [SideJobController::class, 'store'])->name('sidejob.store');
//     Route::get('/sidejob/{id}', [SideJobController::class, 'show'])->name('sidejob.show');
//     Route::get('/sidejob/{sidejob}/edit', [SideJobController::class, 'edit'])->name('sidejob.edit');
//     Route::put('/sidejob/{sidejob}', [SideJobController::class, 'update'])->name('sidejob.update');
//     Route::delete('/sidejob/{sidejob}', [SideJobController::class, 'destroy'])->name('sidejob.destroy');
//     Route::post('/sidejob/{sidejob}/buatPermintaan', [SideJobController::class, 'buatPermintaan'])->name('sidejob.buatPermintaan');
//     Route::patch('/pelamar/{pelamar}/terima', [SideJobController::class, 'terima'])->name('pelamar.terima');
//     Route::patch('/pelamar/{pelamar}/tolak', [SideJobController::class, 'tolak'])->name('pelamar.tolak');
//     Route::get('/transaksi', [TransaksiController::class, 'index'])->name('user.transaksi');
// });





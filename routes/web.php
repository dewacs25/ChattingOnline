<?php

use App\Events\ChatEvent;
use App\Http\Controllers\PesanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('web');
Route::post('/pesan/send',[PesanController::class,'send'])->middleware('auth');
Route::delete('/destroy/{id}', [PesanController::class,'destroy'])->name('pesan.destroy');

Route::post('send',function(Request $req){
    $req->validate([
        'name'=>'required',
        'message'=>'required',
    ]);

    $message = [
        'name'=>$req->name,
        'message'=>$req->message,
    ];

    ChatEvent::dispatch($message);
});

Route::post('/save-audio', [PesanController::class,'pesanAudio']);
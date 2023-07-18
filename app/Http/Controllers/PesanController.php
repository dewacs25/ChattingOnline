<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
    public function send(Request $req){
        $req->validate([
            'isi_pesan'=>'required'
        ]);

        Pesan::create([
            'user_id'=>Auth::guard('web')->user()->id,
            'isi_pesan'=>$req->isi_pesan
        ]);

        return redirect('/');
    }
}

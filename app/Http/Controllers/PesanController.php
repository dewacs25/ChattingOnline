<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Models\Pesan;
use App\Models\User;
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

        $name = User::where('id',Auth::guard('web')->user()->id)->get()->first();

        $message = [
            'name'=>$name->name,
            'message'=>$req->isi_pesan,
            'waktu'=>date("Y-m-d H:i:s"),
        ];
    
        ChatEvent::dispatch($message);

        return redirect('/');
    }
    
    public function destroy($id)
    {
        $data = Pesan::findOrFail($id);
        $data->delete();

        // $data->isi_pesan = "<delete><delete>";
        // $data->save();

        return redirect('/');
    }

}

<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Models\Pesan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
    public function send(Request $req)
    {
        $req->validate([
            'isi_pesan' => 'required'
        ]);

        Pesan::create([
            'user_id' => Auth::guard('web')->user()->id,
            'isi_pesan' => $req->isi_pesan
        ]);

        $name = User::where('id', Auth::guard('web')->user()->id)->get()->first();

        $message = [
            'name' => $name->name,
            'message' => $req->isi_pesan,
            'waktu' => date("Y-m-d H:i:s"),
            'type' => 'text'
        ];

        ChatEvent::dispatch($message);

        return redirect('/');
    }

    public function destroy($id)
    {
        $data = Pesan::findOrFail($id);

        if ($data->type == 'audio') {
            unlink(storage_path('app/public/' . $data->isi_pesan));
        }

        $data->delete();

        // $data->isi_pesan = "<delete><delete>";
        // $data->save();

        return redirect('/');
    }

    public function pesanAudio(Request $request)
    {
        if ($request->hasFile('audioBlob')) {
            $audioBlob = $request->file('audioBlob');
            $path = $audioBlob->store('audio', 'public');


            $pesan = new Pesan();
            $pesan->user_id = Auth::guard('web')->user()->id;
            $pesan->isi_pesan = $path;
            $pesan->type = 'audio';
            $pesan->save();

            $name = User::where('id', Auth::guard('web')->user()->id)->get()->first();

            $message = [
                'name' => $name->name,
                'message' => $path,
                'waktu' => date("Y-m-d H:i:s"),
                'type' => 'audio'
            ];
            ChatEvent::dispatch($message);

            return response()->json(['message' => 'Audio berhasil disimpan.']);

        }

        return response()->json(['error' => 'Tidak ada file audio yang dikirim.'], 400);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $dataPesan = Pesan::orderBy('created_at','ASC')->get();
        $userid = Auth::guard('web')->user()->id;

        return view('home',['dataPesan'=>$dataPesan,'userid'=>$userid]);
    }
}

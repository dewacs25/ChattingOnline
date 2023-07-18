@extends('layouts.app')
@section('content')
    <div class="d-lg-block d-none" style="position: absolute; left: 0;">
        <p>{{ Auth::guard('web')->user()->name }}</p>
        <form action="/logout" method="POST">
            @csrf
            <button>Logout</button>

            
        </form>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 col-12 border-1 border my-1" style="height: 99vh">
                <div class="content-text d-flex mt-2"
                    style="min-height: 90vh; position: fixed inherit; max-height: 90vh; overflow: auto; flex-direction: column;
                align-items: flex-start;">
                    @foreach ($dataPesan as $row)
                        @if ($row->user_id == $userid)
                            <div class="cardPesan card  bg-transparent" style="max-width: 70%; align-self: flex-end;">
                                <div class="card-header  p-0 bg-transparent border-0 text-light">
                                    <span class="ms-1 ">Anda</span><span class="ms-3"
                                        style="font-size: 11px">{{ $row->created_at->format('D M y | H:I A') }}</span>
                                </div>
                                <div class="card-body message-body" style="background-color: rgb(67, 129, 70); color: #fff">
                                    <div class="message-content">{{ $row->isi_pesan }}</div>  
                                    
                                    <a href="#" class="read-more">Baca Selengkapnya...</a>
                                </div>
                            </div>
                        @else
                            <div class="cardPesan card bg-transparent" style="max-width: 70%">
                                <div class="card-header p-0 bg-transparent border-0 text-light">
                                    <span class="ms-1">{{ $row->user->name }}</span><span class="ms-3"
                                        style="font-size: 11px">{{ $row->created_at->format('D M y | H:I A') }}</span>
                                </div>
                                <div class="card-body message-body " style="background-color: rgb(49, 49, 49); color: #fff">
                                   <div class="message-content">{{ $row->isi_pesan }}</div>  
                                   <a href="#" class="read-more">Baca Selengkapnya...</a>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>


                <form action="/pesan/send" method="POST">
                    <div class="input-group ">
                        @csrf
                        <input type="text" autocomplete="off" onfocus="zoomOnFocus()" onblur="resetZoom()" name="isi_pesan"
                            class="form-control sendTxt" placeholder="Tulis Pesan..." >
                        <button type="submit" class="border border-1 btn btn-sm bg-transparent"><i
                                class="fas fa-paper-plane"></i></button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

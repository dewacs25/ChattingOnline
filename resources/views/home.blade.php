@extends('layouts.app')
@section('content')
    <div class="d-md-block d-none" style="position: absolute; left: 0;">

        <p class="text-light">Name : {{ Auth::guard('web')->user()->name }}</p>

        <form action="/logout" method="POST">
            @csrf
            <button class="btn btn-outline-dark text-light border-light">Logout</button>
        </form>

    </div>

    <button class="bg-transparent border-0 text-light fs-2 d-sm-none d-blog" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"
        style="position: fixed; left: 5px; top: 10px; z-index: 10;">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div class="offcanvas offcanvas-start " tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel"
        style="background: #000; box-shadow: 5px 5px 5px #ffffff6e">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-light" id="offcanvasExampleLabel">Chating Online</h5>
            <button style="color: #fff; " type="button" class="btn-close bg-light" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>

        </div>
        <div class="offcanvas-body">
            <div class="text-light">
                <p class="text-light">Name : {{ Auth::guard('web')->user()->name }}</p>

                <form action="/logout" method="POST">
                    @csrf
                    <button class="btn btn-outline-dark text-light border-light">Logout</button>
                </form>
            </div>

        </div>
    </div>


    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 col-12 border-1 border my-1" style="height: 99vh">
                <div id="data-message" class="content-text d-flex mt-2"
                    style="min-height: 90vh; position: fixed inherit; max-height: 90vh; overflow: auto; flex-direction: column;
                align-items: flex-start;">
                    @foreach ($dataPesan as $row)
                        @if ($row->user_id == $userid)
                            <div class="cardPesan card me-2 bg-transparent" style="max-width: 70%; align-self: flex-end;">
                                <div class="card-header  p-0 bg-transparent border-0 text-light">
                                    <span class="ms-1 ">Anda</span><span class="ms-3"
                                        style="font-size: 11px">{{ $row->created_at->format('D M y | H:I A') }}</span>
                                    <div class="dropdown" style="float: right">
                                        <button class="bg-transparent border-0 text-light " type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu border border-2 border-light " style="background: #000">
                                            <li><a class="dropdown-item text-light hoverItem" href="#">Action</a></li>
                                            <li><a class="dropdown-item text-light hoverItem" href="#">Another
                                                    action</a></li>
                                            <li><a class="dropdown-item text-light hoverItem" href="#">Something else
                                                    here</a></li>
                                        </ul>
                                    </div>
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
                        <input type="text" autocomplete="off" onfocus="zoomOnFocus()" onblur="resetZoom()"
                            name="isi_pesan" class="form-control sendTxt" placeholder="Tulis Pesan...">
                        <button type="submit" id="kirim" class="border border-1 btn btn-sm bg-transparent"><i
                                class="fas fa-paper-plane"></i></button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        function autoScrollToBottom() {
            var messageContainer = document.getElementById("data-message");
            messageContainer.scrollTop = messageContainer.scrollHeight;
        }

        autoScrollToBottom();

        $(function() {
            const Http = window.axios;
            const Echo = window.Echo;



            let channel = Echo.channel('channel-chat');

            channel.listen('ChatEvent', function(data) {

                const waktu = data.message.waktu; // Ambil waktu dari data.message.waktu
                const date = new Date(waktu);

                const options = {
                    weekday: 'short',
                    month: 'short',
                    day: 'numeric'
                };
                const formattedDate = date.toLocaleDateString('en-US', options);

                const hours = date.getHours();
                const minutes = date.getMinutes();
                const formattedTime =
                    `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;

                const meridiem = hours >= 12 ? 'PM' : 'AM';

                const result = `${formattedDate} | ${formattedTime} ${meridiem}`;


                $('#data-message')

                    .append(`<div class="cardPesan card bg-transparent" style="max-width: 70%">
                                <div class="card-header p-0 bg-transparent border-0 text-light">
                                    <span class="ms-1">${data.message.name}</span>${result}<span class="ms-3"
                                        style="font-size: 11px"></span>
                                </div>
                                <div class="card-body message-body " style="background-color: rgb(49, 49, 49); color: #fff">
                                    <div class="message-content">${data.message.message}</div>
                                    <a href="#" class="read-more">Baca Selengkapnya...</a>
                                </div>
                            </div>`);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
@endsection

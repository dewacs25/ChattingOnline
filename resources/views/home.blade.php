@extends('layouts.app')
@section('content')
    <button class="bg-transparent border-0 text-light fs-2 d-md-none d-blog" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"
        style="position: fixed; left: 5px; top: 10px; z-index: 10;">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div class="d-md-none d-blog" style="position: fixed; right: 5px; bottom: 60px; z-index: 10;">
        <button id="startButton" class="bg-dark text-light p-2 rounded-circle" style="width: 50px; height: 50px;"><i class="fa-solid fa-microphone"></i></button>
        <button id="stopButton" class="bg-dark p-2 rounded-circle text-danger" style="display: none; width: 50px; height: 50px;"><i class="fa-solid fa-microphone-slash"></i></button>
    </div>

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


    <div class="row ">
        <div class="col-md-4 d-md-block d-none">

            <div class="m-4">
                <p class="text-light">Name : {{ Auth::guard('web')->user()->name }}</p>
                <p class="text-light">Email : {{ Auth::guard('web')->user()->email }}</p>

                <form action="/logout" method="POST">
                    @csrf
                    <button class="btn btn-outline-dark text-light border-light">Logout</button>
                </form>
            </div>


        </div>
        <div class="col-md-4 col-12 border-1 border my-1" style="height: 99vh">
            <div id="data-message" class="content-text d-flex mt-2"
                style="min-height: 90vh; position: fixed inherit; max-height: 90vh; overflow: auto; flex-direction: column;
                align-items: flex-start;">
                @foreach ($dataPesan as $row)
                    @if ($row->user_id == $userid)
                        <div class="cardPesan mb-3 card me-2 bg-transparent" style="max-width: 70%; align-self: flex-end;">
                            <div class="card-header  p-0 bg-transparent border-0 text-light">
                                <span class="ms-1 ">Anda</span><span class="ms-3"
                                    style="font-size: 11px">{{ $row->created_at->format('D M y | H:I A') }}</span>
                                <div class="dropdown" style="float: right">
                                    <button class="bg-transparent border-0 text-light " type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu border border-2 border-light " style="background: #000">
                                        <li class="hoverItem"> <button type="button" class="btn  text-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#confirmDeleteModal{{ $row->id }}">
                                                <i class="fa-solid fa-trash me-2"></i> Hapus
                                            </button></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Modal konfirmasi hapus -->
                            <div class="modal fade" id="confirmDeleteModal{{ $row->id }}" tabindex="-1"
                                aria-labelledby="confirmDeleteModalLabel{{ $row->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus pesan ini ini?

                                            <!-- Tombol hapus dengan form -->
                                            <div class="d-flex justify-content-between ">
                                                <button type="button" class="btn text-success"
                                                    data-bs-dismiss="modal">Batal</button>

                                                <form action="{{ route('pesan.destroy', ['id' => $row->id]) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn text-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body message-body" style="background-color: rgb(67, 129, 70); color: #fff">
                                <div class="message-content">
                                    @if ($row->type == 'audio')
                                        <audio controls style="width: 100%">
                                            <source src="{{ asset('storage/' . $row->isi_pesan) }}" type="audio/ogg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    @else
                                        @if ($row->isi_pesan == '<delete><delete>')
                                            <span class="text-danger"><i class="fa-regular fa-circle-xmark me-1"></i> Pesan
                                                Telah Dihapus</span>
                                        @else
                                            {{ $row->isi_pesan }}
                                        @endif
                                    @endif
                                </div>

                                <a href="#" class="read-more">Baca Selengkapnya...</a>
                            </div>
                        </div>
                    @else
                        <div class="cardPesan mb-3 card bg-transparent" style="max-width: 70%">
                            <div class="card-header p-0 bg-transparent border-0 text-light">
                                <span class="ms-1">{{ $row->user->name }}</span><span class="ms-3"
                                    style="font-size: 11px">{{ $row->created_at->format('D M y | H:I A') }}</span>
                            </div>
                            <div class="card-body message-body " style="background-color: rgb(49, 49, 49); color: #fff">
                                <div class="message-content">

                                    @if ($row->type == 'audio')
                                        <audio controls style="width: 100%">
                                            <source src="{{ asset('storage/' . $row->isi_pesan) }}" type="audio/ogg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    @else
                                        @if ($row->isi_pesan == '<delete><delete>')
                                            <span class="text-danger"><i class="fa-regular fa-circle-xmark me-1"></i> Pesan
                                                Telah Dihapus</span>
                                        @else
                                            {{ $row->isi_pesan }}
                                        @endif
                                    @endif

                                </div>
                                <a href="#" class="read-more">Baca Selengkapnya...</a>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>



            <form action="/pesan/send" method="POST">
                <div class="input-group ">
                    @csrf
                    <button class="border-start border-top border-bottom btn btn-sm bg-transparent" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-ellipsis text-light"></i>
                    </button>
                    <div class="dropdown">
                        <div class="dropdown-menu p-1 border text-light"
                            style="min-width: 200px; min-height: 100px; max-height: 100px; overflow: auto; background: #000;">

                            <p>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="idToHiragana">
                                <label for="">To Hiragana</label>
                            </div>
                            </p>

                            <p>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="flexSwitchCheckChecked" disabled>
                                <label for="">To Kana</label>
                            </div>
                            </p>


                        </div>
                    </div>

                    <input type="text" autocomplete="off" onfocus="zoomOnFocus()" onblur="resetZoom()"
                        name="isi_pesan" id="textPesan" class="form-control sendTxt text-light"
                        placeholder="Tulis Pesan...">
                    <button type="submit" id="kirim" class="border border-1 btn btn-sm bg-transparent"><i
                            class="fas fa-paper-plane"></i></button>

                </div>
            </form>



        </div>
        <div class="col-md-4 d-md-block d-none">
            <div class="m-4">
                <button id="startButton" class="bg-dark text-light p-2 rounded-circle" style="width: 50px; height: 50px;"><i class="fa-solid fa-microphone"></i></button>
                <button id="stopButton" class="bg-dark p-2 rounded-circle text-danger" style="display: none; width: 50px; height: 50px;"><i class="fa-solid fa-microphone-slash"></i></button>
            </div>
        </div>
    </div>

    {{-- notifikasi --}}
    <audio id="notificationSound" src="{{ asset('sound/notifikasi.mp3') }}"></audio>
    {{-- end --}}




    <script>
        let mediaRecorder;
        let recordedChunks = [];

        const startButton = document.getElementById('startButton');
        const stopButton = document.getElementById('stopButton');

        startButton.addEventListener('click', startRecording);
        stopButton.addEventListener('click', stopRecording);

        function startRecording() {
            const constraints = {
                audio: true
            };

            navigator.mediaDevices.getUserMedia(constraints)
                .then(function(stream) {
                    mediaRecorder = new MediaRecorder(stream);

                    mediaRecorder.ondataavailable = function(event) {
                        if (event.data.size > 0) {
                            recordedChunks.push(event.data);
                        }
                    };

                    mediaRecorder.onstop = function() {
                        const blob = new Blob(recordedChunks, {
                            type: 'audio/wav'
                        });
                        const formData = new FormData();
                        formData.append('audioBlob', blob);

                        saveRecording(formData);
                    };

                    mediaRecorder.start();
                    startButton.style.display = 'none';
                    stopButton.style.display = 'block';
                })
                .catch(function(error) {
                    console.error('Error accessing microphone:', error);
                });
        }

        function stopRecording() {
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
                startButton.style.display = 'block';
                stopButton.style.display = 'none';
            }
        }

        function saveRecording(formData) {
            const url = '/save-audio';

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        console.error('Gagal menyimpan audio di server.');
                    }
                })
                .catch(error => {
                    console.error('Terjadi kesalahan saat menyimpan audio:', error);
                });
        }

        // end

        const checkbox = document.getElementById('idToHiragana');
        var input = document.getElementById('textPesan');

        checkbox.addEventListener('change', function() {

            if (checkbox.checked) {
                wanakana.bind(input);

            } else {

                wanakana.unbind(input)
            }
        });

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

                const waktu = data.message.waktu;
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


                if (data.message.type == 'text') {

                    $('#data-message')

                        .append(`<div class="cardPesan card bg-transparent" style="max-width: 70%">
                                    <div class="card-header p-0 bg-transparent border-0 text-light">
                                        <span class="ms-1">${data.message.name}</span><span class="ms-3"
                                            style="font-size: 11px">${result}</span>
                                    </div>
                                    <div class="card-body message-body " style="background-color: rgb(49, 49, 49); color: #fff">
                                        <div class="message-content">${data.message.message}</div>
                                        <a href="#" class="read-more">Baca Selengkapnya...</a>
                                    </div>
                                </div>`);
                } else {
                    $('#data-message')

                        .append(`<div class="cardPesan card bg-transparent" style="max-width: 70%">
                                    <div class="card-header p-0 bg-transparent border-0 text-light">
                                        <span class="ms-1">${data.message.name}</span><span class="ms-3"
                                            style="font-size: 11px">${result}</span>
                                    </div>
                                    <div class="card-body message-body " style="background-color: rgb(49, 49, 49); color: #fff">
                                        
                                        <audio controls style="width: 100%">
                                            <source src="http://127.0.0.1:8000/storage/${data.message.message}" type="audio/ogg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                </div>`);
                }

                var messageContainer = document.getElementById("data-message");
                messageContainer.scrollTop = messageContainer.scrollHeight;

                const audio = document.getElementById("notificationSound");
                audio.play();

            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
@endsection

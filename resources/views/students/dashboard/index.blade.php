@extends('students.layout.index')
@section('content')
    <div class="section-header">
        <h1>Dashboard Siswa</h1>
        {{-- <button onclick="startFCM()">Notif</button> --}}
    </div>
    <div class="row">
        {{-- <div class="col-12">
            <input class="input" id="token-input" style="width: 100%" />
        </div> --}}
        <div class="col-12 col-md-4">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Buku</h4>
                    </div>
                    <div class="card-body">
                        {{ $book }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="far fa-newspaper"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Peminjaman Saya</h4>
                    </div>
                    <div class="card-body">
                        {{ $loan }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pengembalian Saya</h4>
                    </div>
                    <div class="card-body">
                        {{ $revert }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card col-12">
            <div class="card-header">
                <h4>Buku yang sering dipinjam</h4>
            </div>
            <div class="card-body">
                <div class="summary">
                    <div class="summary-item">
                        <ul class="list-unstyled list-unstyled-border">
                            @foreach ($stats as $stat)
                                <li class="media">
                                    <a href="#">
                                        <img class="mr-3 rounded" width="50"
                                            src="{{ asset('assets/img/products/product-1-50.png') }}" alt="product">
                                    </a>
                                    <div class="media-body">
                                        <div class="media-right">{{ $stat->loan_count }}</div>
                                        <div class="media-title"><a href="#">{{ $stat->judul }}</a></div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyBbjq0TcsNaQT_BSzdD7hToELOHdZrwvdY",
            authDomain: "notify-absencify.firebaseapp.com",
            projectId: "notify-absencify",
            storageBucket: "notify-absencify.appspot.com",
            messagingSenderId: "870723237679",
            appId: "1:870723237679:web:31d4afd211e7a8858ed3da",
            measurementId: "G-S0456GJG1T"
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        const tokenInput = document.getElementById('token-input')

        function startFCM() {
            messaging
                .requestPermission()
                .then(function() {
                    return messaging.getToken()
                })
                .then(function(response) {
                    tokenInput.value = response
                }).catch(function(error) {

                });
        }

        messaging.onMessage(function(payload) {
            const title = payload.notification.title;
            const options = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(title, options);
        });
    </script>
@endsection

@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>Scan Pengembalian</h1>
    </div>
    <div class="col-12">
        @if (Session::get('status'))
            <div class="alert alert-dismissible show fade" style="background-color: #22c55e!important;">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    {{ Session::get('status') }}
                </div>
            </div>
        @endif
        <video id="preview" style="width: 100%; height: 100%; margin: 0 auto; display: block"></video>
    </div>
    <script type="text/javascript">
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });
        scanner.addListener('scan', function(content) {
            // window.location.href = content
            // alert(content)

            fetch(`${window.location.origin}/transaksi/pengembalian/proses/${content}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            }).then(e => {
                return e.json()
            }).then(e => {})

            swal('Data berhasil diproses!', {
                icon: 'success',
            }).then(() => {
                window.location.href =
                    `${window.location.origin}/transaksi/pengembalian`
            });
        });
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function(e) {
            console.log(e.message);
        });
    </script>
@endsection

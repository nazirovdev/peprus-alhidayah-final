@extends('layout.index')
@section('content')
<div class="section-header">
    <h1>Tambah Transaksi Peminjaman</h1>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <form class="card-body" action="/transaksi/peminjaman/tambah" method="POST" enctype="multipart/form-data">
                @csrf()
                <div class="row" style="justify-content: space-between; gap: 10px; flex-wrap: wrap">
                    <div class="form-group row mb-4 col-12">
                        <label class="col-form-label" style="font-size: 16px;">Siswa</label>
                        <div class="col-12 p-0">
                            <select class="form-control selectric" name="student_id">
                                <option value="" disabled selected>Silahkan pilih siswa</option>
                                @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('student_id')
                        <span style="font-style: italic; color: red; font-weight: bold;">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="col-12 p-0 books-list">

                    </div>
                    <button class="btn btn-md btn-primary col-12 btn-plus-book">Tambah Buku</button>
                    <button type="button" class="btn btn-sm btn-success col-12  btn-scan-book" data-toggle="modal" data-target="#exampleModal">
                        <span>Scan Buku</span>
                    </button>
                    <div style="width: 45%" class="col-12 col-md-5">
                        <div class="form-group row mb-4">
                            <label class="col-form-label" style="font-size: 16px;" for="tanggal_mulai">Tanggal
                                Mulai</label>
                            <input type="date" class="form-control" placeholder="Masukkan Tanggal Mulai" name="tanggal_mulai" value="{{ $tanggal_mulai }}" id="tanggal_mulai" disabled>
                            @error('tanggal_mulai')
                            <span style="font-style: italic; color: red; font-weight: bold;">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div style="width: 45%" class="col-12 col-md-5">
                        <div class="form-group row mb-4">
                            <label class="col-form-label" style="font-size: 16px;" for="tanggal_akhir">Tanggal
                                Akhir</label>
                            <input type="date" class="form-control" placeholder="Masukkan Tanggal Akhir" name="tanggal_akhir" value="{{ $tanggal_akhir }}" id="tanggal_akhir" disabled>
                            @error('tanggal_akhir')
                            <span style="font-style: italic; color: red; font-weight: bold;">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label"></label>
                    <div class="col-12 p-0">
                        <button type="submit" class="btn col-12" style="background-color: #22c55e; color: white">Tambah
                            Peminjam</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const booksList = document.querySelector('.books-list')
    const btnPlusBook = document.querySelector('.btn-plus-book')

    const btnBookClose = document.querySelectorAll('.btn-book-close')
    const books = []

    let count = 1

    function store(book) {
        const storex = JSON.parse(localStorage.getItem('books')) || []
        if (storex.find(b => b.id == book.id) !== undefined) {
            swal({
                title: 'Buku sudah masuk',
                icon: 'warning',
            })
        } else {
            storex.push(book)
            localStorage.setItem('books', JSON.stringify(storex))
            swal({
                title: 'Buku berhasil masuk',
                icon: 'success',
            })

            booksList.insertAdjacentHTML('beforeend', `
                <div class="form-group row mb-4 col-12">
                    <div class="col-10 p-0">
                        <label class="col-form-label" style="font-size: 16px;">Buku</label>
                        <div class="col-11 p-0">
                            <select class="form-control selectric" name="books[]">
                                <option value="${book.id}">${book.judul}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2 p-0 btn btn-sm btn-danger mt-2 btn-book-close"
                        style="height: 40px; align-self: flex-end; justify-content: center; align-items: center; line-height: 40px;">
                        x
                    </div>
                </div>
            `)
        }
    }

    function dispay() {
        const storex = JSON.parse(localStorage.getItem('books')) || []
        storex.forEach(book => {
            booksList.insertAdjacentHTML('beforeend', `
                <div class="form-group row mb-4 col-12">
                    <div class="col-10 p-0">
                        <label class="col-form-label" style="font-size: 16px;">Buku</label>
                        <div class="col-11 p-0">
                            <select class="form-control selectric" name="books[]">
                                <option value="${book.id}">${book.judul}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2 p-0 btn btn-sm btn-danger mt-2 btn-book-close"
                        style="height: 40px; align-self: flex-end; justify-content: center; align-items: center; line-height: 40px;">
                        x
                    </div>
                </div>
            `)
        });
    }

    function deleteData(id) {
        const storex = JSON.parse(localStorage.getItem('books')) || []

        if (id != '') {
            const newStorex = storex.filter(b => b.id != id)

            localStorage.setItem('books', JSON.stringify(newStorex))
        }
    }

    btnPlusBook.addEventListener('click', function(e) {
        e.preventDefault()
        count += 1
        booksList.insertAdjacentHTML(
            'beforeend',
            `<div class="form-group row mb-4 col-12">
                                <div class="col-10 p-0">
                                    <label class="col-form-label" style="font-size: 16px;">Buku</label>
                                    <div class="col-11 p-0">
                                        <select class="form-control selectric select-books" name="books[]" onchange="showElement(this)">
                                            <option value="" disabled selected>Silahkan pilih buku</option>
                                            @foreach ($books as $book)
                                                <option value="{{ $book->id }}">{{ $book->judul }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('books')
                                        <span style="font-style: italic; color: red; font-weight: bold;">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-2 p-0 btn btn-sm btn-danger mt-2 btn-book-close"
                                    style="height: 40px; align-self: flex-end; justify-content: center; align-items: center; line-height: 40px;">
                                    x
                                </div>
                            </div>`
        )
    })

    booksList.addEventListener('click', (e) => {
        if (e.target.classList.contains('btn-book-close')) {
            e.target.parentElement.remove()
            deleteData(e.target.parentElement.querySelector('.form-control').querySelector('option').value)
        }
    })

    let scanner = new Instascan.Scanner({
        video: document.getElementById('preview')
    });

    scanner.addListener('scan', function(content) {
        swal({
                title: 'Ingin menambah buku ini ?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((confirm) => {
                if (confirm) {

                    fetch(`${window.location.origin}/api/buku`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: content
                        })
                    }).then(e => {
                        return e.json()
                    }).then(e => {
                        store(e.data.book)
                    })

                } else {

                }
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

    function showElement(e) {
        const id = e.value
        const element = e.parentElement.parentElement.parentElement

        const storex = JSON.parse(localStorage.getItem('books')) || []

        fetch(`${window.location.origin}/api/buku`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id
            })
        }).then(e => {
            return e.json()
        }).then(e => {
            if (storex.find(b => b.id == e.data.book.id) !== undefined) {
                swal({
                    title: 'Buku sudah masuk',
                    icon: 'warning',
                })
                element.remove()
            } else {
                storex.push(e.data.book)
                localStorage.setItem('books', JSON.stringify(storex))
            }
        })
    }

    dispay()
</script>
@endsection

<div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Scan Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="section-header">
                    <form class="card-body" action="/peminjaman/import" method="POST" enctype="multipart/form-data">
                        @csrf()
                        <div class="row gx-5" style="gap: 40px">
                            <div class="col-12">
                                <div class="form-group row mb-4" style="height: 300px!important">
                                    <video style="width: 100%; padding: 0 10px;height:100%!important; border-width: 2px; border-color: gray; border-style: dashed;" id="preview" height="100%" ; width="100%">
                                    </video>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script></script>
</div>
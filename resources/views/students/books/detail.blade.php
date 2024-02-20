@extends('students.layout.index')
@section('content')
    <div class="section-header">
        <h1>Tambah Transaksi Peminjaman</h1>
    </div>
    <div class="row">
        <div class="col-12">
            @if (Session::get('status'))
                <div class="alert alert-dismissible show fade"
                    style="background-color: {{ Session::get('error') ? '#dc2626!important' : '#22c55e!important' }};">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        {{ Session::get('status') }}
                    </div>
                </div>
            @endif
            <div class="card">
                <form class="card-body" action="/dashboard/siswa/buku/pinjam/{{ $book->id }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf()
                    <div class="row" style="justify-content: space-between; gap: 10px; flex-wrap: wrap">
                        <div style="width: 45%" class="col-12 col-md-5">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;" for="tanggal_mulai">Tanggal
                                    Mulai</label>
                                <input type="date" class="form-control" placeholder="Masukkan Tanggal Mulai"
                                    name="tanggal_mulai" value="{{ $tanggal_mulai }}" id="tanggal_mulai" disabled>
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
                                <input type="date" class="form-control" placeholder="Masukkan Tanggal Akhir"
                                    name="tanggal_akhir" value="{{ $tanggal_akhir }}" id="tanggal_akhir" disabled>
                                @error('tanggal_akhir')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Buku yang dipinjam</div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">#</th>
                                        <th class="text-center">ISBN</th>
                                        <th>Judul</th>
                                        <th class="text-center">Rak Buku</th>
                                        <th class="text-center">Kategori</th>
                                        <th class="text-center">Pengarang</th>
                                        <th class="text-center">Penerbit</th>
                                        <th class="text-center">Tahun Terbit</th>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td class="text-center">{{ $book->isbn }}</td>
                                        <td>{{ $book->judul }}</td>
                                        <td class="text-center">{{ $book->rack->nama }}</td>
                                        <td class="text-center">{{ $book->category->nama }}</td>
                                        <td class="text-center">{{ $book->pengarang }}</td>
                                        <td class="text-center">{{ $book->penerbit }}</td>
                                        <td class="text-center">{{ $book->tahun_terbit }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label"></label>
                        <div class="col-sm-12 p-0">
                            <button type="submit" class="btn" style="background-color: #22c55e; color: white">Pinjam
                                Sekarang</button>
                            <a href="/dashboard/siswa/buku" class="btn btn-warning">
                                Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const inputUpld = document.querySelector('.input-upld')
        const imgUpld = document.querySelector('.img-upld')
        inputUpld.addEventListener('change', function(e) {
            const file = inputUpld.files[0]
            const reader = new FileReader()

            reader.readAsDataURL(file)
            reader.onload = function() {
                imgUpld.src = reader.result
            }
        })
    </script>
@endsection

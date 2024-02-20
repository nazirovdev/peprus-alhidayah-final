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
                        <div class="form-group row mb-4 col-12">
                            <label class="col-form-label" style="font-size: 16px;">Buku</label>
                            <div class="col-12 p-0">
                                <select class="form-control selectric" name="book_id">
                                    <option value="" disabled selected>Silahkan pilih buku</option>
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}">{{ $book->judul }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('book_id')
                                <span style="font-style: italic; color: red; font-weight: bold;">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div style="width: 45%" class="col-12 col-md-5">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;" for="tanggal_mulai">Tanggal
                                    Mulai</label>
                                <input type="date" class="form-control" placeholder="Masukkan Tanggal Mulai"
                                    name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" id="tanggal_mulai">
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
                                    name="tanggal_akhir" value="{{ old('tanggal_akhir') }}" id="tanggal_akhir">
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
                        <div class="col-sm-12 p-0">
                            <button type="submit" class="btn" style="background-color: #22c55e; color: white">Tambah
                                Peminjam</button>
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

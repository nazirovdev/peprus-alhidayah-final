@extends('layout.index')
@section('content')
<div class="section-header">
    <h1>Edit Buku</h1>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <form class="card-body" action="/buku/edit/{{ $book->id }}" method="POST" enctype="multipart/form-data">
                @csrf()
                @method('PUT')
                <div class="row" style="justify-content: space-between; gap: 10px; flex-wrap: wrap">
                    <div class="col-12">
                        <div class="form-group row mb-4">
                            <label class="col-form-label" style="font-size: 16px;" for="isbn">ISBN</label>
                            <input type="text" class="form-control" placeholder="Masukkan ISBN" name="isbn" value="{{ $book->isbn }}" id="isbn">
                            @error('isbn')
                            <span style="font-style: italic; color: red; font-weight: bold;">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row mb-4">
                            <label class="col-form-label" style="font-size: 16px;" for="judul">Judul Buku</label>
                            <input type="text" class="form-control" placeholder="Masukkan Judul Buku" name="judul" value="{{ $book->judul }}" id="judul">
                            @error('judul')
                            <span style="font-style: italic; color: red; font-weight: bold;">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row mb-4">
                            <label class="col-form-label" style="font-size: 16px;" for="jumlah">Jumlah Buku</label>
                            <input type="text" class="form-control" placeholder="Masukkan Jumlah Buku" name="jumlah" value="{{ $book->jumlah }}" id="jumlah">
                            @error('jumlah')
                            <span style="font-style: italic; color: red; font-weight: bold;">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="form-group row mb-4">
                            <label class="col-form-label" style="font-size: 16px;">Rak Buku</label>
                            <div class="col-12 p-0">
                                <select class="form-control selectric" name="rack_id">
                                    @foreach ($racks as $rack)
                                    @if ($book->rack_id == $rack->id)
                                    <option value="{{ $rack->id }}" selected>{{ $rack->nama }}</option>
                                    @else
                                    <option value="{{ $rack->id }}">{{ $rack->nama }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            @error('rack_id')
                            <span style="font-style: italic; color: red; font-weight: bold;">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="form-group row mb-4">
                            <label class="col-form-label" style="font-size: 16px;">Kategori Buku</label>
                            <div class="col-12 p-0">
                                <select class="form-control selectric" name="category_id">
                                    @foreach ($categories as $category)
                                    @if ($book->category_id == $category->id)
                                    <option value="{{ $category->id }}" selected>{{ $category->nama }}
                                    </option>
                                    @else
                                    <option value="{{ $category->id }}">{{ $category->nama }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id')
                            <span style="font-style: italic; color: red; font-weight: bold;">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group row mb-4">
                            <label class="col-form-label" style="font-size: 16px;" for="pengarang">Pengarang</label>
                            <input type="text" class="form-control" placeholder="Masukkan Pengarang" name="pengarang" value="{{ $book->pengarang }}" id="pengarang">
                            @error('pengarang')
                            <span style="font-style: italic; color: red; font-weight: bold;">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group row mb-4">
                            <label class="col-form-label" style="font-size: 16px;" for="penerbit">Penerbit</label>
                            <input type="text" class="form-control" placeholder="Masukkan Penerbit" name="penerbit" value="{{ $book->penerbit }}" id="penerbit">
                            @error('penerbit')
                            <span style="font-style: italic; color: red; font-weight: bold;">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group row mb-4">
                            <label class="col-form-label" style="font-size: 16px;" for="tahun_terbit">Tahun
                                Terbit</label>
                            <input type="text" class="form-control" placeholder="Masukkan Tahun Terbit" name="tahun_terbit" value="{{ $book->tahun_terbit }}" id="tahun_terbit">
                            @error('tahun_terbit')
                            <span style="font-style: italic; color: red; font-weight: bold;">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row mb-4">
                            <label class="col-form-label" style="font-size: 16px;" for="tanggal_masuk">Tanggal
                                Masuk</label>
                            <input type="date" class="form-control" placeholder="Masukkan Tanggal Masuk" name="tanggal_masuk" value="{{ $book->tanggal_masuk }}" id="tanggal_masuk">
                            @error('tanggal_masuk')
                            <span style="font-style: italic; color: red; font-weight: bold;">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-4 col-12">
                        <label class="col-form-label" style="font-size: 16px;">Foto Sampul</label>
                        <div class="col-12 p-0">
                            <label style="width: 200px; height: 230px;border-width: 2px; border-color: gray; border-style: dashed; padding: 3px" for="upld">
                                <img style="display: block; width: 100%; height: 100%;object-fit: cover" src="{{ $book->image == null ? asset('assets/images/default.jpg') : asset('storage/buku/' . $book->image) }}" class="img-upld" />
                                <input type="file" name="image" id="upld" style="display: none" class="input-upld">
                            </label>
                        </div>
                        @error('image')
                        <span style="font-style: italic; color: red; font-weight: bold;">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group row mb-4 col-12">
                        <label class="col-form-label" style="font-size: 16px;">Qr Code</label>
                        <div class="col-12 p-0">
                            {!! QrCode::size(200)->generate($book->id) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label"></label>
                    <div class="col-sm-12 p-0">
                        <button type="submit" class="btn" style="background-color: #22c55e; color: white">Update
                            Buku</button>
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
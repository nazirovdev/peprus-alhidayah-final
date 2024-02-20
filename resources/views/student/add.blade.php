@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>Tambah Siswa</h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="card-body" action="/siswa/tambah" method="POST" enctype="multipart/form-data">
                    @csrf()
                    <div class="row" style="justify-content: space-between; gap: 10px; flex-wrap: wrap">
                        <div style="width: 45%" class="col-12 col-md-5">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;" for="nis">NIS</label>
                                <input type="text" class="form-control" placeholder="Masukkan NIS" name="nis"
                                    value="{{ old('nis') }}" id="nis">
                                @error('nis')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div style="width: 45%" class="col-12 col-md-5">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;" for="nama">Nama</label>
                                <input type="text" class="form-control" placeholder="Masukkan Nama" name="nama"
                                    value="{{ old('nama') }}" id="nama">
                                @error('nama')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4 col-12">
                            <label class="col-form-label" style="font-size: 16px;">Kelas</label>
                            <div class="col-12 p-0">
                                <select class="form-control selectric" name="classroom_id">
                                    @foreach ($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}">{{ $classroom->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('kelas')
                                <span style="font-style: italic; color: red; font-weight: bold;">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row mb-4 col-12">
                            <label class="col-form-label" style="font-size: 16px;" for="alamat">Alamat</label>
                            <input type="text" class="form-control" placeholder="Masukkan Alamat" name="alamat"
                                value="{{ old('alamat') }}" id="alamat">
                            @error('alamat')
                                <span style="font-style: italic; color: red; font-weight: bold;">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row mb-4 col-12">
                            <label class="col-form-label" style="font-size: 16px;" for="no_telepon">No.Telepon</label>
                            <input type="text" class="form-control" placeholder="Masukkan No Telepon" name="no_telepon"
                                value="{{ old('no_telepon') }}" id="no_telepon">
                            @error('no_telepon')
                                <span style="font-style: italic; color: red; font-weight: bold;">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row mb-4 col-12">
                            <label class="col-form-label" style="font-size: 16px;">Jenis Kelamin</label>
                            <div class="col-12 p-0">
                                <select class="form-control selectric" name="jenis_kelamin">
                                    <option value="l">Laki-laki</option>
                                    <option value="p">Perempuan</option>
                                </select>
                            </div>
                            @error('jenis_kelamin')
                                <span style="font-style: italic; color: red; font-weight: bold;">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row mb-4 col-12">
                            <label class="col-form-label" style="font-size: 16px;">Foto Siswa</label>
                            <div class="col-12 p-0">
                                <label
                                    style="width: 200px; height: 230px;border-width: 2px; border-color: gray; border-style: dashed; padding: 3px"
                                    for="upld">
                                    <img style="display: block; width: 100%; height: 100%;object-fit: cover"
                                        src="{{ asset('assets/images/default.jpg') }}" class="img-upld" />
                                    <input type="file" name="image" id="upld" style="display: none"
                                        class="input-upld">
                                </label>
                            </div>
                            @error('image')
                                <span style="font-style: italic; color: red; font-weight: bold;">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label"></label>
                        <div class="col-sm-12 p-0">
                            <button type="submit" class="btn" style="background-color: #22c55e; color: white">Tambah
                                Anggota</button>
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

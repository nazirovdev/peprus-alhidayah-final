@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>Tambah Kelas</h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="card-body" action="/kelas/tambah" method="POST">
                    @csrf()
                    <div class="row gx-5" style="gap: 40px">
                        <div class="col-12">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;" for="nama">Nama Kelas</label>
                                <input type="text" class="form-control" placeholder="Masukkan Nama Kelas" name="nama"
                                    value="{{ old('nama') }}" id="nama">
                                @error('nama')
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
                                Kelas</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

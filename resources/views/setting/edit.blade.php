@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>Edit Pengaturan</h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="card-body" action="/pengaturan/edit/{{ $setting->id }}" method="POST">
                    @csrf()
                    @method('PUT')
                    <div class="row gx-5">
                        <div class="col-12">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;" for="nama">Maksimal Hari
                                    Peminjaman</label>
                                <input type="text" class="form-control" placeholder="Masukkan Maksimal hari peminjaman"
                                    name="max_hari_pinjam" value="{{ $setting->max_hari_pinjam }}" id="max_hari_pinjam">
                                @error('max_hari_pinjam')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-12">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;" for="nama">Hari
                                    Perpanjangan</label>
                                <input type="text" class="form-control" placeholder="Masukkan hari perpanjangan"
                                    name="perpanjangan_hari" value="{{ $setting->perpanjangan_hari }}"
                                    id="perpanjangan_hari">
                                @error('perpanjangan_hari')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="col-12">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;" for="nama">Denda</label>
                                <input type="text" class="form-control" placeholder="Masukkan denda" name="denda"
                                    value="{{ $setting->denda }}" id="denda">
                                @error('denda')
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
                            <button type="submit" class="btn" style="background-color: #22c55e; color: white">Update
                                Pengaturan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

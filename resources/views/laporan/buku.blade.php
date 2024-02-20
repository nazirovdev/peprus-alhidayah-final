@extends('layout.index')
@section('content')
<div class="section-header">
    <h1>Laporan Buku</h1>
</div>
<div class="row">
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
        <form class="card" action="/laporan/buku" method="POST">
            @csrf()
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Pilih Kategori Buku</label>
                        <select class="form-control" name="category">
                            <option value="">Semua</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->nama }}">{{ $category->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-success col-12">Filter</button>
                    <!-- <a href="/laporan/buku/qrcode" class="btn btn-primary col-12 mt-2">Cetak QR-Code Buku</a> -->
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
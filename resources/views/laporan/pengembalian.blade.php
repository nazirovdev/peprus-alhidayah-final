@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>Laporan Pengembalian</h1>
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
            <form class="card" action="/laporan/pengembalian" method="POST">
                @csrf()
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Tanggal Pengembalian</label>
                            <input type="date" name="date" class="form-control datepicker"
                                value="{{ \Carbon\Carbon::now()->toDateString() }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary col-12">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

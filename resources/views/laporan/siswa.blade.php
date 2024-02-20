@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>Laporan Siswa</h1>
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
            <form class="card" action="/laporan/siswa" method="POST">
                @csrf()
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Pilih Kelas</label>
                            <select class="form-control" name="classroom_id">
                                <option value="">Semua</option>
                                @foreach ($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}">{{ $classroom->nama }}</option>
                                @endforeach
                            </select>
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

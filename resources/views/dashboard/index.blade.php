@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Buku</h4>
                    </div>
                    <div class="card-body">
                        {{ $book }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="far fa-newspaper"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Peminjaman</h4>
                    </div>
                    <div class="card-body">
                        {{ $loan }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pengembalian</h4>
                    </div>
                    <div class="card-body">
                        {{ $revert }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card col-12">
            <div class="card-header">
                <h4>Buku yang sering dipinjam</h4>
            </div>
            <div class="card-body">
                <div class="summary">
                    <div class="summary-item">
                        <ul class="list-unstyled list-unstyled-border">
                            @foreach ($stats as $stat)
                                <li class="media">
                                    <a href="#">
                                        <img class="mr-3 rounded" width="50" src="assets/img/products/product-1-50.png"
                                            alt="product">
                                    </a>
                                    <div class="media-body">
                                        <div class="media-right">{{ $stat->loans_count }}</div>
                                        <div class="media-title"><a href="#">{{ $stat->judul }}</a></div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

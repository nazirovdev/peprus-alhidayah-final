@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>Detail Transaksi Peminjaman</h1>
    </div>
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
    <div class="invoice">
        <div class="invoice-print">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-title">
                        <h2>Kode Transaksi</h2>
                        <div class="invoice-number">{{ $loan->kd_transaksi }}</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <strong style="font-size: 16px">Nama</strong>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <span style="font-size: 16px">{{ $student->nama }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong style="font-size: 16px">Kelas</strong>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <span style="font-size: 16px">{{ $student->classroom->nama }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong style="font-size: 16px">Tanggal Mulai Pinjam</strong>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <span
                                style="font-size: 16px">{{ \Carbon\Carbon::create($loan->tanggal_mulai)->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong style="font-size: 16px">Tanggal Akhir Pinjam</strong>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <span
                                style="font-size: 16px">{{ \Carbon\Carbon::create($loan->tanggal_akhir)->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong style="font-size: 16px">Status</strong>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <span class="badge {{ $loan->status == 'menunggu' ? 'badge-warning' : 'badge-success' }}">
                                {{ $loan->status }}
                            </span>
                        </div>
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
        </div>
        <hr>
        <div class="text-md-right">
            <div class="float-lg-left mb-lg-0 mb-3">
                <a href="/transaksi/peminjaman/proses/{{ $loan->id }}" class="btn btn-primary btn-icon icon-left"><i
                        class="fas fa-credit-card"></i>Proses
                    Peminjaman</a>
                <a href="/transaksi/peminjaman" class="btn btn-danger btn-icon icon-left">
                    Kembali</a>
            </div>
            <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Cetak</button>
        </div>
    </div>
@endsection

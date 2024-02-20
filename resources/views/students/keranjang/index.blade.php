@extends('students.layout.index')
@section('content')
    <div class="section-header">
        <h1>Daftar Keranjang Buku Siswa</h1>
    </div>

    <div class="invoice">
        <div class="invoice-print">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-title">
                        <h2>Kode Transaksi</h2>
                        <div class="invoice-number">{{ 1 }}</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <strong style="font-size: 16px">Nama</strong>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <span style="font-size: 16px">{{ 'Student Nama' }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong style="font-size: 16px">Kelas</strong>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <span style="font-size: 16px">{{ 'Classroom Nama' }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong style="font-size: 16px">Tanggal Mulai Pinjam</strong>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <span style="font-size: 16px">{{ \Carbon\Carbon::create('2023-04-21')->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong style="font-size: 16px">Tanggal Akhir Pinjam</strong>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <span style="font-size: 16px">{{ \Carbon\Carbon::create('2023-04-21')->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong style="font-size: 16px">Status</strong>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <span class="badge {{ true == 'menunggu' ? 'badge-warning' : 'badge-success' }}">
                                {{ 'status' }}
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
                                <th class="">ISBN</th>
                                <th>Judul</th>
                                <th class="">Rak Buku</th>
                                <th class="">Kategori</th>
                                <th class="">Pengarang</th>
                                <th class="">Penerbit</th>
                                <th class="">Tahun Terbit</th>
                            </tr>
                            @foreach ($carts as $cart)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="">{{ $cart->book->isbn }}</td>
                                    <td>{{ $cart->book->judul }}</td>
                                    <td class="">{{ $cart->book->rack->nama }}</td>
                                    <td class="">{{ $cart->book->category->nama }}</td>
                                    <td class="">{{ $cart->book->pengarang }}</td>
                                    <td class="">{{ $cart->book->penerbit }}</td>
                                    <td class="">{{ $cart->book->tahun_terbit }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="text-md-right">
            <div class="float-lg-left mb-lg-0 mb-3">
                <a href="/dashboard/siswa/keranjang/peminjaman" class="btn btn-primary btn-icon icon-left"><i
                        class="fas fa-credit-card"></i>Proses
                    Peminjaman</a>
                <a href="/transaksi/peminjaman" class="btn btn-danger btn-icon icon-left">
                    Kembali</a>
            </div>
            <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Cetak</button>
        </div>
    </div>
@endsection

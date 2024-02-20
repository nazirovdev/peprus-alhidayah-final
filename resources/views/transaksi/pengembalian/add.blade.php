@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>Tambah Transaksi Pengembalian</h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="card-body" action="/transaksi/pengembalian/tambah" method="POST" enctype="multipart/form-data">
                    @csrf()
                    <div class="row" style="justify-content: space-between; gap: 10px; flex-wrap: wrap">
                        <div class="form-group row mb-4 col-12">
                            <label class="col-form-label" style="font-size: 16px;">Pengembalian Buku</label>
                            <div class="col-12 p-0">
                                <select class="form-control selectric" name="transaction_loan_id">
                                    <option value="" disabled selected>Silahkan pilih siswa</option>
                                    @foreach ($loans as $loan)
                                        <option value="{{ $loan->id }}">{{ $loan }}
                                            ({{ $loan->kd_transaksi }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('transaction_loan_id')
                                <span style="font-style: italic; color: red; font-weight: bold;">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row mb-4 col-12">
                            <label class="col-form-label" style="font-size: 16px;" for="tanggal_akhir">Tanggal
                                Pengembalian</label>
                            <input type="date" class="form-control" placeholder="Masukkan Tanggal Akhir"
                                name="tanggal_pengembalian" value="{{ \Carbon\Carbon::now()->toDateString() }}"
                                id="tanggal_pengembalian" disabled>
                            @error('tanggal_pengembalian')
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
                                Pengembalian</button>
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

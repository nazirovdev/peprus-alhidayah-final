<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Peminjaman Buku Siswa</title>
    <style>

    </style>
</head>

<body>
    <table align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <img width="70" style="display: block; margin: 0px auto" src="{{ public_path() . '/assets/images/logo.jpg' }}" />
            </td>
            <td style="width: 500px; text-align: center">
                <h2 style="text-align: center">MTS AL-Hidayah Semarang</h2>
                <h3 style="text-align: center">{{ $title }}</h3>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div style="width: 100%; height: 3px; background-color: black;"></div>
            </td>
        </tr>
    </table>
    <br>
    <table border="1" align="center" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <th style="padding: 3px">No.</th>
                <th style="padding: 3px">Kode Transaksi</th>
                <th style="padding: 3px">Nama Siswa</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Akhir</th>
                <th>Buku</th>
            </tr>
            @forelse ($loans as $loan)
            <tr>
                <td style="text-align: center">{{ $loop->iteration }}</td>
                <td style="text-align: center">{{ $loan->kd_transaksi }}</td>
                <td style="text-align: center">{{ $loan->student->nama }}</td>
                <td style="text-align: center">{{ \Carbon\Carbon::create($loan->tanggal_mulai)->format('d M Y') }}
                </td>
                <td style="text-align: center">{{ \Carbon\Carbon::create($loan->tanggal_akhir)->format('d M Y') }}
                </td>
                <td style="text-align: left">
                    <ul style="padding-right: 10;">
                        @foreach ($loan->books as $book)
                        <li>{{ $book->judul }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="font-weight: bold; text-align: center; color: red">Data tidak ada</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Buku Siswa</title>
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
                <th style="padding: 3px">ISBN</th>
                <th style="padding: 3px">Judul</th>
                <th style="padding: 3px">Kategori</th>
                <th style="padding: 3px">Pengarang</th>
                <th style="padding: 3px">Penerbit</th>
                <th style="padding: 3px">Tahun Penerbit</th>
                <th style="padding: 3px">Tanggal Masuk</th>
                <th style="padding: 3px">Jumlah</th>
            </tr>
            @forelse ($books as $book)
            <tr>
                <td style="text-align: center">{{ $loop->iteration }}</td>
                <td style="text-align: center">{{ $book['isbn'] }}</td>
                <td style="text-align: left">{{ $book['judul'] }}</td>
                <td style="text-align: center">{{ $book['category'] }}</td>
                <td style="text-align: center">{{ $book['pengarang'] }}</td>
                <td style="text-align: center">{{ $book['penerbit'] }}</td>
                <td style="text-align: center">{{ $book['tahun_terbit'] }}</td>
                <td style="text-align: center">{{ \Carbon\Carbon::create($book['tanggal_masuk'])->format('d M Y') }}
                </td>
                <td style="text-align: center">{{ $book['jumlah'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="font-weight: bold; text-align: center; color: red">Data tidak ada</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- <br>
    <br>
    <br>
    <br>
    <table align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <img width="70" style="display: block; margin: 0px auto"
                    src="{{ public_path() . '/assets/images/logo.jpg' }}" />
            </td>
            <td style="width: 500px; text-align: center">
                <h2 style="text-align: center">MTS AL-Hidayah Semarang</h2>
                <h3 style="text-align: center">Qr Code Buku</h3>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div style="width: 100%; height: 3px; background-color: black;"></div>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <table border="1" align="center" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <th style="padding: 3px">No.</th>
                <th style="padding: 3px">ISBN</th>
                <th style="padding: 3px">Judul</th>
                <th style="padding: 3px">QrCode</th>
            </tr>
            @forelse ($books as $book)
                <tr>
                    <td style="text-align: center">{{ $loop->iteration }}</td>
                    <td style="text-align: center">{{ $book['isbn'] }}</td>
                    <td style="text-align: left">{{ $book['judul'] }}</td>
                    <td style="text-align: center; padding: 10px;">
                        <div style="width: 200px; height: 200px; background-color: lightcoral;">
                            <img style="display: block; width: 100%; height: 100%"
                                src="data:image/png;base64, {!! $book['qrcode'] !!}">
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="font-weight: bold; text-align: center; color: red">Data tidak ada</td>
                </tr>
            @endforelse
        </tbody>
    </table> -->
</body>

</html>
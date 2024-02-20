<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Siswa</title>
    <style>

    </style>
</head>

<body>
    <table align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <img width="70" style="display: block; margin: 0px auto"
                    src="{{ public_path() . '/assets/images/logo.jpg' }}" />
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
                <th style="padding: 3px">NIS</th>
                <th style="padding: 3px">Nama</th>
                <th>Kelas</th>
                <th>Alamat</th>
                <th>No.Telepon</th>
                <th>Jenis Kelamin</th>
            </tr>
            @forelse ($students as $student)
                <tr>
                    <td style="text-align: center">{{ $loop->iteration }}</td>
                    <td style="text-align: center">{{ $student->nis }}</td>
                    <td style="text-align: left">{{ $student->nama }}</td>
                    <td style="text-align: center">{{ $student->classroom->nama }}</td>
                    <td style="text-align: center">{{ $student->alamat }}</td>
                    <td style="text-align: center">{{ $student->no_telepon }}</td>
                    <td style="text-align: center">{{ $student->jenis_kelamin == 'l' ? 'Laki-laki' : 'Perempuan' }}</td>
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

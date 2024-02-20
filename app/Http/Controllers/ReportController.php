<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Classroom;
use App\Models\Loan;
use App\Models\Revert;
use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReportController extends Controller
{
    public function book()
    {
        return view('laporan.buku', [
            'title' => 'Laporan Buku',
            'categories' => Category::get()
        ]);
    }

    public function bookFilter(Request $request)
    {
        $books = collect(Book::withWhereHas('category', fn ($query) => $query->where('nama', 'like', '%' . $request->category . '%'))->get());
        $bookMaps = $books->map(fn ($data) => [
            'id' => $data->id,
            'isbn' => $data->isbn,
            'judul' => $data->judul,
            'pengarang' => $data->pengarang,
            'penerbit' => $data->penerbit,
            'tahun_terbit' => $data->tahun_terbit,
            'tanggal_masuk' => $data->tanggal_masuk,
            'image' => $data->image,
            'status' => $data->status,
            'category' => $data->category->nama,
            'rack_id' => $data->rack_id,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'jumlah' => $data->jumlah,
            'qrcode' => base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data->id))
        ]);

        $pdf = Pdf::loadView('laporan.buku_pdf', [
            'books' => $bookMaps,
            'title' => 'Laporan Buku',
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('laporan_buku.pdf');
    }

    public function bookFilterQrCode()
    {
        $books = Book::get();
        $bookMaps = $books->map(fn ($data) => [
            'id' => $data->id,
            'isbn' => $data->isbn,
            'judul' => $data->judul,
            'pengarang' => $data->pengarang,
            'penerbit' => $data->penerbit,
            'tahun_terbit' => $data->tahun_terbit,
            'tanggal_masuk' => $data->tanggal_masuk,
            'image' => $data->image,
            'status' => $data->status,
            'category' => $data->category->nama,
            'rack_id' => $data->rack_id,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'qrcode' => base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data->id))
        ]);
        $pdf = Pdf::loadView('book.book_qrcode', [
            'books' => $bookMaps,
            'title' => 'Qr-Code Buku',
        ])->setPaper('a4');

        return $pdf->stream('laporan_buku.pdf');
    }

    public function loan()
    {
        return view('laporan.peminjaman', [
            'title' => 'Laporan Peminjaman'
        ]);
    }

    public function loanFilter(Request $request)
    {
        $pdf = Pdf::loadView('laporan.peminjaman_pdf', [
            'loans' => Loan::whereDate('tanggal_mulai', $request->date)->get(),
            'title' => 'Laporan Peminjaman Buku'
        ]);

        return $pdf->stream('laporan_peminjaman.pdf');
    }

    public function revert()
    {
        return view('laporan.pengembalian', [
            'title' => 'Laporan pengembalian'
        ]);
    }

    public function revertFilter(Request $request)
    {
        $pdf = Pdf::loadView('laporan.pengembalian_pdf', [
            'reverts' => Revert::whereDate('tanggal_pengembalian', $request->date)->get(),
            'title' => 'Laporan Pengembalian Buku'
        ]);

        return $pdf->stream('laporan_pengembalian.pdf');
    }

    public function student()
    {
        return view('laporan.siswa', [
            'title' => 'Laporan Siswa',
            'classrooms' => Classroom::get()
        ]);
    }

    public function studentFilter(Request $request)
    {
        $pdf = Pdf::loadView('laporan.siswa_pdf', [
            'students' => Student::where('classroom_id', 'like', '%' . $request->classroom_id . '%')->get(),
            'title' => 'Laporan Siswa'
        ]);

        return $pdf->stream('laporan_siswa.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Loan;
use App\Models\Revert;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentBookController extends Controller
{
    public function index()
    {
        return view('students.books.index', [
            'title' => 'Daftar Buku',
            'books' => Book::get(),
        ]);
    }

    public function bukuPinjam(Book $book)
    {
        $maxLoan = Setting::first()->max_hari_pinjam;

        $tanggalMulai = Carbon::now()->addDays(1);
        $tanggalAkhir = Carbon::create($tanggalMulai->toDateString())->addDays($maxLoan - 1);

        return view('students.books.detail', [
            'title' => 'Pinjam Buku',
            'book' => $book,
            'tanggal_mulai' => $tanggalMulai->toDateString(),
            'tanggal_akhir' => $tanggalAkhir->toDateString(),
        ]);
    }

    public function storeBukuPinjam(Request $request, Book $book)
    {
        $maxLoan = Setting::first()->max_hari_pinjam;

        $tanggalMulai = Carbon::now()->addDays(1);
        $tanggalAkhir = Carbon::create($tanggalMulai->toDateString())->addDays($maxLoan - 1);

        $studentId = Auth::guard('student')->id();
        $bookId = $book->id;

        $trxLoan = Loan::count() + 1;
        $kdTransaksi = Carbon::now()->microsecond . Carbon::now()->day . Carbon::now()->year . $trxLoan;

        if (Loan::where('student_id', Auth::guard('student')->id())->where('status', 'menunggu')->count() >= 1) {
            return back()->with([
                'status' => 'Selesaikan dulu peminjaman anda',
                'error' => true
            ]);
        }

        // if (
        //     Loan::withWhereHas('student', fn ($query) => $query->where('status', 'nonmember'))
        //     ->where('tanggal_mulai', Carbon::create($tanggalMulai)->toDateString())
        //     ->where('tanggal_akhir', Carbon::create($tanggalAkhir)->toDateString())
        //     ->count() >= 1
        // ) {
        //     return back()->with([
        //         'status' => 'nonmember hanya bisa meminjam 1 buku',
        //         'error' => true
        //     ]);
        // }

        DB::beginTransaction();
        try {
            $loanId = DB::table('loans')->insertGetId([
                'kd_transaksi' => $kdTransaksi,
                'student_id' => $studentId,
                'book_id' => $bookId,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_akhir' => $tanggalAkhir,
            ]);

            Revert::create([
                'loan_id' => $loanId,
                'tanggal_pengembalian' => null,
                'status' => 'belum_dikembalikan'
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return redirect('/dashboard/siswa/buku')->with([
            'status' => 'Transaksi peminjaman berhasil dibuat'
        ]);
    }
}

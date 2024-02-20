<?php

namespace App\Http\Controllers;

use App\Exports\LoanExport;
use App\Imports\LoanImport;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Revert;
use App\Models\Setting;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class LoanController extends Controller
{
    public function peminjaman()
    {
        return view('peminjaman.index', [
            'title' => 'Peminjaman Buku',
            'loans' => Loan::latest()->get()
        ]);
    }

    public function addPeminjaman()
    {
        $maxLoan = Setting::first()->max_hari_pinjam;

        $tanggalMulai = Carbon::now();
        $tanggalAkhir = Carbon::create($tanggalMulai->toDateString())->addDays($maxLoan - 1);

        return view('peminjaman.add', [
            'title' => 'Tambah Peminjaman Buku',
            'students' => Student::get(),
            'books' => Book::where('jumlah', '>', '0')->get(),
            'tanggal_mulai' => $tanggalMulai->toDateString(),
            'tanggal_akhir' => $tanggalAkhir->toDateString(),
        ]);
    }

    public function storePeminjaman(Request $request)
    {
        $maxLoan = Setting::first()->max_hari_pinjam;

        $tanggalMulai = Carbon::now()->addDays(1);
        $tanggalAkhir = Carbon::create($tanggalMulai->toDateString())->addDays($maxLoan - 1);

        $request->validate([
            'student_id' => 'required',
            'books' => 'required',
        ]);

        $trxLoan = Loan::where('status', 'dipinjam')->count() + 1;
        $kdTransaksi = Carbon::now()->microsecond . Carbon::now()->day . Carbon::now()->year . $trxLoan;


        DB::beginTransaction();
        try {
            $loanId = DB::table('loans')->insertGetId([
                'kd_transaksi' => $kdTransaksi,
                'student_id' => $request->student_id,
                'tanggal_mulai' => $tanggalMulai->toDateString(),
                'tanggal_akhir' => $tanggalAkhir->toDateString(),
                'tanggal_pengembalian' => null,
                'status' => 'dipinjam'
            ]);

            foreach ($request->books as $book) {
                DB::table('book_loan')->insertGetId([
                    'loan_id' => $loanId,
                    'book_id' => $book,
                ]);

                $book = Book::find($book);

                $book->jumlah -= 1;
                $book->save();
            }

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

        return redirect('/transaksi/peminjaman')->with([
            'status' => 'Data berhasil ditambah'
        ]);
    }

    public function detailPeminjam(Loan $loan)
    {
        return view('peminjaman.detail', [
            'title' => 'Detail Peminjaman Buku',
            'loan' => $loan->load('books')
        ]);
    }

    public function processPeminjaman(Loan $loan)
    {
        DB::beginTransaction();
        try {
            $loan->update([
                'status' => 'dipinjam'
            ]);

            Book::find($loan->book_id)->update([
                'status' => 'dipinjam'
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return back()->with([
            'status' => 'Data berhasil diproses'
        ]);
    }

    public function deletePeminjam(Loan $loan)
    {
        $loan->delete();

        return response()->json([
            'data' => [
                'message' => 'Data berhasil dihapus'
            ]
        ]);
    }

    public function scanPeminjaman()
    {
        return view('peminjaman.scan', [
            'title' => 'Scan Peminjaman Buku',
        ]);
    }

    public function getLaporanPeminjaman(Request $request)
    {
        $pdf = Pdf::loadView('peminjaman.pdf', [
            'loans' => Loan::latest()->where('status', 'dipinjam')->get(),
            'title' => 'Laporan Peminjaman Buku'
        ]);

        return $pdf->stream('laporan.pdf');
    }

    public function exportTemplate()
    {
        return (new LoanExport)->download('peminjaman_template_' . Carbon::now()->microsecond . '.xlsx');
    }

    public function importData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(['status' => 'Data gagal diimport', 'error' => true]);
        }

        $reqFile = $request->file('file');

        Excel::import(new LoanImport, $reqFile);

        return redirect()->back()->with(['status' => 'Data sukses diimport', 'error' => false]);
    }

    // Pengembalian
    // public function pengembalian()
    // {
    //     return view('pengembalian.index', [
    //         'title' => 'pengembalian Buku',
    //         'returns' => Transaction::where('status', 'menunggu')->OrWhere('status', 'dikembalikan')->get()
    //     ]);
    // }

    // public function addPengembalian()
    // {
    //     return view('pengembalian.add', [
    //         'title' => 'Tambah Pengembalian Buku',
    //         'loans' => Transaction::where('status', 'dipinjam')->get()
    //     ]);
    // }

    // public function storePengembalian(Request $request)
    // {
    //     $request->validate([
    //         'transaction_loan_id' => 'required',
    //     ]);

    //     Transaction::find($request->transaction_loan_id)->update([
    //         'status' => 'dikembalikan',
    //         'tanggal_pengembalian' => Carbon::now()->toDateString()
    //     ]);

    //     return redirect('/transaksi/pengembalian')->with([
    //         'status' => 'Data berhasil ditambah'
    //     ]);
    // }

    // public function detailPengembalian(Transaction $transaction)
    // {
    //     return view('pengembalian.detail', [
    //         'title' => 'Detail Pengembalian Buku',
    //         'return' => $transaction
    //     ]);
    // }
}

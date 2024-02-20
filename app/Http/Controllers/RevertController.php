<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Revert;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevertController extends Controller
{
    public function pengembalian(Request $request)
    {
        if ($request->date) {
            return view('pengembalian.index', [
                'title' => 'Pengembalian Buku',
                'reverts' => Revert::latest()->where('tanggal_pengembalian', $request->date)->get()
            ]);
        }

        return view('pengembalian.index', [
            'title' => 'Pengembalian Buku',
            'reverts' => Revert::get()
        ]);
    }

    public function addPengembalian()
    {
        return view('pengembalian.add', [
            'title' => 'Tambah Pengembalian Buku',
            'loans' => Loan::where('status', 'dipinjam')->get(),
            'reverts' => Revert::get()
        ]);
    }

    public function detailPengembalian(Revert $revert)
    {
        return view('pengembalian.detail', [
            'title' => 'Detail Pengembalian Buku',
            'revert' => $revert,
        ]);
    }

    public function storePengembalian(Request $request)
    {
        $request->validate([
            'transaction_loan_id' => 'required',
        ]);

        DB::beginTransaction();

        try {
            Revert::create([
                'loan_id' => $request->transaction_loan_id,
                'tanggal_pengembalian' => Carbon::now()->toDateString(),
                'status' => 'dikembalikan'
            ]);

            Loan::find($request->transaction_loan_id)->update([
                'tanggal_pengembalian' => Carbon::now()->toDateString(),
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        // end

        return redirect('/transaksi/pengembalian')->with([
            'status' => 'Data berhasil ditambah'
        ]);
    }

    public function processPengembalian(Revert $revert)
    {
        $denda = 0;
        $terlambat = 0;

        $setting = Setting::first();

        $batasPengembalian = Carbon::create($revert->loan->tanggal_akhir)->addDay($setting->perpanjangan_hari);
        $tanggalPengembalian = Carbon::create(Carbon::now()->toDateString());

        if ($revert->loan->status == 'menunggu') {
            return back()->with([
                'status' => 'Harap proses peminjaman terlebih dahulu',
                'error' => true
            ]);
        }

        if ($tanggalPengembalian > $batasPengembalian) {
            $terlambat = $batasPengembalian->diffInDays($tanggalPengembalian);

            $denda = $terlambat * $setting->denda;
        }

        DB::beginTransaction();
        try {
            $revert->update([
                'status' => 'dikembalikan',
                'tanggal_pengembalian' => Carbon::now()->toDateString(),
                'denda' => $denda,
                'terlambat' => $terlambat
            ]);

            foreach ($revert->loan->books as $book) {
                $bookx = Book::find($book->id);
                $bookx->jumlah += 1;
                $bookx->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return back()->with([
            'status' => 'Data berhasil diproses'
        ]);
    }

    public function scanPengembalian()
    {
        return view('pengembalian.scan', [
            'title' => 'Scan Pengembalian Buku',
        ]);
    }

    public function getLaporanPengembalian(Request $request)
    {
        if ($request->date) {
            $pdf = Pdf::loadView('pengembalian.pdf', [
                'reverts' => Revert::latest()->where('tanggal_pengembalian', $request->date)->where('status', 'dikembalikan')->get(),
                'title' => 'Laporan Pengembalian Buku'
            ]);

            return $pdf->stream('laporan.pdf');
        }

        $pdf = Pdf::loadView('pengembalian.pdf', [
            'reverts' => Revert::where('status', 'dikembalikan')->get(),
            'title' => 'Laporan Pengembalian Buku'
        ]);

        return $pdf->stream('laporan.pdf');
    }
}

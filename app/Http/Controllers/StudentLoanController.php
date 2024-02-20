<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Revert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentLoanController extends Controller
{
    public function peminjaman()
    {
        return view('students.peminjaman.index', [
            'title' => 'Peminjaman Buku',
            'loans' => Loan::where('student_id', Auth::guard('student')->id())->get()
        ]);
    }

    public function detailPeminjam(Loan $loan)
    {
        return view('students.peminjaman.detail', [
            'title' => 'Detail Peminjaman Buku',
            'loan' => $loan
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

    // Pengembalian
    public function pengembalian()
    {
        return view('students.pengembalian.index', [
            'title' => 'Pengembalian Buku',
            // 'reverts' => Revert::withWhereHas('''student_id', Auth::guard('student')->id())->get()
            'reverts' => Revert::withWhereHas('loan', fn ($query) => $query->withWhereHas('student', fn ($query) => $query->where('id',  Auth::guard('student')->id())))->get()
        ]);
    }

    public function detailPengembalian(Revert $revert)
    {
        return view('students.pengembalian.detail', [
            'title' => 'Detail Pengembalian Buku',
            'revert' => $revert
        ]);
    }
}

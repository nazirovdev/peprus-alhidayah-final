<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Loan;
use App\Models\Revert;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function cart()
    {
        return view('students.keranjang.index', [
            'title' => 'Daftar Keranjang Buku Siswa',
            'carts' => Cart::with('book')->where('student_id', Auth::guard('student')->id())->get()
        ]);
    }

    public function cartPeminjaman()
    {
        $carts = Cart::where('student_id', Auth::guard('student')->id())->get();

        $maxLoan = 7;

        $tanggalMulai = Carbon::now()->addDays(1);
        $tanggalAkhir = Carbon::create($tanggalMulai->toDateString())->addDays($maxLoan - 1);

        $trxLoan = Loan::where('status', 'dipinjam')->count() + 1;
        $kdTransaksi = Carbon::now()->microsecond . Carbon::now()->day . Carbon::now()->year . $trxLoan;

        foreach ($carts as $cart) {
            DB::beginTransaction();
            try {
                $loanId = DB::table('loans')->insertGetId([
                    'kd_transaksi' => $kdTransaksi,
                    'student_id' => $cart->student_id,
                    'book_id' => $cart->book_id,
                    'tanggal_mulai' => $tanggalMulai->toDateString(),
                    'tanggal_akhir' => $tanggalAkhir->toDateString(),
                    'status' => 'dipinjam'
                ]);

                Revert::create([
                    'loan_id' => $loanId,
                    'tanggal_pengembalian' => null,
                    'status' => 'belum_dikembalikan'
                ]);

                Cart::find($cart->id)->delete();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        }

        return redirect('/dashboard/siswa/buku')->with([
            'status' => 'Data berhasil diproses'
        ]);
    }

    // API
    public function getCart(Request $request)
    {
        $book = Book::find($request->id);

        return response()->json([
            'data' => $book
        ]);
    }

    public function getCountCart()
    {
        return response()->json([
            'cart' => Cart::where('student_id', Auth::guard('student')->id())->count()
        ]);
    }

    public function storeCart(Request $request)
    {
        if (Cart::where('student_id', Auth::guard('student')->id())->where('book_id', $request->book_id)->count() >= 1) {
            return response()->json([
                'isError' => true,
                'cart_exist' => true,
                'message' => 'Buku sudah ditambah'
            ]);
        }

        if (Auth::guard('student')->user()->status == 'nonmember' && Cart::where('student_id', Auth::guard('student')->id())->count() >= 1) {
            return response()->json([
                'isError' => true,
                'message' => 'Peminjaman maksimal nonmember hanya 1x'
            ]);
        }

        Cart::create([
            'student_id' => Auth::guard('student')->id(),
            'book_id' => $request->book_id,
        ]);

        return response()->json([
            'student_id' => Auth::guard('student')->id(),
            'book_id' => $request->book_id,
        ]);
    }
}

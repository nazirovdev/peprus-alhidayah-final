<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\RackController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RevertController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentBookController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentLoanController;
use App\Http\Controllers\UserController;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Revert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/auth/user/login', [AuthController::class, 'authUserLogin'])->name('login');
    Route::post('/auth/user/login', [AuthController::class, 'proccessAuthUserLogin']);
});

Route::middleware('auth:web')->group(function () {
    Route::get('/auth/user/logout', [AuthController::class, 'proccessAuthUserLogout']);

    Route::get('/', function () {
        return view('dashboard.index', [
            'title' => 'Dashboard',
            'book' => Book::sum('jumlah'),
            'loan' => Loan::where('status', 'dipinjam')->count(),
            'revert' => Revert::where('status', 'dikembalikan')->count(),
            'stats' => Book::withCount('loans')->limit(3)->orderByDesc('loans_count')->get(),
        ]);
    });

    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/tambah', [UserController::class, 'add']);
    Route::post('/user/tambah', [UserController::class, 'store']);
    Route::get('/user/{user:id}', [UserController::class, 'edit']);
    Route::post('/user/edit/{user:id}', [UserController::class, 'update']);
    Route::delete('/user/delete/{user:id}', [UserController::class, 'delete']);
    Route::get('/user/export/template', [UserController::class, 'exportTemplate']);
    Route::post('/user/import', [UserController::class, 'importData']);

    Route::get('/kelas', [ClassroomController::class, 'index']);
    Route::get('/kelas/tambah', [ClassroomController::class, 'add']);
    Route::post('/kelas/tambah', [ClassroomController::class, 'store']);
    Route::get('/kelas/{classroom:id}', [ClassroomController::class, 'edit']);
    Route::put('/kelas/edit/{classroom:id}', [ClassroomController::class, 'update']);
    Route::delete('/kelas/delete/{classroom:id}', [ClassroomController::class, 'delete']);
    Route::get('/kelas/export/template', [ClassroomController::class, 'exportTemplate']);
    Route::post('/kelas/import', [ClassroomController::class, 'importData']);

    Route::get('/siswa', [StudentController::class, 'index']);
    Route::get('/siswa/tambah', [StudentController::class, 'add']);
    Route::post('/siswa/tambah', [StudentController::class, 'store']);
    Route::get('/siswa/{student:id}', [StudentController::class, 'edit']);
    Route::post('/siswa/edit/{student:id}', [StudentController::class, 'update']);
    Route::delete('/siswa/delete/{student:id}', [StudentController::class, 'delete']);
    Route::get('/siswa/export/template', [StudentController::class, 'exportTemplate']);
    Route::post('/siswa/import', [StudentController::class, 'importData']);

    Route::get('/kategori', [CategoryController::class, 'index']);
    Route::get('/kategori/tambah', [CategoryController::class, 'add']);
    Route::post('/kategori/tambah', [CategoryController::class, 'store']);
    Route::get('/kategori/{category:id}', [CategoryController::class, 'edit']);
    Route::put('/kategori/edit/{category:id}', [CategoryController::class, 'update']);
    Route::delete('/kategori/delete/{category:id}', [CategoryController::class, 'delete']);
    Route::get('/kategori/export/template', [CategoryController::class, 'exportTemplate']);
    Route::post('/kategori/import', [CategoryController::class, 'importData']);

    Route::get('/rak', [RackController::class, 'index']);
    Route::get('/rak/tambah', [RackController::class, 'add']);
    Route::post('/rak/tambah', [RackController::class, 'store']);
    Route::get('/rak/{rack:id}', [RackController::class, 'edit']);
    Route::put('/rak/edit/{rack:id}', [RackController::class, 'update']);
    Route::delete('/rak/delete/{rack:id}', [RackController::class, 'delete']);
    Route::get('/rak/export/template', [RackController::class, 'exportTemplate']);
    Route::post('/rak/import', [RackController::class, 'importData']);

    Route::get('/buku', [BookController::class, 'index']);
    Route::get('/buku/tambah', [BookController::class, 'add']);
    Route::post('/buku/tambah', [BookController::class, 'store']);
    Route::get('/buku/{book:id}', [BookController::class, 'edit']);
    Route::put('/buku/edit/{book:id}', [BookController::class, 'update']);
    Route::delete('/buku/delete/{book:id}', [BookController::class, 'delete']);
    Route::get('/buku/export/template', [BookController::class, 'exportTemplate']);
    Route::post('/buku/import', [BookController::class, 'importData']);
    // API
    Route::post('/api/buku', [BookController::class, 'getBook']);

    Route::get('/transaksi/peminjaman', [LoanController::class, 'peminjaman']);
    Route::get('/transaksi/peminjaman/tambah', [LoanController::class, 'addPeminjaman']);
    Route::post('/transaksi/peminjaman/tambah', [LoanController::class, 'storePeminjaman']);
    Route::get('/transaksi/peminjaman/detail/{loan:id}', [LoanController::class, 'detailPeminjam']);
    Route::get('/transaksi/peminjaman/proses/{loan:id}', [LoanController::class, 'processPeminjaman']);
    Route::delete('/transaksi/peminjaman/delete/{loan:id}', [LoanController::class, 'deletePeminjam']);
    Route::get('/peminjaman/scan', [LoanController::class, 'scanPeminjaman']);
    Route::get('/peminjaman/export/pdf', [LoanController::class, 'getLaporanPeminjaman']);
    Route::get('/peminjaman/export/template', [LoanController::class, 'exportTemplate']);
    Route::post('/peminjaman/import', [LoanController::class, 'importData']);

    Route::get('/transaksi/pengembalian', [RevertController::class, 'pengembalian']);
    Route::get('/transaksi/pengembalian/tambah', [RevertController::class, 'addPengembalian']);
    Route::post('/transaksi/pengembalian/tambah', [RevertController::class, 'storePengembalian']);
    Route::get('/transaksi/pengembalian/detail/{revert:id}', [RevertController::class, 'detailPengembalian']);
    Route::get('/transaksi/pengembalian/proses/{revert:id}', [RevertController::class, 'processPengembalian']);
    Route::get('/pengembalian/scan', [RevertController::class, 'scanPengembalian']);
    Route::get('/pengembalian/export/pdf', [RevertController::class, 'getLaporanPengembalian']);

    Route::get('/pengaturan', [SettingController::class, 'index']);
    Route::get('/pengaturan/{setting:id}', [SettingController::class, 'edit']);
    Route::put('/pengaturan/edit/{setting:id}', [SettingController::class, 'update']);

    // Laporan
    Route::get('/laporan/buku', [ReportController::class, 'book']);
    Route::post('/laporan/buku', [ReportController::class, 'bookFilter']);
    Route::get('/laporan/buku/qrcode', [ReportController::class, 'bookFilterQrCode']);
    Route::get('/laporan/peminjaman', [ReportController::class, 'loan']);
    Route::post('/laporan/peminjaman', [ReportController::class, 'loanFilter']);
    Route::get('/laporan/pengembalian', [ReportController::class, 'revert']);
    Route::post('/laporan/pengembalian', [ReportController::class, 'revertFilter']);
    Route::get('/laporan/siswa', [ReportController::class, 'student']);
    Route::post('/laporan/siswa', [ReportController::class, 'studentFilter']);
});

Route::middleware('guest')->group(function () {
    Route::get('/auth/siswa/login', [AuthController::class, 'authStudentLogin']);
    Route::post('/auth/siswa/login', [AuthController::class, 'proccessAuthStudentLogin']);
});

Route::middleware('auth:student')->group(function () {
    Route::get('/auth/siswa/logout', [AuthController::class, 'proccessAuthStudentLogout']);

    Route::get('/dashboard/siswa', function () {
        return view('students.dashboard.index', [
            'title' => 'Dashboard Siswa',
            'book' => Book::count(),
            'loan' => Loan::where('student_id', Auth::guard('student')->id())->where('status', 'dipinjam')->count(),
            // 'revert' => Revert::where('status', 'dikembalikan')->count(),
            'revert' => Revert::withWhereHas('loan', fn ($query) => $query->withWhereHas('student', fn ($query) => $query->where('id', Auth::guard()->id())))->where('status', 'dikembalikan')->count(),
            'stats' => Book::withCount('loan')->limit(3)->orderByDesc('loan_count')->get()
        ]);
    });

    Route::get('/dashboard/siswa/buku', [StudentBookController::class, 'index']);
    Route::get('/dashboard/siswa/buku/pinjam/{book:id}', [StudentBookController::class, 'bukuPinjam']);
    Route::post('/dashboard/siswa/buku/pinjam/{book:id}', [StudentBookController::class, 'storeBukuPinjam']);
    Route::get('/dashboard/siswa/transaksi/peminjaman', [StudentLoanController::class, 'peminjaman']);
    Route::get('/dashboard/siswa/transaksi/peminjaman/detail/{loan:id}', [StudentLoanController::class, 'detailPeminjam']);
    Route::delete('/dashboard/siswa/transaksi/peminjaman/delete/{loan:id}', [StudentLoanController::class, 'deletePeminjam']);

    Route::get('/dashboard/siswa/transaksi/pengembalian', [StudentLoanController::class, 'pengembalian']);
    Route::get('/dashboard/siswa/transaksi/pengembalian/detail/{revert:id}', [StudentLoanController::class, 'detailPengembalian']);

    Route::get('/dashboard/siswa/keranjang', [CartController::class, 'cart']);
    Route::get('/dashboard/siswa/keranjang/peminjaman', [CartController::class, 'cartPeminjaman']);

    // Cart
    Route::get('/cart', [CartController::class, 'getCart']);
    Route::post('/cart', [CartController::class, 'storeCart']);
    Route::get('/cart-count', [CartController::class, 'getCountCart']);
});

<?php

namespace App\Imports;

use App\Models\Loan;
use App\Models\Revert;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LoanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        DB::beginTransaction();
        try {
            $trxLoan = Loan::count() + 1;
            $kdTransaksi = Carbon::now()->microsecond . Carbon::now()->day . Carbon::now()->year . $trxLoan;

            $loanId = DB::table('loans')->insertGetId([
                'kd_transaksi' => $kdTransaksi,
                'student_id' => $row['student_id'],
                'book_id' => $row['book_id'],
                'tanggal_mulai' => $this->transformDate($row['tanggal_mulai']),
                'tanggal_akhir' => $this->transformDate($row['tanggal_akhir']),
                'status' => 'dipinjam'
            ]);

            Revert::create([
                'loan_id' => $loanId,
                'tanggal_pengembalian' => Carbon::create($this->transformDate($row['tanggal_akhir'])->toDateString())->addDays(1)->toDateString(),
                'status' => 'dikembalikan'
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function map(array $row): array
    {
        return [
            'tanggal_mulai' => 'C1',
            'tanggal_akhir' => 'D1'
        ];
    }

    public function transformDate(string $value): \Carbon\Carbon
    {
        return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    }
}

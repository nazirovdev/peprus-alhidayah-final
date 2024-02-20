<?php

namespace App\Exports;

use App\Models\Loan;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class LoanExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        return Loan::query();
    }

    public function map($loan): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'student_id',
            'book_id',
            'tanggal_mulai',
            'tanggal_akhir',
            'status'
        ];
    }
}

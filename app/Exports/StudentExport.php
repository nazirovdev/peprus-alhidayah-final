<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class StudentExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        return Student::query();
    }

    public function map($student): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'nis',
            'nama',
            'classroom_id',
            'alamat',
            'no_telepon',
            'jenis_kelamin',
        ];
    }
}

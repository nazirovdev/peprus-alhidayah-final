<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class UsersExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        return User::query();
    }

    public function map($classroom): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'username',
            'nama',
            'no_telepon',
            'role_id'
        ];
    }
}

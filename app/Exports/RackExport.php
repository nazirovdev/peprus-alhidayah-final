<?php

namespace App\Exports;

use App\Models\Rack;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class RackExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        return Rack::query();
    }

    public function map($student): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'nama',
        ];
    }
}

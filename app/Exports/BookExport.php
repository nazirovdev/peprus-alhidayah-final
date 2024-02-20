<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class BookExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        return Book::query();
    }

    public function map($student): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'isbn',
            'judul',
            'rack_id',
            'category_id',
            'pengarang',
            'penerbit',
            'tahun_terbit',
            'tanggal_masuk',
            'image'
        ];
    }
}

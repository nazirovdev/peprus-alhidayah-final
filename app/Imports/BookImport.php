<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BookImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Book([
            'isbn' => $row['isbn'],
            'judul' => $row['judul'],
            'rack_id' => $row['rack_id'],
            'category_id' => $row['category_id'],
            'pengarang' => $row['pengarang'],
            'penerbit' => $row['penerbit'],
            'tahun_terbit' => $row['tahun_terbit'],
            'tanggal_masuk' => $this->transformDate($row['tanggal_masuk']),
            'jumlah' => $row['jumlah'],
        ]);
    }

    public function map(array $row): array
    {
        return [
            'tanggal_masuk' => 'H1', // Adjust this based on the actual column for tanggal_presensi
        ];
    }

    public function transformDate(string $value): \Carbon\Carbon
    {
        return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    }
}

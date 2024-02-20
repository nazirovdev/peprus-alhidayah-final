<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Student([
            'nis' => $row['nis'],
            'nama' => $row['nama'],
            'classroom_id' => $row['classroom_id'],
            'alamat' => $row['alamat'],
            'no_telepon' => $row['no_telepon'],
            'jenis_kelamin' => $row['jenis_kelamin'],
        ]);
    }
}

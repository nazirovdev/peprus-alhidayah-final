<?php

namespace App\Imports;

use App\Models\Rack;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RackImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Rack([
            'nama' => $row['nama'],
        ]);
    }
}

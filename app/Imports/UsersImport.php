<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'username' => $row['username'],
            'nama' => $row['nama'],
            'no_telepon' => $row['no_telepon'],
            'role_id' => $row['role_id'],
        ]);
    }
}

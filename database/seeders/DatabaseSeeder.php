<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Role::create([
            'nama' => 'Admin'
        ]);

        Role::create([
            'nama' => 'Kepala Sekolah'
        ]);

        User::create([
            'nama' => 'Doni Setiawan',
            'username' => 'admin',
            'no_telepon' => '08112121',
            'image' => null,
            'password' => Hash::make(123)
        ]);

        Setting::create([
            'max_hari_pinjam' => 7,
            'denda' => 1000
        ]);
    }
}

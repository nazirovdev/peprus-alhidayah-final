<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting.index', [
            'title' => 'Pengaturan',
            'settings' => Setting::get()
        ]);
    }

    public function edit(Setting $setting)
    {
        return view('setting.edit', [
            'title' => 'Edit Pengaturan',
            'setting' => $setting
        ]);
    }

    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'max_hari_pinjam' => 'required',
            'denda' => 'required',
        ]);

        $setting->update([
            'max_hari_pinjam' => $request->max_hari_pinjam,
            'denda' => $request->denda,
        ]);

        return redirect('/pengaturan')->with([
            'status' => 'Data berhasil diupdate'
        ]);
    }
}

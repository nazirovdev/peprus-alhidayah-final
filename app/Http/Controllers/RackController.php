<?php

namespace App\Http\Controllers;

use App\Exports\RackExport;
use App\Imports\RackImport;
use App\Models\Rack;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class RackController extends Controller
{
    public function index()
    {
        return view('rack.index', [
            'title' => 'Rak Buku',
            'racks' => Rack::get()
        ]);
    }

    public function add()
    {
        return view('rack.add', [
            'title' => 'Tambah Rak Buku',
        ]);
    }

    public function edit(Rack $rack)
    {
        return view('rack.edit', [
            'title' => 'Edit Rak Buku',
            'rack' => $rack
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        Rack::create([
            'nama' => $request->nama,
        ]);

        return redirect('/rak')->with([
            'status' => 'Data berhasil disimpan'
        ]);
    }

    public function update(Request $request, Rack $rack)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $rack->update([
            'nama' => $request->nama,
        ]);

        return redirect('/rak')->with([
            'status' => 'Data berhasil diupdate'
        ]);
    }

    public function delete(Rack $rack)
    {
        $rack->delete();

        return response()->json([
            'data' => [
                'message' => 'Data berhasil dihapus'
            ]
        ]);
    }

    public function importData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(['status' => 'Data gagal diimport', 'error' => true]);
        }

        $reqFile = $request->file('file');

        Excel::import(new RackImport, $reqFile);

        return redirect()->back()->with(['status' => 'Data sukses diimport', 'error' => false]);
    }

    public function exportTemplate()
    {
        return (new RackExport)->download('rak_template_' . Carbon::now()->microsecond . '.xlsx');
    }
}

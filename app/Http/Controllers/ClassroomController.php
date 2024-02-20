<?php

namespace App\Http\Controllers;

use App\Exports\ClassroomExport;
use App\Imports\ClassroomImport;
use App\Models\Classroom;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ClassroomController extends Controller
{
    public function index()
    {
        return view('classroom.index', [
            'title' => 'Kelas',
            'classrooms' => Classroom::get()
        ]);
    }

    public function add()
    {
        return view('classroom.add', [
            'title' => 'Tambah Kelas'
        ]);
    }

    public function edit(Classroom $classroom)
    {
        return view('classroom.edit', [
            'title' => 'Edit Kelas',
            'classroom' => $classroom
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        Classroom::create([
            'nama' => $request->nama
        ]);

        return redirect('/kelas')->with([
            'status' => 'Data berhasil disimpan'
        ]);
    }

    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        $classroom->update([
            'nama' => $request->nama
        ]);

        return redirect('/kelas')->with([
            'status' => 'Data berhasil diupdate'
        ]);
    }

    public function delete(Classroom $classroom)
    {
        $classroom->delete();

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

        Excel::import(new ClassroomImport, $reqFile);

        return redirect()->back()->with(['status' => 'Data sukses diimport', 'error' => false]);
    }

    public function exportTemplate()
    {
        return (new ClassroomExport)->download('kelas_template_' . Carbon::now()->microsecond . '.xlsx');
    }
}

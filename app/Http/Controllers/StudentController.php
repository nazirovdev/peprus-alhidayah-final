<?php

namespace App\Http\Controllers;

use App\Exports\StudentExport;
use App\Imports\StudentImport;
use App\Models\Classroom;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index()
    {
        return view('student.index', [
            'title' => 'Siswa',
            'students' => Student::get()
        ]);
    }

    public function add()
    {
        return view('student.add', [
            'title' => 'Tambah Siswa',
            'classrooms' => Classroom::get()
        ]);
    }

    public function edit(Student $student)
    {
        return view('student.edit', [
            'title' => 'Edit Siswa',
            'student' => $student,
            'classrooms' => Classroom::get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'nama' => 'required',
            'classroom_id' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required',
            'jenis_kelamin' => 'required',
            'image' => 'image|max:2048'
        ]);

        $reqImage = $request->file('image');
        $newImageName = null;

        if ($reqImage != null) {
            $newImageName = $request->nis . '.' . $reqImage->getClientOriginalExtension();
            $reqImage->storeAs('siswa', $newImageName);
        }

        Student::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'classroom_id' => $request->classroom_id,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'image' => $newImageName
        ]);

        return redirect('/siswa')->with([
            'status' => 'Data berhasil disimpan'
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nis' => 'required',
            'nama' => 'required',
            'classroom_id' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        $status = 'null';

        $reqImage = $request->file('image');
        $newImageName = null;

        if ($reqImage != null) {
            $newImageName = $request->nis . '.' . $reqImage->getClientOriginalExtension();
            $reqImage->storeAs('siswa', $newImageName);
        }

        if ($request->status == 'on') {
            $status = 'member';
        } else {
            $status = 'nonmember';
        }

        $student->update([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'classroom_id' => $request->classroom_id,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status' => $status,
            'image' => $newImageName
        ]);

        return redirect('/siswa')->with([
            'status' => 'Data berhasil diupdate'
        ]);
    }

    public function delete(Student $student)
    {
        $student->delete();

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

        Excel::import(new StudentImport, $reqFile);

        return redirect()->back()->with(['status' => 'Data sukses diimport', 'error' => false]);
    }

    public function exportTemplate()
    {
        return (new StudentExport)->download('siswa_template_' . Carbon::now()->microsecond . '.xlsx');
    }
}

<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExport;
use App\Imports\CategoryImport;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index', [
            'title' => 'Kategori',
            'categories' => Category::get()
        ]);
    }

    public function add()
    {
        return view('category.add', [
            'title' => 'Tambah Kategori',
        ]);
    }

    public function edit(Category $category)
    {
        return view('category.edit', [
            'title' => 'Edit Kategori',
            'category' => $category
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        Category::create([
            'nama' => $request->nama,
        ]);

        return redirect('/kategori')->with([
            'status' => 'Data berhasil disimpan'
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $category->update([
            'nama' => $request->nama,
        ]);

        return redirect('/kategori')->with([
            'status' => 'Data berhasil diupdate'
        ]);
    }

    public function delete(Category $category)
    {
        $category->delete();

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

        Excel::import(new CategoryImport, $reqFile);

        return redirect()->back()->with(['status' => 'Data sukses diimport', 'error' => false]);
    }

    public function exportTemplate()
    {
        return (new CategoryExport)->download('kategori_template_' . Carbon::now()->microsecond . '.xlsx');
    }
}

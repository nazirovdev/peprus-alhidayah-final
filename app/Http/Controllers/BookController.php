<?php

namespace App\Http\Controllers;

use App\Exports\BookExport;
use App\Imports\BookImport;
use App\Models\Book;
use App\Models\Category;
use App\Models\Rack;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    public function index()
    {
        return view('book.index', [
            'title' => 'Buku',
            'books' => Book::get()
        ]);
    }

    public function add()
    {
        return view('book.add', [
            'title' => 'Tambah Buku',
            'racks' => Rack::get(),
            'categories' => Category::get()
        ]);
    }

    public function edit(Book $book)
    {
        return view('book.edit', [
            'title' => 'Edit Buku',
            'book' => $book,
            'racks' => Rack::get(),
            'categories' => Category::get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required|unique:books,isbn',
            'judul' => 'required',
            'jumlah' => 'required|integer',
            'rack_id' => 'required',
            'category_id' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'tanggal_masuk' => 'required',
            'image' => 'image|max:2048'
        ]);

        $reqImage = $request->file('image');
        $newImageName = null;

        if ($reqImage != null) {
            $newImageName = $request->isbn . '.' . $reqImage->getClientOriginalExtension();
            $reqImage->storeAs('buku', $newImageName);
        }

        Book::create([
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'jumlah' => $request->jumlah,
            'rack_id' => $request->rack_id,
            'category_id' => $request->category_id,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'tanggal_masuk' => $request->tanggal_masuk,
            'image' => $newImageName
        ]);

        return redirect('/buku')->with([
            'status' => 'Data berhasil disimpan'
        ]);
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'isbn' => 'required|unique:books,isbn,' . $book->id,
            'judul' => 'required',
            'jumlah' => 'required|integer',
            'rack_id' => 'required',
            'category_id' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'tanggal_masuk' => 'required',
            'image' => 'image|max:2048'
        ]);

        $reqImage = $request->file('image');
        $newImageName = null;

        if ($reqImage != null) {
            $newImageName = $request->isbn . '.' . $reqImage->getClientOriginalExtension();
            $reqImage->storeAs('buku', $newImageName);
        }

        $book->update([
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'jumlah' => $request->jumlah,
            'rack_id' => $request->rack_id,
            'category_id' => $request->category_id,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'tanggal_masuk' => $request->tanggal_masuk,
            'image' => $newImageName
        ]);

        return redirect('/buku')->with([
            'status' => 'Data berhasil diupdate'
        ]);
    }

    public function delete(Book $book)
    {
        $book->delete();

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

        Excel::import(new BookImport, $reqFile);

        return redirect()->back()->with(['status' => 'Data sukses diimport', 'error' => false]);
    }

    public function exportTemplate()
    {
        return (new BookExport)->download('buku_template_' . Carbon::now()->microsecond . '.xlsx');
    }

    // API
    public function getBook(Request $request)
    {
        return response()->json([
            'data' => [
                'book' => Book::find($request->id)
            ]
        ]);
    }
}

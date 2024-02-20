<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index', [
            'title' => 'User',
            'users' => User::get()
        ]);
    }

    public function add()
    {
        return view('user.add', [
            'title' => 'Tambah User',
            'roles' => Role::get(),
        ]);
    }

    public function edit(User $user)
    {
        return view('user.edit', [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => Role::get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'nama' => 'required',
            'no_telepon' => 'required',
            'image' => 'image|max:2048'
        ]);

        $reqImage = $request->file('image');
        $newImageName = null;

        if ($reqImage != null) {
            $newImageName = $request->username . '.' . $reqImage->getClientOriginalExtension();
            $reqImage->storeAs('user', $newImageName);
        }

        User::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'image' => $newImageName,
            'role_id' => $request->role_id
        ]);

        return redirect('/user')->with([
            'status' => 'Data berhasil disimpan'
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'nama' => 'required',
            'no_telepon' => 'required',
            'image' => 'image|max:2048'
        ]);

        $reqImage = $request->file('image');
        $newImageName = null;

        if ($reqImage != null) {
            $newImageName = $request->username . '.' . $reqImage->getClientOriginalExtension();
            $reqImage->storeAs('user', $newImageName);
        }

        $user->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'image' => $newImageName,
            'role_id' => $request->role_id
        ]);

        return redirect('/user')->with([
            'status' => 'Data berhasil diupdate'
        ]);
    }

    public function delete(User $user)
    {
        $user->delete();

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

        Excel::import(new UsersImport, $reqFile);

        return redirect()->back()->with(['status' => 'Data sukses diimport', 'error' => false]);
    }

    public function exportTemplate()
    {
        return (new UsersExport)->download('user_template_' . Carbon::now()->microsecond . '.xlsx');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class RoleController extends Controller
{
    public function index(Request $request): View
    {
        // jumlah data yang ditampilkan per paginasi halaman
        $pagination = 10;

        if ($request->search) {
            // menampilkan pencarian data
            $role = Role::select('id', 'nama')
                ->where('nama', 'LIKE', '%' . $request->search . '%')
                ->paginate($pagination)
                ->withQueryString();
        } else {
            // menampilkan semua data
            $role = Role::select('id', 'nama')
                ->orderBy('nama', 'asc')
                ->paginate($pagination);
        }

        // tampilkan data ke view
        return view('user.role', compact('role'))->with('i', ($request->input('page', 1) - 1) * $pagination);
    }

    public function create(): View
    {
        // tampilkan form tambah data
        return view('user.create-role');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // validasi form
        $request->validate([
            'nama' => 'required|unique:role'
        ], [
            'nama.required' => 'Role tidak boleh kosong.',
            'nama.unique'   => 'Role dokumen sudah ada.'
        ]);

        // simpan data
        Role::create([
            'nama' => $request->nama
        ]);

        // redirect ke halaman index dan tampilkan pesan berhasil simpan data
        return redirect()->route('role.role')->with('success', 'Role berhasil disimpan.');
    }

    public function edit($id): View
    {
        // ambil data role berdasarkan id
        $role = Role::findOrFail($id);

        // tampilkan form edit dengan data role
        return view('user.edit-role', compact('role'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // validasi form
        $request->validate([
            'nama' => 'required|unique:role,nama,' . $id
        ], [
            'nama.required' => 'Role tidak boleh kosong.',
            'nama.unique'   => 'Role dokumen sudah ada.'
        ]);

        // cari data role berdasarkan id dan update
        $role = Role::findOrFail($id);
        $role->update([
            'nama' => $request->nama
        ]);

        // redirect ke halaman index dengan pesan sukses
        return redirect()->route('role.role')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        // cari data berdasarkan id
        $role = Role::findOrFail($id);

        // hapus data
        $role->delete();

        // redirect ke halaman role dengan pesan sukses
        return redirect()->route('role.role')->with('success', 'Role berhasil dihapus.');
    }
}

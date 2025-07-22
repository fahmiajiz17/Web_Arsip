<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // jumlah data yang ditampilkan per paginasi halaman
        $pagination = 10;
        $role = Role::all();

        if ($request->search) {
            $user = User::with('roles')
                ->select('id', 'nama_user', 'username', 'role', 'foto')
                ->whereAny(['nama_user', 'username'], 'LIKE', '%' . $request->search . '%')
                ->paginate($pagination)
                ->withQueryString();
        } else {
            $user = User::with('roles')
                ->select('id', 'nama_user', 'username', 'role', 'foto')
                ->orderBy('nama_user', 'asc')
                ->paginate($pagination);
        }

        // tampilkan data ke view
        return view('user.index', compact('user', 'role'))->with('i', ($request->input('page', 1) - 1) * $pagination);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $role = Role::all();
        // tampilkan form tambah data
        return view('user.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Catat data yang diterima
        Log::info('Data yang diterima:', $request->all());

        // Validasi form
        $request->validate([
            'nama_user' => 'required',
            'username'  => 'required|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-zA-Z]/',     // harus ada huruf
                'regex:/[0-9]/',        // harus ada angka
                'regex:/[@$!%*#?&]/',   // harus ada simbol
            ],
            'role'      => 'required|exists:role,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_user.required' => 'Nama user tidak boleh kosong.',
            'username.required'  => 'Username tidak boleh kosong.',
            'username.unique'    => 'Username sudah ada.',
            'password.required'  => 'Password tidak boleh kosong.',
            'password.regex' => 'Password harus mengandung huruf, angka, dan simbol.',
            'password.min' => 'Password minimal 8 karakter.',
            'role.required'      => 'Role tidak boleh kosong.',
            'role.exists'        => 'Role yang dipilih tidak valid.'
        ]);

        // Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_user', 'public');
        }

        // Simpan data user
        $user = User::create([
            'nama_user' => $request->nama_user,
            'username'  => $request->username,
            'password'  => bcrypt($request->password),
            'role'      => $request->role,
            'foto' => $fotoPath,
        ]);

        // Log informasi data yang berhasil disimpan
        Log::info('Data user berhasil dibuat:', ['id' => $user->id]);

        // Redirect ke halaman index setelah berhasil simpan
        return redirect()->route('user.index')->with('success', 'Data user berhasil disimpan.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        // dapatkan data berdasarakan "id"
        $user = User::findOrFail($id);

        $role = Role::all();
        // tampilkan form ubah data
        return view('user.edit', compact('user', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // validasi form
        $request->validate([
            'nama_user' => 'required',
            'username'  => 'required|unique:users,username,' . $id,
            'role'      => 'required|exists:role,id',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // max 2MB
        ], [
            'nama_user.required' => 'Nama user tidak boleh kosong.',
            'username.required'  => 'Username tidak boleh kosong.',
            'username.unique'    => 'Username sudah ada.',
            'role.required'      => 'Role tidak boleh kosong.',
            'role.in'            => 'Role yang dipilih tidak valid.',
        ]);

        // ambil data user
        $user = User::findOrFail($id);

        // simpan data input ke array update
        $dataUpdate = [
            'nama_user' => $request->nama_user,
            'username'  => $request->username,
            'role'      => $request->role,
        ];

        // jika password diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[a-zA-Z]/',     // harus ada huruf
                    'regex:/[0-9]/',        // harus ada angka
                    'regex:/[@$!%*#?&]/',   // harus ada simbol
                ],
            ], [
                'password.required' => 'Password tidak boleh kosong.',
                'password.regex'    => 'Password harus mengandung huruf, angka, dan simbol.',
                'password.min'      => 'Password minimal 8 karakter.',
            ]);

            $dataUpdate['password'] = bcrypt($request->password);
        }

        // jika ada file foto baru
        if ($request->hasFile('foto')) {
            // hapus foto lama jika ada
            if ($user->foto && \Illuminate\Support\Facades\Storage::exists('public/' . $user->foto)) {
                \Illuminate\Support\Facades\Storage::delete('public/' . $user->foto);
            }

            // simpan foto baru ke folder 'foto_user'
            $fotoPath = $request->file('foto')->store('foto_user', 'public');
            $dataUpdate['foto'] = $fotoPath;
        }

        // update data ke database
        $user->update($dataUpdate);

        // redirect ke halaman index
        return redirect()->route('user.index')->with('success', 'Data user berhasil diubah.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dapatkan data berdasarakan "id"
        $user = User::findOrFail($id);

        // hapus data
        $user->delete();

        // redirect ke halaman index dan tampilkan pesan berhasil hapus data
        return redirect()->route('user.index')->with('success', 'Data user berhasil dihapus.');
    }
}

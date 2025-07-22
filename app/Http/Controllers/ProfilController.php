<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfilController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function index(): View
    {
        // dapatkan data berdasarakan "id"
        $profil = Profil::findOrFail(1);

        // tampilkan data ke view
        return view('profil.index', compact('profil'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(): View
    {
        // dapatkan data berdasarakan "id"
        $profil = Profil::findOrFail(1);

        // tampilkan form ubah data
        return view('profil.edit', compact('profil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
{
    // validasi form
    $request->validate([
        'nama_aplikasi'          => 'required',
        'kepanjangan_aplikasi'   => 'required',
        'nama_copyright'         => 'required',
        'logo_kerjasama'         => 'image|mimes:jpeg,jpg,png|max:1024',
        'logo_instansi'          => 'image|mimes:jpeg,jpg,png|max:1024'
    ], [
        'nama_aplikasi.required'        => 'Nama Aplikasi tidak boleh kosong.',
        'kepanjangan_aplikasi.required' => 'Kepanjangan Nama Aplikasi tidak boleh kosong.',
        'nama_copyright.required'       => 'Nama Copyright tidak boleh kosong.',
        'logo_kerjasama.image'          => 'Logo harus berupa file gambar dengan jenis: jpeg, jpg, png.',
        'logo_kerjasama.mimes'          => 'Logo harus berupa file dengan jenis: jpeg, jpg, png.',
        'logo_kerjasama.max'            => 'Logo tidak boleh lebih besar dari 1 MB.',
        'logo_instansi.image'           => 'Logo harus berupa file gambar dengan jenis: jpeg, jpg, png.',
        'logo_instansi.mimes'           => 'Logo harus berupa file dengan jenis: jpeg, jpg, png.',
        'logo_instansi.max'             => 'Logo tidak boleh lebih besar dari 1 MB.'
    ]);

    // dapatkan data berdasarkan ID
    $profil = Profil::findOrFail(1);

    $data = [
        'nama_aplikasi'        => $request->nama_aplikasi,
        'kepanjangan_aplikasi' => $request->kepanjangan_aplikasi,
        'nama_copyright'       => $request->nama_copyright,
    ];

    // jika ada file logo_kerjasama
    if ($request->hasFile('logo_kerjasama')) {
        $logoKerjasama = $request->file('logo_kerjasama');
        $logoKerjasama->storeAs('public/logo', $logoKerjasama->hashName());

        // hapus logo lama jika ada
        if ($profil->logo_kerjasama) {
            Storage::delete('public/logo/' . $profil->logo_kerjasama);
        }

        // simpan nama file baru
        $data['logo_kerjasama'] = $logoKerjasama->hashName();
    }

    // jika ada file logo_instansi
    if ($request->hasFile('logo_instansi')) {
        $logoInstansi = $request->file('logo_instansi');
        $logoInstansi->storeAs('public/logo', $logoInstansi->hashName());

        // hapus logo lama jika ada
        if ($profil->logo_instansi) {
            Storage::delete('public/logo/' . $profil->logo_instansi);
        }

        // simpan nama file baru
        $data['logo_instansi'] = $logoInstansi->hashName();
    }

    // update data
    $profil->update($data);

    // redirect ke halaman index dan tampilkan pesan berhasil
    return redirect()->route('profil.index')->with('success', 'Profil instansi berhasil diubah.');
}
}
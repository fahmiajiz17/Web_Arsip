<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DasarHukum;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class DasarHukumController extends Controller
{
    public function index(Request $request): View
    {
        $perPage = $request->input('perPage', 5);


        if ($request->search) {
            $search = $request->search;
            $dasar_hukum = DasarHukum::select('id_dasar_hukum', 'nama_dasar_hukum')
                ->where(function ($query) use ($search) {
                    $query->where('nama_dasar_hukum', 'LIKE', "%$search%");
                })
                ->paginate($perPage)
                ->withQueryString();
        } else {
            $dasar_hukum = DasarHukum::select('id_dasar_hukum', 'nama_dasar_hukum')
                ->orderBy('id_dasar_hukum', 'asc') // ganti ke 'id_klasifikasi' jika memang nama kolomnya seperti itu
                ->paginate($perPage);
        }

        return view('arsip.dasarhukum.index', compact('dasar_hukum'))
            ->with('i', ($request->input('page', 1) - 1) * $perPage);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // ambil data jenis
        $dasar_hukum = DasarHukum::select('id_dasar_hukum', 'nama_dasar_hukum')
            ->orderBy('nama_dasar_hukum', 'asc')
            ->get();

        // tampilkan form tambah data arsip dengan data jenis
        return view('arsip.dasarhukum.create', compact('dasar_hukum'));
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        // dapatkan data berdasarakan "id"
        $dasar_hukum = DasarHukum::findOrFail($id);

        // tampilkan form detail data
        return view('arsip.dasarhukum.show', compact('dasar_hukum'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // validasi form
        $request->validate([
            'nama_dasar_hukum' => 'required',
            'dokumen_dasar_hukum' => 'required|file|mimes:pdf|max:5120'
        ], [
            'nama_dasar_hukum.required' => 'Nama dasar hukum tidak boleh kosong',
            'dokumen_dasar_hukum.required' => 'Dokumen tidak boleh kosong.',
            'dokumen_dasar_hukum.file'     => 'Dokumen harus berupa file.',
            'dokumen_dasar_hukum.mimes'    => 'Dokumen harus berupa file dengan jenis: pdf.',
            'dokumen_dasar_hukum.max'      => 'Dokumen tidak boleh lebih besar dari 5 MB.'
        ]);

        $filename = null;

        if ($request->hasFile('dokumen_dasar_hukum')) {
            $file = $request->file('dokumen_dasar_hukum');

            // Simpan dengan nama asli + timestamp
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . preg_replace('/\s+/', '_', $originalName) . '.' . $extension;

            $file->storeAs('public/dasarhukum', $filename);
        }

        DasarHukum::create([
            'nama_dasar_hukum' => $request->nama_dasar_hukum,
            'dokumen_dasar_hukum' => $filename,
        ]);

        return redirect()->route('dasarhukum.index')->with('success', 'Data dasar hukum berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        // dapatkan data berdasarakan "id"
        $dasar_hukum = DasarHukum::findOrFail($id);

        // tampilkan form ubah data
        return view('arsip.dasarhukum.edit', compact('dasar_hukum'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_dasar_hukum' => 'required|string|max:255',
            'dokumen_dasar_hukum' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $dasar_hukum = DasarHukum::findOrFail($id);
        $dasar_hukum->nama_dasar_hukum = $request->nama_dasar_hukum;

        if ($request->hasFile('dokumen_dasar_hukum')) {
            // Hapus file lama jika ada
            if ($dasar_hukum->dokumen_dasar_hukum && Storage::disk('public')->exists('dasarhukum/' . $dasar_hukum->dokumen_dasar_hukum)) {
                Storage::disk('public')->delete('dasarhukum/' . $dasar_hukum->dokumen_dasar_hukum);
            }

            // Simpan file baru dengan nama asli + timestamp
            $file = $request->file('dokumen_dasar_hukum');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . preg_replace('/\s+/', '_', $originalName) . '.' . $extension;

            $file->storeAs('public/dasarhukum', $filename);
            $dasar_hukum->dokumen_dasar_hukum = $filename;
        }

        $dasar_hukum->save();
        return redirect()->route('dasarhukum.show', $id)->with('success', 'Data berhasil diperbarui.');
    }

    public function replaceFile(Request $request, $id)
    {
        $dasar_hukum = DasarHukum::findOrFail($id);

        $request->validate([
            'file' => 'required|file|mimes:pdf|max:5120',
        ]);

        // Hapus file lama
        if ($dasar_hukum->dokumen_dasar_hukum && Storage::disk('public')->exists('dasarhukum/' . $dasar_hukum->dokumen_dasar_hukum)) {
            Storage::disk('public')->delete('dasarhukum/' . $dasar_hukum->dokumen_dasar_hukum);
        }

        // Simpan file baru
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('dasarhukum', $filename, 'public');

        $dasar_hukum->dokumen_dasar_hukum = $filename;
        $dasar_hukum->save();

        return redirect()->route('dasarhukum.show', $id)->with('success', 'File berhasil diganti.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        // dapatkan data berdasarakan "id"
        $dasar_hukum = DasarHukum::findOrFail($id);

        // hapus file
        Storage::delete('public/dasarhukum/' . $dasar_hukum->dokumen_dasar_hukum);

        // hapus data
        $dasar_hukum->delete();

        // redirect ke halaman index dan tampilkan pesan berhasil hapus data
        return redirect()->route('dasarhukum.index')->with('success', 'Data dokumen dasar berhasil dihapus.');
    }
}

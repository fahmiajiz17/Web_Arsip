<?php

namespace App\Http\Controllers;

use App\Models\PanduanPenggunaan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\PanduanExport;
use Maatwebsite\Excel\Facades\Excel;

class PanduanPenggunaanController extends Controller
{
    public function index(Request $request): View
    {
        // Ambil nilai perPage dari query, default ke 10
        $perPage = $request->input('perPage', 5);
        $search = $request->input('search');

        // Query dasar
        $query = PanduanPenggunaan::select('id_panduan', 'nama_dokumen', 'dokumen_panduan');

        // Filter jika ada pencarian
        if ($search) {
            $query->where('nama_dokumen', 'LIKE', '%' . $search . '%');
        }

        // Pagination + query string untuk membawa search/perPage saat klik halaman berikutnya
        $panduan = $query->orderBy('nama_dokumen', 'asc')
            ->paginate($perPage)
            ->withQueryString();

        // Kirim ke view
        return view('arsip.panduan.index', compact('panduan'))
            ->with('i', ($request->input('page', 1) - 1) * $perPage);
    }


    public function create(): View
    {
        return view('arsip.panduan.create');
    }

    public function show(string $id): View
    {
        $panduan = PanduanPenggunaan::findOrFail($id);
        return view('arsip.panduan.show', compact('panduan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_dokumen' => 'required',
            'dokumen_panduan' => 'required|array',
            'dokumen_panduan.*' => 'file|mimes:pdf',
        ]);

        $totalSize = 0;
        if ($request->hasFile('dokumen_panduan')) {
            foreach ($request->file('dokumen_panduan') as $file) {
                $totalSize += $file->getSize(); // dalam byte
            }
        }

        // Batas ukuran total file: 5 MB = 5 * 1024 * 1024 byte
        if ($totalSize > 5 * 1024 * 1024) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['dokumen_panduan' => 'Gagal menyimpan! Total ukuran file melebihi 5 MB.']);
        }

        $filePaths = [];
        if ($request->hasFile('dokumen_panduan')) {
            foreach ($request->file('dokumen_panduan') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/panduan', $filename);
                $filePaths[] = $filename;
            }
        }

        PanduanPenggunaan::create([
            'nama_dokumen' => $request->nama_dokumen,
            'dokumen_panduan' => $filePaths, // stored as JSON
        ]);

        return redirect()->route('panduan.index')->with('success', 'Data berhasil disimpan.');
    }
    public function edit(string $id): View
    {
        $panduan = PanduanPenggunaan::findOrFail($id);
        return view('arsip.panduan.edit', compact('panduan'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_dokumen' => 'required',
        ]);

        $panduan = PanduanPenggunaan::findOrFail($id);

        $data = [
            'nama_dokumen' => $request->nama_dokumen,
        ];

        $panduan->update($data);

        return redirect()->route('panduan.index')->with('success', 'Data panduan berhasil diubah.');
    }

    public function destroy($id): RedirectResponse
    {
        $panduan = PanduanPenggunaan::findOrFail($id);

        $files = is_string($panduan->dokumen_panduan)
            ? json_decode($panduan->dokumen_panduan, true)
            : $panduan->dokumen_panduan;

        if (is_array($files)) {
            foreach ($files as $file) {
                Storage::disk('public')->delete('panduan/' . $file);
            }
        }

        $panduan->delete();

        return redirect()->route('panduan.index')->with('success', 'Data panduan berhasil dihapus.');
    }

    public function replaceFile(Request $request, $id, $index): RedirectResponse
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:5120',
        ]);

        $panduan = PanduanPenggunaan::findOrFail($id);
        $files = is_string($panduan->dokumen_panduan)
            ? json_decode($panduan->dokumen_panduan, true)
            : $panduan->dokumen_panduan;

        if (!isset($files[$index])) {
            return back()->withErrors(['File tidak ditemukan.']);
        }

        // Hapus file lama
        Storage::disk('public')->delete('panduan/' . $files[$index]);

        // Simpan file baru
        $uploadedFile = $request->file('file');
        $newFilename = time() . '_' . $uploadedFile->getClientOriginalName();
        $uploadedFile->storeAs('panduan', $newFilename, 'public');

        // Ganti di array
        $files[$index] = $newFilename;
        $panduan->dokumen_panduan = json_encode($files);
        $panduan->save();

        return redirect()->route('panduan.edit', $id)->with('success', 'File berhasil diganti.');
    }

    public function deleteFile($id, $index): RedirectResponse
    {
        $panduan = PanduanPenggunaan::findOrFail($id);

        $files = is_string($panduan->dokumen_panduan)
            ? json_decode($panduan->dokumen_panduan, true)
            : $panduan->dokumen_panduan;

        if (!isset($files[$index])) {
            return back()->withErrors(['File tidak ditemukan.']);
        }

        // Hapus file dari storage
        Storage::disk('public')->delete('panduan/' . $files[$index]);

        // Hapus file dari array
        unset($files[$index]);
        $files = array_values($files); // reset index array biar tetap rapi

        // Simpan perubahan
        $panduan->dokumen_panduan = json_encode($files);
        $panduan->save();

        return back()->with('success', 'File berhasil dihapus.');
    }


    public function export()
    {
        return Excel::download(new PanduanExport, 'Panduan_Penggunaan_SIPADI_LLDIKTI4.xlsx');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DasarHukum;
use App\Models\Klasifikasi;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Arsip extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    // Tentukan nama tabel jika berbeda dari nama model
    protected $table = 'arsip';

    // Tentukan primary key jika bukan "id"
    protected $primaryKey = 'nomor_dokumen';

    // Untuk Laravel 8 dan sebelumnya
    protected $dates = ['tanggal_arsip'];

    // Untuk Laravel 9+
    protected $casts = [
        'tanggal_arsip' => 'datetime',
        'arsip_dokumen' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_dokumen',
        'nama_dokumen',
        'tanggal_arsip',
        'deskripsi_arsip',
        'dasar_hukum',
        'klasifikasi',
        'jadwal_retensi_arsip_aktif',
        'jadwal_retensi_arsip_inaktif',
        'penyusutan_akhir',
        'keterangan_penyusutan',
        'keamanan_arsip',
        'lokasi_penyimpanan',
        'filling_cabinet',
        'laci',
        'folder',
        'kata_kunci',
        'verifikasi_arsip',
        'catatan_revisi',
        'status_dokumen',
        'dibuat_oleh',
        'disetujui_oleh',
        'batas_status_retensi_aktif',
        'batas_status_retensi_inaktif',
        'vital',
        'terjaga',
        'memori_kolektif_bangsa',
        'arsip_dokumen',
        'status_musnah',
        'surat_berita_path',
    ];

    /**
     * Relasi Kategori
     */
    // Tentukan relasi dengan tabel dasar_hukum
    // Di Arsip.php
    public function dasarHukum()
    {
        return $this->belongsTo(DasarHukum::class, 'dasar_hukum', 'id_dasar_hukum');
    }


    public function dasarHukumData()
    {
        return $this->belongsTo(DasarHukum::class, 'dasar_hukum');
    }

    public function klasifikasiData()
    {
        return $this->belongsTo(Klasifikasi::class, 'klasifikasi', 'id_klasifikasi');
    }

    public function klasifikasiDataExport()
    {
        return $this->belongsTo(Klasifikasi::class, 'klasifikasi');
    }

    // Tentukan mutator untuk memastikan bahwa tanggal_arsip disimpan dalam format yang benar
    public function setTanggalArsipAttribute($value)
    {
        $this->attributes['tanggal_arsip'] = \Carbon\Carbon::createFromFormat('Y-m-d', $value);
    }

    // Tentukan accessor untuk tanggal_arsip jika perlu diubah saat menampilkan
    public function getTanggalArsipAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }

    // Tentukan relasi lain jika ada
    public function user()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function disetujuiOlehUser()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    public function logStatus()
    {
        return $this->hasMany(LogStatusDokumen::class, 'nomor_dokumen', 'nomor_dokumen');
    }
    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function arsipDibuat()
    {
        return $this->hasMany(\App\Models\Arsip::class, 'dibuat_oleh');
    }

    public static function countByStatusForUser($status, $user)
    {
        if (in_array($user->role, [1, 2, 3])) {
            return self::where('status_dokumen', $status)->count();
        } else {
            return self::where('status_dokumen', $status)->where('dibuat_oleh', $user->id)->count();
        }
    }
}

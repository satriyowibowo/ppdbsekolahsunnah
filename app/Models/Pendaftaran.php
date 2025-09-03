<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Pendaftaran extends Model
{
    protected $table = 'pendaftarans';
    protected $fillable = [
        'uuid',
        'nomor_registrasi', 'gelombang_id', 'jenjang', 'jenis_kelamin',
        'tipe_santri', 'kelas', 'nama_lengkap', 'nama_panggilan',
        'jenis_kelamin_santri', 'tempat_lahir', 'tanggal_lahir',
        'usia_pendaftaran', 'anak_ke', 'dari_berapa_bersaudara',
        'status_dalam_keluarga', 'alamat_lengkap', 'catatan_khusus',
        'asal_sekolah', 'nama_ayah', 'pekerjaan_ayah', 'penghasilan_ayah',
        'alamat_ayah', 'kontak_ayah', 'nama_ibu', 'pekerjaan_ibu',
        'penghasilan_ibu', 'alamat_ibu', 'kontak_ibu', 'status_orang_tua',
        'wali_penanggung_jawab', 'nama_wali', 'pekerjaan_wali',
        'penghasilan_wali', 'alamat_wali', 'kontak_wali', 'pas_foto_path',
        'bukti_transfer_path',
        'nik',
        'nisn'
    ];

    protected $dates = ['tanggal_lahir'];
    
    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class);
    }
    
    public static function generateNomorRegistrasi($gelombangId, $kelas, $jenjang)
    {
        $gelombang = Gelombang::find($gelombangId);
        $tahunAjaran = now()->format('y') . (now()->format('y') + 1);
        $nomorUrut = Pendaftaran::where('gelombang_id', $gelombangId)->count() + 1;

        $kodeJenjang = $jenjang == 'KAUD' ? 'R' : 'K';

        $kodeKelas = $jenjang == 'KAUD' ?
                    ($kelas == 'A' ? '1' : '2') :
                    $kelas;
        
        return $tahunAjaran . 
            'G' . $gelombang->nomor_gelombang . 
            $kodeJenjang .
            $kodeKelas . 
            str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
    }
    
    public static function hitungUsia($tanggalLahir)
    {
        $tanggalReferensi = Carbon::create(2026, 7, 1);
        $usia = $tanggalLahir->diff($tanggalReferensi);
        
        return "{$usia->y} tahun {$usia->m} bulan {$usia->d} hari";
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
        
        static::saving(function ($model) {
            $fieldsToCapitalize = [
                'nama_lengkap',
                'nama_panggilan',
                'tempat_lahir',
                'status_dalam_keluarga',
                'alamat_lengkap',
                'catatan_khusus',
                'asal_sekolah',
                'nik',
                'nisn',
                'nama_ayah',
                'pekerjaan_ayah',
                'penghasilan_ayah',
                'alamat_ayah',
                'nama_ibu',
                'pekerjaan_ibu',
                'penghasilan_ibu',
                'alamat_ibu',
                'nama_wali',
                'pekerjaan_wali',
                'penghasilan_wali',
                'alamat_wali'
            ];

            foreach ($fieldsToCapitalize as $field) {
                if (!empty($model->$field)) {
                    $model->$field = strtoupper($model->$field);
                }
            }
        });

    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Helpers\DateHelper;

class Gelombang extends Model
{
    protected $table = 'gelombangs';
    protected $fillable = [
        'nomor_gelombang', 
        'tanggal_mulai', 
        'tanggal_selesai', 
        'status'
    ];
    
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];
    
    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
    
    public function getPeriodeAttribute()
    {
        $mulai = Carbon::parse($this->tanggal_mulai);
        $selesai = Carbon::parse($this->tanggal_selesai);
        
        return "Gelombang {$this->nomor_gelombang} (" . 
            DateHelper::indonesianFormat($this->tanggal_mulai) . " - " . 
            DateHelper::indonesianFormat($this->tanggal_selesai) . ")";
    }
}
<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function indonesianFormat($date)
    {
        $date = Carbon::parse($date);
        
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        
        return $date->format('d') . ' ' . $bulan[$date->format('n') - 1] . ' ' . $date->format('Y');
    }
}
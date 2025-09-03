@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header text-center bg-success text-white">
                <h3>Pendaftaran Berhasil!</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-success text-center">
                    <h4>Nomor Registrasi: {{ $pendaftaran->nomor_registrasi }}</h4>
                </div>
                
                <p>Terima kasih telah mengisi formulir pendaftaran. Data Anda telah berhasil disimpan.</p>
                <p>Silakan simpan nomor registrasi di atas untuk keperluan selanjutnya.</p>
                <div class="alert alert-info mt-4">
                    <h5>Persyaratan Dokumen yang Harus Diserahkan:</h5>
                    <ol>
                        <li>Fotokopi Kartu Keluarga (KK) 2 lembar</li>
                        <li>Fotokopi Akta Kelahiran 2 lembar</li>
                        <li>Fotokopi KTP Orang Tua 2 lembar</li>
                        @if($pendaftaran->status_orang_tua === 'Hanya Ibu' || $pendaftaran->status_orang_tua === 'Tidak Keduanya')
                        <li>Akta Kematian Ayah (bagi yatim) 2 lembar</li>
                        @endif
                        <li>Pas foto 3x4 (yang telah diupload)</li>
                        <li>Bukti transfer formulir (yang telah diupload)</li>
                    </ol>
                    
                    <h5>Alamat Penyerahan Dokumen:</h5>
                    <p>
                        <strong>Panitia PPDB Miftahu Khairil Ummah</strong><br>
                        Ruang Kantor Ikhwan Miftahu Khairil Ummah<br>
                        Taman Wisma Asri II, Jl. Delima V Blok D14<br>
                        Teluk Pucung, Bekasi Utara, Kota Bekasi, Jawa Barat 17125<br>
                        <strong>Kontak:</strong> (021) 8888-8888 / 0812-3456-7890
                    </p>
                    
                    <h5>Catatan Penting:</h5>
                    <ul>
                        <li>Formulir ini harus dicetak dan ditandatangani oleh orang tua/wali</li>
                        <li>Bawa formulir beserta persyaratan dokumen ke alamat di atas</li>
                        <li>Proses verifikasi akan dilakukan setelah penyerahan dokumen</li>
                        <li>Simpan bukti transfer sebagai arsip pribadi</li>
                    </ul>
                </div>                
                <div class="mt-4">
                    <a href="{{ route('pendaftaran.cetak', $pendaftaran->uuid) }}" target="_blank" class="btn btn-primary me-2">
                        <i class="bi bi-printer"></i> Cetak Formulir
                    </a>
                    <a href="{{ route('pendaftaran.pdf', $pendaftaran->uuid) }}" class="btn btn-success">
                        <i class="bi bi-file-earmark-pdf"></i> Simpan sebagai PDF
                    </a>
                </div>
                <a href="{{ route('pendaftaran.jenjang') }}" class="btn btn-primary">Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header text-center bg-success text-white">
                <h3>Pendaftaran Berhasil!</h3>
            </div>
            <div class="card-body text-center">
                <div class="alert alert-success">
                    <h4>Nomor Registrasi: {{ $pendaftaran->nomor_registrasi }}</h4>
                </div>
                
                <p>Terima kasih telah mengisi formulir pendaftaran. Data Anda telah berhasil disimpan.</p>
                <p>Silakan simpan nomor registrasi di atas untuk keperluan selanjutnya.</p>
                
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
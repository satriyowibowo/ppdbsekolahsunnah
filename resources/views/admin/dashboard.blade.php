@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang di panel admin untuk mengelola pendaftaran sekolah.</p>
        
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Gelombang Aktif</h5>
                        <p class="card-text">{{ \App\Models\Gelombang::where('status', true)->count() }}</p>
                        <a href="{{ route('admin.gelombang.index') }}" class="text-white">Kelola Gelombang</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Pendaftar</h5>
                        <p class="card-text">{{ \App\Models\Pendaftaran::count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
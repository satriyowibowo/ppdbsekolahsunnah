@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>{{ isset($gelombang) ? 'Edit' : 'Tambah' }} Gelombang Pendaftaran</h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($gelombang) ? route('admin.gelombang.update', $gelombang->id) : route('admin.gelombang.store') }}" method="POST">
                    @csrf
                    @if(isset($gelombang))
                        @method('PUT')
                    @endif
                    
                    <div class="mb-3">
                        <label for="nomor_gelombang" class="form-label">Nomor Gelombang</label>
                        <input type="number" class="form-control" id="nomor_gelombang" name="nomor_gelombang" 
                               value="{{ old('nomor_gelombang', $gelombang->nomor_gelombang ?? '') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                               value="{{ old('tanggal_mulai', isset($gelombang) ? $gelombang->tanggal_mulai->format('Y-m-d') : '') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                               value="{{ old('tanggal_selesai', isset($gelombang) ? $gelombang->tanggal_selesai->format('Y-m-d') : '') }}" required>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="status" name="status" 
                               {{ old('status', isset($gelombang) && $gelombang->status ? 'checked' : '') }}>
                        <label class="form-check-label" for="status">Aktif</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.gelombang.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
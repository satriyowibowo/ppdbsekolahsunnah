@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Kelola Gelombang Pendaftaran</h1>
    <a href="{{ route('admin.gelombang.create') }}" class="btn btn-primary">Tambah Gelombang</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gelombang</th>
                    <th>Periode</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gelombangs as $gelombang)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>Gelombang {{ $gelombang->nomor_gelombang }}</td>
                    <td>{{ $gelombang->tanggal_mulai->translatedFormat('d F Y') }} - {{ $gelombang->tanggal_selesai->format('d F Y') }}</td>
                    <td>
                        @if($gelombang->status)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.gelombang.edit', $gelombang->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.gelombang.toggleStatus', $gelombang->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            @if($gelombang->status)
                                <button type="submit" class="btn btn-sm btn-secondary">Nonaktifkan</button>
                            @else
                                <button type="submit" class="btn btn-sm btn-success">Aktifkan</button>
                            @endif
                        </form>
                        <form action="{{ route('admin.gelombang.destroy', $gelombang->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
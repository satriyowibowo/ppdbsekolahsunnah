@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Login Admin</div>
            <div class="card-body">
                <form method="POST" action="#">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <div class="mt-3">
                    <p class="text-muted">
                        <strong>Catatan:</strong> Untuk sementara, admin panel dapat diakses tanpa authentication.
                        <a href="{{ route('admin.dashboard') }}">Lanjut ke Dashboard</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
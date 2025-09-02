@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="step-progress">
            <div class="step completed">
                <div class="step-number">1</div>
                <div class="step-label">Jenjang</div>
            </div>
            <div class="step active">
                <div class="step-number">2</div>
                <div class="step-label">Jenis Kelamin</div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-label">Formulir</div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header text-center">
                <h3>Pilih Jenis Kelamin</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('pendaftaran.form') }}" method="POST">
                    @csrf
                    <div class="d-grid gap-3">
                        <button type="submit" name="jenis_kelamin" value="Ikhwan" class="btn btn-outline-primary btn-lg py-4">
                            <h4>Ikhwan (Laki-laki)</h4>
                        </button>
                        <button type="submit" name="jenis_kelamin" value="Akhwat" class="btn btn-outline-primary btn-lg py-4">
                            <h4>Akhwat (Perempuan)</h4>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
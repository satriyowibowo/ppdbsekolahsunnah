@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h3>Pilih Jenjang Pendidikan</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('pendaftaran.jenis-kelamin') }}" method="POST">
                    @csrf
                    <div class="d-grid gap-3">
                        <button type="submit" name="jenjang" value="KAUD" class="btn btn-outline-primary btn-lg py-4">
                            <h4>Kuttab Anak Usia Dini (KAUD) - setingkat TK/RA</h4>
                        </button>
                        <button type="submit" name="jenjang" value="Kuttab" class="btn btn-outline-primary btn-lg py-4">
                            <h4>Kuttab Tahfizhul Qur'an - setingkat SD/MI</h4>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
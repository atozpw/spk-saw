@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>Tambah Posisi Seleksi</h2>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('positions.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Posisi</label>
                            <input type="text" name="position" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('positions.index') }}" class="btn btn-light">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

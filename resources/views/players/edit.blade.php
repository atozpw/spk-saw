@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>Edit Pemain</h2>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('players.update', [$player->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Nama Pemain</label>
                            <input type="text" name="name" value="{{ $player->name }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Asal Tim</label>
                            <input type="text" name="team" value="{{ $player->team }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>No. Punggung</label>
                            <input type="number" name="number" value="{{ $player->number }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Posisi</label>
                            <select name="position_id" class="form-control">
                                @foreach ($positions as $item)
                                <option value="{{ $item->id }}" @if($player->position_id == $item->id) selected @endif>{{ $item->position }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('players.index') }}" class="btn btn-light">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

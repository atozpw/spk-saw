@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>Daftar Pemain</h2>
            @if(session('mess'))
                <div class="alert alert-success">
                    {{ session('mess') }}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('players.create') }}" class="btn btn-primary pull-right">Tambah Pemain</a>
                    <br/><br/>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nama Pemain</th>
                                    <th scope="col">Asal Tim</th>
                                    <th scope="col">No. Punggung</th>
                                    <th scope="col">Posisi</th>
                                    <th scope="col" width="150px">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @forelse($players as $r)
                                <tr>
                                    <td>{{ $r->name }}</td>
                                    <td>{{ $r->team }}</td>
                                    <td>{{ $r->number }}</td>
                                    <td>{{ $r->position->position }}</td>
                                    <td>
                                        <a href="{{ route('players.edit', [$r->id]) }}" class="btn btn-light btn-sm">Edit</a>
                                        <a onclick="confirmDelete({{$i}})" class="btn btn-light btn-sm">Hapus</a>
                                        <form id="form-delete{{$i}}" action="{{ route('players.destroy', [$r->id]) }}" method="POST" style="display: none;">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                                @empty
                                <tr>
                                    <td colspan="4">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $players->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        function confirmDelete(value){
            var alert = window.confirm("Yakin ingin dihapus?")
            if(alert) {
                event.preventDefault();
                document.getElementById('form-delete' + value).submit();
            }
            else {
                return true
            }
        }
    </script>
@endpush
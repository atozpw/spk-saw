@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>Daftar Posisi Seleksi</h2>
            @if(session('mess'))
                <div class="alert alert-success">
                    {{ session('mess') }}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('positions.create') }}" class="btn btn-primary pull-right">Tambah Posisi Seleksi</a>
                    <br/><br/>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Posisi</th>
                                    <th scope="col" width="150px">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @forelse($positions as $r)
                                <tr>
                                    <td>{{ $r->position }}</td>
                                    <td>
                                        <a href="{{ route('positions.edit', [$r->id]) }}" class="btn btn-light btn-sm">Edit</a>
                                        <a onclick="confirmDelete({{$i}})" class="btn btn-light btn-sm">Hapus</a>
                                        <form id="form-delete{{$i}}" action="{{ route('positions.destroy', [$r->id]) }}" method="POST" style="display: none;">
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
                                    <td colspan="2">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $positions->links() }}
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
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>Edit Kriteria Posisi</h2>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('criterias.update', [$position->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Posisi</label>
                            <select class="form-control" name="position_id" required>
                                @foreach($positions as $r)
                                <option value="{{ $r->id }}" @if($position->id == $r->id) selected @endif>{{ $r->position }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kriteria</label>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Kriteria</th>
                                        <th width="100px">Kode</th>
                                        <th width="150px">Jenis</th>
                                        <th width="150px">Bobot</th>
                                        <th width="50px">#</th>
                                    </tr>
                                </thead>
                                <tbody id="tBody">
                                    @php
                                    $i = 0;
                                    @endphp
                                    @forelse($position->criterias as $criteria)
                                    <tr id="tBaris{{ $i }}">
                                        <td>
                                            <input type="text" name="criteria_name[]" class="form-control" value="{{ $criteria->name }}">
                                        </td>
                                        <td>
                                            <input type="text" name="criteria_code[]" class="form-control" value="{{ $criteria->code }}">
                                        </td>
                                        <td>
                                            <select name="criteria_attribute[]" class="form-control">
                                                <option value="benefit" @if($criteria->attribute == 'benefit') selected @endif>Benefit</option>
                                                <option value="cost" @if($criteria->attribute == 'cost') selected @endif>Cost</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="criteria_weight[]" class="form-control" step=".01" value="{{ $criteria->weight }}">
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" onclick="return removeRecord({{ $i }})">X</button>
                                        </td>
                                    </tr>
                                    @php
                                    $i++;
                                    @endphp
                                    @empty
                                    <tr id="tBaris0">
                                        <td>
                                            <input type="text" name="criteria_name[]" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="criteria_code[]" class="form-control">
                                        </td>
                                        <td>
                                            <select name="criteria_attribute[]" class="form-control">
                                                <option value="benefit">Benefit</option>
                                                <option value="cost">Cost</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="criteria_weight[]" class="form-control" step=".01">
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" onclick="return removeRecord(0)">X</button>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <button onclick="return addRecord()" class="btn btn-success">Tambah Baris</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('criterias.index') }}" class="btn btn-light">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var rec = {{ count($position->criterias) }};

        function addRecord(){
            $('#tBody').append(
                '<tr id="tBaris' + rec + '">' +
                    '<td>' +
                        '<input type="text" name="criteria_name[]" class="form-control">' +
                    '</td>' +
                    '<td>' +
                        '<input type="text" name="criteria_code[]" class="form-control">' +
                    '</td>' +
                    '<td>' +
                        '<select name="criteria_attribute[]" class="form-control">' +
                            '<option value="benefit">Benefit</option>' +
                            '<option value="cost">Cost</option>' +
                        '</select>' +
                    '</td>' +
                    '<td>' +
                        '<input type="number" name="criteria_weight[]" class="form-control" step=".01">' +
                    '</td>' +
                    '<td>' +
                        '<button class="btn btn-danger btn-sm" onclick="return removeRecord(' + rec + ')">X</button>' +
                    '</td>' +
                '</tr>'
            );
            rec++;
            return false;
        }

        function removeRecord(value) {
            $('#tBaris' + value).remove();
            return false;
        }
    </script>
@endpush
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>Statistik Pemain</h2>
            @if(session('mess'))
                <div class="alert alert-success">
                    {{ session('mess') }}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('statistics.store') }}" method="POST">
                        @csrf
                        <select name="position_id" class="form-control" onchange="getPosition()">
                            @foreach ($positions as $item)
                            <option value="{{ $item->id }}" @isset($_GET['position_id']) @if($_GET['position_id'] == $item->id) selected @endif @endisset>{{ $item->position }}</option>
                            @endforeach
                        </select>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Pemain</th>
                                        @foreach($criterias as $item)
                                        <th scope="col" title="{{ $item->name }}">
                                            {{ $item->code }}
                                            @if ($item->attribute == 'benefit')
                                            (+)
                                            @else
                                            (-)
                                            @endif
                                        </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 0;
                                    @endphp
                                    @forelse($players as $r)
                                    <tr>
                                        <td>
                                            {{ $r->name }}
                                            <input type="hidden" name="player_id[{{$i}}]" value="{{ $r->id }}">
                                        </td>
                                        @php
                                        $j = 0;
                                        @endphp
                                        @foreach($criterias as $item)
                                        <td>
                                            <input type="number" name="value[{{$i}}][{{$j}}]" class="form-control" value="{{ $item->getValue($r->id) }}" min="1" required>
                                            <input type="hidden" name="criteria_id[{{$i}}][{{$j}}]" value="{{ $item->id }}">
                                        </td>
                                        @php
                                        $j++;
                                        @endphp
                                        @endforeach
                                    </tr>
                                    @php
                                    $i++;
                                    @endphp
                                    @empty
                                    <tr>
                                        <td colspan="{{ count($criterias) + 1 }}">Tidak ada data</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        function getPosition(){
            var q = $('select[name="position_id"]').val();
            window.location = "/statistics?position_id=" + q;
        }
    </script>
@endpush

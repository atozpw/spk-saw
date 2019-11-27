@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>Hasil Seleksi</h2>
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="form-row">
                        <div class="form-group col-md-4">
                            <select name="position_id" class="form-control" onchange="getPosition()">
                                @foreach ($positions as $item)
                                <option value="{{ $item->id }}" @isset($_GET['position_id']) @if($_GET['position_id'] == $item->id) selected @endif @endisset>{{ $item->position }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="number" name="limit" class="form-control" value="1">
                        </div>
                        <div class="form-group col-md-3">
                            <button onclick="return getSort()" data-toggle="modal" data-target="#modalSorting" class="btn btn-primary">Urutkan</button>
                        </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Pemain</th>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($criterias as $item)
                                    <th scope="col">
                                        {{ $item->code }}
                                        <input type="hidden" name="criteria_weight" value="{{ $item->weight }}">
                                    </th>
                                    @endforeach
                                    @foreach ($criterias as $item)
                                    <th scope="col">R{{$i++}}</th>
                                    @endforeach
                                    <th scope="col">V</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $x = 1;
                                @endphp
                                @foreach ($players as $player)
                                <tr>
                                    <td>{{ $player->name }}</td>
                                    @foreach ($criterias as $criteria)
                                    <td>
                                        {{ $criteria->getValue($player->id) }}
                                    </td>
                                    @endforeach
                                    @php
                                    $getV = 0;
                                    $j = 1;
                                    @endphp
                                    @foreach ($criterias as $criteria)
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#modalRating" onclick="return getRating('{{ $player->name }}', '{{ $j++ }}', '{{ $criteria->attribute }}', {{ $criteria->getValue($player->id) }}, {{ $criteria->getMinMax() }})">
                                            {{ number_format($criteria->getRating($player->id), 4) }}
                                        </a>
                                        <input type="hidden" name="criteria_value{{$x}}" value="{{ number_format($criteria->getRating($player->id), 4) }}">
                                    </td>
                                    @php
                                    $getV = $getV + ($criteria->getRating($player->id) * $criteria->weight);
                                    @endphp
                                    @endforeach
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#modalResult" onclick="return getResult('{{ $x++ }}', '{{ number_format($getV, 4) }}')">
                                            {{ number_format($getV, 4) }}
                                        </a>
                                        <input type="hidden" name="data.player" value="{{ $player->name }}">
                                        <input type="hidden" name="data.result" value="{{ number_format($getV, 4) }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Rating -->
<div class="modal fade" id="modalRating" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Informasi Nilai Rating Kinerja Ternormalisasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modalRatingContent" class="modal-body"></div>
        </div>
    </div>
</div>
<!-- Modal Result -->
<div class="modal fade" id="modalResult" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Informasi Ranking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modalResultContent" class="modal-body"></div>
        </div>
    </div>
</div>
<!-- Modal Sorting -->
<div class="modal fade" id="modalSorting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Urutan Alternatif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pemain</th>
                            <th width="120px">Ranking</th>
                        </tr>
                    </thead>
                    <tbody id="modalSortingContent"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        function getPosition() {
            var q = $('select[name="position_id"]').val();
            window.location = "/results?position_id=" + q;
        }

        function getSort() {
            var sortable = [];
            var data1 = $('input[name="data.result"]');
            var data2 = $('input[name="data.player"]');
            var limit = $('input[name="limit"]').val();
            for (var i = 0; i < data1.length; i++) {
                sortable.push([data2[i].value, data1[i].value]);
            }
            var sorting = sortable.sort(function(a, b){return b[1] - a[1]});
            $('#modalSortingContent').empty();
            for (var j = 0; j < parseInt(limit); j++) {
                $('#modalSortingContent').append(
                    '<tr>' +
                        '<td>' + sorting[j][0] + '</td>' +
                        '<td>' + sorting[j][1] + '</td>' +
                    '</tr>'
                );
            }
            return false;
        }

        function getRating(player, num, attr, valC, valMinMax) {
            if (attr == 'benefit') {
                var row00 = '<span style="font-size: 20px" class="text-success">Atribut Keuntungan (Benefit)</span>';
                var row01 = '<span style="font-size: 20px">R</span>ij ' +
                            '<span style="font-size: 20px">=</span> ' +
                            '<span style="font-size: 20px">X</span>ij ' +
                            '<span style="font-size: 20px">/ Max(X</span>ij' +
                            '<span style="font-size: 20px">)</span>';
                var row02 = '<span style="font-size: 20px">R</span>' + num +
                            '<span style="font-size: 20px"> =</span> ' +
                            '<span style="font-size: 20px">' + valC + ' / ' + valMinMax + '</span>';
                var reslt = valC / valMinMax;
                var row03 = '<span style="font-size: 20px">R</span>' + num +
                            '<span style="font-size: 20px"> =</span> ' +
                            '<span style="font-size: 20px">' + reslt.toFixed(4) + '</span>';
                var row04 = 'Max(Xij) = nilai terbesar dari setiap kriteria';
            }
            else {
                var row00 = '<span style="font-size: 20px" class="text-danger">Atribut Biaya (Cost)</span>';
                var row01 = '<span style="font-size: 20px">R</span>ij ' +
                            '<span style="font-size: 20px">=</span> ' +
                            '<span style="font-size: 20px">Min(X</span>ij' +
                            '<span style="font-size: 20px">) </span>' +
                            '<span style="font-size: 20px">/ X</span>ij';
                var row02 = '<span style="font-size: 20px">R</span>' + num +
                            '<span style="font-size: 20px"> =</span> ' +
                            '<span style="font-size: 20px">' + valMinMax + ' / ' + valC + '</span>';
                var reslt = valMinMax / valC;
                var row03 = '<span style="font-size: 20px">R</span>' + num +
                            '<span style="font-size: 20px"> =</span> ' +
                            '<span style="font-size: 20px">' + reslt.toFixed(4) + '</span>';
                var row04 = 'Min(Xij) = nilai terkecil dari setiap kriteria';
            }
            $('#modalRatingContent').empty();
            $('#modalRatingContent').append(
                row00 + 
                '<br/>' +
                row01 + 
                '<br/>' + 
                row02 + 
                '<br/>' + 
                row03 + 
                '<br/><br/>' + 
                'Keterangan:' + 
                '<br/>' + 
                'Rij = nilai rating kinerja ternormalisasi' + 
                '<br/>' + 
                'Xij = nilai atribut yang dimiliki dari setiap kriteria' + 
                '<br/>' + 
                row04
            );
            return false;
        }

        function getResult(num, result) {
            var weight = $('input[name="criteria_weight"]');
            var rating = $('input[name="criteria_value' + num + '"]');
            var sigma = '';
            for (var i = 0; i < weight.length; i++) {
                if (i == (weight.length - 1)) {
                    sigma = sigma + '(' + weight[i].value + ' * ' + rating[i].value + ')';
                }
                else {
                    sigma = sigma + '(' + weight[i].value + ' * ' + rating[i].value + ') + ';
                }
            }
            $('#modalResultContent').empty();
            $('#modalResultContent').append(
                '<span style="font-size: 20px">V</span>i ' +
                '<span style="font-size: 20px">= Σ W</span>j ' +
                '<span style="font-size: 20px">R</span>ij' +
                '<br/>' + 
                '<span style="font-size: 20px">V</span>' + num + ' ' +
                '<span style="font-size: 20px">= ' + sigma + '</span>' +
                '<br/>' + 
                '<span style="font-size: 20px">V</span>' + num + ' ' +
                '<span style="font-size: 20px">= ' + result + '</span>' +
                '<br/><br/>' + 
                'Keterangan:' + 
                '<br/>' + 
                'Vi = ranking untuk setiap alternatif' + 
                '<br/>' + 
                'Wj = nilai bobot dari setiap kriteria' + 
                '<br/>' + 
                'Rij = nilai rating kinerja ternormalisasi'
            );
            return false;
        }
    </script>
@endpush

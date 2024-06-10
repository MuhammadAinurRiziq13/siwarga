@extends('layouts.app')
{{-- @php
    function truncateText($text, $maxLength)
    {
        return strlen($text) > $maxLength ? substr($text, 0, $maxLength) . '...' : $text;
    }
@endphp --}}

@section('content')
    <div class="card">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title my-2 text-white float-left">Rekomendasi Keluarga Prasejahtera Penerima Bantuan</h6>
                <a class="btn btn-sm my-1 btn-secondary float-right"
                    href="{{ url('poor-family') }}">
                        Kembali</a>
        </div>
        {{-- <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">Rekomendasi Keluarga Prasejahtera Penerima Bantuan</h6>
            <div class="card-tools float-right">
                <a href="{{ url('poor-family') }}" class="btn btn-sm btn-secondary float-right">Kembali</a>
            </div>
        </div> --}}
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover table-sm" id="poorFamilyTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No KK</th>
                        <th>Nama Kepala Keluarga</th>
                        <th>Jumlah Anggota</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rankedFamilies as $index => $family)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $family['noKK'] }}</td>
                            <td>{{ $family['nama'] }}</td>
                            <td>{{ $family['jumlah_anggota'] }}</td>
                            <td>{{ round($family['score'], 4) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="col-sm-8">
        <h1 class="h3 text-gray-800">Langkah-langkah Perhitungan Topsis</h1>
    </div>
    <br>
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">Bobot Criteria</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        {{-- <th>Alternatif</th> --}}
                        @foreach ($criteria as $criterion)
                            <th>{{ $criterion }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($steps['decisionMatrix'] as $index => $row) --}}
                    <tr>
                        {{-- <td>{{ $alternatives[$index] }}</td> <!-- Nama alternatif dari variabel $alternatives --> --}}
                        @foreach ($weight as $value)
                            <td>{{ round($value, 4) }}</td>
                        @endforeach
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">Matriks Keputusan</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Alternatif</th>
                        @foreach ($criteria as $criterion)
                            <th>{{ $criterion }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($steps['decisionMatrix'] as $index => $row)
                        <tr>
                            <td>{{ $alternatives[$index] }}</td> <!-- Nama alternatif dari variabel $alternatives -->
                            @foreach ($row as $value)
                                <td>{{ round($value, 4) }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">Matriks Normalisasi</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Alternatif</th>
                        @foreach ($criteria as $criterion)
                            <th>{{ $criterion }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($steps['normalizedMatrix'] as $index => $row)
                        <tr>
                            <td>{{ $alternatives[$index] }}</td> <!-- Nama alternatif dari variabel $alternatives -->
                            @foreach ($row as $score)
                                <td>{{ round($score, 4) }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">Matriks Normalisasi Terbobot</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Alternatif</th>
                        @foreach ($criteria as $criterion)
                            <th>{{ $criterion }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    @foreach ($steps['weightedNormalizedMatrix'] as $index => $row)
                        <tr>
                            <td>{{ $alternatives[$index] }}</td> <!-- Nama alternatif dari variabel $alternatives -->
                            @foreach ($row as $score)
                                <td>{{ round($score, 4) }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">Ideal Positif dan Negatif</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nilai Ideal</th>
                        @foreach ($criteria as $criterion)
                            <th>{{ $criterion }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    @php
                        $index = 0;
                    @endphp
                    @foreach ($steps['idealSolutions'] as $row)
                        <tr>
                            @if ($index == 0)
                                <td>Positif</td> <!-- Alternatif Positif -->
                            @else
                                <td>Negatif</td> <!-- Alternatif Negatif -->
                            @endif
                            @foreach ($row as $score)
                                <td>{{ round($score, 4) }}</td>
                            @endforeach
                        </tr>
                        @php
                            $index++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">Ideal Solution</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 150px;">Alternatif</th>
                        <th style="width: 100px;">Positif Ideal</th>
                        <th style="width: 100px;">Negatif Ideal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alternatives as $index => $alternative)
                        <tr>
                            <td style="width: 150px;">{{ $alternative }}</td>
                            <td style="width: 100px;">{{ round($steps['distances']['positive'][$index], 4) }}</td>
                            <td style="width: 100px;">{{ round($steps['distances']['negative'][$index], 4) }}</td>
                        </tr>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">Nilai Preferensi</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 150px;">Alternatif</th>
                        <th style="width: 100px;">Nilai Preferensi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alternatives as $index => $alternative)
                        <tr>
                            <td>{{ $alternative }}</td>
                            <td>{{ round($steps['scores'][$index], 4) }}</td>
                        </tr>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endpush
@push('js')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#poorFamilyTable').DataTable();
        });
    </script>
@endpush

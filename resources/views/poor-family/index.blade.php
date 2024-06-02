@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header bg-dark-blue">
            <div class="card-tools float-left">
                <a class="btn btn-sm bg-gradient-primary text-white" href="{{ url('poor-family/calculate') }}">Hitung</a>
                {{-- @if (Auth::user()->level == 'admin') --}}
                <a class="btn btn-sm bg-gradient-primary text-white" href="{{ url('poor-family/criteria') }}">Criteria</a>
            </div>
            <div class="card-tools float-right">
                <a class="btn btn-sm bg-gradient-primary text-white" href="{{ url('submission-add') }}">Daftar
                    Pengajuan</a>
                @if (Auth::user()->level == 'admin')
                    <a class="btn btn-sm bg-gradient-primary text-white" href="{{ url('poor-family/create') }}">
                        <i class="fas fa-fw fa-plus"></i> Tambah
                    </a>
                @endif
                <a class="btn btn-sm bg-gradient-primary text-white" href="{{ url('poor-family/import') }}">
                    <i class="fas fa-regular fa-file-excel"></i> Import
                </a>
                <a class="btn btn-sm bg-gradient-primary text-white" href="{{ url('poor-family/export') }}">
                    <i class="fas fa-regular fa-file-excel"></i> Export
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <table id="poorFamilyTable" class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No KK</th>
                        <th>Nama Kepala Keluarga</th>
                        <th>Jumlah Anggota</th>
                        {{-- <th>Pendapatan</th>
                    <th>Jumlah Kendaraan</th>
                    <th>Luas Tanah</th>
                    <th>Kondisi Rumah</th> --}}
                        {{-- <th>Score</th> --}}
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rankedFamilies as $index => $family)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $family['noKK'] }}</td>
                            <td>{{ $family['nama'] }}</td>
                            <td>{{ $family['jumlah_anggota'] }}</td>
                            {{-- <td>{{ $family['pendapatan'] }}</td>
                    <td>{{ $family['jumlah_kendaraan'] }}</td>
                    <td>{{ $family['luas_tanah'] }}</td>
                    <td>{{ $family['kondisi_rumah'] }}</td> --}}
                            {{-- <td>{{ round($family['score'],4) }}</td> --}}
                            <td class="text-center">
                                <a href="{{ url('/poor-family/' . $family['noKK']) }}" class="btn btn-info btn-sm"><i
                                        class="fas fa-eye"></i></a>
                                @if (Auth::user()->level == 'admin')
                                    <a href="{{ url('/poor-family/' . $family['noKK'] . '/edit') }}"
                                        class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                    <form class="d-inline-block" method="POST"
                                        action="{{ url('/poor-family/' . $family['noKK']) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin menghapus data ini?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
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

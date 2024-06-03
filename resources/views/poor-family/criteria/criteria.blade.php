@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header bg-dark-blue">
            <div class="card-tools float-left">
                {{-- <a class="btn btn-sm bg-dark-blue text-white mt-1" href="{{ url('poor-family/createCriteria') }}">Criteria</a> --}}
            </div>
            <div class="card-tools float-right">
                <a class="btn btn-sm bg-gradient-primary text-white" href="{{ url('poor-family/createCriteria') }}">
                    <i class="fas fa-fw fa-plus"></i> Tambah
                </a>
                <a class="btn btn-sm btn-secondary" href="{{ url('poor-family') }}">Kembali</a>
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
                        <th>Kode</th>
                        <th>Nama Criteria</th>
                        <th>Bobot Criteria</th>
                        <th>Jenis Criteria</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($criteria as $index => $column)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $column['kode'] }}</td>
                            <td>{{ $column['nama'] }}</td>
                            <td>{{ $column['bobot'] }}</td>
                            <td>{{ $column['jenis'] }}</td>
                            <td class="text-center">
                                {{-- <a href="{{ url('/poor-family/criteria/' . $column['id']) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> --}}
                                @if (Auth::user()->level == 'admin')
                                    <a href="{{ url('/poor-family/' . $column['id'] . '/edit-criteria') }}"
                                        class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                    <form class="d-inline-block" method="POST"
                                        action="{{ url('/poor-family/delete-criteria/' . $column['id']) }}">
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
                    </tr>
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

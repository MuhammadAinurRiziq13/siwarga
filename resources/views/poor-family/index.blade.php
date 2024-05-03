@extends('layouts.app')

@section('content')
    <div class="card ">
        <div class="card-header bg-transparent">
            <div class="card-tools float-right">
                <a class="btn btn-sm bg-dark-blue text-white mt-1" href="{{ url('poor-family/create') }}">Daftar Pengajuan</a>
                <a class="btn btn-sm bg-dark-blue text-white mt-1" href="{{ url('poor-family/create') }}"><i
                        class="fas fa-fw fa-plus"></i> Tambah</a>
                <a class="btn btn-sm bg-dark-blue text-white mt-1" href="{{ url('poor-family/create') }}"><i
                        class="fas fa-regular fa-file-excel"></i> Import</a>
                <a class="btn btn-sm bg-dark-blue text-white mt-1" href="{{ url('poor-family/create') }}"><i
                        class="fas fa-regular fa-file-excel"></i> Export</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_poorfamily">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No KK</th>
                        <th>Nama Kepala Keluarga</th>
                        <th>Jumlah Anggota</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            var dataFamily = $('#table_poorfamily').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('poor-family/list') }}",
                    "dataType": "json",
                    "type": "POST",
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "noKK",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "jumlah_anggota",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush

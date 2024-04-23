@extends('layouts.app')

@section('content')
    <div class="card ">
        <div class="card-header bg-transparent">
            <div class="card-tools float-right">
                <a class="btn btn-sm bg-dark-blue text-white mt-1" href="{{ url('penjualan/create') }}"><i
                        class="fas fa-fw fa-plus"></i> Tambah Data</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_family">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Judul</th>
                        <th>Tanggal Kegiatan</th>
                        <th>Keterangan</th>
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
            var dataFamily = $('#table_family').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('resident/list') }}",
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
                        data: "NIK",
                        className: "",
                        orderable: true,
                        searchable: true
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
                        data: "tempat_lahir",
                        className: "",
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: "tanggal_lahir",
                        className: "",
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: "jenis_kelamin",
                        className: "",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false, // diiisi true jika ingin kolom ini bisa diurutkan
                        searchable: false // diiisi true jika ingin kolom ini bisa di cari
                    }
                ]
            });
        });
    </script>
@endpush

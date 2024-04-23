@extends('layouts.app')

@section('content')
    <div class="card ">
        <div class="card-header bg-transparent">
            <div class="card-tools float-right">
                <<<<<<< HEAD <a class="btn btn-sm bg-dark-blue text-white mt-1" href="{{ url('penjualan/create') }}">Daftar
                    Pengajuan</a>
                    <a class="btn btn-sm bg-dark-blue text-white mt-1" href="{{ url('penjualan/create') }}"><i
                            class="fas fa-fw fa-plus"></i> Tambah</a>
                    <a class="btn btn-sm bg-dark-blue text-white mt-1" href="{{ url('penjualan/create') }}"><i
                            class="fas fa-regular fa-file-excel"></i> Import</a>
                    <a class="btn btn-sm bg-dark-blue text-white mt-1" href="{{ url('penjualan/create') }}"><i
                            class="fas fa-regular fa-file-excel"></i> Export</a>
                    >>>>>>> d6af4f1342db29db9f88cae13e6dc3db0edb55d3
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_resident">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
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
            var dataResident = $('#table_resident').DataTable({
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

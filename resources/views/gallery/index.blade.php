@extends('layouts.app')

@section('content')
    <div class="card ">
        <div class="card-header bg-transparent">
            <div class="card-tools float-right">
                <a class="btn btn-sm bg-dark-blue text-white mt-1" href="{{ url('gallery/create') }}"><i
                        class="fas fa-fw fa-plus"></i> Tambah Data</a>
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
            <table class="table table-bordered table-striped table-hover table-sm" id="table_gallery">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Judul</th>
                        <th>Tanggal Kegiatan</th>
                        <th>Keterangan</th>
                        <th style="width: 12%">Aksi</th>
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
            var dataFamily = $('#table_gallery').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('gallery/list') }}",
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
                        data: "nama_foto",
                        className: "",
                        orderable: true,
                        searchable: true,
                        render: function(data, type, full, meta) {
                            return '<img src="{{ asset('storage') }}/' + data +
                                '" alt="' + data + '" style="max-width:100px; max-height:100px">';
                        }
                    },
                    {
                        data: "judul",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "tanggal_kegiatan",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "keterangan",
                        className: "",
                        orderable: true,
                        searchable: true
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

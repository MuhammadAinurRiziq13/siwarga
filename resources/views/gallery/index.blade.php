@extends('layouts.app')

@section('content')
    <div class="card ">
        <div class="card-header bg-dark-blue">
            <div class="card-tools float-right">
                @if (Auth::user()->level == 'admin')
                    <a class="btn btn-sm text-white bg-primary" href="{{ url('gallery/create') }}"><i
                            class="fas fa-fw fa-plus"></i> Tambah Data</a>
                @endif
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
            <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="table_gallery">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Judul</th>
                        <th>Tanggal Kegiatan</th>
                        <th>Keterangan</th>
                        <th style="width: 14%">Aksi</th>
                    </tr>
                </thead>
            </table>
            </div>
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
                        searchable: true,
                        render: data => {
                            const date = new Date(data);
                            return `${("0" + date.getDate()).slice(-2)}-${("0" + (date.getMonth() + 1)).slice(-2)}-${date.getFullYear()}`;
                        }
                    },
                    {
                        data: "keterangan",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "text-center",
                        orderable: false, // diiisi true jika ingin kolom ini bisa diurutkan
                        searchable: false // diiisi true jika ingin kolom ini bisa di cari
                    }
                ]
            });
        });
    </script>
@endpush

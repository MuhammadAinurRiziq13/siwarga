@extends('layouts.app')

@section('content')
    <div class="card shadow">
        <div class="card-header bg-transparent">
            <div class="card-tools float-right">
                <a class="btn btn-sm bg-dark-blue text-white mt-1" href="{{ url('resident/create') }}">Daftar
                    Pengajuan</a>
                <a class="btn btn-sm bg-dark-blue text-white mt-1" href="{{ url('resident/create') }}"><i
                        class="fas fa-fw fa-plus"></i> Tambah</a>
                <a class="btn btn-sm bg-dark-blue text-white mt-1" href="{{ url('resident/create') }}"><i
                        class="fas fa-regular fa-file-excel"></i> Import</a>
                <a class="btn btn-sm bg-dark-blue text-white mt-1" href="{{ url('resident/create') }}"><i
                        class="fas fa-regular fa-file-excel"></i> Export</a>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="" class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select name="filter_alamat" id="filter_alamat" class="form-control">
                                <option value="">- Semua -</option>
                                <option value="lokal">Warga Lokal</option>
                                <option value="sementara">Warga Sementara</option>
                            </select>
                            <small class="form-text text-muted">Alamat Asal</small>
                        </div>
                        <div class="col-3">
                            <select name="filter_umur" id="filter_umur" class="form-control">
                                <option value="">- Semua -</option>
                                <option value="balita">Balita</option>
                                <option value="lansia">Lansia</option>
                            </select>
                            <small class="form-text text-muted">Rentang Umur</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_resident">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
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
            var dataResident = $('#table_resident').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('resident/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(data) {
                        data.filter_umur = $('#filter_umur').val();
                        data.filter_alamat = $('#filter_alamat').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'NIK',
                        className: '',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'nama',
                        className: '',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'tempat_lahir',
                        className: '',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'tanggal_lahir',
                        className: '',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'jenis_kelamin',
                        className: '',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'aksi',
                        className: '',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#filter_umur, #filter_alamat').on('change', function() {
                dataResident.ajax.reload();
            });
        });
    </script>
@endpush

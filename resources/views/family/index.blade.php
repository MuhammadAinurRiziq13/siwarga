@extends('layouts.app')

@section('content')
    <div class="card ">
        <div class="card-header bg-dark-blue">
            <div class="card-tools float-right">
                @if (Auth::user()->level == 'admin')
                    <a class="btn btn-sm text-white bg-primary" href="{{ url('family/create') }}">
                        <i class="fas fa-fw fa-plus"></i> Tambah
                    </a>
                @endif
                <!-- Form Import -->
                <form action="{{ url('family/import') }}" method="POST" enctype="multipart/form-data" style="display: inline;">
                    @csrf
                    <input type="file" name="file" class="d-none" id="importFile" onchange="this.form.submit()">
                    <label class="btn btn-sm text-white bg-primary" for="importFile" style="margin-top: 0.5rem;">
                        <i class="fas fa-regular fa-file-excel"></i> Import
                    </label>
                </form>
                <a class="btn btn-sm text-white bg-primary" href="{{ url('family/export') }}">
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
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-sm " id="table_family">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No KK</th>
                            <th>Jml Anggota</th>
                            <th>Alamat</th>
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
            var dataFamily = $('#table_family').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('family/list') }}",
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
                        data: "jumlah_anggota",
                        className: "",
                        orderable: true,
                        searchable: false,
                        render: function(data, type, row) {
                            return data !== null ? data : 0;
                        }
                    },
                    {
                        data: "alamat",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    }
                ],
            });
        });
    </script>
@endpush

@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        {{-- <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">{{ $page->title }}</h6>
        </div> --}}
        <div class="card-header bg-transparent bg-dark-blue">
            <h6 class="card-title my-2 text-white float-left">{{ $page->title }}</h6>
            @empty($poorFamily)
                <a class="btn btn-sm text-white bg-gradient-primary float-right"
                    href="{{ url('/submission-prasejahtera/' . Auth::user()->username . '/create') }}"><i
                        class="fas fa-fw fa-plus"></i>
                    Tambah</a>
            @endempty
        </div>
        <div class="card-body">
            @empty($poorFamily)
                <div class="alert alert-primary alert-dismissible text-center">
                    <h6 class="mb-0"><i class="icon fas fa-ban"></i> Data Anda Tidak Terdaftar Dalam Keluarga Prasejahtera.
                    </h6>
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>No KK</th>
                        <td>{{ $poorFamily->noKK }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Tanggungan</th>
                        <td>{{ $poorFamily->jumlah_tanggungan }}</td>
                    </tr>
                    <tr>
                        <th>Pendapatan</th>
                        <td>{{ $poorFamily->pendapatan }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Kendaraan</th>
                        <td>{{ $poorFamily->pengeluaran }}</td>
                    </tr>
                    <tr>
                        <th>Luas Tanah</th>
                        <td>{{ $poorFamily->luas_tanah }}</td>
                    </tr>
                    <tr>
                        <th>Kondisi Rumah</th>
                        <td>{{ $poorFamily->kondisi_rumah }}</td>
                    </tr>
                </table>
            @endempty
        </div>
    </div>
    <br>
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">Daftar Pengajuan Edit Data</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover table-sm" id="table_submission">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No KK</th>
                        <th>Nama Pemohon</th>
                        <th>Waktu Pengajuan</th>
                        <th>Aksi</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script>
        console.log('{{ $nokk }}');
        $(document).ready(function() {
            var dataFamily = $('#table_submission').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('submission-prasejahtera/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        "nokk": '{{ $nokk }}'
                    }
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
                        data: "waktu_pengajuan",
                        className: "",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "aksi",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "status",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush

@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        {{-- <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">{{ $page->title }}</h6>
        </div> --}}
        <div class="card-header bg-dark-blue">
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
                    @foreach ($criteria as $c)
                        @if (isset($poorFamily->{$c->kode}))
                            @if ($c->nama == 'Jumlah Tanggungan')
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    <td>{{ $poorFamily->{$c->kode} }} orang</td>
                                </tr>
                            @elseif ($c->nama == 'Pendapatan' || $c->nama == 'Aset Kendaraan')
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    <td>Rp{{ $poorFamily->{$c->kode} }}</td>
                                </tr>
                            @elseif ($c->nama == 'Luas Tanah')
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    <td>{{ $poorFamily->{$c->kode} }} m<sup>2</sup></td>
                                </tr>
                            @elseif ($c->nama == 'Kondisi Rumah')
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    @if ($poorFamily->{$c->kode} == 1)
                                        <td>Rumah Kontrak</td>
                                    @elseif ($poorFamily->{$c->kode} == 2)
                                        <td>Buruk Layak</td>
                                    @elseif ($poorFamily->{$c->kode} == 3)
                                        <td>Kurang Layak</td>
                                    @elseif ($poorFamily->{$c->kode} == 4)
                                        <td>Cukup Layak</td>
                                    @elseif ($poorFamily->{$c->kode} == 5)
                                        <td>Layak</td>
                                    @endif
                                </tr>
                            @else
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    <td>{{ $poorFamily->{$c->kode} }}</td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
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

    @if ($message = Session::get('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "{{ session('success') }}"
                });
            });
        </script>
    @endif
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

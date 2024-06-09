@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">Data Anggota Keluarga</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Status Keluarga</th>
                        <th colspan="2" class="text-center" style="width: 10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($family as $family_member)
                        @if ($family_member->jumlah_anggota == 0)
                            <td colspan="6" class="text-center">Tidak ada anggota keluarga</td>
                        @else
                            <tr>
                                <td>{{ $family_member->NIK }}</td>
                                <td>{{ $family_member->nama }}</td>
                                <td>{{ $family_member->tempat_lahir }}</td>
                                <td>{{ date('d-m-Y', strtotime($family_member->tanggal_lahir)) }}</td>
                                <td>{{ $family_member->jenis_kelamin }}</td>
                                <td>{{ $family_member->status_keluarga }}</td>
                                <td class="text-center">
                                    <a href={{ url('/resident-edit/' . $family_member->NIK . '/show') }}
                                        class="btn btn-info btn-sm mr-2"><i class="fas fa-eye"></i></a>
                                    <a href={{ url('/resident-edit/' . $family_member->NIK . '/edit') }}
                                        class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
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
                        <th>NIK</th>
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
        $(document).ready(function() {
            var dataFamily = $('#table_submission').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('resident-edit/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        "nokk": '{{ $family->first()->noKK }}'
                    }
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

@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title my-2 text-white float-left">{{ $page->title }}</h6>
            <a class="btn btn-sm text-white bg-gradient-primary float-right"
                href="{{ url('/submission-pengantar/' . Auth::user()->username . '/create') }}"><i
                    class="fas fa-fw fa-plus"></i>
                Tambah</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover table-sm" id="table_submission">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nik</th>
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
                    "url": "{{ url('submission-pengantar/list') }}",
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

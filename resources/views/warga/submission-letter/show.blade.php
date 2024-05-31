@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header">
            <h6 class="card-title mb-0">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            @empty($letter)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th style="width: 30%">NIK</th>
                        <td>{{ $letter->NIK }}</td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Pekerjaan</th>
                        <td>{{ $letter->pekerjaan }}</td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Pendidikan</th>
                        <td>{{ $letter->pendidikan }}</td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Keperluan</th>
                        <td>{{ $letter->keperluan }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('submission-letter') }}" class="btn btn-sm btn-secondary m-2 float-right">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

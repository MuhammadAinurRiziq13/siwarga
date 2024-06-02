@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            @empty($criteria)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>Kode Kriteria</th>
                        <td>{{ $criteria->kode }}</td>
                    </tr>
                    <tr>
                        <th>Nama Kriteria</th>
                        <td>{{ $criteria->nama }}</td>
                    </tr>
                    <tr>
                        <th>Bobot</th>
                        <td>{{ $criteria->bobot }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kriteria</th>
                        <td>{{ $criteria->jenis }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('poor-family/criteria') }}" class="btn btn-sm btn-secondary mt-2 float-right">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

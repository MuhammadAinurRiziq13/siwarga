@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            @empty($gallery)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>Judul</th>
                        <td>{{ $gallery->judul }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ date('d-m-Y', strtotime($gallery->tanggal_kegiatan)) }}</td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $gallery->keterangan }}</td>
                    </tr>
                    <tr>
                        <th>Foto</th>
                        <td><img src="{{ asset('storage/' . $gallery->nama_foto) }}" style="max-width:300px; max-height:300px"
                                class="rounded">
                        </td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('gallery') }}" class="btn btn-sm btn-secondary mt-2 float-right">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

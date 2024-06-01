@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header">
            <h6 class="card-title mb-0">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            @empty($poorFamily)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan shiw.
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
                        <th>Nilai Aset Kendaraan</th>
                        <td>{{ $poorFamily->aset_kendaraan }}</td>
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
            <a href="{{ url('poor-family') }}" class="btn btn-sm btn-secondary mt-2 float-right">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

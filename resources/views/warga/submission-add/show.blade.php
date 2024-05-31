@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header">
            <h6 class="card-title mb-0">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            @empty($add)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>No KK</th>
                        <td>{{ $add->noKK }}</td>
                    </tr>
                    <tr>
                        <th>Nama Pemohon</th>
                        <td>{{ $add->nama }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah tanggungan</th>
                        <td>{{ $add->jumlah_tanggungan }}</td>
                    </tr>
                    <tr>
                        <th>Nilai Aset Kendaraan</th>
                        <td>{{ $add->aset_kendaraan }}</td>
                    </tr>
                    <tr>
                        <th>Kondisi Rumah</th>
                        <td>{{ $add->kondisi_rumah }}</td>
                    </tr>
                    <tr>
                        <th>Luas Tanah</th>
                        <td>{{ $add->luas_tanah }} m<sup>2</sup></td>
                    </tr>
                    <tr>
                        <th>Pendapatan</th>
                        <td>{{ $add->pendapatan }}</td>
                    </tr>
                    <tr>
                        <th>No HP</th>
                        <td>{{ $add->no_hp }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('submission-add') }}" class="btn btn-sm btn-secondary m-2 float-right">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            @empty($resident)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>NIK</th>
                        <td>{{ $resident->NIK }}</td>
                    </tr>
                    <tr>
                        <th>No KK</th>
                        <td>{{ $resident->noKK }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $resident->nama }}</td>
                    </tr>
                    <tr>
                        <th>Tempat Lahir</th>
                        <td>{{ $resident->tempat_lahir }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td>{{ $resident->tanggal_lahir }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $resident->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <th>Agama</th>
                        <td>{{ $resident->agama }}</td>
                    </tr>
                    <tr>
                        <th>Status Pernikahan</th>
                        <td>{{ $resident->status_pernikahan }}</td>
                    </tr>
                    <tr>
                        <th>Status Keluarga</th>
                        <td>{{ $resident->status_keluarga }}</td>
                    </tr>
                    @if ($resident->alamat_asal)
                        <tr>
                            <th>Alamat Asal</th>
                            <td>{{ $resident->alamat_asal }}</td>
                        </tr>
                    @endif
                </table>
            @endempty
            <a href="{{ url('resident-edit/' . Auth::user()->username) }}"
                class="btn btn-sm btn-secondary mt-2 float-right">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            @empty($family)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>No KK</th>
                        <td>{{ $family->first()->noKK }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $family->first()->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Kecamatan</th>
                        <td>{{ $family->first()->kecamatan }}</td>
                    </tr>
                    <tr>
                        <th>Kabupaten Kota</th>
                        <td>{{ $family->first()->kabupaten_kota }}</td>
                    </tr>
                    <tr>
                        <th>Provinsi</th>
                        <td>{{ $family->first()->provinsi }}</td>
                    </tr>
                </table>
            @endempty
        </div>
    </div>
    <br>
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
                        <th>Status Kerja</th>
                        <th>Status Keluarga</th>
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
                                <td>{{ $family_member->status_kerja }}</td>
                                <td>{{ $family_member->status_keluarga }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <a href="{{ url('family') }}" class="btn btn-sm btn-secondary mt-2 float-right">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

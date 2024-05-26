@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header">
            <h6 class="card-title mb-0">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            @empty($changes)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <form method="POST" action="{{ url('/submission-changes/' . $changes->NIK_pengajuan) }}">
                    @csrf
                    {!! method_field('PUT') !!}
                    <input type="hidden" name="NIK_pengajuan" value="{{ $changes->NIK_pengajuan }}">
                    <input type="hidden" name="nama" value="{{ $changes->nama }}">
                    <input type="hidden" name="tempat_lahir" value="{{ $changes->tempat_lahir }}">
                    <input type="hidden" name="tanggal_lahir" value="{{ $changes->tanggal_lahir }}">
                    <input type="hidden" name="jenis_kelamin" value="{{ $changes->jenis_kelamin }}">
                    <input type="hidden" name="agama" value="{{ $changes->agama }}">
                    <input type="hidden" name="status_pernikahan" value="{{ $changes->status_pernikahan }}">
                    <input type="hidden" name="keterangan" value="{{ $changes->keterangan }}">
                    <input type="hidden" name="no_hp" value="{{ $changes->no_hp }}">
                    <input type="hidden" name="status" value="selesai">

                    <table class="table table-bordered table-striped table-hover table-sm">
                        <tr>
                            <th>NIK</th>
                            <td>{{ $changes->NIK_pengajuan }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $changes->nama }}</td>
                        </tr>
                        <tr>
                            <th>Tempat Lahir</th>
                            <td>{{ $changes->tempat_lahir }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>{{ $changes->tanggal_lahir }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $changes->jenis_kelamin }}</td>
                        </tr>
                        <tr>
                            <th>Agama</th>
                            <td>{{ $changes->agama }}</td>
                        </tr>
                        <tr>
                            <th>Status Pernikahan</th>
                            <td>{{ $changes->status_pernikahan }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $changes->keterangan }}</td>
                        </tr>
                    </table>

                    <button type="submit" class="btn btn-sm btn-success m-2 float-right">Terima</button>
                </form>

                <!-- Form untuk tombol "Tolak" -->
                <form method="POST" action="{{ url('/submission-changes/' . $changes->NIK_pengajuan) }}">
                    @csrf
                    {!! method_field('PUT') !!}
                    <input type="hidden" name="NIK_pengajuan" value="{{ $changes->NIK_pengajuan }}">
                    <input type="hidden" name="nama" value="{{ $changes->nama }}">
                    <input type="hidden" name="tempat_lahir" value="{{ $changes->tempat_lahir }}">
                    <input type="hidden" name="tanggal_lahir" value="{{ $changes->tanggal_lahir }}">
                    <input type="hidden" name="jenis_kelamin" value="{{ $changes->jenis_kelamin }}">
                    <input type="hidden" name="agama" value="{{ $changes->agama }}">
                    <input type="hidden" name="status_pernikahan" value="{{ $changes->status_pernikahan }}">
                    <input type="hidden" name="keterangan" value="{{ $changes->keterangan }}">
                    <input type="hidden" name="no_hp" value="{{ $changes->no_hp }}">
                    <input type="hidden" name="status" value="ditolak">

                    <button type="submit" class="btn btn-sm btn-danger m-2 float-right">Tolak</button>
                </form>

                <a href="{{ url('submission-changes') }}" class="btn btn-sm btn-secondary m-2 float-left">Kembali</a>
            @endempty
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

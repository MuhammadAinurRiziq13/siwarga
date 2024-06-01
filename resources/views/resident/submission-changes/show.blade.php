@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            @empty($changes)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th style="width: 30%">NIK</th>
                        <td>{{ $changes->NIK }}</td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Nama</th>
                        <td>{{ $changes->nama }}</td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Tempat Lahir</th>
                        <td>{{ $changes->tempat_lahir }}</td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Tanggal Lahir</th>
                        <td>{{ $changes->tanggal_lahir }}</td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Jenis Kelamin</th>
                        <td>{{ $changes->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Agama</th>
                        <td>{{ $changes->agama }}</td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Status Pernikahan</th>
                        <td>{{ $changes->status_pernikahan }}</td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Status Keluarga</th>
                        <td>{{ $changes->status_keluarga }}</td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Keterangan</th>
                        <td>{{ $changes->keterangan }}</td>
                    </tr>
                    @if ($changes->alamat_asal)
                        <tr>
                            <th style="width: 30%">Alamat Asal</th>
                            <td>{{ $changes->alamat_asal }}</td>
                        </tr>
                    @endif
                    @if ($changes->family_member)
                        <tr>
                            <th style="width: 30%">Kepala Keluarga Pengganti</th>
                            <td>{{ $pengganti->nama }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th style="width: 30%">Bukti Foto</th>
                        <td>
                            @foreach ($bukti as $foto)
                                <img src="{{ asset('storage/' . $foto->nama_bukti) }}"
                                    style="max-width:400px; max-height:400px" class="rounded mb-2">
                            @endforeach
                        </td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('submission-changes') }}" class="btn btn-sm btn-secondary m-2 float-right">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

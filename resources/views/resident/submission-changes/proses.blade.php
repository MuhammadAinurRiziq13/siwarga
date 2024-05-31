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
                <form method="POST" action="{{ url('/submission-changes/' . $changes->id) }}">
                    @csrf
                    {!! method_field('PUT') !!}
                    <input type="hidden" name="NIK" value="{{ $changes->NIK }}">
                    <input type="hidden" name="nama" value="{{ $changes->nama }}">
                    <input type="hidden" name="tempat_lahir" value="{{ $changes->tempat_lahir }}">
                    <input type="hidden" name="tanggal_lahir" value="{{ $changes->tanggal_lahir }}">
                    <input type="hidden" name="jenis_kelamin" value="{{ $changes->jenis_kelamin }}">
                    <input type="hidden" name="agama" value="{{ $changes->agama }}">
                    <input type="hidden" name="status_pernikahan" value="{{ $changes->status_pernikahan }}">
                    <input type="hidden" name="status_keluarga" value="{{ $changes->status_keluarga }}">
                    <input type="hidden" name="alamat_asal" value="{{ $changes->alamat_asal }}">
                    <input type="hidden" name="keterangan" value="{{ $changes->keterangan }}">
                    <input type="hidden" name="no_hp" value="{{ $changes->no_hp }}">
                    <input type="hidden" name="family_member" value="{{ $changes->family_member }}">
                    <input type="hidden" name="status" value="selesai">

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

                    <button type="submit" class="btn btn-sm btn-success m-2 float-right">Terima</button>
                </form>

                <!-- Form untuk tombol "Tolak" -->
                <form method="POST" action="{{ url('/submission-changes/' . $changes->id) }}">
                    @csrf
                    {!! method_field('PUT') !!}
                    <input type="hidden" name="NIK" value="{{ $changes->NIK }}">
                    <input type="hidden" name="nama" value="{{ $changes->nama }}">
                    <input type="hidden" name="tempat_lahir" value="{{ $changes->tempat_lahir }}">
                    <input type="hidden" name="tanggal_lahir" value="{{ $changes->tanggal_lahir }}">
                    <input type="hidden" name="jenis_kelamin" value="{{ $changes->jenis_kelamin }}">
                    <input type="hidden" name="agama" value="{{ $changes->agama }}">
                    <input type="hidden" name="status_pernikahan" value="{{ $changes->status_pernikahan }}">
                    <input type="hidden" name="status_keluarga" value="{{ $changes->status_keluarga }}">
                    <input type="hidden" name="alamat_asal" value="{{ $changes->alamat_asal }}">
                    <input type="hidden" name="family_member" value="{{ $changes->family_member }}">
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

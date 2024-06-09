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
                <form method="POST" action="{{ url('/submission-letter/' . $letter->id) }}">
                    @csrf
                    {!! method_field('PUT') !!}
                    <input type="hidden" name="nama" value="{{ $letter->nama }}">
                    <input type="hidden" name="tempat_lahir" value="{{ $letter->tempat_lahir }}">
                    <input type="hidden" name="tanggal_lahir" value="{{ $letter->tanggal_lahir }}">
                    <input type="hidden" name="NIK" value="{{ $letter->NIK }}">
                    <input type="hidden" name="pekerjaan" value="{{ $letter->pekerjaan }}">
                    <input type="hidden" name="pendidikan" value="{{ $letter->pendidikan }}">
                    <input type="hidden" name="agama" value="{{ $letter->agama }}">
                    <input type="hidden" name="keperluan" value="{{ $letter->keperluan }}">
                    <input type="hidden" name="no_hp" value="{{ $letter->no_hp }}">
                    <input type="hidden" name="status" value="selesai">

                    <table class="table table-bordered table-striped table-hover table-sm">
                        <tr>
                            <th style="width: 30%">Nama</th>
                            <td>{{ $letter->nama }}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%">Tempat/Tgl. Lahir</th>
                            <td>{{ $letter->tempat_lahir }}, {{date('d-m-Y', strtotime($letter->tanggal_lahir))}}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%">Alamat</th>
                            <td>RT. 05/RW. 1 Dusun Bandilan 1 Desa RandukLindungan, Kecamatan Grati</td>
                        </tr>
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
                            <th style="width: 30%">Agama</th>
                            <td>{{ $letter->agama }}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%">Keperluan</th>
                            <td>{{ $letter->keperluan }}</td>
                        </tr>
                    </table>
                    {{-- <table class="table table-bordered table-striped table-hover table-sm">
                        <tr>
                            <th>NIK</th>
                            <td>{{ $letter->NIK }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $letter->nama }}</td>
                        </tr>
                        <tr>
                            <th>Tempat Lahir</th>
                            <td>{{ $letter->tempat_lahir }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>{{ $letter->tanggal_lahir }}</td>
                        </tr>
                        <tr>
                            <th>Agama</th>
                            <td>{{ $letter->agama }}</td>
                        </tr>
                        <tr>
                            <th>Pekerjaan</th>
                            <td>{{ $letter->pekerjaan }}</td>
                        </tr>
                        <tr>
                            <th>Pendidikan</th>
                            <td>{{ $letter->pendidikan }}</td>
                        </tr>
                        <tr>
                            <th>Keperluan</th>
                            <td>{{ $letter->keperluan }}</td>
                        </tr>
                        <tr>
                            <th>No Hp</th>
                            <td>{{ $letter->no_hp }}</td>
                        </tr>
                    </table> --}}

                    <button type="submit" class="btn btn-sm btn-success m-2 float-right">Terima</button>
                </form>

                <form method="POST" action="{{ url('/submission-letter/' . $letter->id) }}">
                    @csrf
                    {!! method_field('PUT') !!}
                    <input type="hidden" name="nama" value="{{ $letter->nama }}">
                    <input type="hidden" name="tempat_lahir" value="{{ $letter->tempat_lahir }}">
                    <input type="hidden" name="tanggal_lahir" value="{{ $letter->tanggal_lahir }}">
                    <input type="hidden" name="NIK" value="{{ $letter->NIK }}">
                    <input type="hidden" name="pekerjaan" value="{{ $letter->pekerjaan }}">
                    <input type="hidden" name="pendidikan" value="{{ $letter->pendidikan }}">
                    <input type="hidden" name="agama" value="{{ $letter->agama }}">
                    <input type="hidden" name="keperluan" value="{{ $letter->keperluan }}">
                    <input type="hidden" name="no_hp" value="{{ $letter->no_hp }}">
                    <input type="hidden" name="status" value="ditolak">

                    <button type="submit" class="btn btn-sm btn-danger m-2 float-right">Tolak</button>
                </form>

                <a href="{{ url('submission-letter') }}" class="btn btn-sm btn-secondary m-2 float-left">Kembali</a>
            @endempty
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

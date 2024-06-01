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
                <form method="POST" action="{{ url('/submission-add/' . $add->id) }}">
                    @csrf
                    {!! method_field('PUT') !!}
                    <input type="hidden" name="noKK" value="{{ $add->noKK }}">
                    <input type="hidden" name="jumlah_tanggungan" value="{{ $add->jumlah_tanggungan }}">
                    <input type="hidden" name="aset_kendaraan" value="{{ $add->aset_kendaraan }}">
                    <input type="hidden" name="kondisi_rumah" value="{{ $add->kondisi_rumah }}">
                    <input type="hidden" name="luas_tanah" value="{{ $add->luas_tanah }}">
                    <input type="hidden" name="pendapatan" value="{{ $add->pendapatan }}">
                    <input type="hidden" name="no_hp" value="{{ $add->no_hp }}">
                    <input type="hidden" name="status" value="selesai">

                    <table class="table table-bordered table-striped table-hover table-sm">
                        <tr>
                            <th>No KK</th>
                            <td>{{ $add->noKK }}</td>
                        </tr>
                        <tr>
                            <th>Nama Pemohon</th>
                            <td>{{ $nama->kepala_keluarga }}</td>
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
                <form method="POST" action="{{ url('/submission-add/' . $add->id) }}">
                    @csrf
                    {!! method_field('PUT') !!}
                    <input type="hidden" name="noKK" value="{{ $add->noKK }}">
                    <input type="hidden" name="jumlah_tanggungan" value="{{ $add->jumlah_tanggungan }}">
                    <input type="hidden" name="aset_kendaraan" value="{{ $add->aset_kendaraan }}">
                    <input type="hidden" name="kondisi_rumah" value="{{ $add->kondisi_rumah }}">
                    <input type="hidden" name="luas_tanah" value="{{ $add->luas_tanah }}">
                    <input type="hidden" name="pendapatan" value="{{ $add->pendapatan }}">
                    <input type="hidden" name="no_hp" value="{{ $add->no_hp }}">
                    <input type="hidden" name="status" value="ditolak">

                    <button type="submit" class="btn btn-sm btn-danger m-2 float-right">Tolak</button>
                </form>

                <a href="{{ url('submission-add') }}" class="btn btn-sm btn-secondary m-2 float-left">Kembali</a>
            @endempty
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

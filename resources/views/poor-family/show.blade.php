@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            @empty($poorFamily)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan shiw.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    @foreach ($criteria as $c)
                        @if (isset($poorFamily->{$c->kode}))
                            @if ($c->nama == 'Jumlah Tanggungan')
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    <td>{{ $poorFamily->{$c->kode} }} orang</td>
                                </tr>
                            @elseif ($c->nama == 'Pendapatan' || $c->nama == 'Aset Kendaraan')
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    <td>Rp{{ $poorFamily->{$c->kode} }}</td>
                                </tr>
                            @elseif ($c->nama == 'Luas Tanah')
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    <td>{{ $poorFamily->{$c->kode} }} m<sup>2</sup></td>
                                </tr>
                            @elseif ($c->nama == 'Kondisi Rumah')
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    @if ($poorFamily->{$c->kode} == 1)
                                        <td>Rumah Kontrak</td>
                                    @elseif ($poorFamily->{$c->kode} == 2)
                                        <td>Buruk Layak</td>
                                    @elseif ($poorFamily->{$c->kode} == 3)
                                        <td>Kurang layak</td>
                                    @elseif ($poorFamily->{$c->kode} == 4)
                                        <td>Cukup Layak</td>
                                    @elseif ($poorFamily->{$c->kode} == 5)
                                        <td>Layak</td>
                                    @endif
                                </tr>
                            @else
                                <tr>
                                    <th>{{ $c->nama }}</th>
                                    <td>{{ $poorFamily->{$c->kode} }}</td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                    <tr>
                        <th style="width: 30%">Bukti Foto</th>
                        <td>
                            @foreach ($bukti as $foto)
                                <img src="{{ asset('storage/' . $foto->nama_bukti) }}" style="max-width:400px; max-height:400px"
                                    class="rounded mb-2">
                            @endforeach
                        </td>
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

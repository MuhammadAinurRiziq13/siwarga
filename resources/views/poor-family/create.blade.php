@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header">
            <h class="card-title mb-0">{{ $page->title }}</h>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('poor-family') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">No KK</label>
                    <div class="col-10">
                        <select class="form-control select2" id="noKK" name="noKK" required>
                        </select>
                        @error('noKK')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Jumlah Tanggungan</label>
                    <div class="col-10">
                        <input type="number" class="form-control" id="jumlah_tanggungan" name="jumlah_tanggungan"
                            value="{{ old('jumlah_tanggungan') }}" required>
                        @error('jumlah_tanggungan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Pendapatan</label>
                    <div class="col-10">
                        <input type="number" class="form-control" id="pendapatan" name="pendapatan"
                            value="{{ old('pendapatan') }}" required>
                        @error('pendapatan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Nilai Aset Kendaraan</label>
                    <div class="col-10">
                        <input type="number" class="form-control" id="aset_kendaraan" name="aset_kendaraan"
                            value="{{ old('aset_kendaraan') }}" required>
                        @error('aset_kendaraan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Luas Tanah</label>
                    <div class="col-10">
                        <input type="number" class="form-control" id="luas_tanah" name="luas_tanah"
                            value="{{ old('luas_tanah') }}" required>
                        @error('luas_tanah')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Kondisi Rumah</label>
                    <div class="col-10">
                        <select class="form-control" id="kondisi_rumah" name="kondisi_rumah" required>
                            <option value="5">Sangat Baik</option>
                            <option value="4">Baik</option>
                            <option value="3">Cukup</option>
                            <option value="2">Kurang</option>
                            <option value="1">Buruk</option>
                        </select>
                        @error('kondisi_rumah')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div> --}}
                @foreach ($criteria as $c)
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">{{ $c->nama }}</label>
                        <div class="col-10">
                            @if ($c->nama == 'Kondisi Rumah')
                                <select class="form-control" id="{{ $c->kode }}" name="{{ $c->kode }}" required>
                                    <option value="5">Sangat Baik</option>
                                    <option value="4">Baik</option>
                                    <option value="3">Cukup</option>
                                    <option value="2">Kurang</option>
                                    <option value="1">Buruk</option>
                                </select>
                            @else
                                <input type="number" class="form-control" id="{{ $c->kode }}"
                                    name="{{ $c->kode }}" value="{{ old($c->kode) }}" required>
                            @endif
                            @error($c->kode)
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                @endforeach
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label"></label>
                    <div class="col-10">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-secondary ml-1" href="{{ url('poor-family') }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'No KK',
                ajax: {
                    url: '/noKK',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.text
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endpush

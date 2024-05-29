@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header">
            <h class="card-title mb-0">{{ $page->title }}</h>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('family') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">No KK</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="noKK" name="noKK" value="{{ old('noKK') }}"
                            required>
                        @error('noKK')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Provinsi</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="provinsi" name="provinsi"
                            value="{{ old('provinsi') }}" required>
                        @error('provinsi')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Kabupaten / Kota</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="kabupaten_kota" name="kabupaten_kota"
                            value="{{ old('kabupaten_kota') }}" required>
                        @error('kabupaten_kota')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Kecamatan</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                            value="{{ old('kecamatan') }}" required>
                        @error('kecamatan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Kelurahan / Desa</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="kelurahan_desa" name="kelurahan_desa"
                            value="{{ old('kelurahan_desa') }}" required>
                        @error('kelurahan_desa')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Alamat</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="alamat" name="alamat"
                            value="{{ old('alamat') }}" required>
                        @error('alamat')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label"></label>
                    <div class="col-10">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-secondary ml-1" href="{{ url('family') }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

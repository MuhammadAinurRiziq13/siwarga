@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header">
            <h class="card-title mb-0">{{ $page->title }}</h>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('submission-prasejahtera') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">No KK</label>
                    <div class="col-10">
                        <select class="form-control select2" id="noKK" name="noKK" disabled>
                            @foreach ($family as $item)
                                <option value="{{ $item->noKK }}" @if ($item->noKK == $nokk) selected @endif>
                                    {{ $item->noKK }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="noKK" name="noKK" value="{{ $nokk }}">
                        @error('noKK')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
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
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">No HP</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="no_hp" name="no_hp"
                            value="{{ old('no_hp') }}" required>
                        @error('no_hp')
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

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
                {{-- <div class="form-group row">
                    <label class="col-2 control-label col-form-label">No KK</label>
                    <div class="col-10">
                        <select class="form-control" id="noKK" name="noKK" required>
                            <option value="">No KK </option>
                            @foreach ($family as $item)
                                <option value="{{ $item->noKK }}">{{ $item->noKK }}</option>
                            @endforeach
                        </select>
                        @error('noKK')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div> --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Nama Criteria</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="nama_criteria" name="nama_criteria" required>
                        </select>
                        @error('noKK')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Bobot Criteria</label>
                    <div class="col-10">
                        <input type="number" class="form-control" id="bobot_criteria" name="bobot_criteria"
                            value="{{ old('bobot_criteria') }}" required>
                        @error('bobot_criteria')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                {{-- <div class="form-group row">
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
@endpush

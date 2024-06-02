@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('poor-family/storeCriteria/' . $criteria->id) }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Nama Criteria</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="{{ old('kode', $criteria->nama) }}" required>
                        @error('nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Code Criteria</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="kode" value="{{ old('kode', $criteria->kode) }}"
                            name="kode" disabled>
                        @error('kode')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Bobot Criteria</label>
                    <div class="col-10">
                        <input type="number" class="form-control" id="bobot" name="bobot"
                            value="{{ old('bobot', $criteria->bobot) }}" required>
                        @error('bobot')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div> --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Bobot Criteria</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="bobot" name="bobot"
                            value="{{ old('bobot', $criteria->bobot) }}" required step="any">
                        @error('bobot')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Jenis Criteria</label>
                    <div class="col-10">
                        <select class="form-control" id="jenis" name="jenis" required>
                            <option value="benefit" @if ($criteria->jenis == 'benefit') selected @endif>Benefit</option>
                            <option value="cost" @if ($criteria->jenis == 'cost') selected @endif>Cost</option>
                        </select>
                        @error('jenis')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label"></label>
                    <div class="col-10">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-secondary ml-1" href="{{ url('poor-family/criteria') }}">Kembali</a>
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

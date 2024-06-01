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
                    <label class="col-2 control-label col-form-label">Code Criteria</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="code" name="code" required>
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
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Jenis Criteria</label>
                    <div class="col-10">
                        <select class="form-control" id="jenis_criteria" name="jenis_criteria" required>
                            <option value="benefit" {{ old('jenis_criteria') == 'benefit' ? 'selected' : '' }}>Benefit</option>
                            <option value="cost" {{ old('jenis_criteria') == 'cost' ? 'selected' : '' }}>Cost</option>
                        </select>
                        @error('jenis_criteria')
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

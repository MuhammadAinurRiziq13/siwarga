@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header">
            <h class="card-title mb-0">{{ $page->title }}</h>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('submission-pengantar') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">NIK</label>
                    <div class="col-10">
                        <select class="form-control select2" id="NIK" name="NIK" required>
                        </select>
                        @error('NIK')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <label class="col-2 control-label col-form-label">NIK</label>
                    <div class="col-10">
                        <select class="form-control" id="NIK" name="NIK" required>
                            @foreach ($warga as $item)
                                <option value="{{ $item->NIK }}">
                                    {{ $item->NIK }}</option>
                            @endforeach
                        </select>
                        @error('NIK')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div> --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Pekerjaan</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                            value="{{ old('pekerjaan') }}" required>
                        @error('pekerjaan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Pendidikan</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="pendidikan" name="pendidikan"
                            value="{{ old('pendidikan') }}" required>
                        @error('pendidikan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">No HP</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                            required>
                        @error('no_hp')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Keperluan</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="keperluan" name="keperluan"
                            value="{{ old('keperluan') }}" required>
                        @error('keperluan')
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
    <script>
        var id = '{{ Auth::user()->username }}';
        console.log(id);

        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'NIK',
                ajax: {
                    url: '/warga/' +
                        id, // Anda perlu memastikan variabel 'id' sudah didefinisikan dengan nilai yang sesuai sebelumnya
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

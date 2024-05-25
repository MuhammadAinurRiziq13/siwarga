@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header">
            <h class="card-title mb-0">{{ $page->title }}</h>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('resident') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">NIK</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="NIK" name="NIK" value="{{ old('NIK') }}"
                            required>
                        @error('NIK')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">No KK</label>
                    <div class="col-10">
                        <select class="form-control select2" id="noKK" name="noKK" required>
                            {{-- <option value="">No KK </option> --}}
                            {{-- @foreach ($family as $item)
                                <option value="{{ $item->noKK }}">{{ $item->noKK }}</option>
                            @endforeach --}}

                        </select>
                        @error('noKK')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Nama</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}"
                            required>
                        @error('nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Tempat Lahir</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                            value="{{ old('tempat_lahir') }}" required>
                        @error('tempat_lahir')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Tanggal Lahir</label>
                    <div class="col-10">
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Jenis Kelamin</label>
                    <div class="col-10">
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Agama</label>
                    <div class="col-10">
                        <select class="form-control" id="agama" name="agama" required>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                        @error('agama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Status Pernikahan</label>
                    <div class="col-10">
                        <select class="form-control" id="status_pernikahan" name="status_pernikahan" required>
                            <option value="Menikah">Menikah</option>
                            <option value="Belum Menikah">Belum Menikah</option>
                        </select>
                        @error('status_pernikahan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Status Pernikahan</label>
                    <div class="col-10">
                        <select class="form-control" id="status_keluarga" name="status_keluarga" required>
                            <option value="kepala keluarga">Kepala Keluarga</option>
                            <option value="istri">Istri</option>
                            <option value="anak">Anak</option>
                        </select>
                        @error('status_keluarga')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label"></label>
                    <div class="col-10">
                        <div>
                            <input type="checkbox" id="kepala_keluarga" name="kepala_keluarga">
                            <label for="kepala_keluarga">Kepala Keluarga</label>
                            @error('kepala_keluarga')
                                <small class="form-text text-danger">{{ $message }}</small>
                                <br>
                            @enderror
                        </div>
                        <div>
                            <input type="checkbox" id="alamat_asal_checkbox" name="alamat_asal_checkbox"
                                onclick="toggleAlamatAsal()">
                            <label for="alamat_asal_checkbox">Warga Sementara</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Alamat Asal</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="alamat_asal" name="alamat_asal"
                            value="{{ old('alamat_asal') }}" required disabled>
                        @error('alamat_asal')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label"></label>
                    <div class="col-10">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-secondary ml-1" href="{{ url('resident') }}">Kembali</a>
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
        function toggleAlamatAsal() {
            var checkbox = document.getElementById("alamat_asal_checkbox");
            var alamatAsalInput = document.getElementById("alamat_asal");

            if (checkbox.checked) {
                alamatAsalInput.disabled = false;
            } else {
                alamatAsalInput.disabled = true;
            }
        }

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

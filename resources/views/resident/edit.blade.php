@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ $page->title }}</h5>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($resident)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('resident') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/resident/' . $resident->NIK) }}" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!}
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">NIK</label>
                        <div class="col-10">
                            <input type="text" class="form-control" id="NIK" name="NIK"
                                value="{{ old('NIK', $resident->NIK) }}" required>
                            @error('NIK')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">No KK</label>
                        <div class="col-10">
                            <select class="form-control" id="noKK" name="noKK" required>
                                <option value="">No KK </option>
                                @foreach ($family as $item)
                                    <option value="{{ $item->noKK }}" @if ($item->noKK == $resident->noKK) selected @endif>
                                        {{ $item->noKK }}</option>
                                @endforeach
                            </select>
                            @error('noKK')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Nama</label>
                        <div class="col-10">
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ old('nama', $resident->nama) }}" required>
                            @error('nama')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Tempat Lahir</label>
                        <div class="col-10">
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                value="{{ old('tempat_lahir', $resident->tempat_lahir) }}" required>
                            @error('tempat_lahir')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Tanggal Lahir</label>
                        <div class="col-10">
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $resident->tanggal_lahir) }}" required>
                            @error('tanggal_lahir')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Jenis Kelamin</label>
                        <div class="col-10">
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="{{ $resident->jenis_kelamin }}"
                                    @if ($resident->jenis_kelamin == 'L') selected @endif>
                                    Laki-Laki</option>
                                <option value="{{ $resident->jenis_kelamin }}"
                                    @if ($resident->jenis_kelamin == 'P') selected @endif>
                                    Perempuan</option>
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
                                <option value="{{ $resident->agama }}" @if ($resident->agama == 'Islam') selected @endif>Islam
                                </option>
                                <option value="{{ $resident->agama }}" @if ($resident->agama == 'Kristen') selected @endif>
                                    Kristen
                                </option>
                                <option value="{{ $resident->agama }}" @if ($resident->agama == 'Katolik') selected @endif>
                                    Katolik
                                </option>
                                <option value="{{ $resident->agama }}" @if ($resident->agama == 'Hindu') selected @endif>Hindu
                                </option>
                                <option value="{{ $resident->agama }}" @if ($resident->agama == 'Budha') selected @endif>Budha
                                </option>
                                <option value="{{ $resident->agama }}" @if ($resident->agama == 'Konghucu') selected @endif>
                                    Konghucu
                                </option>
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
                                <option value="{{ $resident->status_pernikahan }}"
                                    @if ($resident->status_pernikahan == 'Menikah') selected @endif>Menikah</option>
                                <option value="{{ $resident->status_pernikahan }}"
                                    @if ($resident->status_pernikahan == 'Belum Menikah') selected @endif> Belum Menikah</option>
                            </select>
                            @error('status_pernikahan')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label"></label>
                        <div class="col-10">
                            @if ($resident->kepala_keluarga)
                                <div>
                                    <input type="checkbox" id="kepala_keluarga" name="kepala_keluarga" checked>
                                    <label for="kepala_keluarga">Kepala Keluarga</label>
                                    @error('kepala_keluarga')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        <br>
                                    @enderror
                                </div>
                                <div class="family-members" style="display: none;">
                                    @foreach ($anggota as $member)
                                        @if ($member->noKK == $resident->noKK && $member->NIK != $resident->NIK)
                                            <input type="radio" name="family_member" value="{{ $member->NIK }}">
                                            <label for="">{{ $member->nama }}</label><br>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            <div>
                                <input type="checkbox" id="alamat_asal_checkbox" name="alamat_asal_checkbox"
                                    onclick="toggleAlamatAsal()" {{ !is_null($resident->alamat_asal) ? 'checked' : '' }}>
                                <label for="alamat_asal_checkbox">Warga Sementara</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Alamat Asal</label>
                        <div class="col-10">
                            <input type="text" class="form-control" id="alamat_asal" name="alamat_asal"
                                value="{{ old('alamat_asal', $resident->alamat_asal) }}" required
                                @if (is_null($resident->alamat_asal)) disabled @endif>
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
            @endempty
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

        document.getElementById('kepala_keluarga').addEventListener('change', function() {
            var familyMembersDiv = document.querySelector('.family-members');
            var radioInputs = document.querySelectorAll('.family-members input[type="radio"]');
            if (this.checked) {
                familyMembersDiv.style.display = 'none';
                radioInputs.forEach(function(radio) {
                    radio.checked = false;
                });
            } else {
                familyMembersDiv.style.display = 'block';
            }
        });
    </script>
@endpush

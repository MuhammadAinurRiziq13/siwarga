@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('family/resident') }}" class="form-horizontal">
                @csrf
                <div class="form-group row mx-auto">
                    <div class="col-6">
                        <label class="control-label col-form-label">NIK</label>
                        <input type="text" class="form-control coba" id="NIK" name="NIK"
                            value="{{ old('NIK') }}" required>
                        @error('NIK')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="control-label col-form-label">No KK</label>
                        <input type="text" class="form-control coba" id="noKK" name="noKK"
                            value="{{ old('noKK', $data->first()->noKK) }}" required>
                        @error('noKK')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mx-auto">
                    <div class="col-6">
                        <label class="control-label col-form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}"
                            required>
                        @error('nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="control-label col-form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                            value="{{ old('tempat_lahir') }}" required>
                        @error('tempat_lahir')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mx-auto">
                    <div class="col-6">
                        <label class="control-label col-form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="control-label col-form-label">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mx-auto">
                    <div class="col-6">
                        <label class="control-label col-form-label">Agama</label>
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
                    <div class="col-6">
                        <label class="control-label col-form-label">Status Pernikahan</label>
                        <select class="form-control" id="status_pernikahan" name="status_pernikahan" required>
                            <option value="Menikah">Menikah</option>
                            <option value="Belum Menikah">Belum Menikah</option>
                        </select>
                        @error('status_pernikahan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mx-auto">
                    <div class="col-6">
                        <label class="control-label col-form-label">Status Keluarga</label>
                        <select class="form-control" id="status_keluarga" name="status_keluarga" required>
                            @if ($count == 0)
                                <option value="kepala keluarga">Kepala Keluarga</option>
                            @else
                                <option value="anak">Anak</option>
                                <option value="istri">Istri</option>
                            @endif
                        </select>
                        @error('status_keluarga')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="control-label col-form-label">Status Kerja</label>
                        <select class="form-control" id="status_kerja" name="status_kerja" required>
                            <option value="Kerja">Kerja</option>
                            <option value="Tidak Kerja">Tidak Kerja</option>
                        </select>
                        @error('status_kerja')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mx-auto">
                    <label class="control-label col-form-label"></label>
                    <div class="col-10">
                        {{-- <div>
                            <input type="checkbox" id="kepala_keluarga" name="kepala_keluarga">
                            <label for="kepala_keluarga">Kepala Keluarga</label>
                            @error('kepala_keluarga')
                                <small class="form-text text-danger">{{ $message }}</small>
                                <br>
                            @enderror
                        </div> --}}
                        <div>
                            <input type="checkbox" id="alamat_asal_checkbox" name="alamat_asal_checkbox"
                                onclick="toggleAlamatAsal()">
                            <label for="alamat_asal_checkbox">Warga Sementara</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row mx-auto">
                    <div class="col-12">
                        <label class="control-label col-form-label">Alamat Asal</label>
                        <input type="text" class="form-control" id="alamat_asal" name="alamat_asal"
                            value="{{ old('alamat_asal') }}" required disabled>
                        @error('alamat_asal')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-10 m-3">
                        <button type="submit" class="btn btn-primary btn-sm float-left">Simpan</button>
                        <a class="btn btn-sm btn-secondary ml-2 float-left" href="{{ url('family') }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "{{ session('success') }}",
                    text: "",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya",
                    cancelButtonText: "Tidak"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // window.location.href = "/family/{{ $data->first()->noKK }}/create";
                    } else {
                        window.location.href = "{{ url('family') }}"; // Redirect ke halaman utama
                    }
                });
            });
        </script>
    @endif
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
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
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

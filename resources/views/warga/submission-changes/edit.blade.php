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
                <form method="POST" action="{{ url('/resident-edit/') }}" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row mx-auto">
                        <div class="col-6">
                            <label class="control-label col-form-label">NIK</label>
                            <input type="text" class="form-control" id="NIK" name="NIK"
                                value="{{ old('NIK', $resident->NIK) }}" required>
                            @error('NIK')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="control-label col-form-label">No KK</label>
                            <select class="form-control select2" id="noKK" name="noKK" required disabled>
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
                    <div class="form-group row mx-auto">
                        <div class="col-6">
                            <label class="control-label col-form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ old('nama', $resident->nama) }}" required>
                            @error('nama')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="control-label col-form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                value="{{ old('tempat_lahir', $resident->tempat_lahir) }}" required>
                            @error('tempat_lahir')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mx-auto">
                        <div class="col-6">
                            <label class="control-label col-form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $resident->tanggal_lahir) }}" required>
                            @error('tanggal_lahir')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="control-label col-form-label">Jenis Kelamin</label>
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
                    <div class="form-group row mx-auto">
                        <div class="col-6">
                            <label class="control-label col-form-label">Agama</label>
                            <select class="form-control" id="agama" name="agama" required>
                                <option value="{{ $resident->agama }}" @if ($resident->agama == 'Islam') selected @endif>
                                    Islam
                                </option>
                                <option value="{{ $resident->agama }}" @if ($resident->agama == 'Kristen') selected @endif>
                                    Kristen
                                </option>
                                <option value="{{ $resident->agama }}" @if ($resident->agama == 'Katolik') selected @endif>
                                    Katolik
                                </option>
                                <option value="{{ $resident->agama }}" @if ($resident->agama == 'Hindu') selected @endif>
                                    Hindu
                                </option>
                                <option value="{{ $resident->agama }}" @if ($resident->agama == 'Budha') selected @endif>
                                    Budha
                                </option>
                                <option value="{{ $resident->agama }}" @if ($resident->agama == 'Konghucu') selected @endif>
                                    Konghucu
                                </option>
                            </select>
                            @error('agama')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="control-label col-form-label">Status Pernikahan</label>
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
                    <div class="form-group row mx-auto">
                        <div class="col-6">
                            <label class="control-label col-form-label">No Hp</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                value="{{ old('no_hp') }}" required>
                            @error('no_hp')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="control-label col-form-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan"
                                value="{{ old('keterangan') }}" required>
                            @error('keterangan')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mx-auto">
                        <div class="col-6">
                            <label class="control-label col-form-label">Status Keluarga</label>
                            @if ($resident->status_keluarga == 'kepala keluarga')
                                <select class="form-control" id="status_keluarga" name="status_keluarga" required>
                                    <option value="kepala keluarga">Kepala Keluarga</option>
                                    <option value="anak">Anak</option>
                                    <option value="istri">Istri</option>
                                </select>
                            @else
                                <select class="form-control" id="status_keluarga" name="status_keluarga" required>
                                    <option value="{{ $resident->status_keluarga }}"
                                        @if ($resident->status_keluarga == 'anak') selected @endif> Anak </option>
                                    <option value="{{ $resident->status_keluarga }}"
                                        @if ($resident->status_keluarga == 'istri') selected @endif> Istri </option>
                                    <option value="{{ $resident->status_keluarga }}"
                                        @if ($resident->status_keluarga == 'kepala keluarga') selected @endif> Kepala Keluarga </option>
                                </select>
                            @endif
                            @error('status_keluarga')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- <div class="col-6">
                            <label class="control-label col-form-label">Foto Kegiatan</label>
                            <img class="img-preview img-fluid col-sm-5 m-0 p-0 mb-2" style="display:none;">
                            <img class="img-current img-fluid col-sm-5 m-0 p-0 mb-2"
                                src="{{ asset('storage/' . $resident->nama_bukti) }}">
                            <input type="hidden" name="oldImage" value="{{ $resident->nama_bukti }}">
                            <input
                                class="form-control
                                @error('nama_bukti') is-invalid @enderror"
                                type="file" id="image" name="nama_bukti" onchange="previewImage()"
                                value="{{ old('tanggal_kegiatan', $resident->nama_bukti) }}">
                            @error(' nama_bukti')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="col-6">
                            <label class="control-label col-form-label">Foto Bukti</label>
                            <div class="preview-container gap-2">
                                <!-- Placeholder for image previews -->
                            </div>
                            <input class="form-control @error('nama_bukti') is-invalid @enderror" type="file"
                                id="image" name="nama_bukti[]" multiple onchange="previewImages()">
                            @error('nama_bukti')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mx-auto">
                        <label class="control-label col-form-label"></label>
                        <div class="col-6">
                            @if ($resident->status_keluarga == 'kepala keluarga')
                                <input type="hidden" id="kepala_keluarga" name="kepala_keluarga"
                                    value="{{ $resident->status_keluarga }}">
                                <div class="family-members border-bottom mb-2" style="display: none;">
                                    <p>Pilih kepala keluarga pengganti:</p>
                                    @foreach ($anggota as $member)
                                        @if ($member->noKK == $resident->noKK && $member->NIK != $resident->NIK)
                                            <input type="radio" name="family_member" id=""
                                                value="{{ $member->NIK }}">
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
                    <div class="form-group row mx-auto">
                        <div class="col-12">
                            <label class="control-label col-form-label">Alamat Asal</label>
                            <input type="text" class="form-control" id="alamat_asal" name="alamat_asal"
                                value="{{ old('alamat_asal', $resident->alamat_asal) }}" required
                                @if (is_null($resident->alamat_asal)) disabled @endif>
                            @error('alamat_asal')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {{-- <label class="col-6 control-label col-form-label"></label> --}}
                        <div class="col-2 mx-auto">
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
        // function previewImage() {
        //     const image = document.querySelector('#image')
        //     const imgPrev = document.querySelector('.img-preview')
        //     const imgCurnt = document.querySelector('.img-current')

        //     imgPrev.style.display = 'block'
        //     imgCurnt.style.display = 'none'

        //     const oFReader = new FileReader();
        //     oFReader.readAsDataURL(image.files[0]);

        //     oFReader.onload = function(oFREvent) {
        //         imgPrev.src = oFREvent.target.result;
        //     }
        // }

        function previewImages() {
            const input = document.querySelector('#image');
            const previewContainer = document.querySelector('.preview-container');

            // Clear previous previews
            previewContainer.innerHTML = '';

            if (input.files) {
                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-preview', 'img-fluid', 'col-sm-5', 'm-0', 'p-0', 'mb-2', 'mr-2');
                        previewContainer.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }


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

        document.addEventListener("DOMContentLoaded", function() {
            var kepalaKeluargaInput = document.getElementById("kepala_keluarga");
            var statusKeluargaSelect = document.getElementById("status_keluarga");
            var familyMembersDiv = document.querySelector(".family-members");

            // Function to check if kepala_keluarga value is "kepala keluarga"
            function isKepalaKeluarga() {
                return kepalaKeluargaInput.value === "kepala keluarga";
            }

            // Function to check if status_keluarga select value is "anak" or "istri"
            function isAnakOrIstriSelected() {
                var selectedValue = statusKeluargaSelect.options[statusKeluargaSelect.selectedIndex].value;
                return selectedValue === "anak" || selectedValue === "istri";
            }

            // Function to toggle display of family members based on conditions
            function toggleFamilyMembersDisplay() {
                if (isKepalaKeluarga() && isAnakOrIstriSelected()) {
                    familyMembersDiv.style.display = "block";
                } else {
                    familyMembersDiv.style.display = "none";
                }
            }

            // Initial check on page load
            toggleFamilyMembersDisplay();

            // Listen for changes in kepala_keluarga and status_keluarga inputs
            kepalaKeluargaInput.addEventListener("change", toggleFamilyMembersDisplay);
            statusKeluargaSelect.addEventListener("change", toggleFamilyMembersDisplay);
        });
    </script>
@endpush

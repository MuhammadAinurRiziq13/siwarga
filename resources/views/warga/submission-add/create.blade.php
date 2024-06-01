@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">{{ $page->title }}</h6>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('submission-prasejahtera') }}" class="form-horizontal"
                enctype="multipart/form-data">
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
                    <label class="col-2 control-label col-form-label">Foto Bukti</label>
                    <div class="col-10">
                        <div class="preview-container gap-2">
                            <!-- Placeholder for image previews -->
                        </div>
                        <input class="form-control @error('nama_bukti') is-invalid @enderror" type="file" id="image"
                            name="nama_bukti[]" multiple onchange="previewImages()" accept="image/*">
                        @error('nama_bukti')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label"></label>
                    <div class="col-10">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-secondary ml-1"
                            href="{{ url('submission-prasejahtera/' . Auth::user()->username) }}">Kembali</a>
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
    </script>
@endpush

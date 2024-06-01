@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            @empty($gallery)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('gallery') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/gallery/' . $gallery->id_galeri) }}" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    {!! method_field('PUT') !!}
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Nama Kegiatan</label>
                        <div class="col-10">
                            <input type="text" class="form-control" id="judul" name="judul"
                                value="{{ old('judul', $gallery->judul) }}" required>
                            @error('judul')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Tanggal Kegiatan</label>
                        <div class="col-10">
                            <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan"
                                value="{{ old('tanggal_kegiatan', $gallery->tanggal_kegiatan) }}" required>
                            @error('tanggal_kegiatan')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Foto Kegiatan</label>
                        <div class="col-10">
                            <img class="img-preview img-fluid col-sm-5 m-0 p-0 mb-2" style="display:none;">
                            <img class="img-current img-fluid col-sm-5 m-0 p-0 mb-2"
                                src="{{ asset('storage/' . $gallery->nama_foto) }}">
                            <input type="hidden" name="oldImage" value="{{ $gallery->nama_foto }}">
                            <input class="form-control
                                @error('nama_foto') is-invalid @enderror"
                                type="file" id="image" name="nama_foto" onchange="previewImage()"
                                value="{{ old('tanggal_kegiatan', $gallery->nama_foto) }}">
                            @error(' nama_foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Keterangan</label>
                        <div class="col-10">
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required>{{ old('keterangan', $gallery->keterangan) }}</textarea>
                            @error('keterangan')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label"></label>
                        <div class="col-10">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a class="btn btn-sm btn-secondary ml-1" href="{{ url('gallery') }}">Kembali</a>
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
        function previewImage() {
            const image = document.querySelector('#image')
            const imgPrev = document.querySelector('.img-preview')
            const imgCurnt = document.querySelector('.img-current')

            imgPrev.style.display = 'block'
            imgCurnt.style.display = 'none'

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPrev.src = oFREvent.target.result;
            }
        }
    </script>
@endpush

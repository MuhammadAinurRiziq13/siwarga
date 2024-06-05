@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('poor-family') }}" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">No KK</label>
                    <div class="col-10">
                        <select class="form-control select2" id="noKK" name="noKK" required>
                        </select>
                        @error('noKK')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                @foreach ($criteria as $c)
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">{{ $c->nama }}</label>
                        <div class="col-10">
                            @if ($c->nama == 'Kondisi Rumah')
                                <select class="form-control" id="{{ $c->kode }}" name="{{ $c->kode }}" required>
                                    {{-- <option value="5">Sangat Layak</option> --}}
                                    <option value="5">Layak</option>
                                    <option value="4">Cukup Layak</option>
                                    <option value="3">Kurang Layak</option>
                                    <option value="2">Buruk Layak</option>
                                    <option value="1">Rumah Kontrak</option>
                                </select>
                            @else
                                <input type="number" class="form-control" id="{{ $c->kode }}"
                                    name="{{ $c->kode }}" value="{{ old($c->kode) }}" required>
                            @endif
                            @error($c->kode)
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                @endforeach
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Foto Bukti</label>
                    <div class="col-10">
                        <div class="preview-container gap-2">
                            <!-- Placeholder for image previews -->
                        </div>
                        <input class="form-control @error('nama_bukti') is-invalid @enderror" type="file" id="image"
                            name="nama_bukti[]" accept="image/*" multiple onchange="previewImages()" accept="image/*">
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

        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'No KK',
                ajax: {
                    url: '/noKK1',
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

            $('#noKK').on('change', function() {
                var noKK = $(this).val();
                $.ajax({
                    url: '/get-status-kerja',
                    method: 'GET',
                    data: {
                        noKK: noKK
                    },
                    success: function(response) {
                        $('#C1').val(response.count);
                    }
                });
            });
        });
    </script>
@endpush

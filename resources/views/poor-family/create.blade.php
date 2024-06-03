@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('poor-family') }}" class="form-horizontal">
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
                                    <option value="5">Sangat Layak</option>
                                    <option value="4">Layak</option>
                                    <option value="3">Cukup Layak</option>
                                    <option value="2">Kurang Layak</option>
                                    <option value="1">Buruk Layak</option>
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

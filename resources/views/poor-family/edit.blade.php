@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ $page->title }}</h5>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($poorFamily)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('poor-family') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/poor-family/' . $poorFamily->noKK) }}" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!}
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">No KK</label>
                        <div class="col-10">
                            <select class="form-control select2" id="noKK" name="noKK" required>
                                {{-- <option value="">No KK </option> --}}
                                @foreach ($family as $item)
                                    <option value="{{ $item->noKK }}" @if ($item->noKK == $poorFamily->noKK) selected @endif>
                                        {{ $item->noKK }}</option>
                                @endforeach
                            </select>
                            @error('noKK')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Jumlah Tanggungan</label>
                        <div class="col-10">
                            <input type="number" class="form-control" id="jumlah_tanggungan" name="jumlah_tanggungan"
                                value="{{ old('jumlah_tanggungan', $poorFamily->jumlah_tanggungan) }}" required>
                            @error('jumlah_tanggungan')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Pendapatan</label>
                        <div class="col-10">
                            <input type="number" class="form-control" id="pendapatan" name="pendapatan"
                                value="{{ old('pendapatan', $poorFamily->pendapatan) }}" required>
                            @error('pendapatan')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Pengeluaran</label>
                        <div class="col-10">
                            <input type="number" class="form-control" id="pengeluaran" name="pengeluaran"
                                value="{{ old('pengeluaran', $poorFamily->pengeluaran) }}" required>
                            @error('pengeluaran')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Luas Tanah</label>
                        <div class="col-10">
                            <input type="number" class="form-control" id="luas_tanah" name="luas_tanah"
                                value="{{ old('luas_tanah', $poorFamily->luas_tanah) }}" required>
                            @error('luas_tanah')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Kondisi Rumah</label>
                        <div class="col-10">
                            <select class="form-control" id="kondisi_rumah" name="kondisi_rumah" required>
                                <option value="5" @if ($poorFamily->kondisi_rumah == 5) selected @endif>Sangat Baik</option>
                                <option value="4" @if ($poorFamily->kondisi_rumah == 4) selected @endif>Baik</option>
                                <option value="3" @if ($poorFamily->kondisi_rumah == 3) selected @endif>Cukup</option>
                                <option value="2" @if ($poorFamily->kondisi_rumah == 2) selected @endif>Kurang</option>
                                <option value="1" @if ($poorFamily->kondisi_rumah == 1) selected @endif>Buruk</option>
                            </select>
                            @error('kondisi_rumah')
                                <small class="form-text text-danger">{{ $message }}</small>
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
            @endempty
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

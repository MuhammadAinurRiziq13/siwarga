@extends('layouts.app')

@section('content')
    <div class="card shadow">
        <div class="card-header">Profil Pengguna</div>

        <div class="card-body">
            <div class="row d-flex align-items-center p-3 m-3">
                <div class="col-md-4 d-flex justify-content-center position-relative">
                    <div class="image-container">
                        @if ($user->foto)
                            <img id="previewImage" src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil"
                                style="width: 300px; height: 300px;" class="rounded-circle">
                        @else
                            <img id="previewImage" src="{{ asset('img/undraw_profile.svg') }}" alt="Foto Profil"
                                style="width: 300px; height: 300px;" class="rounded-circle">
                        @endif
                        <div class="image-overlay rounded-circle">
                            <form method="POST" enctype="multipart/form-data" action="{{ url('/profile/' . $user->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="file" name="foto" id="photo" class="d-none" onchange="previewFile()">
                                <label for="photo" class="btn btn-primary mt-3">Pilih Foto</label>

                        </div>
                    </div>
                </div>
                <div class="col-md-8">

                    @csrf
                    {!! method_field('PUT') !!}
                    <div class="form-group row d-flex justify-content-center">
                        <label for="nama" class="col-md-2 col-form-label text-md-left">Nama :</label>
                        <div class="col-md-8">
                            <input id="nama" type="text" class="form-control" name="nama"
                                value="{{ $user->nama }}">
                        </div>
                    </div>

                    <div class="form-group row d-flex justify-content-center">
                        <label for="level" class="col-md-2 col-form-label text-md-left">Level :</label>
                        <div class="col-md-8">
                            <input id="level" type="text" class="form-control" name="level"
                                value="{{ $user->level }}" disabled>
                        </div>
                    </div>

                    <div class="form-group row d-flex justify-content-center">
                        <label for="username" class="col-md-2 col-form-label text-md-left">Username :</label>
                        <div class="col-md-8">
                            <input id="username" type="text" class="form-control" name="username"
                                value="{{ $user->username }}" disabled>
                        </div>
                    </div>

                    <div class="form-group row d-flex justify-content-center">
                        <label for="password" class="col-md-2 col-form-label text-md-left">Password :</label>
                        <div class="col-md-8">
                            <input id="password" type="password" class="form-control" name="password">
                        </div>
                    </div>

                    <div class="form-group row mb-0 d-flex justify-content-center">
                        <div class="col-md-8 offset-md-2">
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "Update Profile Telah Berhasil.."
                });
            });
        </script>
    @endif
@endsection

@push('css')
    <style>
        .image-container {
            position: relative;
            cursor: pointer;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-overlay:hover {
            opacity: 1;
        }

        .image-overlay label {
            cursor: pointer;
        }
    </style>
@endpush
@push('js')
    <script>
        function previewFile() {
            var preview = document.getElementById('previewImage');
            var file = document.querySelector('input[type=file]').files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "{{ asset('img/undraw_profile.svg') }}";
            }
        }
    </script>
@endpush

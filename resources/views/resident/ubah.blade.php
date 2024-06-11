@extends('layouts.app')

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-dark-blue">
            <h6 class="card-title mb-0 text-white">{{ $page->title }}</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('/resident/' . $resident->NIK . '/ubah') }}" class="form-horizontal">
                @csrf
                {!! method_field('PUT') !!}
                <div class="form-group row mx-auto">
                    <div class="col-6">
                        <p>Pilih kepala keluarga pengganti:</p>
                        @foreach ($anggota as $member)
                            @if ($member->noKK == $resident->noKK && $member->NIK != $resident->NIK)
                                @php
                                    $inputId = 'family_member_' . $member->NIK;
                                @endphp
                                <input type="radio" name="family_member" id="{{ $inputId }}"
                                    value="{{ $member->NIK }}">
                                <label for="{{ $inputId }}">{{ $member->nama }}</label><br>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-10 m-3">
                        <button type="submit" class="btn btn-primary btn-sm float-left">Simpan</button>
                        <a class="btn btn-sm btn-secondary ml-2 float-left" href="{{ url('resident') }}">Kembali</a>
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

        // document.getElementById('kepala_keluarga').addEventListener('change', function() {
        //     var familyMembersDiv = document.querySelector('.family-members');
        //     var radioInputs = document.querySelectorAll('.family-members input[type="radio"]');
        //     if (this.checked) {
        //         familyMembersDiv.style.display = 'none';
        //         radioInputs.forEach(function(radio) {
        //             radio.checked = false;
        //         });
        //     } else {
        //         familyMembersDiv.style.display = 'block';
        //     }
        // });
    </script>
@endpush

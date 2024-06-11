@extends('layouts.app')

@section('content')
    <!-- Content Row -->
    @if (Auth::user()->level == 'admin' || Auth::user()->level == 'superadmin')
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    JUMLAH WARGA</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalResident }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    JUMLAH KK</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalFamily }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    JUMLAH PERANTAU</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTemporaryResident }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    JUMLAH Keluarga Prasejahtera</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPoorFamily }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-injured fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-8">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    {{-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div> --}}
                    <!-- Card Body -->
                    <div class="card-body" style="height: 450px;">
                        {!! $chart->container() !!}
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-4">
                <div class="card shadow mb-4" style="height: 210px;">
                    <!-- Card Header - Dropdown -->
                    {{-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div> --}}
                    <!-- Card Body -->
                    <div class="card-body">
                        {!! $chart1->container() !!}
                    </div>
                </div>

                <div class="card shadow mb-4" style="height: 210px;">
                    <!-- Card Header - Dropdown -->
                    {{-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div> --}}
                    <!-- Card Body -->
                    <div class="card-body">
                        {!! $chart2->container() !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
                <div class="card card-outline card-primary shadow">
                    <div class="card-header bg-dark-blue">
                        <h6 class="card-title mb-0 text-white">Data Keluarga</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover table-sm">
                            <tr>
                                <th>No KK</th>
                                <td id="noKK"></td>
                            </tr>
                            <tr>
                                <th>Kepala Keluarga</th>
                                <td id="nama"></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td id="alamat"></td>
                            </tr>
                            <tr>
                                <th>Kelurahan Desa</th>
                                <td id="kelurahan_desa"></td>
                            </tr>
                            <tr>
                                <th>Kecamatan</th>
                                <td id="kecamatan"></td>
                            </tr>
                            <tr>
                                <th>Kabupaten Kota</th>
                                <td id="kabupaten_kota"></td>
                            </tr>
                            <tr>
                                <th>Provinsi</th>
                                <td id="provinsi"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">

            </div>
            
        </div>
    @endif
    
    <div class="container">
        <br><br><br>
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <iframe width="100%" height="350" src="https://lookerstudio.google.com/embed/reporting/b9ee3ea2-7587-4757-bacd-791b8f328774/page/p_tj4qvlmxhd" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
            </div>
            <div class="col-xl-6 col-lg-6">
                <iframe width="100%" height="350" src="https://lookerstudio.google.com/embed/reporting/b9ee3ea2-7587-4757-bacd-791b8f328774/page/p_6qog9anxhd" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
            </div>
        </div>
        <div class="row">
            <div class="justify-content-center d-flex col-12">
            {{-- <div class="col-12"> --}}
                <iframe width="500" height="400" src="https://lookerstudio.google.com/embed/reporting/b9ee3ea2-7587-4757-bacd-791b8f328774/page/p_j16eabnxhd" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
            </div>
        </div>
    </div>
    {{-- <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-12 mb-3">
                        <iframe width="100%" height="350" src="https://lookerstudio.google.com/embed/reporting/b9ee3ea2-7587-4757-bacd-791b8f328774/page/p_tj4qvlmxhd" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
                        <iframe width="100%" height="700" src="https://lookerstudio.google.com/embed/reporting/b9ee3ea2-7587-4757-bacd-791b8f328774/page/p_6qog9anxhd" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
                    </div>
                    <div class="col-12 mb-3">
                        <iframe width="100%" height="350" src="https://lookerstudio.google.com/embed/reporting/b9ee3ea2-7587-4757-bacd-791b8f328774/page/p_j16eabnxhd" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    

    @if ($message = Session::get('LoginBerhasil'))
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
                    title: "Login Telah Berhasil.."
                });
            });
        </script>
    @endif
@endsection

@push('js')
    <script src="{{ $chart->cdn() }}"></script>
    <script src="{{ $chart1->cdn() }}"></script>
    <script src="{{ $chart2->cdn() }}"></script>

    {{ $chart->script() }}
    {{ $chart1->script() }}
    {{ $chart2->script() }}

    <script>
        var id = '{{ Auth::user()->username }}';
        console.log(id);

        $(document).ready(function() {
            $.ajax({
                url: '/keluarga/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Mengisi tabel dengan data keluarga yang diterima dari server
                    $('#noKK').text(response.noKK);
                    $('#nama').text(response.nama);
                    $('#alamat').text(response.alamat);
                    $('#kecamatan').text(response.kecamatan);
                    $('#kabupaten_kota').text(response.kabupaten_kota);
                    $('#kelurahan_desa').text(response.kelurahan_desa);
                    $('#provinsi').text(response.provinsi);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endpush

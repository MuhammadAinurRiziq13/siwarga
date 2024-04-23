<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SiWarga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    {{-- css --}}
    <link rel="stylesheet" href="/css/style.css">
  </head>
  <body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100 pt-4">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        
            @if (session()->has('LoginError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('LoginError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100 text-decoration-none fw-bolder text-dark h1">
                  {{-- <img src="../assets/images/logos/dark-logo.svg" width="180" alt=""> --}}
                  SiWarga
                </a>
                <p class="text-center">Aplikasi Pendataan Warga</p>
                <form action="/login" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Username</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" value="{{ old('email') }}">
                        @error('email')                
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password">
                        @error('password')                
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                          <input class="form-check-input primary" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                          <label class="form-check-label text-dark" for="remember">
                              Remeber this Device
                          </label>
                        </div>
                        <a class="text-primary fw-bold" href="./index.html">Forgot Password ?</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-8 fs-5 mb-4 rounded-2">Sign In</button>
                </form>
                <div class="d-flex align-items-center justify-content-center">
                  <p class="fs-3 mb-0 fw-bold">Not Registered?</p>
                  <a class="text-primary fw-bold ms-2" href="./authentication-register.html">Create an account</a>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>


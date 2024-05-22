<nav class="navbar navbar-expand-lg navbar-light d-flex justify-content-center align-items-center">
    <div class="container" style="text-transform: uppercase; font-size:15px; font-weight:500;">
        <a class="navbar-brand fw-bolder fs-4" href="/">
            <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/4d556d519b490944245704be3d8858cb517bea1d25db73158b6a1f1b782cf518?apiKey=cfbeda57ea98489b824f8f843623dee9&"
                alt="Dashboard logo" class="logo" style="width: 250px;" />
        </a>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page"
                        href="/">dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dataDiri') ? 'active' : '' }} " href="/dataDiri">data diri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('prasejahtera') ? 'active' : '' }} "
                        href="/prasejahtera">pengajuan surat prasejahtera</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Welcome Back, {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-speedometer2"></i> My
                                    Dashboard</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="/logout" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                    </li>
                @else
                    <li class="nav-item"
                        style="background-color: #becfce; color: #072a27; border-radius: 10px; padding: 1px;">
                        <a href="/login" class="nav-link {{ request()->is('login') ? 'active' : '' }}">
                            <i class="fas fa-sign-in-alt"></i> Log in
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

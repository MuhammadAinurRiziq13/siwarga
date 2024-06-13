<ul class="navbar-nav bg-dark-blue sidebar sidebar-dark accordion " id="accordionSidebar">

    <!-- Sidebar - Brand -->

    {{-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#"> --}}
    {{-- <div class="sidebar-brand-icon rotate-n-15"> --}}
        {{-- <i class="fas fa-user-cog"></i> --}}
            <a href="#" class="sidebar-brand d-flex align-items-center justify-content-center">
                <img height="50" src="{{ asset('img/logo siwarga.png') }}" alt="">
                <div class="sidebar-brand-text mx-2 ">PORT-05</div>
            </a>
        {{-- </div> --}}
    {{-- </a> --}}

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a href="{{ url('/dashboard') }}" class="nav-link">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    @if (Auth::user()->level == 'admin' || Auth::user()->level == 'superadmin')
        <!-- Heading -->
        <div class="sidebar-heading">
            Data Penduduk
        </div>

        <li class="nav-item {{ request()->is('family*') ? 'active' : '' }} ">
            <a href="{{ url('/family') }}" class="nav-link">
                <i class="fas fa-fw fa-users"></i>
                <span>Keluarga</span></a>
        </li>
        <li class="nav-item {{ request()->is('resident*') || request()->is('submission-changes*') ? 'active' : '' }}">
            <a href="{{ url('/resident') }}" class="nav-link">
                <i class="fas fa-fw fa-user-alt"></i>
                <span>Data Warga</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('poor-family*') || request()->is('submission-add*') ? 'active' : '' }}">
            <a href="{{ url('/poor-family') }}" class="nav-link">
                <i class="fas fa-fw fa-user-injured"></i>
                <span>Keluarga Prasejahtera</span></a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Landing Page
        </div>

        <li class="nav-item {{ request()->is('gallery*') ? 'active' : '' }}">
            <a href="{{ url('/gallery') }}" class="nav-link">
                <i class="fas fa-fw fa-images"></i>
                <span>Galeri</span></a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Pengajuan
        </div>

        <li class="nav-item {{ request()->is('submission-letter*') ? 'active' : '' }}">
            <a href="{{ url('/submission-letter') }}" class="nav-link">
                <i class="fas fa-fw fa-file-pdf"></i>
                <span>Surat Pengantar</span></a>
        </li>
    @else
        <div class="sidebar-heading">
            Pengajuan
        </div>

        <li class="nav-item {{ request()->is('resident-edit*') || request()->is('resident-edit*') ? 'active' : '' }}">
            <a href="{{ url('/resident-edit/' . Auth::user()->username) }}" class="nav-link">
                <i class="fas fa-fw fa-user-clock"></i>
                <span>Edit Data Warga</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('') || request()->is('submission-prasejahtera*') ? 'active' : '' }}">
            <a href="{{ url('/submission-prasejahtera/' . Auth::user()->username) }}" class="nav-link">
                <i class="fas fa-fw fa-user-injured"></i>
                <span>Keluarga Prasejahtera</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('') || request()->is('submission-pengantar*') ? 'active' : '' }}">
            <a href="{{ url('/submission-pengantar/' . Auth::user()->username) }}" class="nav-link">
                <i class="fas fa-fw fa-file-pdf"></i>
                <span>Surat Pengantar</span>
            </a>
        </li>
    @endif

    <hr class="sidebar-divider">


    {{-- <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> --}}

    {{-- <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li> --}}

    {{-- <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components,
            and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to
            Pro!</a>
    </div> --}}

</ul>

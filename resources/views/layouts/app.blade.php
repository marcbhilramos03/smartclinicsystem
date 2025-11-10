<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartClinic') }}</title>

    <!-- Bootstrap & SB Admin CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon-16x16.png') }}">
<style>
html, body {
    height: 100%;
    margin: 0;
    font-family: 'Poppins', sans-serif;
    font-size: 110%;
}

/* Text scaling */
body, p, a, li, span {
    font-size: 1.1rem;
}

h1 { font-size: 2.75rem; }
h2 { font-size: 2.25rem; }
h3 { font-size: 1.9rem; }
h4 { font-size: 1.5rem; }
h5, h6 { font-size: 1.25rem; }

#wrapper {
    display: flex;
    min-height: 100vh;
}

/* --- Sidebar (desktop view) --- */
.sidebar {
    background-color: #1c0568;
    width: 240px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    overflow-y: auto;
    transition: transform 0.3s ease-in-out;
    z-index: 1030;
}

.sidebar .nav-link {
    color: #adb5bd;
    padding: 0.9rem 1.1rem;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: flex-start;
}

.sidebar .nav-link i {
    margin-right: 0.6rem;
    font-size: 1.3rem;
}

.sidebar .nav-link.active {
    background-color: #495057;
    color: #fff;
    font-weight: bold;
}

/* --- Content Wrapper --- */
#content-wrapper {
    margin-left: 240px;
    width: calc(100% - 240px);
    transition: all 0.3s ease-in-out;
    padding-top: 80px; /* content below fixed navbar */
}

/* --- Topbar (fixed) --- */
nav.topbar {
    background: linear-gradient(90deg, #19273d 0%, #192030 100%) !important;
    color: #fff !important;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    padding: 1rem 1.25rem;
    position: fixed;
    top: 0;
    left: 240px;
    width: calc(100% - 240px);
    z-index: 1050;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.3s ease-in-out;
}

/* --- Sidebar Toggle --- */
#sidebarToggleTop {
    background: none;
    border: none;
    font-size: 1.7rem;
    color: white;
    cursor: pointer;
    display: none;
}

/* --- Sidebar Overlay --- */
.sidebar-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.4);
    z-index: 1029;
    display: none;
}

.sidebar-overlay.active {
    display: block;
}

/* --- Mobile Responsive --- */
@media (max-width: 992px) {
    nav.topbar {
        left: 0;
        width: 100%;
    }

    #content-wrapper {
        margin-left: 0;
        width: 100%;
        padding-top: 80px;
    }

    #sidebarToggleTop {
        display: inline-block;
    }
}

/* --- Bottom Navbar on Mobile (≤768px) --- */
@media (max-width: 768px) {
    html { font-size: 95%; }

    /* Hide left sidebar */
    .sidebar {
        position: fixed;
        bottom: 0;
        top: auto;
        left: 0;
        width: 100%;
        height: 65px;
        background-color: #1c0568;
        display: flex;
        justify-content: space-around;
        align-items: center;
        overflow: hidden;
        border-top: 3px solid #3e4c6d;
        box-shadow: 0 -2px 5px rgba(0,0,0,0.3);
        z-index: 1060;
    }

    .sidebar .nav-link {
        flex-direction: column;
        color: #adb5bd;
        font-size: 0.85rem;
        padding: 0;
    }

    .sidebar .nav-link i {
        margin: 0;
        font-size: 1.4rem;
    }

    .sidebar .nav-link.active {
        color: #ffffff;
        background: none;
    }

    #content-wrapper {
        margin: 0;
        width: 100%;
        padding-top: 80px;
        padding-bottom: 70px; /* space for bottom navbar */
    }

    nav.topbar {
        left: 0;
        width: 100%;
    }
}


</style>

</head>

<body id="page-top">
<div id="wrapper">

    {{-- Show sidebar only if NOT on profile page --}}
    @if(auth()->user()->role === 'admin' && !request()->routeIs(auth()->user()->role . '.profile'))
        @php
            $sidebarLinks = [
                ['route'=>'admin.dashboard','icon'=>'fa-tachometer-alt','label'=>'Dashboard'],
                ['route'=>'admin.users.index','icon'=>'fa-users','label'=>'Manage Users'],
                ['route'=>'admin.patients.index','icon'=>'fa-file-medical','label'=>'Students'],
                ['route'=>'admin.checkups.index','icon'=>'fa-notes-medical','label'=>'Checkups'],
            ];
        @endphp

        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon"><i class="fas fa-heartbeat"></i></div>
                <div class="sidebar-brand-text mx-3">SMARTCLINIC</div>
            </a>
            <hr class="sidebar-divider my-0">
            <br><br><br>

            @foreach($sidebarLinks as $link)
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs($link['route'].'*') ? 'active' : '' }}" href="{{ route($link['route']) }}">
                        <i class="fas {{ $link['icon'] }}"></i>
                        <span>{{ $link['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    <!-- Content Wrapper -->
    <div id="content-wrapper" @if(auth()->user()->role !== 'admin' || request()->routeIs(auth()->user()->role . '.profile')) style="margin-left:0;width:100%;" @endif>
        {{-- Hide topbar on profile page --}}
        @unless(request()->routeIs(auth()->user()->role . '.profile'))
            <nav class="navbar navbar-expand topbar mb-4 shadow">
                @if(auth()->user()->role === 'admin')
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3 text-white">
                        <i class="fa fa-bars"></i>
                    </button>

                    <form action="{{ route('search.patients') }}" method="GET"
                          class="d-none d-sm-inline-block form-inline me-auto ms-md-3 my-2 my-md-0 navbar-search"
                          style="max-width: 900px;">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control small"
                                   placeholder="Search students..." aria-label="Search"
                                   aria-describedby="basic-addon2"
                                          style="text-transform: uppercase;"
>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i> Search
                            </button>
                        </div>
                    </form>
                @endif

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle text-dark" href="#" id="userDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="img-profile rounded-circle" src="{{ asset('images/profile.png') }}">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route(auth()->user()->role . '.profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-dark"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        @endunless

        <!-- Main Content -->
        <div class="container-fluid">
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show">
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-danger shadow-lg">
      <div class="modal-header bg-danger text-white d-flex align-items-center">
        <i class="fas fa-exclamation-triangle fa-2x me-2"></i>
        <h5 class="modal-title fw-bold" id="logoutModalLabel">Confirm Logout</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center fs-6">
        <p class="mb-0">Are you sure you want to <strong>logout</strong> from your account?</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
          <i class="fas fa-times me-1"></i> Cancel
        </button>
        <form id="logout-form-modal" action="{{ route('logout') }}" method="POST" style="display:inline-block;">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('vendor/js/sb-admin-2.min.js') }}"></script>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
@yield('scripts')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    const toggleBtn = document.querySelector('#sidebarToggleTop');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });
});
</script>


</body>
</html>

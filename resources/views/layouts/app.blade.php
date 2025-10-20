<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartClinic') }}</title>

    <!-- SB Admin CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
          crossorigin="anonymous">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">

    <style>
        html, body {
            height: 100%;
        }

        #wrapper {
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        /* Sidebar for admin/staff only */
        @if(auth()->user()->role !== 'patient')
        .sidebar {
            background-color: #1c0568;
            width: 220px;
            transition: all 0.3s ease;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
            z-index: 1030;
        }

        #content-wrapper {
            margin-left: 220px;
            width: calc(100% - 220px);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        @else
        /* Patients: full width content */
        #content-wrapper {
            margin-left: 0;
            width: 100%;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        @endif

        nav.topbar {
            background: linear-gradient(90deg, #19273d 0%, #192030 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            position: sticky;
            top: 0;
            z-index: 1020;
            padding: 0.75rem 1rem;
        }

        .content-wrapper .container-fluid {
            padding: 1.5rem;
            background-color: #f8f9fc;
            flex-grow: 1;
        }

        .btn-primary {
            background-color: #1f3a7d;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2b4ea1;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
            }

            #content-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body id="page-top">

<div id="wrapper">

    @if(auth()->user()->role !== 'patient')
        <!-- Sidebar for admin/staff -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <div class="sidebar-brand-text">SMARTCLINIC</div>
            </a>

            <hr class="sidebar-divider my-0">

            @php
                $user = Auth::user();
                $sidebarLinks = match($user->role) {
                    'admin' => [
                        ['route' => 'admin.dashboard', 'icon' => 'fa-tachometer-alt', 'label' => 'Dashboard'],
                        ['route' => 'admin.users.index', 'icon' => 'fa-users', 'label' => 'Manage Users'],
                        ['route' => 'admin.patients.index', 'icon' => 'fa-file-medical', 'label' => 'Patients Records'],
                        ['route' => 'admin.checkups.index', 'icon' => 'fa-notes-medical', 'label' => 'Checkups'],
                        ['route' => 'admin.inventory.index', 'icon' => 'fa-box', 'label' => 'Inventory Management'],
                    ],
                    'staff' => [
                        ['route' => 'staff.dashboard', 'icon' => 'fa-tachometer-alt', 'label' => 'Dashboard'],
                        ['route' => 'staff.checkups.index', 'icon' => 'fa-notes-medical', 'label' => 'Checkups'],
                    ],
                    default => []
                };
            @endphp

            @foreach($sidebarLinks as $item)
                <li class="nav-item {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route($item['route']) }}">
                        <i class="fas fa-fw {{ $item['icon'] }}"></i>
                        <span>{{ $item['label'] }}</span>
                    </a>
                </li>
            @endforeach

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
    @endif

    <!-- Content Wrapper -->
    <div id="content-wrapper">
        <!-- Topbar -->
        <nav class="navbar navbar-expand topbar mb-4 shadow">
            @if(auth()->user()->role !== 'patient')
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3 text-white">
                    <i class="fa fa-bars"></i>
                </button>
            @endif

            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                <form action="{{ route('search.patients') }}" method="GET"
                      class="d-none d-sm-inline-block form-inline me-auto ms-md-3 my-2 my-md-0 navbar-search"
                      style="max-width: 900px;">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control small"
                               placeholder="Search patients..." aria-label="Search" aria-describedby="basic-addon2">
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
                        <span class="me-2 d-none d-lg-inline small">{{ auth()->user()->first_name }}</span>
                        <img class="img-profile rounded-circle" src="{{ asset('images/profile.png') }}">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route(auth()->user()->role . '.profile') }}">
                                <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-dark"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- Scrollable Content -->
        <div class="content-wrapper">
            <div class="container-fluid">

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')

            </div>
        </div>
    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('vendor/js/sb-admin-2.min.js') }}"></script>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

</body>
</html>

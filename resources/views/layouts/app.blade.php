<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel SB Admin') }}</title>

    <!-- SB Admin CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
          crossorigin="anonymous">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">

    <style>
        html, body {
            height: 100%;
            overflow: hidden; /* Prevent full-page scroll */
        }

        #wrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
            z-index: 1030;
        }

        #content-wrapper {
            margin-left: 250px; /* Adjust if sidebar width changes */
            width: calc(100% - 250px);
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        nav.topbar {
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .content-wrapper {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1rem;
            background-color: #f8f9fc;
        }

        footer.sticky-footer {
            background: #fff;
            border-top: 1px solid #e3e6f0;
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">
        <!-- Sidebar -->
        @php
            $user = Auth::user();
            $sidebarLinks = match($user->role) {
                'admin' => [
                    ['route' => 'admin.dashboard', 'icon' => 'fa-tachometer-alt', 'label' => 'Dashboard'],
                    ['route' => 'admin.users.index', 'icon' => 'fa-users', 'label' => 'Manage Users'],
                    ['route' => 'admin.patients.index', 'icon' => 'fa-file-medical', 'label' => 'Patients Records'],
                    ['route' => 'admin.checkups.index', 'icon' => 'fa-notes-medical', 'label' => 'Checkups'],
                    ['route' => 'admin.inventory.index', 'icon' => 'fa-box', 'label' => 'Inventory', 'submenu' => [
                        ['route' => 'admin.inventory.index', 'icon' => 'fa-list', 'label' => 'View Inventory'],
                        ['route' => 'admin.inventory.archived', 'icon' => 'fa-plus', 'label' => 'Archived Items'],
                    ]],
                ],
                'staff' => [
                    ['route' => 'staff.dashboard', 'icon' => 'fa-tachometer-alt', 'label' => 'Dashboard'],
                    ['route' => 'staff.checkups.index', 'icon' => 'fa-notes-medical', 'label' => 'Checkups'],
                ],
                'patient' => [
                    ['route' => 'patient.dashboard', 'icon' => 'fa-tachometer-alt', 'label' => 'Dashboard'],
                    ['route' => 'patient.medical_records.index', 'icon' => 'fa-file-medical', 'label' => 'My Medical Records'],
                    // ['route' => 'patient.appointments', 'icon' => 'fa-calendar-check',  'label' => 'My Appointments'],
                ],
                default => []
            };
        @endphp

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">{{ config('app.name', 'SmartClinic') }}</div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Dynamic Sidebar -->
            @foreach($sidebarLinks as $item)
                @if(isset($item['submenu']))
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#"
                           data-bs-toggle="collapse"
                           data-bs-target="#collapse-{{ Str::slug($item['label']) }}"
                           aria-expanded="false" aria-controls="collapse-{{ Str::slug($item['label']) }}">
                            <i class="fas fa-fw {{ $item['icon'] }}"></i>
                            <span>{{ $item['label'] }}</span>
                        </a>
                        <div id="collapse-{{ Str::slug($item['label']) }}" class="collapse" data-bs-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                @foreach($item['submenu'] as $sub)
                                    <a class="collapse-item {{ request()->routeIs($sub['route']) ? 'active' : '' }}"
                                       href="{{ route($sub['route']) }}">
                                        <i class="fas fa-fw {{ $sub['icon'] }}"></i> {{ $sub['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                @else
                    <li class="nav-item {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route($item['route']) }}">
                            <i class="fas fa-fw {{ $item['icon'] }}"></i>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow topbar">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
                    <i class="fa fa-bars"></i>
                </button>

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

                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                    <form action="{{ route('search.patients') }}" method="GET"
                        class="d-none d-sm-inline-block form-inline me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control bg-light border-0 small"
                                   placeholder="Search patients..." aria-label="Search" aria-describedby="basic-addon2">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i> Search
                            </button>
                        </div>
                    </form>
                @endif

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="me-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->first_name }}</span>
                            <img class="img-profile rounded-circle" src="{{ auth()->user()->profile_photo_url }}">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                            @if(auth()->user()->isAdmin())
                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Profile
                                </a>
                            @elseif(auth()->user()->isStaff())
                                <a class="dropdown-item" href="{{ route('staff.profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Profile
                                </a>
                            @elseif(auth()->user()->isPatient())
                                <a class="dropdown-item" href="{{ route('patient.profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Profile
                                </a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- Scrollable Content -->
            <div class="content-wrapper">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendor/js/sb-admin-2.min.js') }}"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title', 'Dashboard') &mdash; Posyandu</title>

    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    @stack('styles')
</head>

<body>
    <div id="app">
        <!-- Navbar -->
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li>
                        <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                            <i class="fas fa-bars"></i>
                        </a>
                    </li>
                </ul>
            </form>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                            class="rounded-circle mr-1">
                        <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-title">
                            Role: <span class="badge badge-primary text-uppercase">{{ Auth::user()->role }}</span>
                        </div>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <div class="main-sidebar sidebar-style-2">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <a href="#">Posyandu</a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="#">PS</a>
                </div>
                <ul class="sidebar-menu">
                    <li class="menu-header">Main</li>

                    {{-- Admin Menu --}}
                    @if (Auth::user()->isAdmin())
                        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-fire"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        {{-- Tambahkan menu admin lainnya di sini --}}
                    @endif

                    {{-- Kasir Menu --}}
                    @if (Auth::user()->isKasir())
                        <li class="{{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('kasir.dashboard') }}">
                                <i class="fas fa-fire"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        {{-- Tambahkan menu kasir lainnya di sini --}}
                    @endif

                    {{-- User Menu --}}
                    @if (Auth::user()->isUser())
                        <li class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('user.dashboard') }}">
                                <i class="fas fa-fire"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        {{-- Tambahkan menu user lainnya di sini --}}
                    @endif

                </ul>
            </aside>
        </div>

        <!-- Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>@yield('page-title', 'Dashboard')</h1>
                    <div class="section-header-breadcrumb">
                        @yield('breadcrumb')
                    </div>
                </div>

                <div class="section-body">
                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="footer-left">
                Copyright &copy; {{ date('Y') }} <div class="bullet"></div> Posyandu
            </div>
        </footer>
    </div>

    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    @stack('scripts')
</body>

</html>

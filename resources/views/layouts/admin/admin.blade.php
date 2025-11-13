<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin Panel - SB Admin</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @livewireStyles
    @stack('head')
</head>

<body class="sb-nav-fixed">
    <!-- Navbar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{ route('admin.dashboard') }}">INNOFORUM</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar User Menu-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('admin.settings.show') }}">Settings</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <!-- Sidebar -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <!-- DASHBOARD -->
                        <div class="sb-sidenav-menu-heading">Dashboard</div>
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                            href="{{ route('admin.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <!-- MANAJEMEN PENGGUNA -->
                        <div class="sb-sidenav-menu-heading">Manajemen</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Manajemen Pengguna
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseUser" aria-labelledby="headingUser"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('admin.users.index') }}">Semua Pengguna</a>
                            </nav>
                        </div>

                        <!-- PERTANYAAN -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseThreads" aria-expanded="false" aria-controls="collapseThreads">
                            <div class="sb-nav-link-icon"><i class="fas fa-question-circle"></i></div>
                            Pertanyaan
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseThreads" aria-labelledby="headingThreads"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('admin.threads.index') }}">Semua Pertanyaan</a>
                                <a class="nav-link" href="{{ route('admin.threads.reported') }}">Pertanyaan
                                    Dilaporkan</a>
                            </nav>
                        </div>

                        <!-- KOMENTAR -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseComments" aria-expanded="false"
                            aria-controls="collapseComments">
                            <div class="sb-nav-link-icon"><i class="fas fa-comment-dots"></i></div>
                            Komentar
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseComments" aria-labelledby="headingComments"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('admin.comments.index') }}">Semua Komentar</a>
                                <a class="nav-link" href="{{ route('admin.comments.reported') }}">Komentar
                                    Dilaporkan</a>
                            </nav>
                        </div>

                        <!-- KATEGORI FORUM -->
                        <a class="nav-link" href="{{ route('admin.categories.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                            Kategori Forum
                        </a>

                        <!-- STATISTIK FORUM -->
                        <a class="nav-link" href="{{ route('admin.stats.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                            Statistik Forum
                        </a>

                        <!-- PENGUMUMAN -->
                        <a class="nav-link" href="{{ route('admin.announcements.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-bullhorn"></i></div>
                            Pengumuman
                        </a>

                        <!-- KALENDER AKADEMIK -->
                        <a class="nav-link" href="{{ route('admin.calendar.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                            Kalender Akademik
                        </a>

                        <!-- Pusat Bantuan -->
                        <a class="nav-link" href="{{ route('admin.messages.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div>
                            Pusat Bantuan
                            @php $unread = \App\Models\Message::where('is_read', false)->count(); @endphp
                            @if ($unread)
                                <span class="badge badge-danger ml-2">{{ $unread }}</span>
                            @endif
                        </a>

                        <!-- Activity Admin -->
                        <a class="nav-link" href="{{ route('admin.activities.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                            Aktivitas Admin
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    {{ Auth::user()->name ?? 'Admin' }}
                </div>
            </nav>
        </div>
        <!-- Main Content -->
        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; {{ date('Y') }} Innoforum </div>
                        <div>
                            <a href="{{ route('admin.privacy.policy') }}">Privacy Policy</a>
                            &middot;
                            <a href="{{ route('admin.terms.conditions') }}">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('admin/js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('admin/js/datatables-simple-demo.js') }}"></script>
    @livewireScripts
    @stack('scripts')
</body>

</html>

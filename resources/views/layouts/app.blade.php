
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/assets/css/bootstrap.css">

    <link rel="stylesheet" href="/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/app.css?v={{ \Str::uuid() }}">
    <link rel="shortcut icon" href="/assets/images/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <style>
        html, body {
            font-family: 'DM Sans', sans-serif;
            background-color: #f8f9fa;
        }
        .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
            color: #000000DE
        }
        .form-group label {
            color: #00000099;
            font-size: 14px;
            font-weight: 500
        }
        .form-control, .form-select {
            border-radius: 2rem;
            background-color: #0000000a;
            color: #000000de
        }
        .btn {
            border-radius: 2rem
        }
        th {
            font-size: 12px;
            color: #00000099;
            font-weight: 600
        }
        td {
            color: #000000de;
        }
        .btn-primary {
            background-color: #536DFE;
            border: 0
        }
        .btn-success {
            background-color: #4CAF50;
            border: 0
        }
        .bg-success {
            background-color: #4CAF50!important;
        }
        .badge {
            border-radius: 2rem
        }
        .btn-danger {
            background-color: #F44336;
            border: 0
        }
        .text-muted {
            color: #9E9E9E!important
        }
        .input-group-text{
            border-radius: 2rem 0 0 2rem;
        }
    </style>
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-item @if(in_array(\Route::currentRouteName(), ['dashboard'])) active @endif">
                            <a href="/" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Tahapan</li>
                        <li class="sidebar-item @if(in_array(\Route::currentRouteName(), ['prk', 'prk-detail'])) active @endif">
                            <a href="/prk" class='sidebar-link'>
                                <i class="bi bi-puzzle-fill"></i>
                                <span>PRK</span>
                            </a>
                        </li>
                        <li class="sidebar-item @if(in_array(\Route::currentRouteName(), ['skki', 'skki-detail'])) active @endif">
                            <a href="/skki" class='sidebar-link'>
                                <i class="bi bi-grid-1x2-fill"></i>
                                <span>SKKI</span>
                            </a>
                        </li>
                        <li class="sidebar-item @if(in_array(\Route::currentRouteName(), ['pengadaan', 'pengadaan-detail'])) active @endif">
                            <a href="/pengadaan" class='sidebar-link'>
                                <i class="bi bi-cart-fill"></i>
                                <span>Pengadaan</span>
                            </a>
                        </li>
                        <li class="sidebar-item @if(in_array(\Route::currentRouteName(), ['kontrak', 'kontrak-detail'])) active @endif">
                            <a href="/kontrak" class='sidebar-link'>
                                <i class="bi bi-file-earmark-check-fill"></i>
                                <span>Kontrak</span>
                            </a>
                        </li>
                        <li class="sidebar-item @if(in_array(\Route::currentRouteName(), ['pelaksanaan', 'pelaksanaan-detail'])) active @endif">
                            <a href="/pelaksanaan" class='sidebar-link'>
                                <i class="bi bi-cart"></i>
                                <span>Pelaksanaan</span>
                            </a>
                        </li>
                        <li class="sidebar-item @if(in_array(\Route::currentRouteName(), ['pembayaran', 'pembayaran-detail'])) active @endif">
                            <a href="/pembayaran" class='sidebar-link'>
                                <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                                <span>Pembayaran</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Database</li>

                        <li class="sidebar-item @if(in_array(\Route::currentRouteName(), ['database.material'])) active @endif">
                            <a href="/database/material" class='sidebar-link'>
                                <i class="bi bi-box"></i>
                                <span>Material</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Administrasi</li>
                        @role('super admin')
                        <li class="sidebar-item @if(in_array(\Route::currentRouteName(), ['administrasi.admin'])) active @endif">
                            <a href="/administrasi/admin" class='sidebar-link'>
                                <i class="bi bi-person-badge"></i>
                                <span>Admin</span>
                            </a>
                        </li>
                        @endrole
                        <li class="sidebar-item @if(in_array(\Route::currentRouteName(), ['administrasi.user'])) active @endif">
                            <a href="/administrasi/profile" class='sidebar-link'>
                                <i class="bi bi-person-fill"></i>
                                <span>Profil Anda</span>
                            </a>
                        </li>
                        @if(auth()->check())
                        <li class="sidebar-item">
                            <a id="logout" href="javascript:void(0);" class='sidebar-link'>
                                <i class="bi bi-power text-danger"></i>
                                <span class="text-danger">Keluar</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            @yield('content')

            <footer>
                
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js"></script>
    <script src="/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="/assets/js/config/axios-config.js"></script>
    <script>
        $('#logout').on('click', async function() {
            await axios.post('/logout');
            window.location.href = '/';
        })
    </script>
    @yield('js')
</body>

</html>
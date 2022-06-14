
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table - Mazer Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/assets/css/bootstrap.css">

    <link rel="stylesheet" href="/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/app.css?v={{ \Str::uuid() }}">
    <link rel="stylesheet" href="/assets/css/pages/auth.css">
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
    <div id="auth">
        @yield('content')
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
    @yield('js')
</body>

</html>
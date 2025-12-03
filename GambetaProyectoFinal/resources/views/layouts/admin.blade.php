<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrativo | Gambeta</title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS del proyecto -->
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/calendar.css">

    <style>
        .admin-sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #0A0E1F;
            border-right: 1px solid #0099FF;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
        }

        .admin-sidebar h3 {
            color: #2ECC71;
            font-weight: bold;
        }

        .admin-sidebar .nav-link {
            color: #fff;
            font-size: 1rem;
            padding: 10px 5px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            transition: 0.2s;
        }

        .admin-sidebar .nav-link:hover {
            background-color: #1a2338;
            color: #2ECC71 !important;
            transform: translateX(4px);
        }

        .admin-content {
            margin-left: 250px;
            padding: 30px;
            min-height: 100vh;
        }
    </style>

    @livewireStyles
</head>

<body class="dark-mode">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    {{-- CONTENIDO DEL ADMIN --}}
    <div class="admin-content">
        @yield('content')
    </div>

    @livewireScripts
</body>
</html>

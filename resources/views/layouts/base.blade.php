<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('img/icono.ico') }}">

    <!-- Estilos de bootstrap -->
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}" rel="stylesheet">
    <!-- Estilos css generales -->
    <link href="{{ asset('css/base/css/general.css') }}" rel="stylesheet">
    <link href="{{ asset('css/base/css/menu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/base/css/footer.css') }}" rel="stylesheet">

    <!-- Estilos cambiantes -->
    @yield('styles')


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
</head>

<body>

    <div class="content">
        <!-- Incluir menú
            @ include permite poner una vista dentro de otra vista
        -->
        @include('layouts.menu')


        <section class="section">
        @yield('content')
        </section>

        <!-- Incluir footer -->
        @include('layouts.footer')
    </div>

    <!-- Scripts de bootstrap -->
    <script src="{{ asset('build/assets/app.js') }}" ></script>
</body>

</html>

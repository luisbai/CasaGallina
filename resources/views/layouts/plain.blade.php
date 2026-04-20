<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <title>@yield('page-title')</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    @livewireStyles
    @fluxAppearance
    
    @yield('styles')
</head>

<body>
    <!--  BEGIN MAIN CONTAINER  -->
    <main>
        @yield('content')
    </main>
    <!-- END MAIN CONTAINER -->
    
    @yield('scripts')
</body>

</html>

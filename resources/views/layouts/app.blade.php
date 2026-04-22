<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Casa Gallina - Administrador</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{  asset('assets/images/favicon.png') }}" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    <script>
        document.addEventListener('alpine:init', () => {
            if (window.Flux) {
                window.Flux.appearance = 'light';
            }
        });
    </script>
</head>

<body class="min-h-screen bg-zinc-100">
    <flux:sidebar sticky stashable class="bg-forest-800 border-r border-zinc-200">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <flux:brand href="/" logo="/assets/images/logo-white.png" name="Casa Gallina" class="px-2" />

        <flux:separator class="!bg-forest-700" />

        <flux:navlist>
            <flux:navlist.item icon="squares-2x2" href="/admin" class="!text-forest-300">Dashboard</flux:navlist.item>
            <flux:navlist.item icon="home" href="/admin/homepage" class="!text-forest-300">Homepage</flux:navlist.item>
            <flux:navlist.item icon="calendar-days" href="/admin/programa" class="!text-forest-300">Programa
            </flux:navlist.item>
            <flux:navlist.item icon="photo" href="/admin/exposiciones" class="!text-forest-300">Exposiciones & Proyectos
            </flux:navlist.item>
            <flux:navlist.item icon="newspaper" href="/admin/noticias" class="!text-forest-300">Noticias
            </flux:navlist.item>
            <flux:navlist.item icon="building-library" href="/admin/espacios" class="!text-forest-300">Espacios de
                Colaboración</flux:navlist.item>
            <flux:navlist.item icon="user-group" href="/admin/miembros" class="!text-forest-300">Miembros del Equipo
            </flux:navlist.item>
            <flux:navlist.item icon="envelope" href="/admin/boletines" class="!text-forest-300">Boletines
            </flux:navlist.item>
            <flux:navlist.item icon="document-text" href="/admin/publicaciones" class="!text-forest-300">Publicaciones
            </flux:navlist.item>
            <flux:navlist.item icon="inbox-stack" href="/admin/formularios" class="!text-forest-300">Formularios de
                Contacto</flux:navlist.item>
            <flux:navlist.item icon="credit-card" href="/admin/donaciones" class="!text-forest-300">Donaciones
            </flux:navlist.item>
        </flux:navlist>

        <flux:spacer />

        @auth
            <flux:navlist>
                <flux:navlist.item icon="arrow-right-start-on-rectangle" href="{{ route('logout') }}"
                    class="!text-forest-300">
                    Cerrar Sesión
                </flux:navlist.item>
                <flux:separator class="!bg-forest-700 !my-2" />
                <div class="flex items-center gap-4">
                    <flux:avatar name="{{ Auth::user()->name }}" />
                    <span class="text-sm text-forest-200 font-medium truncate">
                        {{ Auth::user()->name }}
                    </span>
                </div>
            </flux:navlist>
        @endauth
    </flux:sidebar>

    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden !text-forest-800" icon="bars-2" inset="left" />

        <flux:spacer />
    </flux:header>

    <flux:main>
        @yield('content')
    </flux:main>

    <div id="flux-toast-container">
        <flux:toast />
    </div>

    @fluxScripts
</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Casa Gallina @yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Stripe Public Key -->
    <meta name="stripe-pk" content="{{ env('STRIPE_KEY') }}">

    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}" />


    <link href="{{ asset('/assets/styles/style.min.css') }}" rel="stylesheet">
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-16843608832"></script>
    <script>  window.dataLayer = window.dataLayer || []; function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'AW-16843608832');
    </script>


    <!-- Event snippet for Envío de formulario para clientes potenciales conversion page -->
    <script>
        gtag('event', 'conversion', {
            'send_to': 'AW-16843608832/QwVtCLrG7Z8aEICm1N8-',
            'value': 1.0,
            'currency': 'USD'
        });
    </script>


    @yield('meta')
</head>

<body>
    <div id="app">
        <input type="hidden" id="language" value="{{ $language ?? 'es' }}">
        <nav class="navbar navbar-expand-md navbar-light bg-white sticky-top">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Search Toggle -->
                <div class="search-wrapper d-none d-sm-block" style="position: absolute; right: 15.2rem; top: -1.3rem;">
                    <button type="button" id="search-toggle" class="search-toggle-btn"
                        style="background: none; border: none; color: #68945c; padding: 5px; border-radius: 50%; transition: 0.3s all; cursor: pointer;">
                        <svg class="search-icon" width="20" height="20" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                    <div id="search-form" class="search-form hidden"
                        style="position: absolute; top: 30px; right: -50px; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 8px; padding: 8px; min-width: 280px; z-index: 1000;">
                        <form action="/busqueda" method="GET" class="search-form-inner"
                            style="display: flex; gap: 4px;">
                            <input type="text" name="q" placeholder="Buscar..." class="search-input"
                                style="border: 1px solid #ddd; border-radius: 6px; padding: 8px 12px; flex: 1; font-size: 14px; outline: none;"
                                required>
                            <button type="submit" class="search-submit"
                                style="background: #68945c; color: white; border: none; border-radius: 6px; padding: 8px 12px; cursor: pointer; transition: 0.3s all;">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="donate-btn-wrapper d-none d-sm-block">
                    <a data-bs-toggle="modal" data-bs-target="#modal-donacion" href="#">Dona</a>
                </div>

                <x-language-switcher />

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" data-scroll href="/#home-banner">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link whitespace-nowrap" href="/la-casa">La casa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-scroll href="/#home-estrategias">Programa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-scroll href="/#home-publicaciones">Publicaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/noticias">Noticias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-scroll href="/#home-numeralia">Impacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-scroll href="/#home-cartografia">Cartografía</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('aliados') }}">Aliados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/donaciones">Cómo donar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="modal" data-bs-target="#modal-contacto">Contacto</a>
                        </li>
                        <li class="nav-item d-xs-block d-sm-none">
                            <div class="search-mobile p-3">
                                <form action="/busqueda" method="GET" class="d-flex">
                                    <input type="text" name="q" placeholder="Buscar..." class="form-control me-2"
                                        required>
                                    <button type="submit" class="btn btn-outline-success">
                                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </li>
                        <li class="nav-item d-xs-block d-sm-none">
                            <a class="nav-link btn-nav-link" data-bs-toggle="modal" data-bs-target="#modal-donacion"
                                href="#">Dona</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>

        @include('partials.modals')

        <footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="address-title">Casa Gallina</div>
                        <div class="address-text">Sabino 190, Santa María la Ribera, <br>Ciudad de México, 06400.</div>
                        <div class="address-phone">+52 55 2630 2601</div>
                        <div class="address-phone">+52 55 6813 9568</div>
                        <div class="address-email"><a href="mailto:info@casagallina.org.mx">info@casagallina.org.mx</a>
                        </div>
                        <div class="address-social">
                            <a href="https://www.facebook.com/casa.gallina" target="_blank" rel="nofollow"><i
                                    class="fa fa-facebook"></i></a>
                            <a href="https://www.instagram.com/casa_gallina" target="_blank" rel="nofollow"><i
                                    class="fa fa-instagram"></i></a>
                            <a href="https://www.youtube.com/channel/UCSuGlBYI5fWD_YkQGxNVX7A" target="_blank"
                                rel="nofollow"><i class="fa fa-youtube"></i></a>
                        </div>

                        <div class="footer-links mt-3">
                            <a href="/boletines">Archivo de boletines</a>
                            <a href="/aviso-privacidad">Aviso de privacidad</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="certificados-text">Somos parte de</div>
                        <div class="certificados-links"
                            style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; max-width: 320px; margin: 15px auto 0; align-items: center;">
                            <a href="https://www.ngosource.org/about-equivalency-determination-on-file-badge"
                                target="_blank" rel="nofollow"><img src="/assets/images/footer/NGO.png" class="h-8"
                                    style="filter: brightness(0) invert(1); opacity: 0.8; object-fit: contain;"></a>
                            <a href="https://gratitude-network.org/who-we-support/2025-organizations/#" target="_blank"
                                rel="nofollow"><img src="/assets/images/footer/GN.png" class="h-10"
                                    style="filter: brightness(0) invert(1); opacity: 0.8; object-fit: contain;"></a>
                            <a href="https://catalystnow.net/" target="_blank" rel="nofollow"><img
                                    src="/assets/images/footer/CN.png" class="h-10"
                                    style="filter: brightness(0) invert(1); opacity: 0.8; object-fit: contain;"></a>
                            <a href="https://www.cemefi.org/" target="_blank" rel="nofollow"><img
                                    src="/assets/images/footer/cemefi.png" class="h-10"
                                    style="filter: brightness(0) invert(1); opacity: 0.8; object-fit: contain;"></a>
                            <a target="_blank" rel="nofollow"><img src="/assets/images/footer/cemefii.png" class="h-10"
                                    style="filter: brightness(0) invert(1); opacity: 0.8; object-fit: contain;"></a>
                        </div>
                        <div class="address-text mt-4"><i>Casa Gallina es un proyecto comunitario<br>sin afiliación a
                                partidos políticos.</i></div>
                    </div>
                    <div class="col-md-4">
                        <div class="newsletter-title">
                            Suscríbete al boletín
                        </div>
                        @livewire('forms.newsletter-form')
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    @yield('pre_scripts')
    <script src="{{ asset('/assets/scripts/jquery.min.js') }}" defer></script>
    <script src="{{ asset('/assets/scripts/main.min.js') }}" defer></script>
    @yield('scripts')
</body>

</html>
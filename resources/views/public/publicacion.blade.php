@extends('layouts.boilerplate')

@section('title', ' - ' . strip_tags($publicacion->titulo))

@section('content')
    <div class="container">
        <div id="publicacion-index">
            <div class="row justify-content-between">

                <!-- Columna Izquierda: Portada y Enlaces -->
                <div class="col-lg-3">
                    <div class="publicacion-image">
                        <img src="{{ $publicacion->publicacion_thumbnail?->url }}" class="img-fluid" alt="{{ strip_tags($publicacion->titulo) }}">
                    </div>

                    <div class="publicacion-enlaces">
                        <a href="{{ route('publicacion.download', ['slug' => \Str::slug(strip_tags($publicacion->titulo)), 'id' => $publicacion->id]) }}"
                            class="btn-publicacion" data-action="descargar-publicacion">Descargar</a>

                        @if ($publicacion->previsualizacion)
                            <a href="#" class="btn-publicacion" data-new-action="preview-publication"
                                data-publicacion-url="{{ url('/publicacion/' . \Str::slug(strip_tags($publicacion->titulo)) . '/' . $publicacion->id . '/viewer') }}">Previsualizar</a>
                        @endif
                    </div>
                </div>

                <!-- Columna Derecha: Contenido -->
                <div class="col-lg-8">
                    <div class="publicacion-content">
                        <h1 class="publicacion-title">{!! str_replace(['<p>', '</p>'], '', $publicacion->titulo) !!}</h1>

                        <!-- FICHA TÉCNICA (Todos los campos juntos en líneas individuales) -->
                        <div class="publicacion-ficha">
                            @if ($publicacion->campo_opcional_1_titulo && $publicacion->campo_opcional_1)
                                <p><b>{{ rtrim(trim($publicacion->campo_opcional_1_titulo), ':') }}:</b> {{ trim($publicacion->campo_opcional_1) }}</p>
                            @endif

                            @if ($publicacion->campo_opcional_5_titulo && $publicacion->campo_opcional_5)
                                <p><b>{{ rtrim(trim($publicacion->campo_opcional_5_titulo), ':') }}:</b> {{ trim($publicacion->campo_opcional_5) }}</p>
                            @endif

                            @if ($publicacion->coordinacion_editorial)
                                <p><b>Coordinación editorial:</b> {{ trim($publicacion->coordinacion_editorial) }}</p>
                            @endif

                            @if ($publicacion->diseno)
                                <p><b>Diseño:</b> {{ trim($publicacion->diseno) }}</p>
                            @endif

                            @if ($publicacion->textos)
                                <p><b>Textos:</b> {{ trim($publicacion->textos) }}</p>
                            @endif

                            @if ($publicacion->campo_opcional_2_titulo && $publicacion->campo_opcional_2)
                                <p><b>{{ rtrim(trim($publicacion->campo_opcional_2_titulo), ':') }}:</b> {{ trim($publicacion->campo_opcional_2) }}</p>
                            @endif

                            @if ($publicacion->campo_opcional_6_titulo && $publicacion->campo_opcional_6)
                                <p><b>{{ rtrim(trim($publicacion->campo_opcional_6_titulo), ':') }}:</b> {{ trim($publicacion->campo_opcional_6) }}</p>
                            @endif

                            @if ($publicacion->campo_opcional_7_titulo && $publicacion->campo_opcional_7)
                                <p><b>{{ rtrim(trim($publicacion->campo_opcional_7_titulo), ':') }}:</b> {{ trim($publicacion->campo_opcional_7) }}</p>
                            @endif

                            @if ($publicacion->campo_opcional_3_titulo && $publicacion->campo_opcional_3)
                                <p><b>{{ rtrim(trim($publicacion->campo_opcional_3_titulo), ':') }}:</b> {{ trim($publicacion->campo_opcional_3) }}</p>
                            @endif

                            @if ($publicacion->numero_paginas)
                                <p><b>Número de páginas:</b> {{ trim($publicacion->numero_paginas) }}</p>
                            @endif

                            @if ($publicacion->fecha_publicacion)
                                <p><b>Fecha de publicación:</b> {{ trim($publicacion->fecha_publicacion) }}</p>
                            @endif

                            @if ($publicacion->campo_opcional_4_titulo && $publicacion->campo_opcional_4)
                                <p><b>{{ rtrim(trim($publicacion->campo_opcional_4_titulo), ':') }}:</b> {{ trim($publicacion->campo_opcional_4) }}</p>
                            @endif
                        </div>

                        <div class="publicacion-divider"></div>

                        <!-- SINOPSIS (Al final) -->
                        @if ($publicacion->sinopsis)
                            <h2 class="publicacion-subtitle">Sinopsis</h2>
                            <p class="publicacion-text">
                                {!! nl2br($publicacion->sinopsis) !!}
                            </p>
                        @endif

                    </div>
                </div>
            </div>

            <!-- Modal de Previsualización -->
            <div class="modal fade" id="modal-publicacion" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div id="publicacion-brochure-wrapper"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Formulario de Descarga -->
    <div class="modal fade" id="modal-datos-descarga" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="/publicacion/{{ $publicacion->id }}/contacto" method="POST"
                                id="datos-descarga-form" class="datos-descarga-form">
                                <div class="text-center">
                                    <h3>Gracias por tu interés en nuestras publicaciones.</h3>
                                    <h4 id="form-action-message">Déjanos tus datos para mantenernos en contacto</h4>
                                </div>
                                @csrf
                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo electrónico:</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Teléfono:</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="organizacion">Organización:</label>
                                    <input type="text" name="organizacion" id="organizacion" class="form-control">
                                </div>
                                <div class="form-group text-right mt-3">
                                    <button type="submit" class="btn btn-enviar">Enviar</button>
                                </div>
                            </form>
                            <div class="formulario-gracias" style="display: none;">
                                <h3>Tus datos han sido enviados correctamente.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.publicationData = {
            id: {{ $publicacion->id }}
        };
    </script>
@endsection

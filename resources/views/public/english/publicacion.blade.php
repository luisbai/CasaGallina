@extends('layouts.english.boilerplate')

@section('title', ' - ' . strip_tags(strip_tags($publicacion->titulo_en)))

@section('content')
    <div class="container">
        <div id="publicacion-index">
            <div class="row justify-content-between">

                <!-- Columna Izquierda: Portada y Acciones -->
                <div class="col-lg-3">
                    <div class="publicacion-image">
                        <img src="{{ $publicacion->publicacion_thumbnail?->url }}" class="img-fluid" alt="{{ strip_tags($publicacion->titulo_en) }}">
                    </div>

                    <div class="publicacion-enlaces">
                        <a href="{{ route('english.publicacion.download', ['slug' => \Str::slug(strip_tags($publicacion->titulo_en)), 'id' => $publicacion->id]) }}"
                            class="btn-publicacion" data-action="descargar-publicacion">Download</a>
                        @if ($publicacion->previsualizacion)
                            <a href="#" class="btn-publicacion" data-new-action="preview-publication"
                                data-publicacion-url="{{ url('/publicacion/' . \Str::slug(strip_tags($publicacion->titulo_en)) . '/' . $publicacion->id . '/viewer') }}">Preview</a>
                        @endif
                    </div>
                </div>

                <!-- Columna Derecha: Contenido -->
                <div class="col-lg-8">
                    <div class="publicacion-content">
                        <h1 class="publicacion-title">{!! str_replace(['<p>', '</p>'], '', $publicacion->titulo_en) !!}</h1>

                        <!-- FICHA TÉCNICA (Todos los campos juntos en líneas individuales) -->
                        <div class="publicacion-ficha">
                            @if ($publicacion->campo_opcional_1_en_titulo && $publicacion->campo_opcional_1_en)
                                <p><b>{{ rtrim(trim($publicacion->campo_opcional_1_en_titulo), ':') }}:</b> {{ trim($publicacion->campo_opcional_1_en) }}</p>
                            @endif

                            @if ($publicacion->campo_opcional_5_en_titulo && $publicacion->campo_opcional_5_en)
                                <p><b>{{ rtrim(trim($publicacion->campo_opcional_5_en_titulo), ':') }}:</b> {{ trim($publicacion->campo_opcional_5_en) }}</p>
                            @endif

                            @if ($publicacion->coordinacion_editorial_en)
                                <p><b>Editorial coordination:</b> {{ trim($publicacion->coordinacion_editorial_en) }}</p>
                            @endif

                            @if ($publicacion->diseno_en)
                                <p><b>Design:</b> {{ trim($publicacion->diseno_en) }}</p>
                            @endif

                            @if ($publicacion->textos_en)
                                <p><b>Texts:</b> {{ trim($publicacion->textos_en) }}</p>
                            @endif

                            @if ($publicacion->campo_opcional_2_en_titulo && $publicacion->campo_opcional_2_en)
                                <p><b>{{ rtrim(trim($publicacion->campo_opcional_2_en_titulo), ':') }}:</b> {{ trim($publicacion->campo_opcional_2_en) }}</p>
                            @endif

                            @if ($publicacion->campo_opcional_6_en_titulo && $publicacion->campo_opcional_6_en)
                                <p><b>{{ rtrim(trim($publicacion->campo_opcional_6_en_titulo), ':') }}:</b> {{ trim($publicacion->campo_opcional_6_en) }}</p>
                            @endif

                            @if ($publicacion->campo_opcional_7_en_titulo && $publicacion->campo_opcional_7_en)
                                <p><b>{{ rtrim(trim($publicacion->campo_opcional_7_en_titulo), ':') }}:</b> {{ trim($publicacion->campo_opcional_7_en) }}</p>
                            @endif

                            @if ($publicacion->campo_opcional_3_en_titulo && $publicacion->campo_opcional_3_en)
                                <p><b>{{ rtrim(trim($publicacion->campo_opcional_3_en_titulo), ':') }}:</b> {{ trim($publicacion->campo_opcional_3_en) }}</p>
                            @endif

                            @if ($publicacion->numero_paginas)
                                <p><b>Page count:</b> {{ trim($publicacion->numero_paginas) }}</p>
                            @endif

                            @if ($publicacion->fecha_publicacion)
                                <p><b>Publish date:</b> {{ trim($publicacion->fecha_publicacion) }}</p>
                            @endif

                            @if ($publicacion->campo_opcional_4_en_titulo && $publicacion->campo_opcional_4_en)
                                <p><b>{{ rtrim(trim($publicacion->campo_opcional_4_en_titulo), ':') }}:</b> {{ trim($publicacion->campo_opcional_4_en) }}</p>
                            @endif
                        </div>

                        <div class="publicacion-divider"></div>

                        <!-- SINOPSIS / RESUMEN (Al final) -->
                        @if ($publicacion->sinopsis_en)
                            <h2 class="publicacion-subtitle">Summary</h2>
                            <p class="publicacion-text">
                                {!! nl2br($publicacion->sinopsis_en) !!}
                            </p>
                        @endif

                    </div>
                </div>
            </div>

            <!-- Modales -->
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

            <div class="modal fade" id="modal-datos-descarga" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="/en/publication/{{ $publicacion->id }}/contacto" method="POST" class="datos-descarga-form">
                                        <div class="text-center">
                                            <h3>Thanks for your interest in our publications.</h3>
                                            <h4 id="form-action-message">Please leave us your contact details to keep in touch</h4>
                                        </div>
                                        @csrf
                                        <div class="form-group">
                                            <label for="nombre">Name:</label>
                                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="email" name="email" id="email" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="telefono">Phone:</label>
                                            <input type="text" name="telefono" id="telefono" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="organizacion">Organization:</label>
                                            <input type="text" name="organizacion" id="organizacion" class="form-control">
                                        </div>
                                        <div class="form-group text-right mt-3">
                                            <button type="submit" class="btn btn-enviar">Send</button>
                                        </div>
                                    </form>
                                    <div class="formulario-gracias" style="display: none;">
                                        <h3>Your details has been sent successfully.</h3>
                                    </div>
                                </div>
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

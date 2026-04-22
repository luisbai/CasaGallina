@extends('layouts.english.boilerplate')

@section('content')
    <div class="container">
        <div id="publicaciones-index">
            <div class="section-title text-center mb-5">
                <span>Printed Publications</span>
            </div>

            <div class="row">
                <div class="col">
                    <ul class="publicaciones-container">
                        @foreach ($publicaciones_impresas as $publicacion)
                            <li class="publicacion-item">
                                <div class="publicacion">
                                    <div class="publicacion-image">
                                        <a
                                            href="/en/publication/{{ \Str::slug(strip_tags($publicacion->titulo_en)) }}/{{ $publicacion->id }}"><img
                                                src='{{ $publicacion->publicacion_thumbnail?->url }}'></a>
                                    </div>
                                    <div class="publicacion-title">
                                        <a
                                            href="/en/publication/{{ \Str::slug(strip_tags($publicacion->titulo_en)) }}/{{ $publicacion->id }}">{!! $publicacion->titulo_en !!}</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="section-title text-center my-5">
                <span>Digital Publications</span>
            </div>

            <div class="row">
                <div class="col">
                    <ul class="publicaciones-container">
                        @foreach ($publicaciones_digitales as $publicacion)
                            <li class="publicacion-item">
                                <div class="publicacion">
                                    <div class="publicacion-image">
                                        <a
                                            href="/en/publication/{{ \Str::slug(strip_tags($publicacion->titulo_en)) }}/{{ $publicacion->id }}"><img
                                                src='{{ $publicacion->publicacion_thumbnail?->url }}'></a>
                                    </div>
                                    <div class="publicacion-title">
                                        <a
                                            href="/en/publication/{{ \Str::slug(strip_tags($publicacion->titulo_en)) }}/{{ $publicacion->id }}">{!! $publicacion->titulo_en !!}</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
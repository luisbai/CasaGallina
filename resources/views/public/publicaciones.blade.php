@extends('layouts.boilerplate')

@section('content')
    <div class="container">
        <div id="publicaciones-index">
            <div class="section-title text-center mb-5">
                <span>Publicaciones impresas</span>
            </div>

            <div class="row">
                <div class="col">
                    <ul class="publicaciones-container">
                        @foreach ($publicaciones_impresas as $publicacion)
                            <li class="publicacion-item">
                                <div class="publicacion">
                                    <div class="publicacion-image">
                                        <a href="/publicacion/{{ \Str::slug(strip_tags($publicacion->titulo)) }}/{{ $publicacion->id }}">
                                            <img src='/storage/cache/{{ $publicacion->publicacion_thumbnail->filename  }}'>
                                        </a>
                                        
                                    </div>
                                    <div class="publicacion-title">
                                        <a href="/publicacion/{{ \Str::slug(strip_tags($publicacion->titulo)) }}/{{ $publicacion->id }}">{!! $publicacion->titulo !!}</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
            </div>

            <div class="section-title text-center my-5">
                <span>Recetarios</span>
            </div>

            <div class="row">
                <div class="col">
                    <ul class="publicaciones-container">
                        @foreach ($publicaciones_digitales as $publicacion)
                            <li class="publicacion-item">
                                <div class="publicacion">
                                    <div class="publicacion-image">
                                        <a href="/publicacion/{{ \Str::slug(strip_tags($publicacion->titulo)) }}/{{ $publicacion->id }}">
                                            <img src='/storage/cache/{{ $publicacion->publicacion_thumbnail->filename  }}'>
                                        </a>
                                    </div>
                                    <div class="publicacion-title">
                                        <a href="/publicacion/{{ \Str::slug(strip_tags($publicacion->titulo)) }}/{{ $publicacion->id }}">{!! $publicacion->titulo !!}</a>
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
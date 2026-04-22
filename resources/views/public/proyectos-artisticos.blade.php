@extends('layouts.boilerplate')

@section('content')
    <div class="container">
        <div id="proyectos-artisticos-index">
            <div class="section-title text-center">
                <span>Proyectos Artísticos</span>
            </div>

            <div class="intro-text text-center mb-4">
                Iniciativas creativas que surgen del diálogo entre artistas y la comunidad, generando obras que reflejan las
                experiencias y saberes locales.
            </div>

            <div class="row">
                <div class="card-columns">
                    @forelse ($proyectos as $proyecto)
                        <div class="card">
                            <div class="proyecto-item">
                                @if($proyecto->multimedia->first())
                                    <div class="proyecto-image"
                                        onclick="window.location = '/proyecto-artistico/{{ \Str::slug($proyecto->titulo) }}/{{ $proyecto->id }}'">
                                        <img src='{{ $proyecto->multimedia->first()?->multimedia?->url }}' class="img-fluid">
                                    </div>
                                @endif
                                <div class="proyecto-title">
                                    <a
                                        href="/proyecto-artistico/{{ \Str::slug($proyecto->titulo) }}/{{ $proyecto->id }}">{{ strip_tags($proyecto->titulo) }}</a>
                                </div>
                                <div class="proyecto-subtitle">
                                    {{ strip_tags($proyecto->fecha) }}
                                </div>
                                @if($proyecto->metadatos)
                                    <div class="proyecto-description">
                                        {{ \Str::limit(strip_tags($proyecto->metadatos), 150) }}
                                    </div>
                                @endif
                                @if($proyecto->tags->count() > 0)
                                    <div class="proyecto-tags">
                                        @foreach($proyecto->tags->take(3) as $tag)
                                            <span class="tag">{{ $tag->nombre }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                No hay proyectos artísticos disponibles en este momento.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="/programa" class="btn btn-primary">
                    ← Volver al programa principal
                </a>
            </div>
        </div>
    </div>
@endsection
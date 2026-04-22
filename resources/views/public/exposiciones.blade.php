@extends('layouts.boilerplate')

@section('content')
    <div class="container">
        <div id="exposiciones-index">
            <div class="section-title text-center">
                <span>Exposiciones</span>
            </div>

            <div class="intro-text text-center mb-4">
                Espacios de encuentro y reflexión que visibilizan los procesos comunitarios y las narrativas locales a
                través del arte y la cultura.
            </div>

            <div class="row">
                <div class="card-columns">
                    @forelse ($exposiciones as $exposicion)
                        <div class="card">
                            <div class="exposicion-item">
                                @if($exposicion->multimedia->first())
                                    <div class="exposicion-image" onclick="window.location = '/exposicion/{{ $exposicion->slug }}'">
                                        <img src='{{ $exposicion->multimedia->first()?->multimedia?->url }}' class="img-fluid">
                                    </div>
                                @endif
                                <div class="exposicion-title">
                                    <a href="/exposicion/{{ $exposicion->slug }}">{{ strip_tags($exposicion->titulo) }}</a>
                                </div>
                                <div class="exposicion-subtitle">
                                    {{ strip_tags($exposicion->fecha) }}
                                </div>
                                @if($exposicion->metadatos)
                                    <div class="exposicion-description">
                                        {{ \Str::limit(strip_tags($exposicion->metadatos), 150) }}
                                    </div>
                                @endif
                                @if($exposicion->tags->count() > 0)
                                    <div class="exposicion-tags">
                                        @foreach($exposicion->tags->take(3) as $tag)
                                            <span class="tag">{{ $tag->nombre }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                No hay exposiciones disponibles en este momento.
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
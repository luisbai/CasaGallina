@extends('layouts.english.boilerplate')

@section('content')
    <div class="container">
        <div id="exposiciones-index">
            <div class="section-title text-center">
                <span>Exhibitions</span>
            </div>

            <div class="intro-text text-center mb-4">
                Spaces for encounter and reflection that make community processes and local narratives visible through art
                and culture.
            </div>

            <div class="row">
                <div class="card-columns">
                    @forelse ($exposiciones as $exposicion)
                        <div class="card">
                            <div class="exposicion-item">
                                @if($exposicion->multimedia->first())
                                    <div class="exposicion-image"
                                        onclick="window.location = '/en/exhibition/{{ $exposicion->slug }}'">
                                        <img src='{{ $exposicion->multimedia->first()?->multimedia?->url }}' class="img-fluid">
                                    </div>
                                @endif
                                <div class="exposicion-title">
                                    <a href="/en/exhibition/{{ $exposicion->slug }}">{{ strip_tags($exposicion->titulo) }}</a>
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
                                No exhibitions available at this time.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="/en/program" class="btn btn-primary">
                    ← Back to main program
                </a>
            </div>
        </div>
    </div>
@endsection
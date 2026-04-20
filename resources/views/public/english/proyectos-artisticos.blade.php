@extends('layouts.english.boilerplate')

@section('content')
    <div class="container">
        <div id="proyectos-artisticos-index">
            <div class="section-title text-center">
                <span>Artistic Projects</span>
            </div>

            <div class="intro-text text-center mb-4">
                Creative initiatives that arise from dialogue between artists and the community, generating works that
                reflect local experiences and knowledge.
            </div>

            <div class="row">
                <div class="card-columns">
                    @forelse ($proyectos as $proyecto)
                        <div class="card">
                            <div class="proyecto-item">
                                @if($proyecto->multimedia->first())
                                    <div class="proyecto-image"
                                        onclick="window.location = '/en/artistic-project/{{ \Str::slug($proyecto->titulo) }}/{{ $proyecto->id }}'">
                                        <img src='{{ $proyecto->multimedia->first()?->multimedia?->url }}' class="img-fluid">
                                    </div>
                                @endif
                                <div class="proyecto-title">
                                    <a
                                        href="/en/artistic-project/{{ \Str::slug($proyecto->titulo) }}/{{ $proyecto->id }}">{{ strip_tags($proyecto->titulo) }}</a>
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
                                No artistic projects available at this time.
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
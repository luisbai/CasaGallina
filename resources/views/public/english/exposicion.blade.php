@extends('layouts.english.boilerplate')

@section('content')
    <div class="container">
        <div id="exposicion-index">
            <h1 class="estrategia-title">{{ $exposicion->titulo }}</h1>

            @if($exposicion->multimedia->count() > 0)
                <div class="estrategia-slider">
                    <div class="slider">
                        @foreach ($exposicion->multimedia as $imagen)
                            <div><img src="{{ $imagen->multimedia?->url }}" alt=""></div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-4">
                    <div class="estrategia-sidebar">
                        @if (!empty($exposicion->fecha))
                            <div class="sidebar-title">DATE</div>
                            <div class="sidebar-subtitle">{{ $exposicion->fecha }}</div>
                        @endif

                        @if ($exposicion->tags->count() > 0)
                            <div class="sidebar-title">CATEGORIES</div>
                            <div class="sidebar-subtitle">
                                @foreach($exposicion->tags as $tag)
                                    {{ $tag->nombre }}@if(!$loop->last), @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="estrategia-content">
                        @if (!empty($exposicion->metadatos))
                            <div class="content-section">
                                <h3>Description</h3>
                                {!! nl2br($exposicion->metadatos) !!}
                            </div>
                        @endif

                        @if (!empty($exposicion->contenido))
                            <div class="content-section">
                                {!! $exposicion->contenido !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Related Estrategias Section -->
            @if($estrategias->count() > 0)
                <div class="related-estrategias mt-5">
                    <h2>Related Strategies</h2>

                    <!-- Category Filter -->
                    <div class="filters-section mb-4">
                        <form method="GET" action="{{ route('english.exposicion', $exposicion->slug) }}" class="filter-form">
                            <div class="form-group">
                                <label for="category">Filter by category:</label>
                                <select name="category" id="category" class="form-control" onchange="this.form.submit()">
                                    <option value="">All categories</option>
                                    @foreach($categories as $categoryOption)
                                        <option value="{{ $categoryOption }}" {{ $category == $categoryOption ? 'selected' : '' }}>
                                            {{ ucfirst($categoryOption) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="row">
                        @foreach($estrategias as $estrategia)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="estrategia-item">
                                    <div class="estrategia-image"
                                        style="background-image: url('{{ $estrategia->featured_multimedia?->url }}')"
                                        onclick="window.location = '/en/strategy/{{ \Str::slug($estrategia->titulo_en) }}/{{ $estrategia->id }}'">
                                    </div>
                                    <div class="estrategia-title">
                                        <a
                                            href="/en/strategy/{{ \Str::slug($estrategia->titulo_en) }}/{{ $estrategia->id }}">{{ $estrategia->titulo_en }}</a>
                                    </div>
                                    <div class="estrategia-subtitle">
                                        {{ $estrategia->fecha_en }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="estrategia-back mt-4">
                <a href="/en/exhibitions">← Back to exhibitions</a>
            </div>
        </div>
    </div>
@endsection
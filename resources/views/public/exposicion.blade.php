@extends('layouts.boilerplate')

@section('content')
    <div class="container">
        <div id="exposicion-index">
            <h1 class="estrategia-title">{{ $exposicion->titulo }}</h1>

            @if($exposicion->multimedia->count() > 0)
                <div class="estrategia-slider">
                    <div class="slider">
                        @foreach ($exposicion->multimedia as $imagen)
                            <div><img src="/storage/cache/{{ $imagen->multimedia->filename }}" alt=""></div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-4">
                    <div class="estrategia-sidebar">
                        @if (!empty($exposicion->fecha))
                            <div class="sidebar-title">FECHA</div>
                            <div class="sidebar-subtitle">{{ $exposicion->fecha }}</div>
                        @endif

                        @if ($exposicion->tags->count() > 0)
                            <div class="sidebar-title">CATEGORÍAS</div>
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
                                <h3>Descripción</h3>
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
                    <h2>Estrategias Relacionadas</h2>
                    
                    <!-- Category Filter -->
                    <div class="filters-section mb-4">
                        <form method="GET" action="{{ route('exposicion', $exposicion->slug) }}" class="filter-form">
                            <div class="form-group">
                                <label for="category">Filtrar por categoría:</label>
                                <select name="category" id="category" class="form-control" onchange="this.form.submit()">
                                    <option value="">Todas las categorías</option>
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
                                         style="background-image: url('/storage/cache/{{ $estrategia->destacada_multimedia->filename }}')"
                                         onclick="window.location = '/estrategia/{{ \Str::slug($estrategia->titulo) }}/{{ $estrategia->id }}'">
                                    </div>
                                    <div class="estrategia-title">
                                        <a href="/estrategia/{{ \Str::slug($estrategia->titulo) }}/{{ $estrategia->id }}">{{ $estrategia->titulo }}</a>
                                    </div>
                                    <div class="estrategia-subtitle">
                                        {{ $estrategia->fecha }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="estrategia-back mt-4">
                <a href="/exposiciones">← Volver a exposiciones</a>
            </div>
        </div>
    </div>
@endsection
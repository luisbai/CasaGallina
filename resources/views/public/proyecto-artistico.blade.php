@extends('layouts.boilerplate')

@section('content')
    <div class="container">
        <div id="proyecto-artistico-index">
            <h1 class="estrategia-title">{{ $proyecto->titulo }}</h1>

            @if($proyecto->multimedia->count() > 0)
                <div class="estrategia-slider">
                    <div class="slider">
                        @foreach ($proyecto->multimedia as $imagen)
                            <div><img src="/storage/cache/{{ $imagen->multimedia->filename }}" alt=""></div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-4">
                    <div class="estrategia-sidebar">
                        @if (!empty($proyecto->fecha))
                            <div class="sidebar-title">FECHA</div>
                            <div class="sidebar-subtitle">{{ $proyecto->fecha }}</div>
                        @endif

                        @if ($proyecto->tags->count() > 0)
                            <div class="sidebar-title">CATEGORÍAS</div>
                            <div class="sidebar-subtitle">
                                @foreach($proyecto->tags as $tag)
                                    {{ $tag->nombre }}@if(!$loop->last), @endif
                                @endforeach
                            </div>
                        @endif

                        <!-- Category Filter -->
                        @if($categories->count() > 0)
                            <div class="sidebar-title">FILTRAR</div>
                            <form method="GET" action="{{ route('proyecto-artistico', [\Str::slug($proyecto->titulo), $proyecto->id]) }}" class="filter-form">
                                <div class="form-group">
                                    <select name="category" id="category" class="form-control" onchange="this.form.submit()">
                                        <option value="">Todas las categorías</option>
                                        @foreach($categories as $categoryOption)
                                            <option value="{{ $categoryOption }}" {{ $category == $categoryOption ? 'selected' : '' }}>
                                                {{ $categoryOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="estrategia-content">
                        @if (!empty($proyecto->metadatos))
                            <div class="content-section">
                                <h3>Descripción</h3>
                                {!! nl2br($proyecto->metadatos) !!}
                            </div>
                        @endif

                        @if (!empty($proyecto->contenido))
                            <div class="content-section">
                                <h3>Contenido</h3>
                                {!! $proyecto->contenido !!}
                            </div>
                        @endif

                        <!-- Artists Section -->
                        @if ($proyecto->tags->where('type', 'artista')->count() > 0)
                            <div class="content-section">
                                <h3>Artistas</h3>
                                <div class="artists-list">
                                    @foreach($proyecto->tags->where('type', 'artista') as $artista)
                                        <div class="artist-item">
                                            <h4>{{ $artista->nombre }}</h4>
                                            @if($artista->descripcion)
                                                <p>{{ $artista->descripcion }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Technical Details -->
                        <div class="content-section">
                            <h3>Detalles del Proyecto</h3>
                            <div class="project-details">
                                @if($proyecto->fecha)
                                    <p><strong>Fecha:</strong> {{ $proyecto->fecha }}</p>
                                @endif
                                @if($proyecto->tags->where('type', 'tecnica')->count() > 0)
                                    <p><strong>Técnicas:</strong> 
                                        @foreach($proyecto->tags->where('type', 'tecnica') as $tecnica)
                                            {{ $tecnica->nombre }}@if(!$loop->last), @endif
                                        @endforeach
                                    </p>
                                @endif
                                @if($proyecto->tags->where('type', 'material')->count() > 0)
                                    <p><strong>Materiales:</strong> 
                                        @foreach($proyecto->tags->where('type', 'material') as $material)
                                            {{ $material->nombre }}@if(!$loop->last), @endif
                                        @endforeach
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="estrategia-back mt-4">
                <a href="/proyectos-artisticos">← Volver a proyectos artísticos</a>
            </div>
        </div>
    </div>
@endsection
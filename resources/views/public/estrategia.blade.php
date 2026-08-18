@extends('layouts.boilerplate')

@section('content')
    @php
        $attrs = $estrategia->getAttributes();
    @endphp

    <div class="container py-4">
        <div id="estrategia-index">
            <!-- Título -->
            <h1 class="estrategia-title mb-4">
                {{ $attrs['titulo'] ?? '' }}
            </h1>

            <!-- Slider / Imágenes -->
            @if(!empty($estrategia->multimedia) && $estrategia->multimedia->count() > 0)
                <div class="estrategia-slider mb-4">
                    <div class="slider">
                        @foreach ($estrategia->multimedia as $imagen)
                            @if(!empty($imagen->multimedia?->filename))
                                <div>
                                    <img src="{{ asset('/storage/cache/' . $imagen->multimedia->filename) }}" alt="{{ $attrs['titulo'] ?? 'Estrategia' }}" class="img-fluid">
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="row">
                <!-- Barra Lateral -->
                <div class="col-md-4">
                    <div class="estrategia-sidebar">
                        @if(!empty($attrs['colaboradores']))
                            <div class="sidebar-title font-weight-bold">COLABORADORES</div>
                            <div class="sidebar-subtitle mb-3">{!! nl2br(e($attrs['colaboradores'])) !!}</div>
                        @endif

                        @if(!empty($attrs['fecha']))
                            <div class="sidebar-title font-weight-bold">FECHA</div>
                            <div class="sidebar-subtitle mb-3">{{ $attrs['fecha'] }}</div>
                        @endif

                        @if(!empty($attrs['lugar']))
                            <div class="sidebar-title font-weight-bold">LUGAR</div>
                            <div class="sidebar-subtitle mb-3">{!! nl2br(e($attrs['lugar'])) !!}</div>
                        @endif

                        @for($i = 1; $i <= 5; $i++)
                            @if(!empty($attrs["campo_opcional_{$i}_titulo"]) && !empty($attrs["campo_opcional_{$i}"]))
                                <div class="sidebar-title font-weight-bold">{{ strtoupper($attrs["campo_opcional_{$i}_titulo"]) }}</div>
                                <div class="sidebar-subtitle mb-3">{!! nl2br(e($attrs["campo_opcional_{$i}"])) !!}</div>
                            @endif
                        @endfor
                    </div>
                </div>

                <!-- Contenido Principal -->
                <div class="col-md-8">
                    <div class="estrategia-content">
                        @if(!empty($attrs['subtitulo']))
                            <div class="estrategia-intro lead mb-4" style="font-weight: 500;">
                                {!! nl2br(e($attrs['subtitulo'])) !!}
                            </div>
                        @endif

                        @if(!empty($attrs['contenido']))
                            <div class="estrategia-description mb-4">
                                {!! $attrs['contenido'] !!}
                            </div>
                        @endif

                        @if(!empty(strip_tags($attrs['programas'] ?? '')))
                            <div class="estrategia-programas mt-4">
                                <div class="estrategia-programas-title font-weight-bold mb-2">Programas de implementación de la estrategia:</div>
                                {!! nl2br(e($attrs['programas'])) !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

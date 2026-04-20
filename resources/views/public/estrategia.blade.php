@extends('layouts.boilerplate')

@section('content')
    <div class="container">
        <div id="estrategia-index">
            <h1 class="estrategia-title">{{ $estrategia->titulo }}</h1>

            <div class="estrategia-slider">
            	<div class="slider">
            		@foreach ($estrategia->multimedia as $imagen)
            			<div><img src="/storage/cache/{{ $imagen->multimedia->filename }}" alt=""></div>
            		@endforeach
				</div>
            </div>

            <div class="row">
            	<div class="col-md-4">
            		<div class="estrategia-sidebar">
                        @if (!empty($estrategia->campo_opcional_1_titulo) && !empty($estrategia->campo_opcional_1))
                            <div class="sidebar-title">{{ strtoupper($estrategia->campo_opcional_1_titulo) }}</div>
                            <div class="sidebar-subtitle">{!! nl2br($estrategia->campo_opcional_1) !!}</div>
                        @endif

						@if (!empty($estrategia->campo_opcional_2_titulo) && !empty($estrategia->campo_opcional_2))
                            <div class="sidebar-title">{{ strtoupper($estrategia->campo_opcional_2_titulo) }}</div>
                            <div class="sidebar-subtitle">{!! nl2br($estrategia->campo_opcional_2) !!}</div>
                        @endif

						@if (!empty($estrategia->campo_opcional_3_titulo) && !empty($estrategia->campo_opcional_3))
                            <div class="sidebar-title">{{ strtoupper($estrategia->campo_opcional_3_titulo) }}</div>
                            <div class="sidebar-subtitle">{!! nl2br($estrategia->campo_opcional_3) !!}</div>
                        @endif

                        @if (!empty(strip_tags($estrategia->colaboradores)))
						<div class="sidebar-title">COLABORADORES</div>
						<div class="sidebar-subtitle">{!! nl2br($estrategia->colaboradores) !!}</div>
                        @endif
                        
						@if (!empty(strip_tags($estrategia->fecha)))
						<div class="sidebar-title">FECHA</div>
						<div class="sidebar-subtitle fecha">{{ $estrategia->fecha }}</div>
                        @endif

						@if (!empty(strip_tags($estrategia->lugar)))
						<div class="sidebar-title">LUGAR</div>
						<div class="sidebar-subtitle">{!! nl2br($estrategia->lugar) !!}</div>
                        @endif

						@if (!empty($estrategia->campo_opcional_4_titulo) && !empty($estrategia->campo_opcional_4))
                            <div class="sidebar-title">{{ strtoupper($estrategia->campo_opcional_4_titulo) }}</div>
                            <div class="sidebar-subtitle">{!! nl2br($estrategia->campo_opcional_4) !!}</div>
                        @endif

						@if (!empty($estrategia->campo_opcional_5_titulo) && !empty($estrategia->campo_opcional_5))
                            <div class="sidebar-title">{{ strtoupper($estrategia->campo_opcional_5_titulo) }}</div>
                            <div class="sidebar-subtitle">{!! nl2br($estrategia->campo_opcional_5) !!}</div>
                        @endif
            		</div>
            	</div>
            	<div class="col-md-8">
            		<div class="estrategia-content">
            			<div class="estrategia-intro">
            				{!! nl2br($estrategia->subtitulo) !!}
            			</div>
            			<div class="estrategia-description">
            				{!! $estrategia->contenido !!}
            			</div>
            			@if (!empty(strip_tags($estrategia->programas)))
            				<div class="estrategia-programas">
                                <div class="estrategia-programas-title">Programas de implementación de la estrategia:</div>
	            				{!! nl2br($estrategia->programas) !!}
	            			</div>
            			@endif
            		</div>
            	</div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.english.boilerplate')

@section('content')
	<div class="container">
		<div id="estrategia-index">
			<h1 class="estrategia-title">{{ $estrategia->titulo_en }}</h1>

			<div class="estrategia-slider">
				<div class="slider">
					@foreach ($estrategia->multimedia as $imagen)
						<div><img src="{{ $imagen->multimedia?->url }}" alt=""></div>
					@endforeach
				</div>
			</div>

			<div class="row">
				<div class="col-md-4">
					<div class="estrategia-sidebar">
						@if (!empty($estrategia->campo_opcional_1_en_titulo) && !empty($estrategia->campo_opcional_1_en))
							<div class="sidebar-title">{{ strtoupper($estrategia->campo_opcional_1_en_titulo) }}</div>
							<div class="sidebar-subtitle">{!! nl2br($estrategia->campo_opcional_1_en) !!}</div>
						@endif

						@if (!empty($estrategia->campo_opcional_2_en_titulo) && !empty($estrategia->campo_opcional_2_en))
							<div class="sidebar-title">{{ strtoupper($estrategia->campo_opcional_2_en_titulo) }}</div>
							<div class="sidebar-subtitle">{!! nl2br($estrategia->campo_opcional_2_en) !!}</div>
						@endif

						@if (!empty($estrategia->campo_opcional_3_en_titulo) && !empty($estrategia->campo_opcional_3_en))
							<div class="sidebar-title">{{ strtoupper($estrategia->campo_opcional_3_en_titulo) }}</div>
							<div class="sidebar-subtitle">{!! nl2br($estrategia->campo_opcional_3_en) !!}</div>
						@endif

						<div class="sidebar-title">COLLABORATORS</div>
						<div class="sidebar-subtitle">{!! nl2br($estrategia->colaboradores_en) !!}</div>

						<div class="sidebar-title">DATE</div>
						<div class="sidebar-subtitle fecha">{{ $estrategia->fecha_en }}</div>

						<div class="sidebar-title">PLACE</div>
						<div class="sidebar-subtitle">{!! nl2br($estrategia->lugar_en) !!}</div>

						@if (!empty($estrategia->campo_opcional_4_en_titulo) && !empty($estrategia->campo_opcional_4_en))
							<div class="sidebar-title">{{ strtoupper($estrategia->campo_opcional_4_en_titulo) }}</div>
							<div class="sidebar-subtitle">{!! nl2br($estrategia->campo_opcional_4_en) !!}</div>
						@endif

						@if (!empty($estrategia->campo_opcional_5_en_titulo) && !empty($estrategia->campo_opcional_5_en))
							<div class="sidebar-title">{{ strtoupper($estrategia->campo_opcional_5_en_titulo) }}</div>
							<div class="sidebar-subtitle">{!! nl2br($estrategia->campo_opcional_5_en) !!}</div>
						@endif
					</div>
				</div>
				<div class="col-md-8">
					<div class="estrategia-content">
						<div class="estrategia-intro">
							{!! nl2br($estrategia->subtitulo_en) !!}
						</div>
						<div class="estrategia-description">
							{!! $estrategia->contenido_en !!}
						</div>
						@if (!empty($estrategia->programas_en))
							<div class="estrategia-programas">
								<div class="estrategia-programas-title">Strategy implementation programs:</div>
								{!! nl2br($estrategia->programas_en) !!}
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
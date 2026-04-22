@extends('layouts.english.boilerplate')

@section('title', ' - ' . strip_tags(strip_tags($publicacion->titulo_en)))

@section('content')
	<div class="container">
		<div id="publicacion-index">
			<div class="row justify-content-between">
				<div class="col-lg-3">
					<div class="publicacion-image">
						<img src="{{ $publicacion->publicacion_thumbnail?->url }}" class="img-fluid">
					</div>

					<div class="publicacion-enlaces">
						<a href="{{ route('english.publicacion.download', ['slug' => \Str::slug(strip_tags($publicacion->titulo_en)), 'id' => $publicacion->id]) }}"
							class="btn-publicacion" data-action="descargar-publicacion">Download</a>
						@if ($publicacion->previsualizacion)
							<a href="#" class="btn-publicacion" data-new-action="preview-publication"
								data-publicacion-url="{{ url('/publicacion/' . \Str::slug(strip_tags($publicacion->titulo_en)) . '/' . $publicacion->id . '/viewer') }}">Preview</a>
						@endif
					</div>
				</div>

				<div class="col-lg-8">
					<div class="publicacion-content">
						<h1 class="publicacion-title">{!! str_replace(['<p>', '</p>'], '', $publicacion->titulo_en) !!}</h1>

						<div class="publicacion-ficha">
							@if ($publicacion->campo_opcional_1_en_titulo && $publicacion->campo_opcional_1_en)
								<p><b>{{ $publicacion->campo_opcional_1_en_titulo }}</b> {{ $publicacion->campo_opcional_1_en }}
								</p>
							@endif

							@if ($publicacion->campo_opcional_5_en_titulo && $publicacion->campo_opcional_5_en)
								<p><b>{{ $publicacion->campo_opcional_5_en_titulo }}</b> {{ $publicacion->campo_opcional_5_en }}
								</p>
							@endif

							@if ($publicacion->coordinacion_editorial_en)
								<p><b>Editorial coordination:</b> {{ $publicacion->coordinacion_editorial_en }}</p>
							@endif

							@if ($publicacion->diseno_en)
								<p><b>Design:</b> {{ $publicacion->diseno_en }}</p>
							@endif

							@if ($publicacion->textos_en)
								<p><b>Texts:</b> {{ $publicacion->textos_en }}</p>
							@endif

							@if ($publicacion->campo_opcional_2_en_titulo && $publicacion->campo_opcional_2_en)
								<p><b>{{ $publicacion->campo_opcional_2_en_titulo }}</b> {{ $publicacion->campo_opcional_2_en }}
								</p>
							@endif

							@if ($publicacion->campo_opcional_6_en_titulo && $publicacion->campo_opcional_6_en)
								<p><b>{{ $publicacion->campo_opcional_6_en_titulo }}</b> {{ $publicacion->campo_opcional_6_en }}
								</p>
							@endif

							@if ($publicacion->campo_opcional_7_en_titulo && $publicacion->campo_opcional_7_en)
								<p><b>{{ $publicacion->campo_opcional_7_en_titulo }}</b> {{ $publicacion->campo_opcional_7_en }}
								</p>
							@endif
						</div>



						<div class="publicacion-divider"></div>

						@if ($publicacion->sinopsis_en)
							<h2 class="publicacion-subtitle">Summary</h2>

							<p class="publicacion-text">
								{!! nl2br($publicacion->sinopsis_en) !!}
							</p>
						@endif

						<div class="row publicacion-details">
							@if ($publicacion->campo_opcional_3_en_titulo && $publicacion->campo_opcional_3_en)
								<div class="col-lg-3">
									<p><b>{{ $publicacion->campo_opcional_3_en_titulo }}</b>
										{{ $publicacion->campo_opcional_3_en }}</p>
								</div>
							@endif

							@if ($publicacion->numero_paginas)
								<div class="col-lg-3">
									<p><b>Page count:</b> {{ $publicacion->numero_paginas }}</p>
								</div>
							@endif

							@if ($publicacion->fecha_publicacion)
								<div class="col-lg-3">
									<p><b>Publish date:</b> {{ $publicacion->fecha_publicacion }}</p>
								</div>
							@endif

							@if ($publicacion->campo_opcional_4_en_titulo && $publicacion->campo_opcional_4_en)
								<div class="col-lg-3">
									<p><b>{{ $publicacion->campo_opcional_4_en_titulo }}</b>
										{{ $publicacion->campo_opcional_4_en }}</p>
								</div>
							@endif
						</div>


					</div>
				</div>
			</div>

			<div class="modal fade" id="modal-publicacion" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-body p-0">
							<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<div id="publicacion-brochure-wrapper"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="modal-datos-descarga" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-body">
							<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<div class="row">
								<div class="col-md-12">

									<form action="/en/publication/{{ $publicacion->id }}/contacto" method="POST"
										class="datos-descarga-form">
										<div class="text-center">
											<h3>Thanks for your interest in our publications.</h3>
											<h4 id="form-action-message">Please leave us your contact details to keep in
												touch</h4>
										</div>
										@csrf
										<div class="form-group">
											<label for="nombre">Name:</label>
											<input type="text" name="nombre" id="nombre" class="form-control" required>
										</div>
										<div class="form-group">
											<label for="email">Email:</label>
											<input type="email" name="email" id="email" class="form-control">
										</div>
										<div class="form-group">
											<label for="telefono">Phone:</label>
											<input type="text" name="telefono" id="telefono" class="form-control">
										</div>
										<div class="form-group">
											<label for="organizacion">Organization:</label>
											<input type="text" name="organizacion" id="organizacion" class="form-control">
										</div>
										<div class="form-group text-right mt-3">
											<button type="submit" class="btn btn-enviar">Send</button>
										</div>
									</form>
									<div class="formulario-gracias" style="display: none;">
										<h3>Your details has been sent successfully.</h3>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		// Pass publication data to JavaScript
		window.publicationData = {
			id: {{ $publicacion->id }}
			};
	</script>

@endsection
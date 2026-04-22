@extends('layouts.boilerplate')

@section('content')
	<div id="home-index">
		@if($banners && $banners->count() > 0)
			<!-- Custom Banner Slider -->
			<section id="home-banner-slider" class="relative" x-data="{ 
												activeSlide: 0, 
												totalSlides: {{ $banners->count() }},
												autoplayInterval: null,
												intervalDuration: 5000,
												startAutoplay() {
													this.autoplayInterval = setInterval(() => {
														this.nextSlide();
													}, this.intervalDuration);
												},
												stopAutoplay() {
													clearInterval(this.autoplayInterval);
												},
												nextSlide() {
													this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
												},
												prevSlide() {
													this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
												}
											}" x-init="startAutoplay()" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">

				<div class="grid grid-cols-1 grid-rows-1">
					@foreach($banners as $index => $banner)
						<div class="col-start-1 row-start-1 relative bg-cover bg-center bg-no-repeat flex items-center transition-opacity duration-1000 ease-in-out"
							x-show="activeSlide === {{ $index }}" x-transition:enter="transition ease-out duration-1000"
							x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
							x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100"
							x-transition:leave-end="opacity-0"
							style="background-image: url('{{ $banner->backgroundImage ? $banner->backgroundImage->url : '/assets/images/casa/banner.jpg' }}'); min-height: 60vh;">

							<!-- Content with overlay background -->
							<div class="container mx-auto px-4 py-16">
								<div class="bg-green-900/90 p-10 mx-auto max-w-2xl text-center space-y-6 rounded-xl">
									<div class="banner-content">
										{!! $banner->content_es !!}
									</div>
									@if($banner->cta_text_es && $banner->cta_url_es)
										<div>
											<a href="{{ $banner->cta_url_es }}"
												class="inline-block !bg-green-600 text-white !px-7 !py-2 rounded-3xl hover:!bg-green-700 hover:!no-underline transition-colors font-medium text-lg">
												{{ $banner->cta_text_es }}
											</a>
										</div>
									@endif
								</div>
							</div>
						</div>
					@endforeach
				</div>

				<!-- Navigation Arrows -->
				@if($banners->count() > 1)
					<button @click="prevSlide()"
						class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/50 text-white rounded-full p-2 transition-colors z-10">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
						</svg>
					</button>
					<button @click="nextSlide()"
						class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/50 text-white rounded-full p-2 transition-colors z-10">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
						</svg>
					</button>


					<!-- Dots Indicator -->
					<div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
						@foreach($banners as $index => $banner)
							<button @click="activeSlide = {{ $index }}" class="w-3 h-3 rounded-full transition-colors duration-300"
								:class="activeSlide === {{ $index }} ? 'bg-white' : 'bg-white/50 hover:bg-white/80'">
							</button>
						@endforeach
					</div>
				@endif
			</section>
		@else
			<!-- Default Video Banner -->
			<section id="home-banner">
				<div class="video-container">
					<video class="jquery-background-video" loop autoplay muted playsinline
						poster="/assets/images/home/home-banner.jpg" data-bgvideo="true">
						<source src="/assets/images/home/home-banner.mp4" type="video/mp4">
					</video>
				</div>
			</section>
		@endif

		<section id="home-intro">
			<div class="container">
				@if($introContent)
					<div class="intro-text">
						{!! $introContent->main_text_es !!}
					</div>

					<div class="intro-description">
						{!! $introContent->secondary_text_es !!}
					</div>
				@else
					{{-- Fallback content if no database content exists --}}
					<div class="intro-text">
					Casa Gallina es una organización creativa y sin fines de lucro en México dedicada a promover la protección
					 del medio ambiente y la expresión cultural de las comunidades locales en todo el país. Fomentamos fuertes
					  conexiones con el mundo natural, así como con las culturas indígenas, comenzando con las iniciativas
					   impulsadas por la comunidad en la colonia Santa María la Ribera de la Ciudad de México y extendiéndolas
					    a otras áreas urbanas y rurales del país.
					</div>

					<div class="intro-description">
					Casa Gallina funciona como un dinámico laboratorio cultural, elaborando proyectos innovadores que combinan
					 el arte con la participación de la comunidad para preservar el medio ambiente, construir conexiones sociales
					  y aumentar la educación sobre las prácticas culturales tradicionales. Casa Gallina cree que cuando los vecinos 
					  tienen el tiempo y el espacio para construir conexiones intencionadas, construyen empatía entre ellos y pueden
					   colaborar para crear proyectos que promuevan el bien común.
					</div>
				@endif

				<div class="intro-readmore">
					<a href="/la-casa">Leer más<div class="plus-sign">+</div></a>
				</div>
			</div>
		</section>

		<section id="home-estrategias" class="py-16 bg-white" x-data="{
										currentIndex: 0,
										itemsPerPage: window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1),
										totalItems: {{ $programa_tags->count() }},
										get totalSlides() { return Math.ceil(this.totalItems / this.itemsPerPage) },
										get canGoNext() { return this.currentIndex < this.totalSlides - 1 },
										get canGoPrev() { return this.currentIndex > 0 },
										get translateX() { return -(this.currentIndex * (100 / this.itemsPerPage)) },
										next() { if (this.canGoNext) this.currentIndex++ },
										prev() { if (this.canGoPrev) this.currentIndex-- },
										goToSlide(index) { this.currentIndex = index },
										updateItemsPerPage() {
											const oldItemsPerPage = this.itemsPerPage;
											this.itemsPerPage = window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1);
											if (oldItemsPerPage !== this.itemsPerPage) {
												this.currentIndex = Math.min(this.currentIndex, this.totalSlides - 1);
											}
										}
									}" x-init="
										updateItemsPerPage();
										window.addEventListener('resize', () => updateItemsPerPage());
									">
			<div class="container mx-auto">
				<!-- Section Title -->
				<div class="text-center border-b-2 border-green-600 pb-2 mb-2">
					<span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Programa</span>
				</div>

				<!-- Intro Text -->
				<div class="font-serif text-green-600 text-xl leading-6 py-4 md:px-16 pb-2 text-center">
					Casa Gallina desarrolla programas transdisciplinarios que conectan cultura, comunidad y medio ambiente a
					través de experiencias colectivas de resiliencia, regeneración ecológica y creatividad social en el
					barrio de Santa María la Ribera.
				</div>

				<!-- Intro Description -->
				<div class="font-libre text-gray-600 leading-5 py-2 md:px-16 tracking-wide space-y-2 pb-8">
					<p>Nuestros programas se construyen mediante procesos de intercambio colectivo que involucran a la
						comunidad local en colaboración con profesionales, artistas, científicos y gestores de diversas
						disciplinas.</p>

					<p>Cada programa está diseñado para generar experiencias transformadoras que fortalezcan las redes
						comunitarias y promuevan el cambio sostenible.</p>
				</div>

				<!-- Carousel -->
				<div class="relative mb-12">
					<!-- Carousel Container -->
					<div class="overflow-hidden">
						<div class="flex transition-transform duration-500 ease-in-out"
							:style="`transform: translateX(${translateX}%)`">
							@foreach($programa_tags as $tag)
													<div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
														<a href="{{ $tag->type === 'programa-local' ? route(
									'programa.estrategia-local.detalle',
									$tag->slug
								) : route('programa.estrategia-externa.detalle', $tag->slug) }}" class="block text-center hover:opacity-80 transition-opacity duration-300 !no-underline
																																																		hover:!no-underline">
															<div class="mb-3 h-64">
																@if($tag->thumbnail)
																	<img src="{{ $tag->thumbnail?->url }}" alt="{{ $tag->nombre }}"
																		class="w-full h-full object-cover">
																@elseif($tag->multimedia)
																	<img src="{{ $tag->multimedia?->url }}" alt="{{ $tag->nombre }}"
																		class="w-full h-full object-cover">
																@else
																	<img src="{{ asset('images/no-image.svg') }}" alt="{{ $tag->nombre
																																																																	}}" class="w-full h-full object-cover">
																@endif
															</div>
															<h3 class="font-sans text-green-600 !text-xl leading-5 tracking-tight mb-2">{{ $tag->nombre
																																																		}}</h3>
														</a>
													</div>
							@endforeach
						</div>
					</div>

					<!-- Navigation Buttons -->
					<button @click="prev()" x-show="canGoPrev" class="absolute -left-6 top-26 bg-green-600 hover:bg-green-700 shadow-lg rounded-full p-3
								transition-colors duration-200 z-10">
						<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
						</svg>
					</button>

					<button @click="next()" x-show="canGoNext" class="absolute -right-6 top-26 bg-green-600 hover:bg-green-700 shadow-lg rounded-full p-3
								transition-colors duration-200 z-10">
						<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
						</svg>
					</button>

					<!-- Dots Indicator -->
					<div class="absolute -bottom-4 left-1/2 -translate-x-1/2 translate-y-4 flex justify-center
								gap-3" x-show="totalSlides > 1">
						<template x-for="(slide, index) in Array.from({length: totalSlides}, (_, i) => i)" :key="index">
							<button @click="goToSlide(index)" class="w-3 h-3 rounded-full transition-colors duration-200"
								:class="currentIndex === index ? 'bg-green-600' : 'bg-gray-400 hover:bg-gray-500'">
							</button>
						</template>
					</div>
				</div>

				<!-- Read More Link -->
				<div class="text-center mt-8">
					<a href="/programa" class="inline-flex items-center !text-green-600 hover:!text-green-700 transition-colors
								duration-200 !no-underline hover:!no-underline">
						<span class="text-lg font-medium mr-2">Ver más</span>
						<div class="w-6 h-6 !bg-green-600 hover:!bg-green-700 !text-white rounded-full flex
								items-center justify-center text-sm font-bold transition-colors duration-200">
							+</div>
					</a>
				</div>
			</div>
		</section>

		<section id="home-publicaciones">
			<div class="container">
				<div class="section-title text-center">
					<span>Publicaciones</span>
				</div>

				<div class="publicaciones-carousel row">
					@foreach ($publicaciones as $publicacion)
								<div class="publicacion-item col-md-6 col-lg-4">
									<div class="publicacion-image"
										style="background-image: url('{{ $publicacion->publicacion_thumbnail?->url }}')"
										onclick="window.location = '/publicacion/{{ \Str::slug($publicacion->titulo) }}/{{ $publicacion->id }}'">
									</div>
									<div class="publicacion-title">
										<a
											href="/publicacion/{{ \Str::slug(strip_tags($publicacion->titulo)) }}/{{ $publicacion->id }}">{!!
						$publicacion->titulo !!}</a>
									</div>
									<div class="publicacion-subtitle">
										{{ $publicacion->subtitulo }}
									</div>
								</div>
					@endforeach
				</div>

				<div class="publicaciones-readmore">
					<a href="/publicaciones">Ver más<div class="plus-sign">+</div></a>
				</div>
			</div>
		</section>

		<section id="home-noticias" class="py-16 bg-gray-50">
			<div class="container mx-auto">
				<!-- Section Title -->
				<div class="text-center border-b-2 border-green-600 pb-2 mb-8">
					<span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Noticias</span>
				</div>

				<!-- Intro Text -->
				<div class="font-serif text-green-600 text-xl leading-6 py-4 md:px-16 pb-8 text-center">
					Mantente al día con las últimas noticias, eventos y actividades de Casa Gallina y la comunidad.
				</div>

				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
					@foreach ($noticias as $noticia)
						<div class="text-center">
							<a href="/noticia/{{ $noticia->slug }}"
								class="block hover:opacity-80 transition-opacity duration-300 !no-underline hover:!no-underline">
								<div class="mb-3 h-64">
									@if($noticia->featured_image)
										<img src="{{ $noticia->featured_image?->url }}" alt="{{ strip_tags($noticia->titulo) }}"
											class="w-full h-full object-cover">
									@else
										<img src="{{ asset('assets/images/casa/banner.jpg') }}"
											alt="{{ strip_tags($noticia->titulo) }}" class="w-full h-full object-cover">
									@endif
								</div>
								<h3 class="font-sans text-green-600 !text-xl leading-6 tracking-tight mb-2">
									{{ \Str::limit(strip_tags($noticia->titulo), 60) }}
								</h3>
								<p class="text-gray-600 text-sm leading-5">
									{{ \Str::limit($noticia->excerpt, 100) }}
								</p>
							</a>
						</div>
					@endforeach
				</div>

				<div class="text-center mt-8">
					<a href="/noticias"
						class="inline-flex items-center !text-green-600 hover:!text-green-700 transition-colors duration-200 !no-underline hover:!no-underline">
						<span class="text-lg font-medium mr-2">Ver más</span>
						<div
							class="w-6 h-6 !bg-green-600 hover:!bg-green-700 !text-white rounded-full flex items-center justify-center text-sm font-bold transition-colors duration-200">
							+</div>
					</a>
				</div>
			</div>
		</section>

		<section id="home-numeralia">
			<div class="container">
				<div class="section-title text-center">
					<span>Impacto</span>
				</div>
			</div>

			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-11">
						<div class="numeralia-content">
							<div class="fechas-header">
								A partir de 2019
							</div>

							<div class="container" style="border: 0px solid gray">
								<div
									style="text-align: center; color: #073D8C;font-size: 39px; line-height: 1.2; font-weight: 700;">
									ALCANCE COMUNITARIO
								</div>
								<div class="row" style="text-align: center; padding-top: 0px; padding-bottom: 35;">

									<div class="col-md-6">
										<br><br>
										<img loading="lazy" src="/assets/images/home/numeralia/object-01.png"><br>
										<br>
										<span style="color: #073D8C; font-size: 48px; line-height: 60px; font-weight: 700;"
											class="countup-element" data-number="13121">13,121</span>
										<br>
										<span
											style="color: #4a5d5a; font-size: 22px; line-height: 30px; font-weight: 400;">vecinos
											participando <br>en programas</span>
										<br>
										<span style="color: #073D8C; font-size: 50px; line-height: 60px; font-weight: 700;"
											class="countup-element" data-number="307">307</span>
										<br>
										<span
											style="color: #4a5d5a; font-size: 22px; line-height: 30px; font-weight: 400;">asistentes
											mensuales a<br>la Casa en promedio</span>
									</div>

									<div class="col-md-6">

										<span
											style="color: #073D8C; font-size: 70px; line-height: 80px; font-weight: 700;">49,000</span><br>
										<span
											style="color: #4a5d5a; font-size: 22px; line-height: 30px; font-weight: 400;">beneficiarios
											indirectos<br>(número de habitantes<br>de Santa María la Ribera)</span><br>
										<div class="row" style="padding-top: 35px;">
											<div class="col-sm-5" style="text-align: right;">
												<span
													style="color: #073D8C; font-size: 80px; line-height: 110px; font-weight: 700;"
													class="countup-element" data-number="25">25</span>
											</div>
											<div class="col-sm-7" style="text-align: left;">
												<span
													style="color: #073D8C; font-size: 33px; line-height: 30px; font-weight: 600;"><br>iniciativas<br></span><span
													style="color: #073D8C; font-size: 36px; line-height: 33px; font-weight: 600;">vecinales</span>
											</div>

										</div>
										<span
											style="color: #073D8C; font-size: 27px; line-height: 9px; font-weight: 600;">&nbsp&nbsp&nbsppor
											el bien común</span><br><br><br>


										<span
											style="color: #4a5d5a; font-size: 22px; line-height: 33px; font-weight: 400;">Colaboraciones
											con<br> <span
												style="color: #073D8C; font-size: 30px; line-height: 10px; font-weight: 600;">19
												escuelas</span> locales, apoyando<br>el aprendizaje creativo y
											significativo<br>de <span
												style="color: #073D8C; font-size: 30px; line-height: 10px; font-weight: 600;">9,981
												niñas</span> y niños, y el<br>trabajo de <span
												style="color: #073D8C; font-size: 30px; line-height: 10px; font-weight: 600;">556
												docentes</span></span>
										</span>
									</div>

								</div>
								<div style="text-align: center;padding-top: 20px; padding-bottom: 35px">

									<br><br>
									<span
										style="color: #073D8C; font-size: 38px; line-height: 40px; font-weight: 650;">Testimonio<br></span>
									<br>
									<span
										style="color: #4a5d5a; font-size: 22px; line-height: 24px; font-weight: 400;"><span
											style="color: #073D8C; font-size: 30px; line-height: 24px; font-weight: 700;">“</span>
										Vivimos desde el adultocentrismo que es la base<br>de la enseñanza y aquí tienen
										otro enfoque pedagógico<br>donde los niños pueden fomentar el sentido de la
										comunidad,
										<br>esa situación de apoyo, generar un espacio<br>donde se sientan seguros, y como
										niños
										<br>y adultos podamos expresarnos<span
											style="color: #073D8C; font-size: 30px; line-height:24px; font-weight: 700;">”<br><br></span><span
											style="color: #073D8C; font-size: 18px; line-height:24px; font-weight:450;">-
											Jessica Martínez, mamá de niña participante en el curso de verano <i>Vida en mi
												entorno</i>, agosto de 2022</span></span>
								</div>

							</div>
							<br><br>
							<div class="container" style="border: 0px solid gray">
								<div class="row" style="text-align: center; padding-top: 20px; padding-bottom: 35;">
									<div class="col-md-6">
										<br><br>
										<span
											style="text-align: center; color: #F4B519;font-size: 50px; line-height: 50px; font-weight: 700;">EXPANSIÓN<br>A
											OTROS<br>TERRITORIOS</span><br><br>
										<span
											style="color: #4a5d5a; font-size: 20px; line-height: 28px; font-weight: 400;">Vínculo
											con <b>333 organizaciones<br> </b>y<b> agentes comunitarios<br></b><b>258</b>
											aliados activan<br>nuestros productos,<br>narrativas y proyectos en<br><b>151
												comunidades,</b> de<br><b>23
												estados: </b></span><br>
										<img loading="lazy" src="/assets/images/home/numeralia/pais2.png"><br>
										<span
											style="color: #4a5d5a; font-size: 20px; line-height: 28px; font-weight: 400;">Alcanzando
											a <b>56,275 personas<br>en otros territorios</b></span>

										<div class="row">
											<div class="col-sm-4" style="text-align: right;">
												<span
													style="color: #F4B519; font-size: 130px; line-height: 170px; font-weight: 700;"
													class="countup-element" data-number="8">8</span>
											</div>
											<div class="col-sm-8" style="text-align: left;">
												<span
													style="color: #F4B519; font-size: 30px; line-height: 35px; font-weight: 600;"><br>programas
													de<br>educación<br>ambiental</span>
											</div>


											<div class="row">

												<div class="col-sm-2"></div>
												<div class="col-sm-7" style="text-align: left;"> <span
														style="color: #4a5d5a; font-size: 20px; line-height: 28px; font-weight: 400;"><br><b>103</b>
														centros educativos <br><b>512</b> educadores<br><b>9958</b>
														estudiantes<br></span>
												</div>
												<div class="col-sm-3">

													<img loading="lazy" src="/assets/images/home/numeralia/maestra.png"><br>
												</div>
											</div>

											<span
												style="color: #4a5d5a; font-size: 22px; line-height: 28px; font-weight: 400;text-align: left;"><b>En
													Oaxaca, Campeche,<br>Guerrero, Ciudad de México, Puebla,<br>Veracruz y
													Jalisco</b><br><br><br></span>



										</div>
										<div class="row">
											<div class="col-sm-3">
												<span
													style="color: #F4B519; font-size: 130px; line-height: 175px; font-weight: 700; text-align: left;"
													class="countup-element" data-number="9">9</span>
											</div>
											<div class="col-sm-5" style="text-align: left;">
												<span
													style="color: #F4B519; font-size: 28px; line-height: 28px; font-weight: 600;"><br>exposiciones<br>comunitarias<br>activadas<br>en
													8 estados</span>
											</div>
											<div class="col-sm-4" style="text-align: left;">
												<img loading="lazy" src="/assets/images/home/numeralia/expomaiz.png">
											</div>
										</div>
										<div class="row">
											<span
												style="color: #4a5d5a; font-size: 24px; line-height: 34px; font-weight: 400; text-align: left;">Ciudad
												de México, Estado<br>de México, Nayarit, Tabasco,<br>Quintana Roo,
												Oaxaca,<br>Chiapas y Puebla<br></span>
										</div>

									</div>






									<div class="col-md-6">
										<div class="row">
											<div class="col-sm-4">
												<span
													style="color: #F4B519; font-size: 130px; line-height: 170px; font-weight: 700;"
													class="countup-element" data-number="15">15</span>
											</div>
											<div class="col-sm-8" style="text-align: left;">
												<span
													style="color: #F4B519; font-size: 30px; line-height: 35px; font-weight: 600;"><br>libros
													publicados y<br>distribuidos a nivel<br> nacional:</span>
											</div>
											<div style="text-align: left;"> <span
													style="color: #4a5d5a; font-size: 30px; line-height: 40px; font-weight: 500;">&nbsp&nbsp<i>Somos
														maíz &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></span>
												<img loading="lazy" src="/assets/images/home/numeralia/maiz.png"><br>
											</div>
											<div class="col-sm-9" style="text-align: left;">
												<span
													style="color: #4a5d5a; font-size: 28px; line-height: 36px; font-weight: 500;"><i>Constelaciones.
														<br>Manual de herramientas<br>para mapeos colectivos</i></span>
											</div>
											<div class="col-sm-3" style="text-align: : left;">
												<img loading="lazy" src="/assets/images/home/numeralia/constelaciones.png">
											</div>
											<br>
											<br>
											<div class="col-sm-10" style="text-align: left; padding-top: 25px">
												<span
													style="color: #4a5d5a; font-size: 28px; line-height: 36px; font-weight: 500;"><i>Interconexiones.
														Criaturas<br>grandes y pequeñas en el<br>mismo mundo</i></span>
											</div>
											<div class="col-sm-2"
												style="text-align: : left; padding-top: 25px; padding-left: 1px">
												<img loading="lazy" src="/assets/images/home/numeralia/colibiinter.png"><br>
											</div>
											<div style="text-align: left;"> <span
													style="color: #4a5d5a; font-size: 30px; line-height: 50px; font-weight: 500;">&nbsp&nbsp<i>La
														huerta distribuida
														&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></span>
												<img loading="lazy" src="/assets/images/home/numeralia/hoja.png"><br><br>
											</div>
											<div style="text-align: left;"> <span
													style="color: #4a5d5a; font-size: 30px; line-height: 40px; font-weight: 500;">&nbsp&nbsp<i>Vida
														en mi entorno &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></span>
												<img loading="lazy" src="/assets/images/home/numeralia/tlaco.png"><br>
											</div>

											<div style="text-align: left;"> <span
													style="color: #4a5d5a; font-size: 30px; line-height: 40px; font-weight: 500;">&nbsp&nbsp<i>Hacemos
														nuestro río &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></span>
												<img loading="lazy" src="/assets/images/home/numeralia/rio.png"><br>
											</div>
											<div class="col-sm-8" style="text-align: left;">
												<span
													style="color: #4a5d5a; font-size: 30px; line-height: 40px; font-weight: 500;"><i>Sabores
														y saberes<br>de la milpa</i></span>
											</div>
											<div class="col-sm-4" style="text-align: : left;">
												<img loading="lazy" src="/assets/images/home/numeralia/ejote.png">
											</div>
											<div class="col-sm-11" style="text-align: left;">
												<span
													style="color: #4a5d5a; font-size: 30px; line-height: 40px; font-weight: 500;"><i>Trazar
														lo común.<br>Los territorios que nos habitan</i></span>
											</div>
											<div class="col-sm-1" style="text-align: : left;">
												<img loading="lazy" src="/assets/images/home/numeralia/ave.png">
											</div>
											<div class="col-sm-11" style="text-align: left;"> <span
													style="color: #4a5d5a; font-size: 30px; line-height: 40px; font-weight: 500;"><i>Recrea.
														Compilación de<br>estrategias educativas</i></span>
											</div>
											<div class="col-sm-1" style="text-align: : right;">
												<img loading="lazy" src="/assets/images/home/numeralia/recrea.png"><br>
											</div>
											<div class="col-sm-8" style="text-align: left;">
												<span
													style="color: #4a5d5a; font-size: 30px; line-height: 40px; font-weight: 500;"><i>El
														sentido de jardín</i></span>
											</div>
											<div class="col-sm-4" style="text-align: : left;">
												<img loading="lazy" src="/assets/images/home/numeralia/sentido.png">
											</div>
											<div class="col-sm-11" style="text-align: left;">
												<span
													style="color: #4a5d5a; font-size: 30px; line-height: 40px; font-weight: 500;"><i>Alientos:
														Siete apuntes<br>de mediación lectora</i></span>
											</div>
											<div class="col-sm-1" style="text-align: : left;">
												<img loading="lazy" src="/assets/images/home/numeralia/alientos.png">
											</div>

											<div class="col-sm-6" style="padding-top: 25px; padding-bottom: 10;">
												<span
													style="color: #F4B519; font-size: 100px; line-height: 100px; font-weight: 700;">32%</span>
											</div>
											<div class="col-sm-6"
												style="text-align: left; padding-top: 25px; padding-bottom: 10;">
												<span
													style="color: #F4B519; font-size: 23px; line-height: 30px; font-weight: 500;">del
													tiraje consiste<br>en ediciones en 10<br>lenguas indígenas:</span>
											</div>
											<span
												style="text-align: left;color: #4a5d5a; font-size: 28px; line-height: 36px; font-weight: 400;">&nbsp&nbsp&nbsp&nbspzapoteco,
												maya, náhuatl, wixárika,<br>&nbsp&nbsp&nbsp&nbsppurépecha, ombeayiüts,
												tsotsil<br>&nbsp&nbsp&nbsp&nbsptseltal, mazateco y totonaco</span><br><br>
										</div>
									</div>
								</div>
							</div>
							<br>
							<div class="text-center mt-8">
								<a href="{{ route('impacto') }}"
									class="inline-flex items-center !text-green-600 hover:!text-green-700 transition-colors duration-200 !no-underline hover:!no-underline">
									<span class="text-lg font-medium mr-2">Ver todo el impacto</span>
									<div
										class="w-5 h-5 !bg-green-600 hover:!bg-green-700 !text-white rounded-full flex items-center justify-center text-lg font-bold transition-colors duration-200">
										+</div>
								</a>
							</div>
						</div>
					</div>
				</div>

			</div>
		</section>

		<section id="home-cartografia">
			@livewire('components.cartografia-map')
		</section>

		<section id="home-aliados">
			<div class="container">
				<div class="section-title text-center">
					<span>Aliados</span>
				</div>
			</div>

			<div class="aliados-banner">
				<img loading="lazy" src="assets/images/home/aliados/banner.jpg" class="img-fluid">
			</div>

			<div class="container">
				<div class="aliados-text">
					<p>Casa Gallina trabaja en construir y fortalecer redes de alianzas con colectivos, individuos,
						asociaciones civiles e instituciones públicas y privadas con los que existen intereses compartidos.
						En diversos formatos y marcos de colaboración se construyen procesos de colaboración que tejen redes
						para compartir recursos, estrategias y metodologías.</p>
				</div>

				<div class="aliados-description">
					<p>Las distintas alianzas se construyen para activar procesos y acciones en torno a narrativas críticas
						con el fin de activar experiencias colectivas sobre ecología, resiliencia, articulación comunitaria
						y creatividad en la vida cotidiana. </p>

					<p>La red de colaboración se construye a través de la implementación de las estrategias y programas de
						Casa Gallina que constantemente cuentan con aliados de muy diversa índole. Esta red se profundiza a
						través de la creación de nuevos programas y formatos de trabajo en coparticipación con los agentes y
						organizaciones con las que se colabora. En búsqueda de expansión constante la red está abierta para
						integrar constantemente nuevas organizaciones, colectivos e instituciones que compartan los
						intereses por crear proyectos a favor del bien común, la cultura, la comunidad y el medio ambiente.
					</p>
				</div>

				<div class="text-center mt-8">
					<a href="{{ route('aliados') }}"
						class="inline-flex items-center !text-green-600 hover:!text-green-700 transition-colors duration-200 !no-underline hover:!no-underline">
						<span class="text-lg font-medium mr-2">Ver más</span>
						<div
							class="w-5 h-5 !bg-green-600 hover:!bg-green-700 !text-white rounded-full flex items-center justify-center text-lg font-bold transition-colors duration-200">
							+</div>
					</a>
				</div>

			</div>
		</section>


	</div>
@endsection

@section('pre_scripts')
	<script
		src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initGoogleMaps"
		async defer></script>
	<script>
		window.initGoogleMaps = function () {
			console.log('Google Maps loaded');
		};
	</script>
@endsection
@extends('layouts.boilerplate')

@section('title', ' - Aquí es una casa - Campaña de fondeo colectivo')

@section('meta')

    <meta name="description" content="Aquí es una casa - Campaña de fondeo colectivo para hacer posible una publicación infantil y actividades comunitarias.">
    <meta name="keywords" content="donaciones, Casa Gallina, campaña, fundación, cultura, medio ambiente, arte, educación, comunidad, Aquí es una casa">
    <meta name="author" content="Casa Gallina">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Aquí es una casa - Campaña de fondeo colectivo">
    <meta property="og:description" content="Campaña de fondeo colectivo para hacer posible una publicación infantil y actividades comunitarias.">
    <meta property="og:image" content="{{ asset('assets/images/donaciones/aqui-banner.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Casa Gallina">
@endsection

@section('content')
    <div class="mx-auto max-w-4xl px-4">
        <!-- Banner Section -->
        <section class="pt-2 pb-4">
            <div class="relative">
                <img src="{{ asset('assets/images/donaciones/aqui-banner.jpg') }}" class="mx-auto w-4/5 max-w-4xl rounded-lg shadow-lg" alt="Banner de Aquí es una casa">
            </div>
        </section>

        <!-- Header Section -->
        <section class="text-center pt-6">
            <h1 class="text-5xl text-forest font-serif mb-2">
                Aquí es una casa
            </h1>
            <h2 class="text-3xl md:text-4xl text-gray font-serif">Campaña de fondeo colectivo</h2>
            <p class="text-xl text-forest font-serif mt-4">Del 13 de octubre al 11 de diciembre de 2025</p>
        </section>

        <!-- Introduction Section -->
        <section class="py-8 mt-4">
            <div class="max-w-3xl mx-auto">
                <div class="space-y-6">
                    <p class="text-lg md:text-xl text-forest font-serif text-center">
                        <em>Aquí es una casa</em> es una campaña de fondeo colectivo para hacer posible una publicación infantil y una serie de actividades comunitarias. El proyecto es resultado de un proceso de colaboración con comunidades infantiles en Santa María la Ribera y Milpa Alta.
                    </p>
                    <p class="text-lg md:text-xl text-gray font-serif text-center">
                        En un formato de acordeón, el libro presenta ilustraciones de la artista <strong>María José Retana</strong> y textos de la escritora <strong>Alejandra Retana</strong>, ambas originarias de Milpa Alta.
                    </p>
                    <p class="text-lg md:text-xl text-gray font-serif text-center">
                        <em>Aquí es una casa</em> nos lleva de la mano por dos territorios: Santa María la Ribera y Milpa Alta, para reconocerlos desde el amanecer hasta el anochecer a través de las voces de las infancias que los habitan.
                    </p>
                </div>
            </div>

            <div class="mt-8">
                <div class="flex justify-center">
                    <a href="#"
                       data-bs-toggle="modal"
                       data-bs-target="#modal-donacion"
                       class="bg-forest hover:text-white hover:no-underline text-white px-6 py-1 rounded-2xl font-medium font-serif hover:bg-forest/700 transition duration-300 text-lg">
                        Apoya esta causa
                    </a>
                </div>
            </div>
        </section>

        <section class="py-8 max-w-3xl mx-auto">
            <iframe
                src="https://www.youtube.com/embed/ATShrUp1wOo?si=snAct_3YQD8gZDgB&amp;controls=0&amp;start=1"
                title="Aquí es una casa"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen
                class="w-full h-96 rounded-lg shadow-md"
            ></iframe>
        </section>

        <!-- Main Content Section -->
        <section class="py-8">
            <div class="max-w-5xl mx-auto space-y-8">
                <!-- Description -->
                <div class="space-y-4">
                    <p class="text-justify text-gray font-sans">
                        Además del libro, habrá una exposición en el Museo de Geología, que permitirá compartir las miradas de niñas y niños sobre sus territorios y propiciar el encuentro con quienes visiten el museo, con artistas y con personas de la comunidad, para continuar la conversación y el aprendizaje colectivo.
                    </p>
                    <p class="text-justify text-gray font-sans">
                        El objetivo de esta campaña es ayudar a financiar las distintas actividades relacionadas con el proyecto y generar experiencias que fortalezcan procesos educativos, así como la identidad local y cultural de diversas comunidades.
                    </p>
                    <p class="text-justify text-gray font-sans">
                        ¡Te invitamos a ser parte de nuestras actividades y seguir sumando a la conversación colectiva!
                    </p>
                    <p class="text-justify text-gray font-sans">
                        Preventa disponible del <strong>13 de octubre al 11 de diciembre</strong> en nuestra página web y en Casa Gallina.
                    </p>
                </div>

                <!-- Image Section -->
                <div class="flex justify-center">
                    <img src="{{ asset('assets/images/donaciones/aqui-gallery.jpg') }}" alt="Aquí es una casa" class="w-full max-w-3xl rounded-lg shadow-md">
                </div>

                <!-- Donation Section -->
                <div class="space-y-6">
                    <div class="w-full border-b-2 border-forest flex justify-center mb-10">
                        <h3 class="text-2xl text-center bg-forest font-regular text-white font-serif mb-0 py-1 px-4">
                            ¿Cómo puedo donar?
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col justify-between bg-forest p-4 rounded-3xl shadow-sm">
                            <h4 class="font-medium text-2xl text-white font-serif w-2/3 mr-auto">Donación a través de nuestra página web</h4>

                            <div class="mb-2 self-end">
                                <a href="#"
                                   data-bs-toggle="modal"
                                   data-bs-target="#modal-donacion"
                                   class="bg-white hover:text-gray hover:no-underline text-forest px-6 py-3 rounded-2xl font-medium font-serif hover:bg-forest-700 transition duration-300 text-xl">
                                    Donar
                                </a>
                            </div>
                        </div>

                        <div class="flex flex-col gap-6 justify-between bg-gray-100 p-4 rounded-3xl shadow-sm">
                            <div>
                                <h4 class="font-medium text-2xl text-gray font-serif w-2/3 mr-auto mb-0">Donación presencial</h4>
                                <h5 class="text-forest font-medium mb-0 font-serif text-lg">
                                    Aportaciones en efectivo se reciben en las alcancías instaladas en Casa Gallina
                                </h5>
                            </div>

                            <div class="mb-0 text-right font-serif">
                                <h6 class="mb-0 text-xl font-sans text-forest font-semibold">
                                   
                                </h6>
                                <p class="text-gray mb-0 text-lg leading-5 text-gray-600">
                                    
                                <a href="mailto:quetzalli@casagallina.org.mx"
                                   class="text-forest hover:text-forest/90 underline mb-0">
                                    
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recognition Section -->
                <div class="space-y-6">
                    <div class="w-full border-b-2 border-forest flex justify-center mb-10">
                        <h3 class="text-2xl text-center bg-forest font-regular text-white font-serif mb-0 py-1 px-4">
                            Reconocimientos
                        </h3>
                    </div>

                    <p class="text-gray font-sans text-center">
                        Te invitamos a hacer una aportación mayor al valor del libro y recibir reconocimientos como:
                    </p>

                    <ul class="list-disc list-inside text-gray font-sans space-y-2 max-w-3xl mx-auto">
                        <li>20% de descuento en el libro</li>
                        <li>Visita guiada a la exposición (feb-abr 2026)</li>
                        <li>Stickers para WhatsApp</li>
                        <li>Máscaras recortables digitales</li>
                        <li>Boleto para rifa de canastas agroecológicas</li>
                        <li>Calendario 2026</li>
                        <li>Libros editados por Casa Gallina</li>
                    </ul>

                    <!-- Recognition Image -->
                    <div class="flex justify-center">
                        <img src="{{ asset('assets/images/donaciones/aqui-recognitions.jpg') }}" alt="Reconocimientos" class="w-full max-w-4xl rounded-lg shadow-md my-4">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Recognition Card -->
                        @php
                            $recognitions = [
                                [
                                    'amount' => '$400.00',
                                    'description' => '¡Muchas gracias por tu apoyo! Como agradecimiento te haremos llegar el libro <em>Aquí es una casa</em> con descuento + visita guiada + stickers + máscaras recortables + mención en la web.'
                                ],
                                [
                                    'amount' => '$500.00',
                                    'description' => '¡Te agradecemos profundamente! Tu donación está teniendo un impacto significativo. En agradecimiento te haremos llegar el libro Aquí es una casa con descuento + visita guiada + stickers + máscaras recortables + mención en la web + 1 boleto para la rifa de canasta local.'
                                ],
                                [
                                    'amount' => '$700.00',
                                    'description' => '¡Muchísimas gracias! Tu aportación está haciendo una gran diferencia. Como agradecimiento recibirás el libro Aquí es una casa con descuento + visita guiada + stickers + máscaras recortables + mención en la web + calendario 2026.'
                                ],
                                [
                                    'amount' => '$1,000.00',
                                    'description' => '¡Wow! No sabemos cómo agradecer tu ayuda pero vamos a intentarlo con un gesto en el que recibirás el libro <em>Aquí es una casa</em> con descuento + visita guiada + stickers + máscaras recortables + mención en la web + libro La huerta distribuida.'
                                ],
                                [
                                    'amount' => '$1,500.00',
                                    'description' => '¡Wow! No sabemos cómo agradecer tu ayuda pero vamos a intentarlo con un gesto en el que recibirás el libro <em>Aquí es una casa</em> con descuento + visita guiada + stickers + máscaras recortables + mención en la web + libro La huerta distribuida + un ejemplar de <em>Alientos</em> o <em>Historias y sabores que habitamos</em> (a elegir).'
                                ],
                            ];
                        @endphp

                        @foreach($recognitions as $recognition)
                            <div class="bg-white border border-forest-200 rounded-lg shadow-sm p-6">
                                <h4 class="text-xl font-semibold text-forest mb-2">{{ $recognition['amount'] }}</h4>
                                <p class="text-gray text-sm font-sans">
                                    {!! $recognition['description'] !!}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="space-y-4">
                    <div class="w-full border-b-2 border-forest flex justify-center mb-10">
                        <h3 class="text-2xl text-center bg-forest font-regular text-white font-serif mb-0 py-1 px-4">
                            ¿Cómo y cuando se entregan los reconocimientos?
                        </h3>
                    </div>
                    <p class="text-gray font-sans">
                        Los materiales digitales te llegarán en un plazo máximo de 7 días hábiles después de tu compra.
                    </p>
                    <p class="text-gray font-sans">
                        Los materiales físicos (excepto el libro <strong>Aquí es una casa</strong>) se entregarán en Casa Gallina el 6 de diciembre durante la kermés, o bien podrás recogerlos en Casa Gallina antes del 31 de enero de 2026.
                    </p>
                    <p class="text-gray font-sans">
                        El libro <strong>Aquí es una casa</strong> se entregará en febrero de 2026.
                    </p>
                </div>

                <!-- Contact Section -->
                <div class="flex flex-col gap-6 justify-between bg-gray-100 p-4 rounded-3xl shadow-sm">
                    <div>
                        <h4 class="font-medium text-2xl text-gray font-serif w-2/3 mr-auto mb-0">Contacto</h4>
                        <h5 class="text-forest font-medium mb-0 font-serif text-lg">
                            
                        </h5>
                    </div>

                    <div class="mb-0 text-right font-serif">
                        <h6 class="mb-0 text-xl font-sans text-forest font-semibold">
                            Quetzalli Villanueva
                        </h6>
                        <p class="text-gray mb-0 text-lg leading-5 text-gray-600">
                            Desarrollo y Alianzas estratégicas
                        </p>
                        <a href="mailto:quetzalli@casagallina.org.mx"
                           class="text-forest hover:text-forest/90 underline mb-0">
                            quetzalli@casagallina.org.mx
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


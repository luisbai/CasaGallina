@extends('layouts.boilerplate')

@section('title', ' - Donaciones Campaign')

@section('meta')
    <meta name="description" content="Apoya a Casa Gallina para continuar con su trabajo de preservación de la cultura y medio ambiente.">
    <meta name="keywords" content="donaciones, Casa Gallina, campaña, fundación, cultura, medio ambiente, arte, educación, comunidad">
    <meta name="author" content="Casa Gallina">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Campaña de fondeo colectivo: Oficios que hacen al barrio">
    <meta property="og:description" content="Apoya a Casa Gallina para continuar con su trabajo de preservación de la cultura y medio ambiente.">
    <meta property="og:image" content="{{ asset('assets/images/donaciones/campaign-banner.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Casa Gallina">
@endsection

@section('content')
    <div class="mx-auto max-w-4xl px-4">
        <!-- Banner Section -->
        <section class="pt-2 pb-4">
            <div class="relative">
                <img src="{{ asset('assets/images/donaciones/portada-oficios.png') }}" class="mx-auto w-5/5 max-w-4xl rounded-lg shadow-lg" alt="Banner de la campaña de donaciones">
            </div>
        </section>

        <!-- Header Section -->
        <section class="text-center pt-6">
            <h1 class="text-5xl text-forest font-serif mb-2">
                 <span class="font-semibold block py-2 pt-3">Oficios que hacen al barrio </span>
            </h1>
            <h2 class="text-3xl md:text-4xl text-gray font-serif">Campaña de fondeo colectivo</h2>
        </section>

        <!-- Introduction Section -->
        <section class="py-8 mt-4">
            <div class="max-w-3xl mx-auto">
                <div class="space-y-6">
                    <p class="text-lg md:text-xl text-forest font-serif text-center">
                    ¿Qué hace que un barrio siga vivo? La energía de la gente: la de todas esas personas que saben hacer, reparar, transformar y enseñar.

                    </p>
                    <p class="text-lg md:text-xl text-gray font-serif text-center">
                    Los oficios habitan nuestro barrio y son saberes que pasan de una generación a otra y que nos enseñan a cuidar lo que tenemos, a reparar en lugar de desechar y a construir comunidad.
                    Por eso lanzamos “Oficios que hacen al barrio”, una campaña de fondeo colectivo para mantener y ampliar un programa educativo y de vinculación barrial durante 2027 que incluye:<br><br>
●	Talleres impartidos por maestras y maestros de oficios, para compartir saberes directamente con vecinas y vecinos.<br>
●	Sesiones de cine-debate, para abrir conversaciones sobre trabajo, saberes y formas de vida.<br>
●	Curso de verano para niñas y niños de la colonia, donde puedan aprender haciendo y acercarse a distintos oficios.<br>
●	Curso de verano para jóvenes del barrio, para explorar los oficios desde sus propios intereses y perspectivas.<br>
●	Encuentros y activaciones comunitarias con vecinas y vecinos, que permitan que estos aprendizajes continúen más allá de cada actividad.<br><br>
Tenemos una meta de $100,000 MX, lo cual nos permitirá cubrir materiales, honorarios de maestras y maestros de oficio, producción y distribución de materiales didácticos y acompañamiento para que estas actividades sean gratuitas y accesibles para la comunidad.

                    </p>
                </div>
            </div>

           <div class="max-w-2xl mx-auto">
                 <!--<div class="bg-gray-200 rounded-3xl px-4 py-4 mt-12">
                    <h3 class="text-2xl text-center font-serif text-forest mb-6">
                        Campaña abierta hasta el 10 de diciembre de 2026
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col text-center">
                            <h4 class="text-gray-500 text-xl mb-0">
                                Total Recaudado
                            </h4>
                            <span class="text-gray-600 text-2xl font-medium">
                                $0 pesos
                            </span>
                        </div>
                        <div class="flex flex-col text-center">
                            <h4 class="text-gray-500 text-xl mb-0">
                                Meta
                            </h4>
                            <span class="text-gray-600 text-2xl font-medium">
                                $100,000 pesos
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 mb-2">
                    <div class="flex flex-col text-center">
                            <h4 class="text-gray-500 text-xl mb-0">
                                Porcentaje:
                            </h4>
                            <span class="text-gray-600 text-2xl font-medium">
                              0 % <br><br>
                            </span>
                        </div>

                        <h4 class="text-gray-500 text-xl mb-2 text-center">
                            Donadores
                        </h4>
                        <div class="flex flex-wrap justify-center gap-4 text-gray-600 font-medium text-xl leading-4">
                            <span></span>
                           
                        </div>
                        <h4 class="text-gray-500 text-xl mb-2 text-center">
                        <br><br>Donadores en especie
                        </h4>
                        <div class="flex flex-wrap justify-center gap-4 text-gray-600 font-medium text-xl leading-4">
                            <span></span>
                           
                        </div>
                        </div>
                    </div>-->

                    <div class="mt-8">
                        <div class="flex justify-center">
                            <a href="#"
                               data-bs-toggle="modal"
                               data-bs-target="#modal-donacion"
                               class="bg-forest hover:text-white hover:no-underline text-white px-6 py-1 rounded-2xl font-medium font-serif hover:bg-forest/700 transition duration-300 text-lg">
                                Donar ahora
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-8 max-w-3xl mx-auto">
            <iframe 
                src="https://www.youtube.com/embed/JDKmCBBGSDk?si=N42OPJ8ryLmwlgdy" 
                title="Oficios que hacen al barrio" 
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
                    ¡Ayúdanos a lograrlo!
                    </p>
                    <p class="text-justify text-gray font-sans">
                    Nuestra meta es reunir $100,000 MXN tenemos del 1 de octubre al 10 de diciembre de 2026.
                   </p>
                    <p class="text-justify text-gray font-sans">
                    Tu aportación hace posible que alguien enseñe lo que sabe, que alguien más pueda aprenderlo y que estos saberes sigan circulando para seguir haciendo al barrio.
                    </p>
                    <p class="text-justify text-gray font-sans">
                    Tu aportación hace posible que alguien enseñe lo que sabe, que alguien más pueda aprenderlo y que estos saberes sigan circulando para seguir haciendo al barrio.
                    </p>
                    <p class="text-justify text-gray font-sans">
                    Dona. Comparte. Participa.<br>
                    Oficios que hacen al barrio.<br>
                    Saberes que hacen comunidad.
                    </p>
                </div>

                <!-- Image Section
                <div class="flex justify-center">
                    <img src="https://casagallina.org.mx/assets/images/campana/museo.jpg" alt="Museo" class="w-full max-w-3xl rounded-lg shadow-md">
                </div> -->

                <!-- Funding Allocation 
                <div class="space-y-4">
                    <p class="text-gray font-sans">
                        Todo lo recaudado se destinará a financiar los programas de Casa Gallina, asegurando que nuestras actividades continúen generando un impacto significativo en la comunidad. Los fondos se utilizarán específicamente en:
                    </p>
                    <ul class="list-disc list-inside text-gray font-sans space-y-2">
                        <li><strong>Espacio comunitario</strong> </li>
                        <li><strong>Proyectos artísticos</strong></li>
                        <li><strong>Exposiciones</strong></li>
                        <li><strong>Publicaciones</strong></li>
                        <li><strong>Programa educativo</strong></li>
                    </ul>
                </div>-->

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
                <!-- Montos Section -->
                <div class="space-y-6">

                <!-- Montos Image -->
                    <div class="flex justify-center">
                        <img src="{{ asset('assets/images/donaciones/montos-oficios.png') }}" alt="Montos" class="w-full max-w-4xl rounded-lg shadow-md my-4">
                    </div>

                <!-- Recognition Section -->
                <div class="space-y-6">

                    <div class="w-full border-b-2 border-forest flex justify-center mb-10">
                        <h3 class="text-2xl text-center bg-forest font-regular text-black font-serif mb-0 py-1 px-4">
                        Los montos son aportaciones sugeridas que contribuyen a cubrir los costos de producción y realización de las actividades.
                        </h3>
                    </div>

                    <!-- Recognition Image -->
                    <div class="flex justify-center">
                        <img src="{{ asset('assets/images/donaciones/beneficios-oficios.png') }}" alt="Reconocimientos" class="w-full max-w-4xl rounded-lg shadow-md my-4">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Recognition Card 
                        @php
                            $recognitions = [
                                [
                                    'amount' => '$300.00',
                                    'description' => 'Amig@: Ayudas a que un saber circule'
                                ],
                                [
                                    'amount' => '$500.00',
                                    'description' => 'Colaborador: Haces posible una sesión de cine de Oficios facilitada por un vecino'
                                ],
                                [
                                    'amount' => '$1,000.00',
                                    'description' => 'Benefactor: Haces posible que un vecino participe en un taller de oficios con materiales incluidos'
                                ],
                                [
                                    'amount' => '$2,000.00',
                                    'description' => 'Promotor: Materiales para 15 personas para un taller de oficios'
                                ],
                                [
                                    'amount' => '$3,000.00',
                                    'description' => 'Institucuines-Mentor: Haces posible que 5 niños y niñas del barrio participen en el curso de verano, guiado por maestros de oficios'
                                ],
                                [
                                    'amount' => '$5,000.00',
                                    'description' => 'Empresas - Mecenas: Una semana de curso de verano de oficios para 15 niñ@s en Casa Gallina'
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
                        @endforeach-->
                    </div>
                </div>



                <!-- Delivery Information -->
                <div class="space-y-4">
                    
                
                    <p class="text-gray font-sans">
                    Los reconocimientos digitales te llegarán en un lapso de 7 días hábiles después de haber realizado tu donativo.<br>
Los reconocimientos físicos serán entregados en la Kermés de Casa Gallina el 5 de diciembre de 2026.

                    </p>
                </div>
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
                                Desarrollo y <br> alianzas estratégicas
                                </p>
                                <a href="mailto:malinalli@casagallina.org.mx"
                                   class="text-forest hover:text-forest/90 underline mb-0">
                                    quetzalli@casagallina.org.mx
                                </a>
                            </div>
                        </div>
            
            </div>
        </section>
    </div>
@endsection

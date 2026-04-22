@extends('layouts.boilerplate')

@section('title', ' - Donaciones Campaign')

@section('meta')
    <meta name="description" content="Apoya a Casa Gallina para continuar con su trabajo de preservación de la cultura y medio ambiente.">
    <meta name="keywords" content="donaciones, Casa Gallina, campaña, fundación, cultura, medio ambiente, arte, educación, comunidad">
    <meta name="author" content="Casa Gallina">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Campaña de Fondeo Colectivo de Casa Gallina. 10 años de trabajo comunitario.">
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
                <img src="{{ asset('assets/images/donaciones/campaign-banner.jpg') }}" class="mx-auto w-4/5 max-w-4xl rounded-lg shadow-lg" alt="Banner de la campaña de donaciones">
            </div>
        </section>

        <!-- Header Section -->
        <section class="text-center pt-6">
            <h1 class="text-5xl text-forest font-serif mb-2">
                Casa Gallina <span class="font-semibold block py-2 pt-3">10 años de trabajo comunitario</span>
            </h1>
            <h2 class="text-3xl md:text-4xl text-gray font-serif">Campaña de fondeo colectivo</h2>
        </section>

        <!-- Introduction Section -->
        <section class="py-8 mt-4">
            <div class="max-w-3xl mx-auto">
                <div class="space-y-6">
                    <p class="text-lg md:text-xl text-forest font-serif text-center">
                        Este año celebramos 10 años de Casa Gallina, una década en la que hemos construido una comunidad sólida en Santa María la Ribera y otros territorios, promoviendo la preservación del medio ambiente y la expresión cultural local.
                    </p>
                    <p class="text-lg md:text-xl text-gray font-serif text-center">
                        A lo largo de este tiempo, hemos impulsado el aprendizaje colaborativo y las conexiones entre vecinos, artistas, educadores y científicos, fortaleciendo también el vínculo con la naturaleza y las culturas indígenas de México.
                    </p>
                </div>
            </div>

            <div class="max-w-2xl mx-auto">
                <div class="bg-gray-200 rounded-3xl px-4 py-4 mt-12">
                    <h3 class="text-2xl text-center font-serif text-forest mb-6">
                        Campaña abierta hasta el 13 de diciembre
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col text-center">
                            <h4 class="text-gray-500 text-xl mb-0">
                                Total Recaudado
                            </h4>
                            <span class="text-gray-600 text-2xl font-medium">
                                $124,305 pesos
                            </span>
                        </div>
                        <div class="flex flex-col text-center">
                            <h4 class="text-gray-500 text-xl mb-0">
                                Meta
                            </h4>
                            <span class="text-gray-600 text-2xl font-medium">
                                $95,000 pesos
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 mb-2">
                    <div class="flex flex-col text-center">
                            <h4 class="text-gray-500 text-xl mb-0">
                                Porcentaje:
                            </h4>
                            <span class="text-gray-600 text-2xl font-medium">
                              130.8 % <br><br>
                            </span>
                        </div>

                        <h4 class="text-gray-500 text-xl mb-2 text-center">
                            Donadores
                        </h4>
                        <div class="flex flex-wrap justify-center gap-4 text-gray-600 font-medium text-xl leading-4">
                            <span>Luis Gómez</span>
                            <span>Lorena Durán</span>
                            <span>Laura Ferreiro</span>
                            <span>Christiane Burkhard</span>
                            <span>Fomento Universal para la Difusión Arquitectónica de México A.C.</span>
                            <span>Paulina Daniela Romero Lopez</span>
                            <span>Josefa Ortega</span>
                            <span>Consuelo Santos</span>
                            <span>Rosalía Terán</span>
                            <span>Miguel Iwadare</span>
                            <span>Martha Patricia Uresti</span>
                            <span>Tania Ximena</span>
                            <span>Adela González</span>
                            <span>Aurora Salas</span>
                            <span>Aurora Torres</span>
                            <span>Blanca Estela Castillo</span>
                            <span>Enrique Muñoz</span>
                            <span>Estela Salinas</span>
                            <span>Francisca Castrejón</span>
                            <span>Guadalupe Tapia</span>
                            <span>José Ignacio Esparza</span>
                            <span>Julieta Torres</span>
                            <span>Lilia Melo</span>
                            <span>Tere Benítez</span>
                            <span>Silvia García</span>
                            <span>Catalina Pérez</span>
                            <span>Florencia Mejía</span>
                            <span>Cecilia Pompa</span>
                            <span>Nicol Figueroa</span>
                            <span>Julieta Giménez Cacho</span>
                            <span>Isabel Pérez Cerqueda</span>
                            <span>Emilia Sandoval</span>
                            <span>Ángel Badillo</span>
                            <span>Consejo de Niñeces de Santa María la Ribera</span>
                            <span>Lucía Martínez</span>
                            <span>Maru Torres</span>
                            <span>Elsa Pérez</span>
                            <span>Lilian Varela</span>
                            <span>Francisco Xavier Muciño</span>
                            <span>Ma. Elena Ortiz</span>
                            <span>Lucelena Cortéz Alquicira</span>
                            <span>Paola Rivera Aguilera</span>
                            <span>Roxanna Erdman</span>
                            <span>Sophie Greenspan</span>
                            <span>Ana Calderón</span>
                            <span>Adriana Baranda</span>
                            <span>Rosa Morales</span>
                            <span>Emilio Fernández Allende</span>
                            <span>Rosa María Aguilera</span>
                            <span>David Hernández</span>
                            <span>Claudia Kitchenista</span>
                            <span>Paul Byrne</span>
                            <span>María González</span>
                            <span>Marialuisa Erreguerena</span>
                            <span>Flora Gómez</span>
                            <span>Adriana Rivera</span>
                            <span>Alejandra Baume</span>
                            <span>Josefa Erreguerena</span>
                            <span>Axel Solorzano</span>
                            <span>Joel Ortega </span>
                            <span>León Octavio</span>
                            <span>Patty Corona</span>
                            <span>Laura Cruz</span>
                            <span>Alfonso Santiago</span>
                            <span>Ximena Jordan</span>
                            <span>Gina Segoviano</span>
                            <span>Socorro Cortes</span>
                            <span>Sofia llesel</span>
                            <span>Mariana Vega</span>
                            <span>Silvia Melchor Uribe</span>
                            <span>Bertha Santibañez</span>
                        </div>
                        <h4 class="text-gray-500 text-xl mb-2 text-center">
                        <br><br>Donadores en especie
                        </h4>
                        <div class="flex flex-wrap justify-center gap-4 text-gray-600 font-medium text-xl leading-4">
                            <span>Claudel Estrella</span>
                            <span>Daniel Bolívar</span>
                            <span>Daniel Chepe</span>
                            <span>Dulce Chacón</span>
                            <span>Emily C-D</span>
                            <span>Enrique Sañudo</span>
                            <span>Ivan E. Segota</span>
                            <span>Jozé Daniel</span>
                            <span>Mariana Aranda</span>
                            <span>Mariana Roldán</span>
                            <span>Mariano Arribas</span>
                            <span>Maricarmen Zapatero</span>
                            <span>Melissa Paredes</span>
                            <span>Miauuris (Laura Hernández Cortés)</span>
                            <span>Rodrigo Simancas</span>
                            <span>Santiago Solis</span>
                            <span>Sofia Echeverri</span>
                            <span>Vero Anaya</span>
                            <span>Consejo de niñeces de Santa María la Ribera</span>
                            <span>Guadalupe Tapia</span>
                            <span>José Ignacio Esparza</span>
                            <span>Julieta Torres</span>
                            <span>Lilia Melo</span>
                            <span>Tere Benítez</span>
                            <span>Silvia García</span>
                            <span>Catalina Pérez</span>
                            <span>Florencia Mejía</span>
                            <span>Cecilia Pompa</span>
                            <span>Nicol Figueroa</span>
                            <span>Julieta Giménez Cacho</span>
                            <span>Isabel Pérez Cerqueda</span>
                            <span>Emilia Sandoval</span>
                            <span>Ángel Badillo</span>
                            <span>Consejo de Niñeces de Santa María la Ribera</span>
                            <span>Comunidad de adultas mayores de Casa Gallina</span>
                            <span>Pausita Café</span>
                            <span>Glaciar: libros y helados</span>
                            <span>Maíz de cacao</span>
                            <span>Anteojería metropolitana</span>
                            <span>Peluquería Miguel</span>
                            <span>Zirandas Gourmet</span>
                            <span>Rancho agroecológico "El Arco"</span>
                            <span>Granja "La Bolchevitta"</span>
                            <span>Cooperativa Oyameyo</span>
                            <span>Azul Verde</span>
                            <span>Bertha Santibañez</span>
                            <span>Lina Marea Cortes Rojas</span>
                            <span>Lucia Martinez</span>
                            <span>Guadalupe Tapia Suárez</span>
                            <span>Teresita Benitez Romero</span>
                            <span>Cinthia Roens</span>
                            <span>Consuelo Santos</span>
                            <span>María De Los Ángeles Salinas</span>
                            <span>Rosa Isela Pérez</span>
                            <span>Jessica Carolina Pérez</span>
                            <span>Aaron Velazquez y Jessarela Miranda</span>
                            <span>Edaena Mata Zayas</span>
                            <span>Angélica López Cisneros</span>
                            <span>Yosdi Martínez</span>
                        </div>
                        </div>
                    </div>

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
                src="https://www.youtube.com/embed/QkoECsdoVyU?si=snAct_3YQD8gZDgB&amp;controls=0&amp;start=1"
                title="Casa Gallina - 10 años de trabajo comunitario"
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
                        Nuestros proyectos han dado vida a exposiciones, publicaciones y eventos que preservan las tradiciones, lenguas e historias de las comunidades urbanas y rurales, siempre en colaboración con quienes habitan estos territorios. Trabajamos de la mano con organizaciones y agentes locales, tanto de Santa María la Ribera como de otras regiones, para crear experiencias que abordan los desafíos específicos de cada contexto, fortaleciendo la memoria cultural y la resiliencia comunitaria.
                    </p>
                    <p class="text-justify text-gray font-sans">
                        El objetivo de esta campaña es invitarte a apoyar la continuidad de este proyecto, que ha impactado tantas vidas. Con tu apoyo, podremos seguir llevando a cabo nuestro trabajo y generar nuevas oportunidades para Santa María la Ribera y otros territorios.
                    </p>
                    <p class="text-justify text-gray font-sans">
                        Te invitamos a ser parte de Casa Gallina y contribuir a que su misión siga avanzando. Tu aporte nos ayudará a seguir nutriendo estas relaciones, construyendo experiencias transformadoras y preservando la riqueza cultural de nuestras comunidades. ¡Juntos, podemos marcar la diferencia y seguir tejiendo una red de aprendizaje y cuidado colectivo que perdure por muchos años más!
                    </p>
                </div>

                <!-- Image Section -->
                <div class="flex justify-center">
                    <img src="https://casagallina.org.mx/assets/images/campana/museo.jpg" alt="Museo" class="w-full max-w-3xl rounded-lg shadow-md">
                </div>

                <!-- Funding Allocation -->
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
                                    
                                <a href="mailto:malinalli@casagallina.org.mx"
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

                    <!-- Recognition Image -->
                    <div class="flex justify-center">
                        <img src="https://casagallina.org.mx/assets/images/campana/reconocimientos.jpg" alt="Reconocimientos" class="w-full max-w-4xl rounded-lg shadow-md my-4">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Recognition Card -->
                        @php
                            $recognitions = [
                                [
                                    'amount' => '$100.00',
                                    'description' => '¡Te agradecemos profundamente! Tu contribución está marcando una gran diferencia. Como agradecimiento te haremos llegar un paquete de stickers conmemorativos para WhatsApp + mención especial en nuestra página web.'
                                ],
                                [
                                    'amount' => '$500.00',
                                    'description' => '¡Tu generosidad es altamente valorada! Tu donación está teniendo un impacto significativo. En agradecimiento te haremos llegar un recetario digital de remedios caseros + stickers conmemorativos para WhatsApp + mención especial en nuestra página web.'
                                ],
                                [
                                    'amount' => '$1,000.00',
                                    'description' => '¡Muchísimas gracias! Tu aportación está haciendo una gran diferencia. Como agradecimiento recibirás una lotería digital de Casa Gallina + un ejemplar de la publicación <em>Alientos</em> + un recetario digital de remedios caseros + stickers conmemorativos para WhatsApp + mención especial en nuestra página web.'
                                ],
                                [
                                    'amount' => '$3,000.00',
                                    'description' => '¡Wow! No sabemos cómo agradecer tu ayuda pero vamos a intentarlo con un gesto en el que recibirás cuatro recetarios impresos de talleres de cocina de Casa Gallina + una tisana artesanal + un póster conmemorativo de Casa Gallina + un ejemplar de la publicación <em>Alientos</em> + un recetario digital de remedios caseros + stickers conmemorativos para WhatsApp + mención especial en nuestra página web.'
                                ],
                                [
                                    'amount' => '$5,000.00',
                                    'description' => '¡Wow! No sabemos cómo agradecer tu ayuda pero vamos a intentarlo con un gesto en el que recibirás una piñata hecha por la comunidad de infancias de Casa Gallina + cuatro recetarios impresos de talleres de cocina de Casa Gallina + una tisana artesanal + un póster de Casa Gallina + un ejemplar de las publicaciones <em>Alientos, Trazar lo común y El sentido del jardín</em> + un recetario digital de remedios caseros + stickers conmemorativos para WhatsApp + mención especial en nuestra página web.'
                                ],
                                [
                                    'amount' => '$8,000.00',
                                    'description' => '¡Millones de gracias! Tu generosidad significa mucho para Casa Gallina, por eso te invitaremos a la cena especial de donadores de Casa Gallina y te haremos llegar una piñata hecha por la comunidad de infancias de Casa Gallina + cuatro recetarios impresos de talleres de cocina de Casa Gallina + una tisana artesanal + un póster de Casa Gallina + un ejemplar de las publicaciones <em>Alientos, Trazar lo común y El sentido del jardín</em> + un recetario digital de remedios caseros + stickers conmemorativos para WhatsApp + mención especial en nuestra página web.'
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
                        Los reconocimientos digitales te llegarán en un lapso de 7 días hábiles después de haber realizado tu donativo.
                    </p>
                    <p class="text-gray font-sans">
                        Los reconocimientos físicos serán entregados en Casa Gallina a más tardar a finales de enero de 2025.
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
                                    Mariana Malinalli
                                </h6>
                                <p class="text-gray mb-0 text-lg leading-5 text-gray-600">
                                    Vinculación comunitaria y <br> alianzas estratégicas
                                </p>
                                <a href="mailto:malinalli@casagallina.org.mx"
                                   class="text-forest hover:text-forest/90 underline mb-0">
                                    malinalli@casagallina.org.mx
                                </a>
                            </div>
                        </div>
            
            </div>
        </section>
    </div>
@endsection

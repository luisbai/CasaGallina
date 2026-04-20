@extends('layouts.english.boilerplate')

@section('title', ' - Donations Campaign')

@section('meta')
    <meta name="description" content="Support Casa Gallina to continue its work in preserving culture and the environment.">
    <meta name="keywords" content="donations, Casa Gallina, campaign, foundation, culture, environment, art, education, community">
    <meta name="author" content="Casa Gallina">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Casa Gallina Crowdfunding Campaign. 10 years of community work.">
    <meta property="og:description" content="Support Casa Gallina to continue its work in preserving culture and the environment.">
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
                <img src="{{ asset('assets/images/donaciones/campaign-banner.jpg') }}" class="mx-auto w-4/5 max-w-4xl rounded-lg shadow-lg" alt="Donations campaign banner">
            </div>
        </section>

        <!-- Header Section -->
        <section class="text-center pt-6">
            <h1 class="text-5xl text-forest font-serif mb-2">
                Casa Gallina <span class="font-semibold block py-2 pt-3">10 Years of Community Work</span>
            </h1>
            <h2 class="text-3xl md:text-4xl text-gray font-serif">Crowdfunding Campaign</h2>
        </section>

        <!-- Introduction Section -->
        <section class="py-8 mt-4">
            <div class="max-w-3xl mx-auto">
                <div class="space-y-6">
                    <p class="text-lg md:text-xl text-gray font-serif text-center">
                    This year we celebrate 10 years of Casa Gallina, a decade of community work in Santa María la Ribera and other territories, where we have promoted environmental preservation and local culture. 
                    </p>
                    <p class="text-lg md:text-xl text-forest font-serif text-center">
                    Throughout this time, we have promoted collaborative learning and connections between neighbors, artists, teachers and scientists, also strengthening the link with nature and indigenous cultures of Mexico.
                    </p>
                </div>
            </div>

            <div class="max-w-2xl mx-auto">
                <div class="bg-gray-200 rounded-3xl px-4 py-4 mt-12">
                    <h3 class="text-2xl text-center font-serif text-forest mb-6">
                        Campaign open until December 13th
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col text-center">
                            <h4 class="text-gray-500 text-xl mb-0">
                            Collected funds: 
                            </h4>
                            <span class="text-gray-600 text-2xl font-medium">
                            $124,305 pesos
                            </span>
                        </div>
                        <div class="flex flex-col text-center">
                        
                            <h4 class="text-gray-500 text-xl mb-0">
                            The goal is 
                            </h4>
                            <span class="text-gray-600 text-2xl font-medium">
                                $95,000 pesos
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 mb-2">
                    <div class="flex flex-col text-center">
                            <h4 class="text-gray-500 text-xl mb-0">
                            Percentage:
                            </h4>
                            <span class="text-gray-600 text-2xl font-medium">
                            130.8 %  <br><br>
                            </span>
                        </div>
                        <h4 class="text-gray-500 text-xl mb-2 text-center">
                            Donors
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
                            <span>Emilio Fernandez Allende</span>
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
                            <span>Axel Solórzano</span>
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
                        <br><br>In-kind Donations
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

                    <div class="mt-8">
                        <div class="flex justify-center">
                            <a href="#"
                               data-bs-toggle="modal"
                               data-bs-target="#modal-donacion"
                               class="bg-forest hover:text-white hover:no-underline text-white px-6 py-1 rounded-2xl font-medium font-serif hover:bg-forest/700 transition duration-300 text-lg">
                                Donate Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-8 max-w-3xl mx-auto">
            <iframe
                src="https://www.youtube.com/embed/4zaUb1-2gGc?si=lwAIo6VNfG9M9se5&amp;controls=0&amp;start=2"
                title="Casa Gallina - 10 years of community work"
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
                    Our projects have given life to exhibitions, publications and events that preserve the traditions, languages and histories of urban and rural communities, always in collaboration with those who inhabit these territories. We work hand in hand with local organizations and agents, in Santa María la Ribera as well as in other regions, to create experiences that address the specific challenges of each context, strengthening cultural memory and community resilience.
                    </p>
                    <p class="text-justify text-gray font-sans">
                    The goal of this campaign is to invite you to support the continuity of this project, which has impacted so many lives. With your support, we will be able to continue carrying out our work and create new opportunities for Santa María la Ribera and other territories.
                    </p>
                    <p class="text-justify text-gray font-sans">
                    We invite you to be part of Casa Gallina and contribute so its mission can continue moving forward. Your contribution will help us continue to strengthen these relationships, build transformative experiences, and preserve the cultural richness of our communities. Together, we can make a difference and continue to weave a network of collective learning and care that lasts for many years to come!
                    </p>
                </div>

                <!-- Image Section -->
                <div class="flex justify-center">
                    <img src="https://casagallina.org.mx/assets/images/campana/museo.jpg" alt="Museum" class="w-full max-w-3xl rounded-lg shadow-md">
                </div>

                <!-- Funding Allocation -->
                <div class="space-y-4">
                    <p class="text-gray font-sans">
                    All collected funds will go towards financing Casa Gallina's programs, ensuring that our activities continue to make a significant impact on the community. The funds will be used specifically for:
                    </p>
                    <ul class="list-disc list-inside text-gray font-sans space-y-2">
                        <li><strong>Community Space</strong></li>
                        <li><strong>Artistic Projects:</strong></li>
                        <li><strong>Exhibitions</strong></li>
                        <li><strong>Publications</strong></li>
                        <li><strong>Educational Program</strong></li>
                    </ul>
                </div>

                <!-- Donation Section -->
                <div class="space-y-6">
                    <div class="w-full border-b-2 border-forest flex justify-center mb-10">
                        <h3 class="text-2xl text-center bg-forest font-regular text-white font-serif mb-0 py-1 px-4">
                            How can I donate?
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col justify-between bg-forest p-4 rounded-3xl shadow-sm">
                            <h4 class="font-medium text-2xl text-white font-serif w-2/3 mr-auto">Donate through our website</h4>

                            <div class="mb-2 self-end">
                                <a href="#"
                                   data-bs-toggle="modal"
                                   data-bs-target="#modal-donacion"
                                   class="bg-white hover:text-gray hover:no-underline text-forest px-6 py-3 rounded-2xl font-medium font-serif hover:bg-forest-700 transition duration-300 text-xl">
                                    Donate
                                </a>
                            </div>
                        </div>

                        <div class="flex flex-col gap-6 justify-between bg-gray-100 p-4 rounded-3xl shadow-sm">
                            <div>

                                <h4 class="font-medium text-2xl text-gray font-serif w-2/3 mr-auto mb-0">In-person donation</h4>
                                <h5 class="text-forest font-medium mb-0 font-serif text-lg">
                                    Contact details
                                </h5>
                            </div>

                            <div class="mb-0 text-right font-serif">
                                <h6 class="mb-0 text-xl font-sans text-forest font-semibold">
                                    Mariana Malinalli
                                </h6>
                                <p class="text-gray mb-0 text-lg leading-5 text-gray-600">
                                    Community engagement and <br> strategic alliances
                                </p>
                                <a href="mailto:malinalli@casagallina.org.mx"
                                   class="text-forest hover:text-forest/90 underline mb-0">
                                    malinalli@casagallina.org.mx
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Recognition Section -->
                <div class="space-y-6">

                    <div class="w-full border-b-2 border-forest flex justify-center mb-10">
                        <h3 class="text-2xl text-center bg-forest font-regular text-white font-serif mb-0 py-1 px-4">
                        Rewards 
                        </h3>
                    </div>

                    <!-- Recognition Image -->
                    <div class="flex justify-center">
                        <img src="https://casagallina.org.mx/assets/images/campana/reconocimientos.jpg" alt="Recognitions" class="w-full max-w-4xl rounded-lg shadow-md my-4">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Recognition Card -->
                        @php
                            $recognitions = [
                                [
                                    'amount' => '$100.00',
                                    'description' => 'We deeply appreciate your support! Your contribution is making a big difference. As a token of our gratitude, we will send you a commemorative sticker pack for WhatsApp + a special mention on our website.'
                                ],
                                [
                                    'amount' => '$500.00',
                                    'description' => 'Your generosity is highly valued! Your donation is making a significant impact. As a thank you, we will send you a digital cookbook of home remedies + commemorative stickers for WhatsApp + a special mention on our website.'
                                ],
                                [
                                    'amount' => '$1,000.00',
                                    'description' => 'Thank you so much! Your contribution is making a big difference. As a thank you, you will receive a digital Casa Gallina lottery game + a copy of the publication <em>Alientos</em> + a digital cookbook of home remedies + commemorative stickers for WhatsApp + a special mention on our website.'
                                ],
                                [
                                    'amount' => '$3,000.00',
                                    'description' => 'Wow! We don’t know how to thank you, but we’ll try with a gesture where you will receive four printed cookbooks from Casa Gallina\'s kitchen workshops + an artisanal herbal tea + a commemorative Casa Gallina poster + a copy of the publication <em>Alientos</em> + a digital cookbook of home remedies + commemorative stickers for WhatsApp + a special mention on our website.'
                                ],
                                [
                                    'amount' => '$5,000.00',
                                    'description' => 'Wow! We don’t know how to thank you, but we’ll try with a gesture where you will receive a piñata made by Casa Gallina\'s children community + four printed cookbooks from Casa Gallina\'s kitchen workshops + an artisanal herbal tea + a Casa Gallina poster + a copy of the publications <em>Alientos, Trazar lo común, and El sentido del jardín</em> + a digital cookbook of home remedies + commemorative stickers for WhatsApp + a special mention on our website.'
                                ],
                                [
                                    'amount' => '$8,000.00',
                                    'description' => 'Millions of thanks! Your generosity means a lot to Casa Gallina, so we invite you to the special Casa Gallina donor dinner and will send you a piñata made by the children community of Casa Gallina + four printed cookbooks from Casa Gallina\'s kitchen workshops + an artisanal herbal tea + a Casa Gallina poster + a copy of the publications <em>Alientos, Trazar lo común, and El sentido del jardín</em> + a digital cookbook of home remedies + commemorative stickers for WhatsApp + a special mention on our website.'
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
                        How and when will the rewards be delivered?
                        </h3>
                    </div>
                    <p class="text-gray font-sans">
                    Digital rewards will arrive within 7 business days of your donation. 
                    </p>
                    <p class="text-gray font-sans">
                    Physical rewards will be delivered at Casa Gallina no later than the end of March 2025. 
                    </p>
                </div>
            </div>
        </section>
    </div>
@endsection

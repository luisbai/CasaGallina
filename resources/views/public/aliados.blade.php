@extends('layouts.boilerplate')

@section('content')
<div class="aliados-index">

    <div class="w-full h-[35vh] relative">
        <img src="{{ asset('assets/images/home/aliados/banner.jpg') }}" alt="Aliados Casa Gallina" class="w-full h-full object-cover">
    </div>

    <!-- Intro Section -->
    <section class="pt-8">
        <div class="container mx-auto">

            <!-- Two Column Layout -->
            <div class="flex flex-col py-8">

                <!-- Right Column - Content -->
                <div class="">
                    <!-- Section Title -->
                    <div class="text-center border-b-2 border-green-600 pb-2 mb-2">
                        <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Aliados</span>
                    </div>
                    <!-- Intro Text -->
                    <div class="font-serif text-green-600 text-xl leading-6 py-4 md:px-16 pb-2 text-center">
                        Casa Gallina trabaja en construir y fortalecer redes de alianzas con colectivos, individuos, asociaciones civiles e instituciones públicas y privadas con los que existen intereses compartidos. En diversos formatos y marcos de colaboración se construyen procesos de colaboración que tejen redes para compartir recursos, estrategias y metodologías.
                    </div>

                    <!-- Intro Description -->
                    <div class="font-libre text-gray-600 leading-5 py-2 md:px-16 tracking-wide space-y-2">
                        <p>Las distintas alianzas se construyen para activar procesos y acciones en torno a narrativas críticas con el fin de activar experiencias colectivas sobre ecología, resiliencia, articulación comunitaria y creatividad en la vida cotidiana.</p>

                        <p>La red de colaboración se construye a través de la implementación de las estrategias y programas de Casa Gallina que constantemente cuentan con aliados de muy diversa índole. Esta red se profundiza a través de la creación de nuevos programas y formatos de trabajo en coparticipación con los agentes y organizaciones con las que se colabora. En búsqueda de expansión constante la red está abierta para integrar constantemente nuevas organizaciones, colectivos e instituciones que compartan los intereses por crear proyectos a favor del bien común, la cultura, la comunidad y el medio ambiente.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Form Section -->
    <section class="py-8">
        <div class="container mx-auto">
            <div class="flex flex-col py-8">

                <!-- Section Title -->
                <div class="text-center border-b-2 border-green-600 pb-2 mb-2">
                    <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">¿Te interesa colaborar con nosotros?</span>
                </div>
                <!-- Form Intro Text -->
                <div class="font-serif text-green-600 text-xl leading-6 py-4 md:px-16 pb-2 text-center">
                    Cuéntanos sobre tu organización y cómo te gustaría trabajar juntos para crear proyectos a favor del bien común, la cultura, la comunidad y el medio ambiente.
                </div>

                <!-- Form Container -->
                <div class="md:px-16">
                    @livewire('forms.aliados-form')
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
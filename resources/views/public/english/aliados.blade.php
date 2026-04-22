@extends('layouts.english.boilerplate')

@section('content')
<div class="aliados-index">

    <div class="w-full h-[35vh] relative">
        <img src="{{ asset('assets/images/home/aliados/banner.jpg') }}" alt="Allies Casa Gallina" class="w-full h-full object-cover">
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
                        <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Allies</span>
                    </div>
                    <!-- Intro Text -->
                    <div class="font-serif text-green-600 text-xl leading-6 py-4 md:px-16 pb-2 text-center">
                        Casa Gallina strives to build and strengthen networks of alliances with collectives, individuals, civil society organizations and public or private institutions with whom we share common interests. Collaborative processes are built in different formats and frameworks, which weave networks to share resources, strategies and methodologies.
                    </div>

                    <!-- Intro Description -->
                    <div class="font-libre text-gray-600 leading-5 py-2 md:px-16 tracking-wide space-y-2">
                        <p>These different alliances aim to enable processes and actions related to critical narratives, so as to trigger collective experiences on ecology, resilience, community liaisons and creativity in daily life.</p>

                        <p>This network is deepened through the creation of new programs and work formats in co-participation with the agents and organizations with which it collaborates. In search of constant expansion, the network is open to constantly integrate new organizations, groups and institutions that share the interests of creating projects in favor of the common good, culture, community and the environment.</p>
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
                    <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Interested in collaborating with us?</span>
                </div>
                <!-- Form Intro Text -->
                <div class="font-serif text-green-600 text-xl leading-6 py-4 md:px-16 pb-2 text-center">
                    Tell us about your organization and how you would like to work together to create projects in favor of the common good, culture, community and the environment.
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
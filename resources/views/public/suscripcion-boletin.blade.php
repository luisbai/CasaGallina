@extends('layouts.boilerplate')

@section('content')
<div class="suscribete-index">

    <!-- Banner -->
    <div class="w-full h-[35vh] relative">
        <img src="{{ asset('assets/images/home/aliados/banner.jpg') }}" alt="Suscríbete al Boletín" class="w-full h-full object-cover">
    </div>



    <!-- Form Section -->
    <section class="py-8">
        <div class="container mx-auto">
            <div class="flex flex-col max-w-xl mx-auto px-4">
                <div class="text-center border-b-2 border-green-600 pb-2 mb-4">
                    <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Suscríbete al boletín</span>
                </div>

                <!-- Aquí se llama al componente de Livewire -->
                <div class="w-full pt-4">
                    @livewire('forms.newsletter-form')
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

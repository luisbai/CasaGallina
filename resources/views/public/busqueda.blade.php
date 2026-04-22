@extends('layouts.boilerplate')

@section('meta')
    <!-- add alpinejs -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection

@section('content')
    <div class="busqueda-page">

        <!-- Banner -->
        <div class="w-full h-56 relative">
            <img src="{{ asset('assets/images/casa/banner.jpg') }}" alt="Búsqueda Casa Gallina" class="w-full h-full object-cover">
        </div>

        <!-- Search Section -->
        <section class="pt-8">
            <div class="container mx-auto">
                <div class="flex flex-col py-8">
                    <!-- Section Title -->
                    <div class="text-center border-b-2 border-green-600 pb-2 mb-6">
                        <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Resultados de búsqueda</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Search Results Component -->
        <livewire:public.search-page :query="$query" language="es" />

    </div>
@endsection
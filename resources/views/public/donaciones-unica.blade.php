@extends('layouts.boilerplate')

@section('content')
    <div id="donaciones-index">
        <section id="donaciones-banner">
            <div class="position-relative">
                <img src="/assets/images/donaciones/banner-thin.jpg" class="img-fluid">

                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="donaciones-title">
                                <h1>Tu apoyo directo a Casa Gallina</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="donaciones-iconos">
            <div class="container">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-4">
                    <div class="p-4 bg-forest-100 rounded h-full flex flex-col">
                        <h2 class="!text-xl font-libre !font-semibold text-forest-600 mb-2">Donación única</h2>
                        <p class="!text-base !text-gray-700 flex-grow">Llena un sencillo formulario y paga directamente con tu tarjeta de débito o crédito. Tu donación es fácil y segura gracias a Stripe.</p>
                    </div>
                    <div class="p-4 bg-forest-100 rounded h-full flex flex-col">
                        <h3 class="!text-xl font-libre !font-semibold text-forest-600 mb-2">Recompensas</h3>
                        <ul class="!text-base !text-gray-700 space-y-2 flex-grow">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-forest-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Boletín cuatrimestral digital</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-forest-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Mención en la página web</span>
                            </li>
                        </ul>
                    </div>
                    <div class="p-4 bg-forest-100 rounded h-full flex flex-col">
                        <h4 class="!text-xl font-libre !font-semibold text-forest-600 mb-2">¿Por qué donar?</h4>
                        <p class="!text-base !text-gray-700 mb-0 flex-grow">Las donaciones únicas nos permiten responder rápidamente a necesidades específicas de nuestros programas y financiar proyectos especiales que requieren apoyo inmediato.</p>
                    </div>
                </div>

                <!-- Additional information section -->
                <div class="text-center pb-5">
                    <div class="bg-forest-200 rounded p-6 mb-4">
                        <p class="text-forest-900 mb-0 ">Todas las donaciones a partir de MXN $50,000.00 reciben: acceso a una experiencia anual y un calendario anual</p>
                    </div>
                    <p class="text-gray-700 !text-sm">Si tienes dudas o te gustaría conocer más información contáctanos al correo <a href="mailto:dona@casagallina.org.mx" class="!text-forest-600 hover:text-forest-700">dona@casagallina.org.mx</a> o habla al <a href="tel:+525526302601" class="!text-forest-600 hover:text-forest-700">5526302601</a> y con gusto te atenderemos.</p>
                </div>
            </div>
        </section>

        <!-- Donation Form Section -->
        <section class="py-20 bg-green-800">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                        <!-- Left side - Image -->
                        <div class="flex flex-col rounded-xl overflow-hidden donation-section">
                            <div class="relative h-[450px] bg-green-600 overflow-hidden">
                                <img src="{{ asset('assets/images/donaciones/modal-bg4.jpg') }}"
                                     alt="Donación única"
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="donation-content p-6 bg-white">
                                <h3 class="text-xl font-bold text-green-600 mb-3">Tu donación única marca la diferencia</h3>
                                <p class="text-gray-700">Cada donación única nos ayuda a mantener nuestros programas activos y a responder a las necesidades emergentes de nuestra comunidad.</p>
                            </div>
                        </div>

                        <!-- Right side - Donation Form -->
                        <livewire:components.donation-form :donationType="'unica'" />
                    </div>
                </div>
            </div>
        </section>

        <x-donation-info-gallery />
    </div>

    <!-- Thank You Modal -->
    <div class="modal fade" id="modal-gracias-donacion" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="donacion-imagen">
                                <img src="{{ asset('assets/images/donaciones/modal-bg4.jpg') }}" alt="¡Muchas gracias!">
                            </div>

                            <div class="donacion-text-wrapper">
                                <h3>¡Muchas gracias!</h3>

                                <p>Tu <strong>donación única</strong> <span>ayudará</span> a seguir creando un <span>cambio social</span> a través de <span>procesos comunitarios y culturales</span> en favor del bien común y el medio ambiente.</p>

                                <div class="text-right mt-12">
                                    <a href="{{ route('donaciones') }}"
                                       class="px-4 py-2 rounded-xl bg-forest text-white mt-4 hover:no-underline hover:bg-green-800/90 transition">
                                        Más información
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="donacion-content">
                                <h3>Casa Gallina: 10 años de trabajo comunitario</h3>

                                <div class="default-content">
                                    <p>Tu donación única nos permite responder rápidamente a necesidades específicas de nuestros programas y financiar proyectos especiales que requieren apoyo inmediato.</p>
                                    <p>Gracias por apoyar nuestro trabajo comunitario. Tu contribución nos ayuda a seguir construyendo espacios de transformación social y cultural.</p>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(request()->has('gracias'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Show thank you modal if payment was successful
                const modal = new bootstrap.Modal(document.getElementById('modal-gracias-donacion'));
                modal.show();

                // Clean up URL after showing modal
                const url = new URL(window.location);
                url.searchParams.delete('gracias');
                url.searchParams.delete('donation_id');
                window.history.replaceState({}, document.title, url.pathname);
            });
        </script>
    @endif
@endsection
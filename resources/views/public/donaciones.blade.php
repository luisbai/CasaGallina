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
                                <h1>Tu donativo hace posible los programas de Casa Gallina</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="donaciones-iconos">
            <div class="container">
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-5 col-md-6">
                        <div class="donaciones-icon">
                            <div class="icon-container">
                                <img src="/assets/images/donaciones/icon-donacion-unica.png" alt="Donación Única">
                            </div>

                            <h2>Donación <br> única</h2>

                            <p>Llena un sencillo formulario y paga directamente con tu tarjeta de débito o crédito. Tu donación es fácil y segura gracias a Stripe.</p>

                            <div class="btn-container">
                                <a href="{{ route('donaciones.unica') }}" class="btn-donar">Donar</a>
                            </div>

                            <h3>Recompensas</h3>

                            <ul>
                                <li>Boletín cuatrimestral digital</li>
                                <li>Mención en la página web</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="donaciones-icon">
                            <div class="icon-container">
                                <img src="/assets/images/donaciones/icon-donacion-mensual.png" alt="Donación Mensual">
                            </div>
                            <h2>Donación <br> mensual</h2>
                            <p>Llena un sencillo formulario y paga directamente con tu tarjeta de débito o crédito. Tu donación es fácil y segura gracias a Stripe.</p>

                            <div class="btn-container">
                                <a href="{{ route('donaciones.mensual') }}" class="btn-donar">Donar</a>
                            </div>
                            <h3>Recompensas</h3>
                            <ul>
                                <li>Calendario anual</li>
                                <li>Boletín cuatrimestral digital</li>
                                <li>Mención en la página web</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <div class="donaciones-icon">
                            <div class="icon-container">
                                <img src="/assets/images/donaciones/icon-donacion-personalizada.png" alt="Donación Personalizada">
                            </div>
                            <h2>Donación <br> personalizada</h2>
                            <p>Si prefieres hacer una transferencia o un depósito bancario, deja tus datos y con gusto te contactaremos.</p>
                            <div class="btn-container">
                                <a href="{{ route('donaciones.personalizada') }}" class="btn-donar">Contáctanos</a>
                            </div>

                            <h3>Recompensas</h3>
                            <ul>
                                <li>Boletín cuatrimestral digital</li>
                                <li>Mención en la página web</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-6">
                        <div class="donaciones-icon">
                            <div class="icon-container">
                                <img src="/assets/images/donaciones/icon-donaciones-internacionales.png" alt="Donación Fiscal USA">
                            </div>
                            <h2>Donación <br> internacional</h2>
                            <p>Haz tu donación deducible de impuestos en Estados Unidos a través de Myriad USA. Tu apoyo es fácil y seguro a través de Every.org.</p>
                            <div class="btn-container">
                                <a href="{{ route('donaciones.internacional') }}" class="btn-donar">Donar</a>
                            </div>

                            <h3>Recompensas</h3>
                            <ul>
                                <li>Boletín cuatrimestral digital</li>
                                <li>Mención en la página web</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <x-donation-info-gallery />
    </div>

    <div class="modal fade" id="modal-donacion-personalizada" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="row">
                        <div class="col-md-12">

                            <form action="/donaciones/contacto" method="POST" class="donacion-personalizada-form">
                                <div class="text-center">
                                    <h3>Gracias por tu interés.</h3>
                                    <h4>Déjanos tus datos, te contactaremos pronto.</h4>
                                </div>
                                @csrf
                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo electrónico:</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Teléfono:</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="organizacion">Organización:</label>
                                    <input type="text" name="organizacion" id="organizacion" class="form-control">
                                </div>
                                <div class="form-group text-right mt-3">
                                    <button type="submit" class="btn btn-enviar">Enviar</button>
                                </div>
                            </form>
                            <div class="formulario-gracias" style="display: none;">
                                <h3>Tus datos han sido enviados correctamente.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

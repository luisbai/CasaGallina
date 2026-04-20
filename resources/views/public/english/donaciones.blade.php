@extends('layouts.english.boilerplate')

@section('content')
    <div id="donaciones-index">
        <section id="donaciones-banner">
            <div class="position-relative">
                <img src="/assets/images/donaciones/banner-thin.jpg" class="img-fluid">

                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="donaciones-title">
                                <h1>Your donation makes Casa Gallina's programs possible</h1>
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
                                <img src="/assets/images/donaciones/icon-donacion-unica.png" alt="Unique Donation">
                            </div>

                            <h2>Unique Donation</h2>

                            <p>Fill out a simple form and pay directly with your debit or credit card. Your donation is easy and safe thanks to Stripe.</p>

                            <div class="btn-container">
                                <a href="{{ route('english.donaciones.unica') }}" class="btn-donar">Donate</a>
                            </div>

                            <h3>Rewards</h3>

                            <ul>
                                <li>Four-monthly digital newsletter</li>
                                <li>Mention on website</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="donaciones-icon">
                            <div class="icon-container">
                                <img src="/assets/images/donaciones/icon-donacion-mensual.png" alt="Monthly Donation">
                            </div>
                            <h2>Monthly donation</h2>
                            <p>Fill out a simple form and pay directly with your debit or credit card. Your donation is easy and safe thanks to Stripe.</p>
                            <div class="btn-container">
                                <a href="{{ route('english.donaciones.mensual') }}" class="btn-donar">Donate</a>
                            </div>
                            <h3>Rewards</h3>
                            <ul>
                                <li>Annual calendar</li>
                                <li>Four-monthly digital newsletter</li>
                                <li>Mention on website</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <div class="donaciones-icon">
                            <div class="icon-container">
                                <img src="/assets/images/donaciones/icon-donacion-personalizada.png" alt="Personalized Donation">
                            </div>
                            <h2>Personalized donation</h2>
                            <p>If you prefer to make a bank transfer or deposit, leave your details and we will be happy to contact you.</p>
                            <div class="btn-container">
                                <a href="{{ route('english.donaciones.personalizada') }}" class="btn-donar">Contact Us</a>
                            </div>
                            <h3>Rewards</h3>
                            <ul>
                                <li>Four-monthly digital newsletter</li>
                                <li>Mention on website</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-6">
                        <div class="donaciones-icon">
                            <div class="icon-container">
                                <img src="/assets/images/donaciones/icon-donaciones-internacionales.png" alt="Tax-deductible USA Donation">
                            </div>
                            <h2>Tax-deductible <br> USA donation</h2>
                            <p>Make your tax-deductible donation in the United States through Myriad USA. Your support is easy and secure via Every.org.</p>
                            <div class="btn-container">
                                <a href="{{ route('english.donaciones.internacional') }}" class="btn-donar">Donate</a>
                            </div>
                            <h3>Rewards</h3>
                            <ul>
                                <li>Four-monthly digital newsletter</li>
                                <li>Mention on website</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <x-english.donation-info-gallery />
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
                                    <h3>Thank you for your interest.</h3>
                                    <h4>Leave us your info and we will be in touch shortly.</h4>
                                </div>
                                @csrf
                                <div class="form-group">
                                    <label for="nombre">Name:</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Phone:</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="organizacion">Organization:</label>
                                    <input type="text" name="organizacion" id="organizacion" class="form-control">
                                </div>
                                <div class="form-group text-right mt-3">
                                    <button type="submit" class="btn btn-enviar">Send</button>
                                </div>
                            </form>
                            <div class="formulario-gracias" style="display: none;">
                                <h3>Your info has been sent correctly.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
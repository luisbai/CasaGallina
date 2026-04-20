<div class="modal fade" id="modal-donacion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="row">
                    <div class="col-lg-7">
                        <div class="donacion-imagen">
                            <img src="{{ asset('assets/images/donaciones/modal-bg4.jpg') }}"
                                alt="Contribution Campaign">
                        </div>

                        <div class="donacion-text-wrapper">
                            <h3>¡Thank you!</h3>

                            <p>Your contribution <span>will help</span> to continue creating a <span>social
                                    change</span> through <span>community and cultural processes</span> in favor of the
                                common good and the environment. </p>

                            <div class="text-right">
                                <a href="{{ route('english.donaciones.campaign') }}"
                                    class="px-4 py-2 rounded-xl bg-forest text-white mt-4 hover:no-underline hover:bg-green-800/90 transition">
                                    Read more
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <form class="donacion-content" id="form-donacion-details">
                            <h3>Donate</h3>

                            <div class="donacion-radio-buttons">

                                <label class="form-control">
                                    <input type="radio" name="tipo_donacion" id="radio--donacion-unica" value="unica"
                                        checked required>
                                    One time donation
                                </label>

                                <label class="form-control">
                                    <input type="radio" name="tipo_donacion" id="radio--donacion-mensual"
                                        value="mensual" checked>
                                    Recurring donation
                                </label>
                            </div>

                            <div class="donacion-cantidades-options">
                                <div class="radio-group">
                                    <input type="radio" class="btn-check" name="radio-cantidad" id="option1" value="500"
                                        checked>
                                    <label class="btn btn-outline-primary" for="option1">$500 MXN</label>
                                </div>

                                <div class="radio-group">
                                    <input type="radio" class="btn-check" name="radio-cantidad" id="option2"
                                        value="1000">
                                    <label class="btn btn-outline-primary" for="option2">$1,000 MXN</label>
                                </div>

                                <div class="radio-group">
                                    <input type="radio" class="btn-check" name="radio-cantidad" id="option3"
                                        value="1500">
                                    <label class="btn btn-outline-primary" for="option3">$1,500 MXN</label>
                                </div>

                                <div class="radio-group">
                                    <input type="radio" class="btn-check" name="radio-cantidad" id="option4"
                                        value="2000">
                                    <label class="btn btn-outline-primary" for="option4">$2,000 MXN</label>
                                </div>

                                <div class="radio-group">
                                    <input type="radio" class="btn-check" name="radio-cantidad" id="option5"
                                        value="2500">
                                    <label class="btn btn-outline-primary" for="option5">$2,500 MXN</label>
                                </div>

                                <div class="radio-group">
                                    <input type="radio" class="btn-check" name="radio-cantidad" id="option6"
                                        value="3000">
                                    <label class="btn btn-outline-primary" for="option6">$3,000 MXN</label>
                                </div>
                            </div>

                            <div class="donacion-cantidad-custom" style="display: none;">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">$</span>
                                    <input type="number" id="cantidad-custom" name="input-cantidad" class="form-control"
                                        aria-label="Custom quantity"" placeholder=" Custom quantity (MXN)" min="10">
                                </div>
                            </div>

                            <input type="hidden" name="cantidad" id="cantidad" value="500">

                            <div class="donacion-cantidad-help-text">
                                <p>*Donation in mexican pesos (MXN).</p>
                            </div>

                            <div class="donacion-user-details">
                                <div class="form-group">
                                    <label for="donation-nombre">Name</label>
                                    <input type="text" name="name" class="form-control" id="donation-nombre"
                                        placeholder="Enter your name" required>
                                </div>

                                <div class="form-group">
                                    <label for="donation-email">Email Address</label>
                                    <input type="email" name="email" class="form-control" id="donation-email"
                                        placeholder="Enter your email" required>
                                </div>

                                <div class="form-group">
                                    <label for="comprobante"><input type="checkbox" name="comprobante" id="comprobante">
                                        I would like to receive a tax receipt</label>
                                </div>
                            </div>

                            <div class="donacion-buttons">
                                <button data-action="create-card">Continue</button>
                            </div>
                        </form>

                        <div id="card-container" class="donacion-content" style="display: none;">
                            <h3>Donate</h3>

                            <div class="donacion-details">
                                <div class="donacion-details-item">
                                    <span class="donacion-details-item__label">Donation type</span>
                                    <span class="donacion-details-item__value" id="donacion-details-tipo">Donacion
                                        Mensual</span>
                                </div>

                                <div class="donacion-details-item">
                                    <span class="donacion-details-item__label">Quantity</span>
                                    <span class="donacion-details-item__value"
                                        id="donacion-details-cantidad">$500</span>
                                </div>

                                <div class="donacion-details-item">
                                    <span class="donacion-details-item__label">Name</span>
                                    <span class="donacion-details-item__value" id="donacion-details-nombre">Juan
                                        Pérez</span>
                                </div>

                                <div class="donacion-details-item">
                                    <span class="donacion-details-item__label">Email</span>
                                    <span class="donacion-details-item__value"
                                        id="donacion-details-email">ricgarcas@gmail.com</span>
                                </div>
                            </div>

                            <div class="donacion-payment-wrapper">
                                <h4>Fill these form with your card details below.</h4>

                                <div id="card-element-container"></div>
                                <div class="payment-errors"></div>

                                <div class="donacion-buttons mt-4">
                                    <button id="card-button">
                                        <div class="spinner hidden" id="spinner"></div>
                                        <span id="button-text">Send</span>
                                    </button>

                                    <div class="secure-badge">
                                        <img src="/assets/images/donaciones/powered-stripe-logo.svg"
                                            alt="Powered by Stripe">
                                    </div>
                                </div>
                            </div>

                            <div class="result-message" style="display: none;">
                                <h4>¡Thank you!</h4>

                                <p>Your contribution <span>will help</span> to continue creating a <span>social
                                        change</span> through <span>community and cultural processes</span> in favor of
                                    the common good and the environment. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-newsletter" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="row">
                    <div class="col-lg-7">
                        <div class="newsletter-imagen">
                            <img src="/assets/images/donaciones/modal-bg.jpg" alt="">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="newsletter-info">
                            <div class="newsletter-title">
                                Subscribe to the newsletter
                            </div>
                            <form action="/newsletter" method="POST" class="newsletter-form">
                                <div class="newsletter-input">
                                    <input type="email" name="email" placeholder="Email Address" required>
                                </div>
                                <div class="newsletter-message" style="display: none;">Thank you for contacting us.
                                </div>
                                <div class="newsletter-submit">
                                    <button type="submit" class="btn btn-enviar">send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-contacto" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="row">
                    <div class="col-md-4">
                        <div class="newsletter-title">
                            Contact Us
                        </div>
                        <div class="mb-3">
                            <p class="text-sm text-gray-600">We'd love to hear from you. Send us a message and we'll
                                respond soon.</p>
                        </div>
                        @livewire('forms.contact-form')
                    </div>
                    <div class="col-md-8">
                        <div class="mapa">
                            <img src="/assets/images/casa/mapa.jpg" class="img-fluid">
                        </div>
                        <div class="mt-3">
                            <div class="address-title">Casa Gallina</div>
                            <div class="address-text">Sabino 190, Santa María la Ribera, <br>Mexico City, 06400.
                            </div>
                            <div class="address-phone"><a href="tel:5526302601">+52 55 2630 2601</a></div>
                            <div class="address-phone"><a href="tel:5568139568">+52 55 6813 9568</a></div>
                            <div class="address-email"><a
                                    href="mailto:info@casagallina.org.mx">info@casagallina.org.mx</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
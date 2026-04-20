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
                            <img src="/assets/images/donaciones/modal-bg.jpg" alt="">
                        </div>

                        <div class="donacion-text-wrapper">
                            <h3>¡Muchas gracias!</h3>

                            <p>Tu aportación <span>ayudará</span> a seguir creando un <span>cambio social</span> a través de <span>procesos comunitarios y culturales</span> en favor del bien común y el
                                medio ambiente.</p>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <form class="donacion-content" id="form-donacion-details" method="POST" action="/donaciones/checkout">
                            @csrf
                           
                            <h3>Dona</h3>

                            <div class="donacion-radio-buttons">

                                <label class="form-control">
                                    <input type="radio" name="tipo_donacion" id="radio--donacion-unica" value="unica"
                                        checked required>
                                    Donación única
                                </label>

                                <label class="form-control">
                                    <input type="radio" name="tipo_donacion" id="radio--donacion-mensual"
                                        value="mensual" checked>
                                    Donación mensual
                                </label>
                            </div>

                            <div class="donacion-cantidades-options">
                                <div class="radio-group">
                                    <input type="radio" class="btn-check" name="radio-cantidad" id="option1" value="500"
                                        checked>
                                    <label class="btn btn-outline-primary" for="option1">$500</label>
                                </div>

                                <div class="radio-group">
                                    <input type="radio" class="btn-check" name="radio-cantidad" id="option2"
                                        value="1000">
                                    <label class="btn btn-outline-primary" for="option2">$1,000</label>
                                </div>

                                <div class="radio-group">
                                    <input type="radio" class="btn-check" name="radio-cantidad" id="option3"
                                        value="1500">
                                    <label class="btn btn-outline-primary" for="option3">$1,500</label>
                                </div>

                                <div class="radio-group">
                                    <input type="radio" class="btn-check" name="radio-cantidad" id="option4"
                                        value="2000">
                                    <label class="btn btn-outline-primary" for="option4">$2,000</label>
                                </div>

                                <div class="radio-group">
                                    <input type="radio" class="btn-check" name="radio-cantidad" id="option5"
                                        value="2500">
                                    <label class="btn btn-outline-primary" for="option5">$2,500</label>
                                </div>

                                <div class="radio-group">
                                    <input type="radio" class="btn-check" name="radio-cantidad" id="option6"
                                        value="3000">
                                    <label class="btn btn-outline-primary" for="option6">$3,000</label>
                                </div>
                            </div>

                            <div class="donacion-cantidad-custom" style="display: none;">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">$</span>
                                    <input type="number" id="cantidad-custom"           name="input-cantidad" class="form-control"
                                        aria-label="Cantidad Personalizada (MXN)" placeholder="Otra cantidad (MXN)"
                                        min="100">
                                </div>
                            </div>

                            <div class="donacion-cantidad-help-text">
                                <p>
                                    Cantidad mínima $100 MXN <br>
                                    Cantidades en pesos mexicanos
                                </p>
                            </div>

                            <input type="hidden" name="cantidad" id="cantidad" value="500">

                            <div class="donacion-user-details">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" name="name" class="form-control" id="nombre"
                                        placeholder="Escribe tu nombre" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Correo Electrónico</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        placeholder="Escribe tu dirección de correo electrónico" required>
                                </div>

                                <div class="form-group">
                                    <label for="comprobante">
                                        <input type="checkbox" name="comprobante" id="comprobante">
                                        Deseo comprobante fiscal
                                    </label>
                                </div>
                            </div>

                            <div class="donacion-buttons">
                                <button data-action="store-donor-data">Continuar</button>
                            </div>
                        </form>

                        <!-- <div id="card-container" class="donacion-content" style="display: none;">
                            <h3>Dona</h3>

                            <div class="donacion-details">
                                <div class="donacion-details-item">
                                    <span class="donacion-details-item__label">Tipo</span>
                                    <span class="donacion-details-item__value" id="donacion-details-tipo">Donacion
                                        Mensual</span>
                                </div>

                                <div class="donacion-details-item">
                                    <span class="donacion-details-item__label">Cantidad</span>
                                    <span class="donacion-details-item__value"
                                        id="donacion-details-cantidad">$500</span>
                                </div>

                                <div class="donacion-details-item">
                                    <span class="donacion-details-item__label">Nombre</span>
                                    <span class="donacion-details-item__value" id="donacion-details-nombre">Juan
                                        Pérez</span>
                                </div>

                                <div class="donacion-details-item">
                                    <span class="donacion-details-item__label">Correo Electrónico</span>
                                    <span class="donacion-details-item__value"
                                        id="donacion-details-email">ricgarcas@gmail.com</span>
                                </div>
                            </div>

                            <div class="donacion-payment-wrapper">
                                <h4>Llena este formulario con tus datos de tarjeta.</h4>

                                <div id="card-element-container"></div>
                                <div class="payment-errors"></div>

                                <div class="donacion-buttons mt-4">
                                    <button id="card-button">
                                        <div class="spinner hidden" id="spinner"></div>
                                        <span id="button-text">Enviar</span>
                                    </button>

                                    <div class="secure-badge">
                                        <img src="/assets/images/donaciones/powered-stripe-logo.svg"
                                            alt="Powered by Stripe">
                                    </div>
                                </div>
                            </div>

                            <div class="result-message" style="display: none;">
                                <h4>Muchas gracias por tu donación</h4>

                                <p>Tu aportación <span>ayudará</span> a seguir creando un <span>cambio social</span> a
                                    través de <span>procesos comunitarios y culturales</span> en favor del bien común y
                                    el medio ambiente.</p>
                            </div>
                        </div> -->
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
                                Suscríbete al boletín
                            </div>
                            <form action="/newsletter" method="POST" class="newsletter-form">
                                <div class="newsletter-input">
                                    <input type="email" name="email" placeholder="Correo Electrónico" required>
                                </div>
                                <div class="newsletter-message" style="display: none;">Gracias por contactarnos.</div>
                                <div class="newsletter-submit">
                                    <button type="submit" class="btn btn-enviar">enviar</button>
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
                        <div class="address-title">Casa Gallina</div>
                        <div class="address-text">Sabino 190, Santa María la Ribera, <br>Ciudad de México, 06400.
                        </div>
                        <div class="address-phone"><a href="5526302601">+52 55 2630 2601</a></div>
                        <div class="address-phone"><a href="5568139568">+52 55 6813 9568</a></div>
                        <div class="address-email"><a href="mailto:info@casagallina.org.mx">info@casagallina.org.mx</a>
                        </div>

                        <div class="newsletter-title">
                            Suscríbete al boletín
                        </div>
                        <form action="/newsletter" method="POST" class="newsletter-form">
                            <div class="newsletter-input">
                                <input type="email" name="email" placeholder="Correo Electrónico" required>
                            </div>
                            <div class="newsletter-message" style="display: none;">Gracias por contactarnos.</div>
                            <div class="newsletter-submit">
                                <button type="submit" class="btn btn-enviar">enviar</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <div class="mapa">
                            <img src="/assets/images/casa/mapa.jpg" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
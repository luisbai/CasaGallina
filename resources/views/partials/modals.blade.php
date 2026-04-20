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
                                alt="Campaña de fondeo colectivo">
                        </div>

                        <div class="donacion-text-wrapper">
                            <h3>¡Muchas gracias!</h3>

                            <p>Tu aportación <span>ayudará</span> a seguir creando un <span>cambio social</span> a
                                través de <span>procesos comunitarios y culturales</span> en favor del bien común y el
                                medio ambiente.</p>

                            <div class="text-right mt-12">
                                <a href="{{ route('donaciones') }}"
                                    class="px-4 py-2 rounded-xl bg-forest text-white mt-4 hover:no-underline hover:bg-green-800/90 transition">
                                    Más información
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <form class="donacion-content" id="form-donacion-details" method="POST"
                            action="/donaciones/checkout">
                            @csrf

                            <h3>Casa Gallina: 10 años de trabajo comunitario</h3>


                            <!--
                            <div class="donacion-radio-buttons">

                                <label class="form-control">
                                    <input type="radio" name="tipo_donacion" id="radio--donacion-unica" value="unica"
                                           checked>
                                    Donación única
                                </label>


                            </div>
                            -->

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

                            <div class="donacion-cantidad-custom">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">$</span>
                                    <input type="number" id="cantidad-custom" name="input-cantidad" class="form-control"
                                        aria-label="Cantidad Personalizada (MXN)" placeholder="Otra cantidad (MXN)"
                                        min="100">
                                </div>
                            </div>


                            <input type="hidden" name="cantidad" id="cantidad" value="500">

                            <div class="donacion-user-details">
                                <div class="form-group">
                                    <label for="donation-nombre">Nombre</label>
                                    <input type="text" name="name" class="form-control" id="donation-nombre"
                                        placeholder="Escribe tu nombre" required>
                                </div>

                                <div class="form-group">
                                    <label for="donation-email">Correo Electrónico</label>
                                    <input type="email" name="email" class="form-control" id="donation-email"
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

                        {{-- <div id="card-container" class="donacion-content" style="display: none;">
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
                        </div> --}}
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
                            <form action="/newsletter" method="POST" class="newsletter-form" id="newsletter-modal-form">
                                @csrf
                                <div class="newsletter-input">
                                    <input type="email" name="email" id="newsletter-email-input"
                                        placeholder="Correo Electrónico" required class="form-control">
                                    <div class="invalid-feedback"
                                        style="display: none; color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;">
                                        Por favor ingresa un correo electrónico válido.
                                    </div>
                                </div>
                                <div class="newsletter-message" style="display: none;">Gracias por contactarnos.</div>
                                <div class="newsletter-submit">
                                    <button type="submit" class="btn btn-enviar" id="newsletter-submit-btn" disabled>
                                        enviar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('newsletter-modal-form');
        const emailInput = document.getElementById('newsletter-email-input');
        const submitBtn = document.getElementById('newsletter-submit-btn');
        const invalidFeedback = emailInput?.parentElement.querySelector('.invalid-feedback');

        if (!form || !emailInput || !submitBtn) return;

        // Email validation regex
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        function validateEmail() {
            const email = emailInput.value.trim();
            const isValid = email.length > 0 && emailRegex.test(email);

            if (email.length === 0) {
                // Empty field - no error, but button disabled
                emailInput.classList.remove('is-invalid', 'is-valid');
                if (invalidFeedback) invalidFeedback.style.display = 'none';
                submitBtn.disabled = true;
            } else if (isValid) {
                // Valid email
                emailInput.classList.remove('is-invalid');
                emailInput.classList.add('is-valid');
                if (invalidFeedback) invalidFeedback.style.display = 'none';
                submitBtn.disabled = false;
            } else {
                // Invalid email
                emailInput.classList.remove('is-valid');
                emailInput.classList.add('is-invalid');
                if (invalidFeedback) invalidFeedback.style.display = 'block';
                submitBtn.disabled = true;
            }
        }

        // Validate on input (real-time)
        emailInput.addEventListener('input', validateEmail);

        // Validate on blur
        emailInput.addEventListener('blur', validateEmail);

        // Prevent form submission if invalid
        form.addEventListener('submit', function (e) {
            const email = emailInput.value.trim();
            if (!email || !emailRegex.test(email)) {
                e.preventDefault();
                validateEmail();
                return false;
            }
        });

        // Reset form when modal is closed
        const modal = document.getElementById('modal-newsletter');
        if (modal) {
            modal.addEventListener('hidden.bs.modal', function () {
                form.reset();
                emailInput.classList.remove('is-invalid', 'is-valid');
                if (invalidFeedback) invalidFeedback.style.display = 'none';
                submitBtn.disabled = true;
            });
        }
    });
</script>


<div class="modal fade" id="modal-contacto" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="row">
                    <div class="col-md-5">
                        <h3 class="!text-2xl !text-gray-100">
                            Contáctanos
                        </h3>
                        <div class="mb-3">
                            <p class="!text-base !text-gray-100 !leading-4">Nos encantaría escuchar de ti. Envíanos un
                                mensaje y te responderemos pronto.</p>
                        </div>
                        @livewire('forms.contact-form')
                    </div>
                    <div class="col-md-7">
                        <div class="mapa">
                            <img src="/assets/images/casa/mapa.jpg" class="img-fluid">
                        </div>
                        <div class="mt-3">
                            <table class="w-full">
                                <tbody>
                                    <tr>
                                        <td class="!font-bold">Dirección</td>
                                        <td class="!text-gray-100 text-right">Sabino 190, Santa María la Ribera,
                                            <br>Ciudad de México, 06400.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="!font-bold">Teléfonos</td>
                                        <td class="!text-gray-100 text-right">+52 55 2630 2601<br>+52 55 6813 9568</td>
                                    </tr>
                                    <tr>
                                        <td class="!font-bold">Correo</td>
                                        <td class="!text-gray-100 text-right"><a href="mailto:info@casagallina.org.mx"
                                                class="!text-gray-100">info@casagallina.org.mx</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
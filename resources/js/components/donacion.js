import $ from 'jquery';
import 'bootstrap';

class DonacionComponent {
	constructor() {
		if ($('#modal-donacion').length > 0) {
			this.init();
		}
	}

    stripe = null;
    client_secret = null;
    donacion_data = [];
    locale = document.documentElement.lang;

    setStripe () {
        // Add script to DOM to load Stripe
        let script = document.createElement('script');
        script.src = 'https://js.stripe.com/v3/';
        script.async = true;
        document.body.appendChild(script);

        const stripePublicKey = document.head.querySelector('meta[name="stripe-pk"]').content;

        script.addEventListener('load', () => {
            this.stripe = Stripe(stripePublicKey, {
                locale: this.locale
            });
        });

        this.card = null;
    }

    setCardElement () {

        $('#card-container').show();

        const elements = this.stripe.elements({ clientSecret: this.client_secret });

        this.card = elements.create("card", {
            iconStyle: "solid",
            style: {
                base: {
                    iconColor: "#FFF",
                    color: "#FFF",
                    fontWeight: 400,
                    fontFamily: "Lato, sans-serif",
                    fontSize: "16px",
                    fontSmoothing: "antialiased",
                    "::placeholder": {
                        color: "#CCC"
                    },
                    ":-webkit-autofill": {
                        color: "#CCC"
                    }
                },
                invalid: {
                    iconColor: "#1b2b90",
                    color: "#1b2b90"
                }
            }
        });

        this.card.mount("#card-element-container");

        this.setPaymentMethod();
    }

    setPaymentMethod () {

        const cardHolderName = this.findDonacionData('name');
        const cardButton = document.getElementById('card-button');''
        const paymentType = this.findDonacionData('tipo_donacion').value;
        const clientSecret = this.client_secret;

        cardButton.addEventListener('click', async (e) => {
            this.loading(true);

            const { setupIntent, error } = await this.stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: this.card,
                        billing_details: { name: cardHolderName.value }
                    },

                }
            );

            if (error) {
                // Display "error.message" to the user...
                $('.payment-errors').html('<span class="alert alert-danger">' + error.message + '</span>');
                this.loading(false);
            } else {
                this.sendPaymentToServer(setupIntent.payment_method, paymentType);
            }
        });
    }

    sendPaymentToServer (payment_method, payment_type) {
        let url = (payment_type == 'mensual') ? '/api/checkout/subscription' : '/api/checkout/charge';

        window.axios.post(url, {
            payment_method: payment_method,
            donacion_data: this.donacion_data
        }).then((response) => {
            this.loading(false);
            // The payment has been made successfully...
            $('.result-message').show();
            $('.donacion-payment-wrapper').hide();
        }).catch((error) => {
            this.loading(false);
            // The payment failed -- ask your customer for a new payment method.
            $('.payment-errors').html('<span class="alert alert-danger">' + error.message + '</span>');
        });
    }

    // Show a spinner on payment submission
    loading (isLoading) {
        if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("#card-button").disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#button-text").classList.add("hidden");
        } else {
            document.querySelector("#card-button").disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#button-text").classList.remove("hidden");
        }
    };

    findDonacionData (key) {
        return this.donacion_data.find((item) => {
            return item.name == key;
        });
    }

    setDonacionData () {
        let tipo = this.findDonacionData('tipo_donacion').value;

        if (this.locale == 'es') {
            $('#donacion-details-tipo').html(tipo == 'mensual' ? 'Mensual' : 'Única');
        } else {
            $('#donacion-details-tipo').html(tipo == 'mensual' ? 'Monthly' : 'One time');
        }


        $('#donacion-details-cantidad').html('$ ' + this.findDonacionData('cantidad').value + ' MXN');
        $('#donacion-details-nombre').html(this.findDonacionData('name').value);
        $('#donacion-details-email').html(this.findDonacionData('email').value);
    }

    showModalOncePerDay() {
        const lastShown = localStorage.getItem('donationModalLastShown');
        const now = new Date().getTime();
        const oneDay = 24 * 60 * 60 * 1000; // milliseconds in one day

        if (!lastShown || now - lastShown > oneDay) {
            // Show the modal
            $('#modal-donacion').modal('show');
            // Update the last shown time
            localStorage.setItem('donationModalLastShown', now);
        }
    }

	init () {
        // Event to check if bootstrap modal has been opened
        $('#modal-donacion').on('shown.bs.modal', () => {
            this.setStripe();
        });

        $('#cantidad-custom').on('change', (e) => {
            $('[name="radio-cantidad"]:checked').prop('checked', false);
            $('#cantidad').val(e.currentTarget.value);
        });

        $('[name="radio-cantidad"]').on('change', (e) => {
            $('#cantidad-custom').val('');
            $('#cantidad').val(e.currentTarget.value);
        });

        $('[name=tipo_donacion]').on('change', (e) => {
            if (e.currentTarget.value == 'unica') {
                $('.donacion-cantidad-custom').show();
            } else {
                $('.donacion-cantidad-custom').hide();
            }
        });

        const modalElement = document.getElementById('modal-donacion');

        // Show the modal element
        // if (modalElement) {
        //     this.showModalOncePerDay();
        // }

        $('#form-donacion-details').validate({
            submitHandler: (form) => {
                $('[data-action="store-donor-data"]').attr('disabled', true);

                form.submit();

                // this.setDonacionData();
                // this.donacion_data = $(form).serializeArray();

                // Get setup intent from api and set it to the form
                // window.axios.post('/api/checkout/setup-intent', {
                //     email: $('#form-donacion-details [name="email"]').val(),
                //     name: $('#form-donacion-details [name="name"]').val(),
                //     comprobante: $('#form-donacion-details [name="comprobante"]').is(":checked"),
                // }).then((response) => {
                //     this.client_secret = response.data.client_secret;

                //     $('#form-donacion-details').hide();

                //     this.setCardElement();
                // });
            }
        });
	}
}

const donacionComponent = new DonacionComponent();

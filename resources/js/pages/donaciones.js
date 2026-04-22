class DonacionesIndex {
	constructor() {
		if ($('#donaciones-index').length > 0) {
			this.init();
		}
	}

	init () {
		const language = $('#language').val();

		$('[data-scroll]').on('click', (event) => {
			event.preventDefault();
	    	let section = $(event.currentTarget).attr('href');
	    	let url = '';

	    	if (language == 'es') {
				url = '/' + section;
			} else if (language == 'en') {
				url = '/en' + section;
			}

	    	window.location = section;
		});

        $('.donacion-personalizada-form').validate({
            submitHandler: function(form) {
                let data = $(form).serializeArray();
                let url = $(form).attr('action');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            $('.donacion-personalizada-form').hide();
                            $('.formulario-gracias').show();
                        }
                    }
                });
            }
        });

		$('[data-action="donacion-unica"]').on('click', (event) => {
			$('#radio--donacion-unica').prop('checked', true);
			$('.donacion-cantidad-custom').show();

			// Open modal
			$('#modal-donacion').modal('show');
		});

		$('[data-action="donacion-mensual"]').on('click', (event) => {
			$('#radio--donacion-mensual').prop('checked', true);
			$('.donacion-cantidad-custom').hide();

			// Open modal
			$('#modal-donacion').modal('show');
		});

	}

}

let donacionesIndex = new DonacionesIndex();
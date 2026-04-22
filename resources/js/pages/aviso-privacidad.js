class AvisoPrivacidadIndex {
	constructor() {
		if ($('#aviso-privacidad-index').length > 0) {
			this.init();
		}
	}

	init () {
		let language = $('#language').val();

		$('[data-scroll]').on('click', (event) => {
			event.preventDefault();
	    	let section = $(event.currentTarget).attr('href');

	    	let url = '';

	    	if (language == 'es') {
				url = '/' + section;
			} else if (language == 'en') {
				url = '/en' + section;
			}

	    	window.location = url;
		});
	}

}

let avisoPrivacidadIndex = new AvisoPrivacidadIndex();
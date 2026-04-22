class BoletinesIndex {
	constructor() {
		if ($('#boletines-index').length > 0) {
			this.init();
		}
	}

	init () {
		let language = $('#language').val();


		if (language == 'es') {
			moment.locale('es');
		}
		

		$('#boletines-table .fecha').each(function(index, el) {
			$(el).html(window.moment($(el).html(), "YYYY-MM-DD").format('MMMM'));
		});
	}

}

let boletinesIndex = new BoletinesIndex();
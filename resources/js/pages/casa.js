class CasaIndex {
	constructor() {
		if ($('#casa-index').length > 0) {
			this.init();
		}
	}

	init () {
		let language = $('#language').val();

		
		$('[data-action="toggle-miembro"]').click(function(event) {
			let miembro_id = $(this).data('miembro');
			$('#miembro-' + miembro_id + '-modal').modal('show');
		});
	}

	
}

let casaIndex = new CasaIndex();
class AdminBoletinesEdit {
	constructor() {
		if ($('#admin-boletines-edit').length > 0) {
			this.init();
		}
	}

	init () {
		$('#admin-boletines-edit-form').validate({
			rules: {
        		'multimedia_id': {
        			extension: "pdf",
        			filesize: 10
        		}
        	}
		});

		$('.datepicker').datetimepicker({
            format: 'YYYY-MM-DD',
            locale: 'es'
        });
	}
}

let adminBoletinesEdit = new AdminBoletinesEdit();
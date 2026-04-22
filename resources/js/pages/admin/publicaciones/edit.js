class AdminPublicacionesEdit {
	constructor() {
		if ($('#admin-publicaciones-edit').length > 0) {
			this.init();
		}
	}

	init () {

		$('.datepicker').datetimepicker({
            format: 'YYYY-MM-DD',
            locale: 'es'
        });

        $('#admin-publicaciones-edit-form').validate({
        	ignore: [],
        	rules: {
        		"publicacion_multimedia": {
        			extension: "pdf,docx,doc",
        			filesize: 250
        		},
                "publicacion_multimedia_en": {
        			extension: "pdf,docx,doc",
        			filesize: 250
        		},
        		'publicacion_thumbnail': {
        			extension: "jpg,jpeg,png",
        			filesize: 5
        		},
        		'publicacion_thumbnail_en': {
        			extension: "jpg,jpeg,png",
        			filesize: 5
        		}
        	}
        });

		$('.tinymce').each(function (i, val) { 
			let height = (typeof $(this).data('height') !== 'undefined') ? $(this).data('height') : 150;

			tinymce.init({
				selector: '#' + $(this).attr('id'),
				toolbar: 'bold italic',
				menubar: false,
				statusbar: false,
				height: height,
			});
		});

	}
}

let adminPublicacionesEdit = new AdminPublicacionesEdit();
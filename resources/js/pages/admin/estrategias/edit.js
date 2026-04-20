import Quill from 'quill';

class AdminEstrategiasEdit {
	constructor() {
		if ($('#admin-estrategias-edit').length > 0) {
			this.init();
		}
	}

	init () {
		$('#estrategias-table').dataTable({
			language: window.dataTableLanguage
		}).on( 'draw', function () {
		    $('#estrategias-table .fecha').each(function(index, el) {
				$(el).html(moment($(el).html(), "YYYY-MM-DD hh:mm:ss").format('LL'));
			});
		});

		let contenido_editor = new Quill('#contenido', Object.assign(window.quillSettings, {
			placeholder: 'Contenido de la estrategia'
		}));

		contenido_editor.on('selection-change', function(range, oldRange, source) {
			if (range === null && oldRange !== null) {
				$('#contenido-input').val(contenido_editor.root.innerHTML);
			}
		});

		if ($('#contenido-input').val() !== '') {
			contenido_editor.clipboard.dangerouslyPasteHTML($('#contenido-input').val());
		}

		let contenido_en_editor = new Quill('#contenido-en', Object.assign(window.quillSettings, {
			placeholder: 'Contenido de la estrategia (EN)'
		}));

		contenido_en_editor.on('selection-change', function(range, oldRange, source) {
			if (range === null && oldRange !== null) {
				$('#contenido-en-input').val(contenido_en_editor.root.innerHTML);
			}
		});

		if ($('#contenido-en-input').val() !== '') {
			contenido_en_editor.clipboard.dangerouslyPasteHTML($('#contenido-en-input').val());
		}

		let programas_editor = new Quill('#programas', Object.assign(window.quillSettings, {
			placeholder: 'Programas de implementación de la estrategia'
		}));

		programas_editor.on('selection-change', function(range, oldRange, source) {
			if (range === null && oldRange !== null) {
				$('#programas-input').val(programas_editor.root.innerHTML);
			}
		});

		if ($('#programas-input').val() !== '') {
			programas_editor.clipboard.dangerouslyPasteHTML($('#programas-input').val());
		}

		let programas_en_editor = new Quill('#programas-en', Object.assign(window.quillSettings, {
			placeholder: 'Programas de implementación de la estrategia (EN)'
		}));

		programas_en_editor.on('selection-change', function(range, oldRange, source) {
			if (range === null && oldRange !== null) {
				$('#programas-en-input').val(programas_en_editor.root.innerHTML);
			}
		});

		if ($('#programas-en-input').val() !== '') {
			programas_en_editor.clipboard.dangerouslyPasteHTML($('#programas-en-input').val());
		}

		$('.datepicker').datetimepicker({
            format: 'YYYY-MM-DD',
            locale: 'es'
        });

        $('#admin-estrategias-edit-form').validate({
        	ignore: [],
        	rules: {
        		"imagenes[]": {
        			extension: "jpg,jpeg,png",
        			filesize: 5
        		},
        		'destacada_multimedia_id': {
        			extension: "jpg,jpeg,png",
        			filesize: 5
        		}
        	}
        });

        $('.estrategia-multimedia .close').click(function(event) {
        	let multimedia_id = $(this).data('multimediaId');
        	let estrategia_id = $(this).data('estrategiaId');
        	let tipo = $(this).data('tipo');
        	let $this = $(this);

        	window.Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas eliminar esta imagen?",
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Eliminar'
            }).then(function (result) {
            	if (result.value) {
            		window.axios.delete('/admin/estrategias/' + estrategia_id + '/image', {
            			params: {
            				'multimedia_id': multimedia_id,
            				'tipo': tipo
            			}
		            }).then(function (response) {
		                $this.parent().remove();
		            }).catch(function (e) {
		                window.Swal.fire(
		                    'Oops',
		                    'La imagen no ha podido ser eliminado',
		                    'error'
		                );
		            }); 
            	}
            }); 
        });
	}
}

let adminEstrategiasEdit = new AdminEstrategiasEdit();
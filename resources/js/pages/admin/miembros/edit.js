class AdminMiembrosEdit {
	constructor() {
		if ($('#admin-miembros-edit').length > 0) {
			this.init();
		}
	}

	init () {
		$('#admin-miembros-edit-form').validate({
			ignore: [],
		});

		let biografia_editor = new Quill('#biografia', Object.assign(window.quillSettings, {
			placeholder: 'Contenido de la biografía'
		}));

		biografia_editor.on('selection-change', function(range, oldRange, source) {
			if (range === null && oldRange !== null) {
				$('#biografia-input').val(biografia_editor.root.innerHTML);
			}
		});

		if ($('#biografia-input').val() !== '') {
			biografia_editor.clipboard.dangerouslyPasteHTML($('#biografia-input').val());
		}

		let biografia_en_editor = new Quill('#biografia-en', Object.assign(window.quillSettings, {
			placeholder: 'Contenido de la biografía'
		}));

		biografia_en_editor.on('selection-change', function(range, oldRange, source) {
			if (range === null && oldRange !== null) {
				$('#biografia-en-input').val(biografia_en_editor.root.innerHTML);
			}
		});

		if ($('#biografia-en-input').val() !== '') {
			biografia_en_editor.clipboard.dangerouslyPasteHTML($('#biografia-en-input').val());
		}
	}
}

let adminMiembrosEdit = new AdminMiembrosEdit();
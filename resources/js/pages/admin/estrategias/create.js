import Quill from 'quill';

class AdminEstrategiasCreate {
    constructor() {
        if ($('#admin-estrategias-edit').length > 0) {
            this.init();
        }
    }

    init() {
        let contenido_editor = new Quill('#contenido', Object.assign(window.quillSettings, {
            placeholder: 'Contenido de la estrategia'
        }));

        contenido_editor.on('selection-change', function (range, oldRange, source) {
            if (range === null && oldRange !== null) {
                $('#contenido-input').val(contenido_editor.root.innerHTML);
            }
        });

        let contenido_en_editor = new Quill('#contenido-en', Object.assign(window.quillSettings, {
            placeholder: 'Contenido de la estrategia (EN)'
        }));

        contenido_en_editor.on('selection-change', function (range, oldRange, source) {
            if (range === null && oldRange !== null) {
                $('#contenido-en-input').val(contenido_en_editor.root.innerHTML);
            }
        });

        let programas_editor = new Quill('#programas', Object.assign(window.quillSettings, {
            placeholder: 'Programas de implementación de la estrategia'
        }));

        programas_editor.on('selection-change', function (range, oldRange, source) {
            if (range === null && oldRange !== null) {
                $('#programas-input').val(programas_editor.root.innerHTML);
            }
        });

        let programas_en_editor = new Quill('#programas-en', Object.assign(window.quillSettings, {
            placeholder: 'Programas de implementación de la estrategia (EN)'
        }));

        programas_en_editor.on('selection-change', function (range, oldRange, source) {
            if (range === null && oldRange !== null) {
                $('#programas-en-input').val(programas_en_editor.root.innerHTML);
            }
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
    }
}

let adminEstrategiasCreate = new AdminEstrategiasCreate();

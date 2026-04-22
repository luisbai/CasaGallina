import _ from 'lodash';
import Swal from 'sweetalert2';
import { createPopper } from '@popperjs/core';
import $ from 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import './plugins/jquery.background-video.js';
import axios from 'axios';
import 'jquery-validation'; // Ensure jquery-validation is installed via npm
import './quill'; // Assuming you have a custom quill setup in this file
import moment from 'moment';

// Assigning libraries to the global window object for accessibility
window._ = _;
window.Swal = Swal;
window.Popper = createPopper;
window.$ = window.jQuery = $;
window.moment = moment;
window.axios = axios;

// Axios Configuration
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached.
 */
const tokenElement = document.head.querySelector('meta[name="csrf-token"]');

if (tokenElement) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = tokenElement.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// DataTable Language Configuration
window.dataTableLanguage = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
};

// Quill Editor Settings
window.quillSettings = {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, false] }],
            ['bold', 'italic', 'link'],
            [{ list: 'ordered' }, { list: 'bullet' }]
        ]
    },
};

// jQuery Validation - Spanish Messages
$.extend($.validator.messages, {
    required: "Este campo es obligatorio.",
    remote: "Por favor, rellena este campo.",
    email: "Por favor, escribe una dirección de correo válida.",
    url: "Por favor, escribe una URL válida.",
    date: "Por favor, escribe una fecha válida.",
    dateISO: "Por favor, escribe una fecha (ISO) válida.",
    number: "Por favor, escribe un número válido.",
    digits: "Por favor, escribe sólo dígitos.",
    creditcard: "Por favor, escribe un número de tarjeta válido.",
    equalTo: "Por favor, escribe el mismo valor de nuevo.",
    extension: "Por favor, escribe un valor con una extensión aceptada.",
    maxlength: $.validator.format("Por favor, no escribas más de {0} caracteres."),
    minlength: $.validator.format("Por favor, no escribas menos de {0} caracteres."),
    rangelength: $.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
    range: $.validator.format("Por favor, escribe un valor entre {0} y {1}."),
    max: $.validator.format("Por favor, escribe un valor menor o igual a {0}."),
    min: $.validator.format("Por favor, escribe un valor mayor o igual a {0}."),
    nifES: "Por favor, escribe un NIF válido.",
    nieES: "Por favor, escribe un NIE válido.",
    cifES: "Por favor, escribe un CIF válido."
});

// jQuery Validation - Custom Methods
$.validator.addMethod("extension", function(value, element, param) {
    param = typeof param === "string" ? param.replace(/,/g, "|") : "png|jpe?g|gif";
    return this.optional(element) || new RegExp("\\.(" + param + ")$", "i").test(value);
}, $.validator.format("Por favor agrega una extensión valida: ({0})"));

$.validator.addMethod('filesize', function(value, element, param) {
    param = param * (1000 * 1000); // Convert MB to bytes

    if (this.optional(element)) {
        return true;
    }

    let valid = true;
    $.each(element.files, function(index, file) {
        if (file.size >= param) {
            valid = false;
            return false; // Break the loop
        }
    });

    return valid;
}, 'Cada imagen debe de pesar máximo {0} MB');

// Ensure Google is available if used
try {
    window.google = google;
} catch (e) {
    console.warn('Google API not available:', e);
}

// Newsletter Form Validation and Submission
function setupNewsletterForm(selector) {
    $(selector).validate({
        highlight: function(element) {
            $(element).addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).removeClass('has-error');
        },
        errorPlacement: function(error, element) {},
        submitHandler: function(form) {
            window.axios.post('/newsletter', $(form).serialize())
                .then(function(response) {
                    if (response.data.status === 'success') {
                        $(form).find('.newsletter-input input').val('');
                        $(form).find('.newsletter-message').show();
                    } else {
                        console.error(response.data.message);
                    }
                })
                .catch(function(error) {
                    console.error('An error occurred:', error);
                });

            return false;
        }
    });
}

// Initialize Newsletter Forms
setupNewsletterForm('.newsletter-form-modal');
setupNewsletterForm('.newsletter-form');

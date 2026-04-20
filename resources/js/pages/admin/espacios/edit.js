class AdminEspaciosEdit {
	constructor() {
		if ($('#admin-espacios-edit').length > 0) {
			this.init();
		}
	}

	AutocompleteDirectionsHandler() {
		let direccionInput = document.getElementById('ubicacion-input');

		let direccionAutocomplete = new window.google.maps.places.Autocomplete(
		  direccionInput, {fields: ['place_id', 'name', 'geometry'], types:[], componentRestrictions: {country: 'mx'}});

		direccionAutocomplete.addListener('place_changed', function () {
            var place = direccionAutocomplete.getPlace();
            $('#ubicacion-lat').val(place.geometry.location.lat());
            $('#ubicacion-long').val(place.geometry.location.lng());
        });

        $('#ubicacion-input').focus(function() {
		    $(this).attr('autocomplete', 'new-password');
		});
	}

	init () {
		$('#admin-espacios-edit-form').validate({
			ignore: [],
			rules: {
        		'multimedia_id': {
        			extension: "jpg,jpeg,png",
        			filesize: 5
        		}
        	}
		});
		
        this.AutocompleteDirectionsHandler();

        $('[data-action="eliminar-estrategia"]').click(function(event) {
        	let estrategia_id = $(this).data('estrategiaId');
        	let espacio_id = $('#espacio-id').val();

    		window.Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas desasignar esta estrategia?",
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Eliminar'
            }).then(function (result) {
            	if (result.value) {
            		window.axios.post('/api/admin/espacios/' + espacio_id + '/estrategia', {
	                    _method: 'DELETE',
	                    estrategia_id: estrategia_id
	                }).then(function (response) {
	                    window.Swal.fire(
	                        'Éxito',
	                        'Estrategia desasignada',
	                        'success'
	                    ).then(function () {
	                        location.reload();
	                    })
	                }).catch(function (e) {
	                    window.Swal.fire(
	                        'Oops',
	                        'El registro no ha podido ser eliminado',
	                        'error'
	                    );
	                });  
            	}
            });
        });

        $('.table-estrategias').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: '/api/admin/estrategias/datatables',
	        columns: [
	            {data: 'titulo', name: 'titulo', width: '80%'},
	            {data: 'acciones', name: 'acciones', width: '20%'},
	        ]
	    }).on('draw', function(event) {
	    	$('.table-estrategias [data-action="agregar-estrategia"]').click(function(event) {
	    		let estrategia_id = $(this).data('estrategia');
	    		let espacio_id = $('#espacio-id').val();

	    		window.axios.put('/api/admin/espacios/' + espacio_id + '/estrategia', {
	    			estrategia_id: estrategia_id
	    		}).then((response) => {
					if (response.data.status == 'success') {
						window.Swal.fire(
	                        'Estrategia asignada',
	                        'La estrategia ha sido asignada exitosamente',
	                        'success'
	                    ).then(function() {
	                    	location.reload();
	                    });
					}
				});
	    	});
	    });

	    $('#modal-estrategias').on('shown.bs.modal', function (e) {
			$('.table-estrategias').DataTable().columns.adjust();
		});
	}
}

let adminEspaciosEdit = new AdminEspaciosEdit();
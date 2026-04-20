class AdminBoletinesIndex {
	constructor() {
		if ($('#admin-boletines-index').length > 0) {
			this.init();
		}
	}

	init () {
		moment.locale('es');

		$('#boletines-table').dataTable({
			language: window.dataTableLanguage,
			columns: [
				{
					width: '70%'
				},
				{
					width: '30%'
				},
			]
		});

		$('#boletines-table .fecha').each(function(index, el) {
			$(el).html(window.moment($(el).html(), "YYYY-MM-DD hh:mm:ss").format('MMMM Y'));
		});

		$('.delete-record').click(function(event) {
            var $_self = $(this);
            window.Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas eliminar este registro de la base de datos?",
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Eliminar'
            }).then(function (result) {
            	if (result.value) {
            		window.axios.post('/admin/boletines/' + $_self.data('recordId'), {
	                    _method: 'DELETE'
	                }).then(function (response) {
	                    window.Swal.fire(
	                        'Eliminado',
	                        'El registro ha sido eliminado',
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
            })
            
        });


	}

	
}

let adminBoletinesIndex = new AdminBoletinesIndex();
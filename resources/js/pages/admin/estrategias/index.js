class AdminEstrategiasIndex {
	constructor() {
		if ($('#admin-estrategias-index').length > 0) {
			this.init();
		}
	}

	init () {
		moment.locale('es');

		$('#estrategias-table').dataTable({
			language: window.dataTableLanguage,
			order: [[1, 'asc']],
			columns: [
				{
					width: '15%'
				},
				{
					width: '8%'
				},
				{
					width: '38%'
				},
				{
					width: '20%'
				},
				{
					width: '20%'
				}
			]
		});

		$('#estrategias-table .fecha').each(function(index, el) {
			$(el).html(window.moment($(el).html(), "YYYY-MM-DD hh:mm:ss").format('YYYY-MM-DD'));
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
            		window.axios.post('/admin/estrategias/' + $_self.data('recordId'), {
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

let adminEstrategiasIndex = new AdminEstrategiasIndex();
class AdminMiembrosIndex {
	constructor() {
		if ($('#admin-miembros-index').length > 0) {
			this.init();
		}
	}

	deleteRecord() {
		console.log('deleteRecord');
		$('.delete-record').on('click', (e) => {
            const target = e.currentTarget;
			const dataSet = target.dataset;
			const recordId = dataSet.recordId;

            window.Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas eliminar este registro de la base de datos?",
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Eliminar'
            }).then((result) => {
            	if (result.value) {
            		window.axios.post(`/admin/miembros/${recordId}`, {
	                    _method: 'DELETE'
	                }).then((response) => {
	                    window.Swal.fire(
	                        'Eliminado',
	                        'El registro ha sido eliminado',
	                        'success'
	                    ).then(() => {
	                        location.reload();
	                    })
	                }).catch((e) => {
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

	init () {
		moment.locale('es');

		$('#miembros-table').dataTable({
			language: window.dataTableLanguage,
			columns: [
				{
					width: '10%'
				},
				{
					width: '30%'
				},
				{
					width: '30%'
				},
				{
					width: '10%'
				},
				{
					width: '20%'
				}
			],
			order: [[ 3, "desc" ]],
		}).on('draw.dt', () => {
			this.deleteRecord();
		})

		this.deleteRecord();

		$('#miembros-table .fecha').each(function(index, el) {
			$(el).html(window.moment($(el).html(), "YYYY-MM-DD hh:mm:ss").format('LL'));
		});

		


	}

	
}

let adminMiembrosIndex = new AdminMiembrosIndex();
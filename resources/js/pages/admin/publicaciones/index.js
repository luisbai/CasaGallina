class AdminPublicacionesIndex {
	constructor() {
		if ($('#admin-publicaciones-index').length > 0) {
			this.init();
		}
	}

	init () {
		moment.locale('es');

		const publicacionesDT = $('#publicaciones-table').dataTable({
			language: window.dataTableLanguage,
			order: [[1, 'asc']],
			columns: [
				{
					width: '5%'
				},
				{
					width: '5%'
				},
				{
					width: '30%'
				},
				{
					width: '10%'
				},
				{
					width: '5%'
				},
				{
					width: '5%'
				},
				{
					width: '5%'
				},
				{
					width: '15%'
				}
			]
		});

		$('#publicaciones-table .fecha').each(function(index, el) {
			$(el).html(window.moment($(el).html(), "YYYY-MM-DD hh:mm:ss").format('YYYY-MM-DD'));
		});

		// on Draw event
		publicacionesDT.on('draw.dt', function() {
			$('.delete-record').on('click', function(event) {
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
						window.axios.post('/admin/publicaciones/' + $_self.data('recordId'), {
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
		});


	}

	
}

let adminPublicacionesIndex = new AdminPublicacionesIndex();
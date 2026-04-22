class EstrategiaIndex {
	constructor() {
		if ($('#estrategia-index').length > 0) {
			this.init();
		}
	}

	init () {
		let language = $('#language').val();
		
		$('[data-scroll]').on('click', (event) => {
			event.preventDefault();
	    	var section = $(event.currentTarget).attr('href');
	    	let url = '';

	    	if (language == 'es') {
				url = '/' + section;
			} else if (language == 'en') {
				url = '/en' + section;
			}

	    	window.location = section;
		});

		$('.estrategia-slider .slider').slick({
			dots: true,
			infinite: true,
			speed: 500,
			fade: true,
			arrow: true,
			cssEase: 'linear',
			autoplay: true
		});

		moment.locale('es');

		// $('.fecha').each(function(index, el) {
		// 	$(el).html(window.moment($(el).html(), "YYYY-MM-DD").format('LL'));
		// });
	}

	
}

let estrategiaIndex = new EstrategiaIndex();
import $ from "jquery";

class HomeIndex {
	constructor() {
		if ($('#home-index').length > 0) {
			this.init();
		}
	}

	language = $('#language').val();

	setMapa() {
		// Check if Google Maps is loaded
		if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
			console.log('Google Maps not loaded yet, retrying...');
			setTimeout(() => this.setMapa(), 100);
			return;
		}

		let markers = [];

		// Define marker icon styles based on status
		const markerIcons = {
			'activo': '/assets/images/casa/marker-red.png',
			'finalizado': '/assets/images/casa/marker-orange.png'
		};

		// Mexico center coordinates
		const mexico = { lat: 23.340619, lng: -101.865957 };

		console.log('Initializing map with custom styles...');

		// Create the map without mapId to allow custom styling
		const map = new google.maps.Map(document.getElementById('cartografia-map'), {
				zoom: 5,
				center: mexico,
				streetViewControl: false,
				mapTypeId: 'roadmap',
				mapTypeControl: false,
				rotateControl: false,
				fullscreenControl: false,
				styles: [
					{
						"featureType": "all",
						"elementType": "labels",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "all",
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "administrative",
						"elementType": "all",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "landscape.man_made",
						"elementType": "all",
						"stylers": [
							{
								"visibility": "simplified"
							}
						]
					},
					{
						"featureType": "landscape.man_made",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "#e2e1e1"
							}
						]
					},
					{
						"featureType": "landscape.man_made",
						"elementType": "labels",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "landscape.man_made",
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "landscape.natural.landcover",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"color": "#8fbf54"
							},
							{
								"visibility": "on"
							}
						]
					},
					{
						"featureType": "landscape.natural.terrain",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"color": "#8fbf54"
							},
							{
								"visibility": "simplified"
							}
						]
					},
					{
						"featureType": "poi",
						"elementType": "geometry",
						"stylers": [
							{
								"visibility": "simplified"
							}
						]
					},
					{
						"featureType": "poi",
						"elementType": "labels",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "poi.attraction",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "#e2e1e1"
							}
						]
					},
					{
						"featureType": "poi.attraction",
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "poi.business",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "#e2e1e1"
							}
						]
					},
					{
						"featureType": "poi.government",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "#e2e1e1"
							}
						]
					},
					{
						"featureType": "poi.medical",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "#e2e1e1"
							}
						]
					},
					{
						"featureType": "poi.park",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"color": "#cfe1b5"
							},
							{
								"visibility": "simplified"
							}
						]
					},
					{
						"featureType": "poi.place_of_worship",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"color": "#e2e1e1"
							}
						]
					},
					{
						"featureType": "poi.school",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"color": "#e2e1e1"
							}
						]
					},
					{
						"featureType": "poi.sports_complex",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "#b0b0b0"
							}
						]
					},
					{
						"featureType": "road",
						"elementType": "all",
						"stylers": [
							{
								"saturation": -100
							},
							{
								"lightness": 45
							},
							{
								"visibility": "simplified"
							}
						]
					},
					{
						"featureType": "road",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "#ffffff"
							}
						]
					},
					{
						"featureType": "road",
						"elementType": "geometry.stroke",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "road",
						"elementType": "labels",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "road",
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "transit",
						"elementType": "all",
						"stylers": [
							{
								"visibility": "simplified"
							}
						]
					},
					{
						"featureType": "transit.line",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "#ffffff"
							}
						]
					},
					{
						"featureType": "transit.station",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"color": "#323232"
							},
							{
								"visibility": "on"
							}
						]
					},
					{
						"featureType": "transit.station",
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "water",
						"elementType": "all",
						"stylers": [
							{
								"color": "#ffffff"
							},
							{
								"visibility": "on"
							}
						]
					},
					{
						"featureType": "water",
						"elementType": "labels",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					}
				]
			});

		// Adjust zoom for mobile
		if ($(document).width() < 768) {
			map.setZoom(4);
		}

		// Fetch espacios data
		window.axios
			.get('/api/espacios')
			.then((response) => {
				// Create markers for each espacio
				response.data.forEach((espacio, index) => {
					// Create simple marker with custom icon
					const marker = new google.maps.Marker({
						position: {
							lat: parseFloat(espacio.ubicacion_lat),
							lng: parseFloat(espacio.ubicacion_long)
						},
						map: map,
						title: espacio.direccion,
						icon: markerIcons[espacio.status] || markerIcons['activo'],
						index: index,
						status: espacio.status
					});

					// Store marker data
					markers.push({
						espacio_id: espacio.id,
						marker: marker,
						status: espacio.status
					});

					// Add click listener - only send ID to Livewire
					marker.addListener('click', () => {
						// Emit Livewire event with named parameter
						if (window.Livewire) {
							window.Livewire.dispatch('markerSelected', { espacioId: espacio.id });
						}
					});
				});

				// Handle external marker triggers
				$('[data-action="toggle-marker"]').off('click').on('click', function(event) {
					event.preventDefault();
					const espacio_id = $(this).data('espacioId');

					if (window.Livewire) {
						window.Livewire.dispatch('markerSelected', { espacioId: parseInt(espacio_id) });
					}
				});
			});
	}

	init () {
		const language = this.language;

		this.setMapa();
	}


}

let homeIndex = new HomeIndex();

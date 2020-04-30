/* --------------------------------------------
Google Map
-------------------------------------------- */

const trackShipment = (code) => {
	axios.post('/backend/shipment.php', {
		t_code: code
	}).then((response) => {
		console.log(response);
		document.getElementById('loader').style.display = 'none'

	}).catch((err)=>{

		document.getElementById('loader').style.display = 'none'
	})
}
// Initialize and add the map
function initMap() {
	// The location of Uluru
	var uluru = { lat: -25.344, lng: 131.036 };

	var directionServices = new google.maps.DirectionsService;
	var directionDisplay = new google.maps.DirectionsRenderer;
	
	

	var options = {
		zoom: 7,
		center: uluru
	}
	// The map, centered at Uluru
	var map = new google.maps.Map(
		document.getElementById('map-canvas'), options);
	// The marker, positioned at Uluru
	var marker = new google.maps.Marker({ position: uluru, map: map });

	directionDisplay.setMap(map)

	const trackForm = document.getElementById('track-form');
	const code = document.getElementById('tracking-number').value
	trackForm.addEventListener('submit', function(e) {
		document.getElementById('loader').style = 'background-color: "#f00"'
		trackShipment(code)
	})

}

//Calculate route and display on map
function calculateAndShowRoute(directionService, directionDisplay, origin, destination) {
	directionService.route({
		origin: origin,
		destination: destination,
		travelMode: 'DRIVING'
	}, function(response, status){
		if (status == 'OK'){
			directionDisplay.setDirection(response)
		} else{
			window.alert('Direction request Failed due to ' + status)
		}
	})
}

//Function to add custom markers
function addMarker(coords) {
	var marker = new google.maps.Marker({ position: coords, map: map });
}


document.getElementById('map-canvas').style.display = "none"

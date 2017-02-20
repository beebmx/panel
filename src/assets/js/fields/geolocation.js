var Geolocation = function() {
    var geo_options = {}, markers = {}, marker;
    function setMaps(e){
		var location, address,
		    latLng = [], geoField = $(e),
		    input = geoField.find('input.map'),
		    field = geoField.find('input.map').val(),
		    input_search = geoField.find('input.map-search'),
		    button_search = geoField.find('button.map-button'),
		    current = input[0].id;
		
		markers[current] = [];
		geo_options[current] = {
			canvas:					geoField.find('div.map-canvas'),
			field:					geoField.find('input.map'),
			map_geo:                null,
			geocoder:               null,
			defaultLat:				input.data('lat'),
			defaultLng:				input.data('lng'),
			currentLat:				null,
			currentLng:				null,
			defaults: {
				panControl:         false,
				zoomControl:        true,
				zoomControlOptions: true,
				scaleControl:       false,
				mapTypeControl:     false,
				streetViewControl:  false,
				scrollwheel:        false,
				zoom:               input.data('zoom')
			}
		};
		if (geo_options[current].currentLat === null && field){
			latLng = field.split(',');
			geo_options[current].currentLat = latLng[0];
			geo_options[current].currentLng = latLng[1];
			geo_options[current].defaults.zoom = 15;
		}else{
			geo_options[current].currentLat = geo_options[current].defaultLat;
			geo_options[current].currentLng = geo_options[current].defaultLng;
		}
		setGeolocation(current, false, false);
		
		var options = $.extend({}, geo_options[current].defaults, {
		  center: new google.maps.LatLng(geo_options[current].currentLat,geo_options[current].currentLng),
		  minZoom: 3,
		});
		geo_options[current].map_geo = new google.maps.Map(geo_options[current].canvas[0], options);
		location = new google.maps.LatLng(geo_options[current].currentLat, geo_options[current].currentLng);
		geo_options[current].geocoder = new google.maps.Geocoder();
		
		geoAddMarker(current, location);
		
		input_search.on('keypress', function(e) {
			if (e.which === 13) {
			e.preventDefault();
			address = input_search.val();
				if(address === ""){
					input_search.focus();
					return;
				}else{
					geoSearch(current, address);
				}
			}
		});
		
		button_search.on("click", function(e){
			e.preventDefault();
			address = input_search.val();
			if(address === "") {
				input_search.focus();
				return;
			} else {
				geoSearch(current, address);
			}
		});
	}
	
	function getGeolocation(current){
		return (geo_options[current].currentLat, geo_options[current].currentLng);
	}
	
	function setGeolocation(current, lat, lng){
    	var string;
    	if (!lat && ! lng){
		    string = geo_options[current].currentLat + "," + geo_options[current].currentLng;
		} else {
    		string = lat + "," + lng;
		}
		geo_options[current].field.val(string);
	}
	
	function geoAddMarker(current, location){
    	marker = new google.maps.Marker({
			position	:location,
			map			:geo_options[current].map_geo,
			draggable	:true,
			animation	:google.maps.Animation.DROP
		});
		markers[current].push(marker);
		google.maps.event.addListener(marker, 'dragend', function(){
            geoStoreLocation(current, this.getPosition(), false);
		});
	}
	
	function geoStoreLocation(current, location, zoom){
		geo_options[current].map_geo.panTo(location);
		if(zoom){
			geo_options[current].map_geo.setZoom(15);
		}
		setGeolocation(current, location.lat(),location.lng());
	}	
	
	function geoRemoveMarkers(current) {
		for (var i = 0; i < markers[current].length; i++) {
			markers[current][i].setMap(null);
		}
		markers[current] = [];
	}
	
	function geoSearch(current, address) {
		geo_options[current].geocoder.geocode( { 'address': address}, function(results, status) {
			if (status === google.maps.GeocoderStatus.OK) {
				var location = results[0].geometry.location;
				geoRemoveMarkers(current);
				geoAddMarker(current, location);
				geoStoreLocation(current, location, true);
			} else {
				alert('Geocode was not successful for the following reason: ' + status);
			}
		});
	}
    
	function loadGMap(){
    	var API_KEY = $('.map-geolocation').first().data('api');
			var script = document.createElement('script');
				script.type = 'text/javascript';
				script.src = 'https://maps.googleapis.com/maps/api/js?key='+API_KEY+'&' +
	            			 'callback=Geolocation.setMaps';
			document.body.appendChild(script);
	}
    return {
        init: function(){
            if ($('.map-geolocation').length){
                loadGMap();
    		}
        },
        setMaps: function(){
            $('.map-geolocation').each(function(i, e){
                setMaps(e);
            });
        },
        view: function(){
            
        }
    };
}();
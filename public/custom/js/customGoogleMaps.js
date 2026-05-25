var componentForm = {
    postal_code: 'short_name'
};
var isMapUpdate = false;

/**
 * Procesa la respuesta del Google Maps Place API al escribir
 * una direccion.
 */    
function fillInAddress(place) {
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];

        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            addressType = (addressType == 'locality') ? 'city' : addressType;

            $("#"+addressType).val(val).trigger('change');
           
          }
    }
}

function getAddress(position) {
    var geocoder = new google.maps.Geocoder();
    
    // Extract lat/lng from position object
    var lat = typeof position.lat === 'function' ? position.lat() : position.lat;
    var lng = typeof position.lng === 'function' ? position.lng() : position.lng;

    new Promise((resolve, reject) => {
        geocoder
            .geocode({ location: { lat: lat, lng: lng } })
            .then(({ results }) => {
                if (results[0]) {
                    // Set flag to prevent other listeners from overwriting the address
                    isMapUpdate = true;

                    $('#map-lat').val(lat);
                    $('#map-lon').val(lng);
                    $('#map-address').val(results[0].formatted_address);
                    
                    // Temporarily disable the manual edit flag
                    if (typeof isManualAddressEdit !== 'undefined') {
                        window.tempIsManualEdit = isManualAddressEdit;
                        isManualAddressEdit = false;
                    }
                    
                    $('#details-address').val(results[0].formatted_address);
                    
                    fillInAddress(results[0]);

                    // Restore flags after a delay
                    setTimeout(function() {
                        isMapUpdate = false;
                        if (typeof window.tempIsManualEdit !== 'undefined') {
                            isManualAddressEdit = window.tempIsManualEdit;
                        }
                    }, 500);

                    resolve(results[0].formatted_address);
                } else {
                    reject("No results found");
                }
            })
            .catch((e) => reject("Geocoder failed due to: " + e));
    });
}

function getImage(position) {
    var apiKey = window.googleMapsApiKey || '';
    var imageUrl = 'https://maps.googleapis.com/maps/api/staticmap?center='+position.lat+','+position.lng+'&zoom=13&size=600x300&maptype=roadmap&markers=color:red%7Clabel:C%7C'+position.lat+','+position.lng;

    if (apiKey) {
        imageUrl += '&key=' + encodeURIComponent(apiKey);
    }

    $('#map-image').val(imageUrl)
}

function geoCodeAddress(map, geocoder, address, draggableMarker){
    if (!address || address.trim() === '') return;
    
    geocoder.geocode({'address': address}, function(results, status) {
        if (status === 'OK' && results[0]) {
            var location = results[0].geometry.location;
            var locationType = results[0].geometry.location_type;
            
            // Update map center and marker position
            map.setCenter(location);
            draggableMarker.position = location;
            
            // Adjust zoom based on location type and address components
            var zoomLevel = 12; // Default zoom
            
            // Determine zoom based on location precision
            if (locationType === 'ROOFTOP') {
                zoomLevel = 18; // Exact address
            } else if (locationType === 'RANGE_INTERPOLATED') {
                zoomLevel = 17; // Street address
            } else if (locationType === 'GEOMETRIC_CENTER') {
                zoomLevel = 15; // Street or neighborhood
            } else if (locationType === 'APPROXIMATE') {
                // Check address components to refine zoom
                var types = results[0].types;
                if (types.includes('street_address') || types.includes('premise')) {
                    zoomLevel = 10;
                } else if (types.includes('route') || types.includes('neighborhood')) {
                    zoomLevel = 15;
                } else if (types.includes('locality') || types.includes('postal_code')) {
                    zoomLevel = 13;
                } else if (types.includes('administrative_area_level_2')) {
                    zoomLevel = 11;
                } else if (types.includes('administrative_area_level_1')) {
                    zoomLevel = 9;
                } else if (types.includes('country')) {
                    zoomLevel = 6;
                }
            }
            
            map.setZoom(zoomLevel);
            
            // Update hidden fields
            var position = {
                lat: typeof location.lat === 'function' ? location.lat() : location.lat,
                lng: typeof location.lng === 'function' ? location.lng() : location.lng
            };
            
            $('#map-lat').val(position.lat);
            $('#map-lon').val(position.lng);
            $('#map-address').val(results[0].formatted_address);
            getImage(position);
            
            // Set flag to prevent circular updates
            isMapUpdate = true;
            
            // Fill in postal code if available
            fillInAddress(results[0]);
            
            setTimeout(function() {
                isMapUpdate = false;
            }, 500);
        }
    });
}

async function initMap() {
    var { Map } = await google.maps.importLibrary("maps");
    var { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker");

    // Get initial country to set map center
    var initialCountry = $('#country_id option:selected').text() || 'Guatemala';
    var initialAddress = initialCountry;
    
    // Default coordinates (will be updated by geocoding)
    var defaultLat = 14.6210873146291;
    var defaultLng = -90.507504672491;

    var map = new Map(document.getElementById("map"), {
        center: { lat: defaultLat, lng: defaultLng },
        zoom: 12,
        mapId: "DEMO_MAP_ID"
    });

    var pin = new PinElement({
        background: "#8A1E41",
        borderColor: "#D9D9D9",
        glyphColor: "#D9D9D9",
        scale: 2.0
    });

    var draggableMarker = new AdvancedMarkerElement({
        map,
        content: pin.element,
        position: { lat: defaultLat, lng: defaultLng },
        gmpDraggable: true
    });

    var geocoder = new google.maps.Geocoder();
    
    // Initialize map with current address or country
    var currentAddress = $('#details-address').val();
    if (currentAddress && currentAddress.trim() !== '') {
        geoCodeAddress(map, geocoder, currentAddress, draggableMarker);
    } else {
        geoCodeAddress(map, geocoder, initialAddress, draggableMarker);
    }

    // Update fields when marker is dragged
    draggableMarker.addListener("dragend", (event) => {
        getAddress(draggableMarker.position);
        getImage(draggableMarker.position);
    });

    // Debounce timer for address input
    var addressInputTimer;

    // Update map when address input changes (with debounce)
    $('#details-address').on('input', function() {
        var address = $(this).val();
        
        // Clear previous timer
        clearTimeout(addressInputTimer);
        
        // Set new timer - wait 1 second after user stops typing
        addressInputTimer = setTimeout(function() {
            if (address && address.trim() !== '') {
                geoCodeAddress(map, geocoder, address, draggableMarker);
            }
        }, 1000);
    });

    // Update map immediately when field loses focus
    $('#details-address').on('blur', function() {
        clearTimeout(addressInputTimer);
        var address = $(this).val();
        if (address && address.trim() !== '') {
            geoCodeAddress(map, geocoder, address, draggableMarker);
        }
    });

    // Update map when triggered programmatically
    $('#details-address').on('change', function() {
        var address = $(this).val();
        if (address && address.trim() !== '') {
            geoCodeAddress(map, geocoder, address, draggableMarker);
        }
    });
}

// Solo inicializar el mapa si el elemento existe
if (document.getElementById('map')) {
    // Wait for DOM to be fully loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMap);
    } else {
        initMap();
    }
}
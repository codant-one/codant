var componentForm = {
    postal_code: 'short_name'
};

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

    new Promise((resolve, reject) => {
        var loc = position && typeof position.lat === 'function'
            ? { lat: position.lat(), lng: position.lng() }
            : { lat: position.lat, lng: position.lng };
        geocoder
            .geocode({ location: loc })
            .then(({ results }) => {
                if (results[0]) {
                    $('#map-lat').val(loc.lat)
                    $('#map-lon').val(loc.lng)
                    $('#map-address').val(results[0].formatted_address)
                    $('#details-address').val(results[0].formatted_address)

                    // $("#postal_code").val('').trigger('change');
                    fillInAddress(results[0]);

                    resolve(results[0].formatted_address)
                } else {
                    reject("No results found")
                }
            })
            .catch((e) =>reject("Geocoder failed due to: " + e));
    });
}

function getImage(position) {
    var imageUrl = 'https://maps.googleapis.com/maps/api/staticmap?center='+position.lat+','+position.lng+'&zoom=13&size=600x300&maptype=roadmap&markers=color:red%7Clabel:C%7C'+position.lat+','+position.lng+'&key=AIzaSyAlgAB6Fzzvgl9tpwNU3x_gwTeaM79HUqI'
    $('#map-image').val(imageUrl)
}

function geoCodeAddress(map, geocoder, address, draggableMarker){
    geocoder.geocode({'address': address}, function(results, status) {
        // geocoder.geocode({'componentRestrictions':{'country': 'gt', 'postalCode': address}}, function(results, status) {
            if (status === 'OK') {
                fillInAddress(results[0]);
                map.setCenter(results[0].geometry.location);
                draggableMarker.position = {
                    lat: results[0].geometry.location.lat(),
                    lng: results[0].geometry.location.lng()
                }
            } else {
                console.error('Geocoder failed: ' + status);
            }
        });
}

async function initMap() {
    var { Map } = await google.maps.importLibrary("maps");
    var { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker");

    var defaultPosition = { lat: 14.6210873146291, lng: -90.507504672491 };
    var startPosition = defaultPosition;

    try {
        var resp = await fetch('https://ipapi.co/json/');
        if (resp && resp.ok) {
            var data = await resp.json();
            if (data && data.latitude && data.longitude) {
                startPosition = {
                    lat: parseFloat(data.latitude),
                    lng: parseFloat(data.longitude)
                };
            }
        }
    } catch (e) {
        console.warn('IP geolocation failed, using default position', e);
    }

    var map = new Map(document.getElementById("map"), {
        center: startPosition,
        zoom: 17,
        mapId: "DEMO_MAP_ID"
    });
    
    getAddress(startPosition)
    getImage(startPosition)

    var pin = new PinElement({
        background: "#8A1E41",
        borderColor: "#D9D9D9",
        glyphColor: "#D9D9D9",
        scale: 2.0
    });

    var draggableMarker = new AdvancedMarkerElement({
        map,
        content: pin.element,
        position: startPosition,
        gmpDraggable: true
    });

    draggableMarker.addListener("dragend", (event) => {
        getAddress(draggableMarker.position)
        getImage(draggableMarker.position)
    });

    var geocoder = new google.maps.Geocoder();

    function debounce(fn, wait) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() { fn.apply(context, args); }, wait);
        };
    }

    $('#details-address').on('input', debounce(function() {
        var address = $('#details-address').val();
        // $("#postal_code").val('').trigger('change');
        geoCodeAddress(map, geocoder, address, draggableMarker);
    }, 400));

    $('#details-address').on('change', function() {
        var address = $('#details-address').val();
        // $("#postal_code").val('').trigger('change');
        geoCodeAddress(map, geocoder, address, draggableMarker);
    });
}

initMap();
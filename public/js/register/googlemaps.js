function initMap() {
  var map = new google.maps.Map(document.getElementById('map-reg'), {
    center: {lat: 40.416775, lng: -3.703790},
    zoom: 13
  });
  
  var input = document.getElementById('address-reg')
  var autocomplete = new google.maps.places.Autocomplete(input);

  // Bind the map's bounds (viewport) property to the autocomplete object,
  // so that the autocomplete requests use the current map bounds for the
  // bounds option in the request.
  autocomplete.bindTo('bounds', map);

  // Set the data fields to return when the user selects a place.
  autocomplete.setFields(
      ['formatted_address', 'geometry', 'place_id']);

  var infowindow = new google.maps.InfoWindow();
  var infowindowContent = document.getElementById('infowindow-content');
  infowindow.setContent(infowindowContent);
  var marker = new google.maps.Marker({
    map: map,
    anchorPoint: new google.maps.Point(0, -29)
  });

  autocomplete.addListener('place_changed', function() {
    infowindow.close();
    marker.setVisible(false);
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      // User entered the name of a Place that was not suggested and
      // pressed the Enter key, or the Place Details request failed.
      swal.fire({
        title: 'No hay detalles de la ubicacion',
        text:  place.name,
        icon: 'error',
        confirmButtonText: 'Ok'
      });
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);  // Why 17? Because it looks good.
    }
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);

    var place = autocomplete.getPlace();
    // get place_id
    var place_id = place.place_id;
    document.getElementById('place_id').value = place_id; 
    //get formatted_address
    var formatted_address = place.formatted_address;
    document.getElementById('formatted_address').value = formatted_address;
    // get lat
    var lat = place.geometry.location.lat();
    document.getElementById('lat').value = lat;
    // get lng
    var lng = place.geometry.location.lng();
    document.getElementById('lng').value = lng;
      
  });
}

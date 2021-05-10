function initMap() {
    var myLatlng = new google.maps.LatLng($("#lat").val(), $("#lng").val());
    var map = new google.maps.Map(document.getElementById("map"), {
        center: myLatlng,
        zoom: 13,
    });

    var input = document.getElementById("formatted_address");
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.bindTo("bounds", map);

    autocomplete.setFields(["formatted_address", "geometry", "place_id"]);

    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById("infowindow-content");
    infowindow.setContent(infowindowContent);
    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29),
    });

    autocomplete.addListener("place_changed", function () {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            swal.fire({
                title: "No hay detalles de la ubicacion",
                text: place.name,
                icon: "error",
                confirmButtonText: "Ok",
            });

            return;
        }

        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

        var place = autocomplete.getPlace();
        // get place_id
        var place_id = place.place_id;
        document.getElementById("place_id").value = place_id;
        //get formatted_address
        var formatted_address = place.formatted_address;
        document.getElementById("formatted_address").value = formatted_address;
        // get lat
        var lat = place.geometry.location.lat();
        document.getElementById("lat").value = lat;
        // get lng
        var lng = place.geometry.location.lng();
        document.getElementById("lng").value = lng;
    });
}

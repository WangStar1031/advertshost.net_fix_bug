jQuery(document).ready(function(){

  var geocoder;
  var map;
  var marker;

  var geocoder = new google.maps.Geocoder();

  function geocodePosition(pos) {
    geocoder.geocode({
      latLng: pos
    }, function(responses) {
      if (responses && responses.length > 0) {
        updateMarkerAddress(responses[0].formatted_address);
      } else {
        updateMarkerAddress('Cannot determine address at this location.');
      }
    });
  }

  function updateMarkerPosition(latLng) {
    jQuery('#latitude').val(latLng.lat());
    jQuery('#longitude').val(latLng.lng());
  }

  function updateMarkerAddress(str) {
    jQuery('#address').val(str);
  }


  function initialize() {

    var latlng = new google.maps.LatLng(0, 0);
    var mapOptions = {
      zoom: 2,
      center: latlng
    }

    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    geocoder = new google.maps.Geocoder();

    marker = new google.maps.Marker({
      map: map,
      draggable: true
    });

    // Add dragging event listeners.
    google.maps.event.addListener(marker, 'dragstart', function() {
      updateMarkerAddress('Dragging...');
    });
    
    google.maps.event.addListener(marker, 'drag', function() {
      updateMarkerPosition(marker.getPosition());
    });
    
    google.maps.event.addListener(marker, 'dragend', function() {
      geocodePosition(marker.getPosition());
    });

  }

  google.maps.event.addDomListener(window, 'load', initialize);

  jQuery(document).ready(function() { 
           
    initialize();
            
    jQuery(function() {
      jQuery("#address").autocomplete({
        //This bit uses the geocoder to fetch address values
        source: function(request, response) {
          geocoder.geocode( {'address': request.term }, function(results, status) {
            response(jQuery.map(results, function(item) {
              return {
                label:  item.formatted_address,
                value: item.formatted_address,
                latitude: item.geometry.location.lat(),
                longitude: item.geometry.location.lng()
              }
            }));
          })
        },
        //This bit is executed upon selection of an address
        select: function(event, ui) {
          jQuery("#latitude").val(ui.item.latitude);
          jQuery("#longitude").val(ui.item.longitude);

          var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);

          marker.setPosition(location);
          map.setZoom(16);
          map.setCenter(location);

        }
      });
    });
    
    //Add listener to marker for reverse geocoding
    google.maps.event.addListener(marker, 'drag', function() {
      geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {
            jQuery('#address').val(results[0].formatted_address);
            jQuery('#latitude').val(marker.getPosition().lat());
            jQuery('#longitude').val(marker.getPosition().lng());
          }
        }
      });
    });
    
  });

});
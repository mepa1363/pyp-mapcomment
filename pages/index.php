<?php

$title = "  ";

$content = "<div>
<br/>
<h1>Tell us what you do and don't like about your community</h1>
<br/>
<input id='address' type='text' placeholder='Enter an address or click on the map to add your comment' style='width:605px'/>
<input type='button' value='Locate' class='elgg-button elgg-button-action' style='width:100px;height:30px' onclick='codeAddress()'/>
<div><br/></div>
</div>
";

$add_marker = 'mod/pypMapComment/graphics/circle.png';
$add_marker = elgg_normalize_url($add_marker);

$map_js = '/mod/pypMapComment/js/leaflet.js';
$map_js = elgg_normalize_url($map_js);

$map_css = '/mod/pypMapComment/css/leaflet.css';
$map_css = elgg_normalize_url($map_css);

$content .= "
<div id='map' style='height:600px; width:100%'>
<script	type='text/javascript' src='$map_js'></script>
<script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false'></script>
<link type='text/css' rel='stylesheet' href='$map_css'/>
<script type='text/javascript'>
	var map;
 var grey_map = L.tileLayer('http://a.tiles.mapbox.com/v3/planyourplace.glamorgan/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href=http://osm.org/copyright>OpenStreetMap</a> contributors', wax: 'http://a.tiles.mapbox.com/v3/planyourplace.glamorgan.jsonp'});
    var map_options = {center: [51.014, -114.153],
        zoom: 15,
        layers: [grey_map]};
    map = new L.Map('map', map_options);

    var geocoder = new google.maps.Geocoder();

    var _marker_icon = new L.Icon({
    iconUrl: '$add_marker',
    iconSize: [25, 25], // size of the icon
    iconAnchor: [13, 40], // point of the icon which will correspond to marker's location
    shadowAnchor: [13, 40], // the same for the shadow
    popupAnchor: [0, -40] // point from which the popup should open relative to the iconAnchor
});
var map_center = new L.LatLng(51.014, -114.153);
var marker = new L.Marker(map_center, {icon: _marker_icon, draggable: true}).addTo(map).bindPopup('Drag & Report!').openPopup();
$('#coord_id').val('POINT ('+map_center.lng.toString() + ' ' + map_center.lat.toString()+')');

marker.on('drag', function (e) {
    var point = e.target.getLatLng();
    var lat = point.lat;
    var lng = point.lng;
    $('#coord_id').val('POINT ('+lng.toString() + ' ' + lat.toString()+')');
});

marker.on('move', function (e) {
    var point = e.target.getLatLng();
    var lat = point.lat;
    var lng = point.lng;
    $('#coord_id').val('POINT ('+lng.toString() + ' ' + lat.toString()+')');
});
	
function codeAddress() {
    var address = document.getElementById('address').value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {

        map.panTo([results[0].geometry.location.lat(),results[0].geometry.location.lng()]);
        map.setZoom(16);
        marker.setLatLng([results[0].geometry.location.lat(),results[0].geometry.location.lng()]);

      } else {
        $('#result').html('Geocode was not successful for the following reason: ' + status);
      }
    });
  }

  
</script>
</div>
";

$user = elgg_get_logged_in_user_entity();
if (elgg_is_logged_in()) {
    $content_sidebar = elgg_view_form('pypMapComment/save');
    //$content_sidebar = elgg_view_form('pypMapComment/delete');
    $vars = array(
        'content' => $content,
        'sidebar' => $content_sidebar,
        'title' => $title,
        'filter' => false,
    );
    $body = elgg_view_layout('one_sidebar', $vars);
    echo elgg_view_page($title, $body);
} else {
    $content = elgg_view('pypMapComment/pypMapComment');
    $vars = array('content' => $content);
    $body = elgg_view_layout('one_columne', $vars);
    echo elgg_view_page($title, $body);
}

?>
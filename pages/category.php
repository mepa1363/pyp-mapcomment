<?php

$options = array(
    'type' => 'object',
    'subtype' => 'mapobject',
    'limit' => 0
);
$array = elgg_get_entities($options);
$i = 0;
$like = 0;
$dislike = 0;
$entity_like_array = array();
$entity_dislike_array = array();
foreach ($array as $ent) {
    $category_number = $ent->category;
    if ($category_number == 1) {
        $like_coordinate = $ent->coordinate;
        $like_coordinate = substr($like_coordinate, 7);
        $like_coordinate_array = explode(" ", $like_coordinate);
        $longitude = $like_coordinate_array[0];
        $latitude = substr($like_coordinate_array[1], 0, strlen($like_coordinate_array[1]) - 1);
        $coordinate = $longitude . ',' . $latitude;
        $entity_like_array[$like] = array($ent->guid, $coordinate, $category_number);
        $like++;
    } elseif ($category_number == 2) {
        $dislike_coordinate = $ent->coordinate;
        $dislike_coordinate = substr($dislike_coordinate, 7);
        $dislike_coordinate_array = explode(" ", $dislike_coordinate);
        $longitude = $dislike_coordinate_array[0];
        $latitude = substr($dislike_coordinate_array[1], 0, strlen($dislike_coordinate_array[1]) - 1);
        $coordinate = $longitude . ',' . $latitude;
        $entity_dislike_array[$dislike] = array($ent->guid, $coordinate, $category_number);
        $dislike++;
    }
    $i++;
}
//print_r($array);
//for ($i=0; $i<count($array);$i++)
//{
//print_r($array[$i]->guid."--------");
//}
$category = mapobject_get_categories();
$title = "  ";

$longitude = '-114';
$latitude = '51';
$issue_title = '';
$issue_description = '';
$coordinate = $latitude . ',' . $longitude;
$issue = get_input('category');
//print_r($issue);

if ($issue) {
    $issue_entity = get_entity($issue);
    $issue_owner_id = $issue_entity->owner_guid;
    $issue_title = $issue_entity->title;
    $issue_description = $issue_entity->description;
    $issue_coordinate = $issue_entity->coordinate;
    $issue_coordinate = substr($issue_coordinate, 7);
    $issue_coordinate_array = explode(" ", $issue_coordinate);
    $longitude = $issue_coordinate_array[0];
    $latitude = substr($issue_coordinate_array[1], 0, strlen($issue_coordinate_array[1]) - 1);
    $coordinate_issue = $latitude . ',' . $longitude;
    $issue_owner = get_entity($issue_owner_id);
    $issue_owner_name = $issue_owner->name;
    $issue_owner_profile_url = $issue_owner->getURL();
    $issue_owner_image = $issue_owner->getIconURL('small'); //tiny
}

$like_legend_icon = 'mod/pypMapComment/graphics/like_legend.png';
$like_legend_icon = elgg_normalize_url($like_legend_icon);

$dislike_legend_icon = 'mod/pypMapComment/graphics/dislike_legend.png';
$dislike_legend_icon = elgg_normalize_url($dislike_legend_icon);

$content = "<div>
<br/>
<h1>Tell us what you do and don't like about your community</h1>
<br/>
<input id='address' type='text' placeholder='Enter an address or click on the map to add your comment' style='width:605px'/>
<input type='button' value='Locate' class='elgg-button elgg-button-action' style='width:100px;height:30px' onclick='codeAddress()'/>
<div></div>
<img src='$like_legend_icon' style='height:16px; width:16px'/> Likes &nbsp;&nbsp;
<img src='$dislike_legend_icon'  style='height:16px; width:16px'/> Dislikes
</div>
";

$map_js = '/mod/pypMapComment/js/leaflet.js';
$map_js = elgg_normalize_url($map_js);

$cluster_js = '/mod/pypMapComment/js/leaflet.markercluster.js';
$cluster_js = elgg_normalize_url($cluster_js);

$map_css = '/mod/pypMapComment/css/leaflet.css';
$map_css = elgg_normalize_url($map_css);

$cluster_css = '/mod/pypMapComment/css/MarkerCluster.css';
$cluster_css = elgg_normalize_url($cluster_css);

$cluster_css_default = '/mod/pypMapComment/css/MarkerCluster.Default.css';
$cluster_css_default = elgg_normalize_url($cluster_css_default);

$content .= "<div id='map' style='height:600px; width:100%'>
<script type='text/javascript' src='$map_js'></script>
<script	type='text/javascript' src='$cluster_js'></script>
<script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false'></script>
<link type='text/css' rel='stylesheet' href='$map_css'/>
<link type='text/css' rel='stylesheet' href='$cluster_css'/>
<link type='text/css' rel='stylesheet' href='$cluster_css_default'/>
<script type='text/javascript'>
	var map;
 var grey_map = L.tileLayer('http://a.tiles.mapbox.com/v3/planyourplace.glamorgan/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href=http://osm.org/copyright>OpenStreetMap</a> contributors',
        wax: 'http://a.tiles.mapbox.com/v3/planyourplace.glamorgan.jsonp'});
    var map_options = {center: [51.014, -114.153],
        zoom: 15,
        minZoom:13,
        layers: [grey_map]};
    map = new L.Map('map', map_options);

    var southWest = new L.LatLng(51, -114.187),
    northEast = new L.LatLng(51.0345, -114.118),
    bounds = new L.LatLngBounds(southWest, northEast);
    map.setMaxBounds(bounds);

var geocoder = new google.maps.Geocoder();

";

$base_url = 'pypMapComment/category/';
$base_url = elgg_normalize_url($base_url);

$dislike_pointList_json = '{"type": "FeatureCollection", "features": [';
for ($i = 0; $i < count($entity_dislike_array); $i++) {
    $coord = $entity_dislike_array[$i][1];
    $guid = $entity_dislike_array[$i][0];
    $url_dislike = $base_url . $guid;
    $dislike_pointList_json .= '{"type": "Feature","geometry": {"type": "Point", "coordinates":[' . $coord . ']}, "properties": {"url": "' . $url_dislike . '", "icon": "' . $dislike_legend_icon . '",}},';
}
$dislike_pointList_json = substr($dislike_pointList_json, 0, -1);
$dislike_pointList_json .= ']}';
//print_r($dislike_pointList_json);


$like_pointList_json = '{"type": "FeatureCollection", "features": [';
for ($i = 0; $i < count($entity_like_array); $i++) {
    $coord = $entity_like_array[$i][1];
    $guid = $entity_like_array[$i][0];
    $url_like = $base_url . $guid;
    $like_pointList_json .= '{"type": "Feature","geometry": {"type": "Point", "coordinates":[' . $coord . ']}, "properties": {"url": "' . $url_like . '", "icon": "' . $like_legend_icon . '",}},';
}
$like_pointList_json = substr($like_pointList_json, 0, -1);
$like_pointList_json .= ']}';

$content .= "

var dislike_overlay = show_markers($dislike_pointList_json, 'dislike');
map.addLayer(dislike_overlay);

var like_overlay = show_markers($like_pointList_json, 'like');
map.addLayer(like_overlay);

function show_markers(_data, _type) {
    var _markers = new L.MarkerClusterGroup({iconCreateFunction: function (cluster) {
				var childCount = cluster.getChildCount();
                var c = ' marker-cluster-'+_type;
                return new L.DivIcon({ html: '<div><span>' + childCount + '</span></div>', className: 'marker-cluster' + c, iconSize: new L.Point(40, 40)});
			    },
                showCoverageOnHover: false});
    var geoJsonLayer = L.geoJson(_data,
    {
        onEachFeature: function (feature, layer) {
            setGeoJsonFeatureIcon(feature, layer);
        }
    }
    );
    _markers.addLayer(geoJsonLayer);
    return _markers;
}

function setGeoJsonFeatureIcon(feature, layer) {
    if (feature.properties && feature.properties.icon) {
        layer.setIcon(new L.Icon({
            iconUrl: feature.properties.icon,
            iconSize: [20, 20],
            iconAnchor: [10, 0], // point of the icon which will correspond to marker's location
            popupAnchor: [0, 0] // point from which the popup should open relative to the iconAnchor
        }));
    }

    layer.on('click', function(){window.location = feature.properties.url;});
}

function codeAddress() {
    var address = document.getElementById('address').value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {

        map.panTo([results[0].geometry.location.lat(),results[0].geometry.location.lng()]);
        map.setZoom(16);

      } else {
        $('#result').html('Geocode was not successful for the following reason: ' + status);
      }
    });
  }


";


if ($issue) {
    $content .= "
    map.panTo(new L.LatLng($coordinate_issue));
    map.setZoom(18);";
}
$content .= "
    </script>
</div>";

// create the sidebar
$vars = array('category' => $category);
$sidebar = elgg_view('pypMapComment/sidebar_list', $var);

if ($issue) {
    $categoty_url = 'pypMapComment/category';
    $categoty_url = elgg_normalize_url($categoty_url);

    $sidebar = "<div style='border-bottom: 1px solid #cccccc;margin-bottom: 5px;'><h4><a href='$categoty_url'>Back to Comments...</a></h4></div>";

    $sidebar .= "<div style='margin-top: 10px;'>
	<div class='class=elgg-avatar elgg-avatar-small'>
		<a href='$issue_owner_profile_url'><img src='$issue_owner_image' /></a>
	</div>
	<div style='margin-left:50px;margin-top:-40px'>
		<a href='$issue_owner_profile_url' style='display:block'>$issue_owner_name</a>
			
		<h3>$issue_title</h3>
		</div>
		<br />
		$issue_description
	</div>";
    $sidebar .= elgg_view_comments($issue_entity);
}

$params = array(
    'content' => $content,
    'sidebar' => $sidebar,
    'title' => $title,
    'filter' => false,
);
$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($title, $body);
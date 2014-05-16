<?php

$js_popup = 'mod/pypMapComment/js/popup.js';
$js_popup = elgg_normalize_url($js_popup);

$css_popup = 'mod/pypMapComment/css/popup.css';
$css_popup = elgg_normalize_url($css_popup);

$map_js = '/mod/pypMapComment/js/leaflet.js';
$map_js = elgg_normalize_url($map_js);

$map_css = '/mod/pypMapComment/css/leaflet.css';
$map_css = elgg_normalize_url($map_css);
?>
<link rel='stylesheet' type='text/css' href='<?php echo $map_css?>'/>
<link rel="stylesheet" href="<?php echo $css_popup ?>"/>
<script type='text/javascript' src='<?php echo $map_js ?>'></script>
<script type="text/javascript" src="<?php echo $js_popup ?>"></script>


<div>
    <br/>

    <h1>Tell us what you do and don't like about your community</h1>
    <br/>
    <input type='text' placeholder='Enter an address or click on the map to add your comment' style='width:885px'/>
    <input type='button' value='Locate' class='elgg-button elgg-button-action' style='width:100px;height:30px'/>

    <div><br/></div>
</div>
<div id='map' style='height:600px; width:100%'>
    <script type='text/javascript'>
        var map;
        var grey_map = L.tileLayer('http://a.tiles.mapbox.com/v3/planyourplace.glamorgan/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            wax: 'http://a.tiles.mapbox.com/v3/planyourplace.glamorgan.jsonp'});
        var map_options = {center: [51.014, -114.153],
            zoom: 15,
            layers: [grey_map]};
        map = new L.Map('map', map_options);


    </script>
</div>


<div id="blanket" style="display:none;"></div>
<div id="popUpDiv" style="display:none;">
    <!--<a href="#" onclick="popup('popUpDiv')">Close</a>-->
    <div id="loginBox">
        <?php
        $title = elgg_echo('login');
        $body = elgg_view_form('login', array('action' => "{$login_url}action/login"), array('returntoreferer' => TRUE));
        echo elgg_view_module($module, $title, $body);
        ?>
    </div>
</div>

<?php
if (!elgg_is_logged_in()) {

    //system_message('You should register first!');
    echo "<script type='text/javascript'>popup('popUpDiv');</script>";
}
?>

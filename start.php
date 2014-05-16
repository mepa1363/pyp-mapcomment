<?php

elgg_register_event_handler('init', 'system','pypMapComment_init');
function pypMapComment_init() {
	elgg_register_page_handler('pypMapComment', 'pypMapComment_page_handler');
	$item = new ElggMenuItem('pypMapComment', 'MapComment', 'pypMapComment');
	elgg_register_menu_item('site', $item);	
	// register the save and delete actions for admins only
	$base = elgg_get_plugins_path(). 'pypMapComment/actions';
	elgg_register_action("pypMapComment/save", "$base/save.php", "public");//alternatives: admin, logged_in
	elgg_register_action("pypMapComment/delete", "$base/delete.php", "public");
	// //make sure our library of PHP functions is available
	$lib = elgg_get_plugins_path() . 'pypMapComment/lib/pypMapComment.php';
	elgg_register_library('pypMapComment', $lib);
	elgg_load_library('pypMapComment');
	elgg_extend_view('css/elgg', 'pypMapComment/css');
	
}
function pypMapComment_page_handler($page, $identifier) {
	$plugin_path = elgg_get_plugins_path();
	$base_path = $plugin_path . 'pypMapComment/pages/';
	//require "$base_path/index.php";
	
	if (count($page) == 0) {
		$page[0] = 'category';
	}

	switch ($page[0]) {
		// help/category/<category>
		case 'category':
			set_input('category', $page[1]);
			require "$base_path/category.php";
			break;
		// index page or unknown requests
		case 'index':
			require "$base_path/index.php";
			break;
		// unrecognized help page so we don't handle it
		default:
			return false;
			break;
	}
	
	return true;
}

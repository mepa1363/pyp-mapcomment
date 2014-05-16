<?php
/**
 * mapobject function library
 */

/**
 * Save a mapobject topic
 *
 * @param string $question  Text for the question
 * @param string $answer    Text for the answer including any HTML
 * @param string $category  Category string as defined in mapobject_get_categories()
 * @param int    $access_id See ACCESS* defines
 * @param int    $guid      GUID of the previously saved mapobject topic
 * @return bool
 */
function mapobject_save_topic($question, $answer, $category, $access_id, $coordinate, $guid = 0) {
	if ($guid) {
		$mapobject = get_entity($guid);
		if (!$mapobject) {
			return FALSE;
		}
	} else {
		$mapobject = new ElggObject();
		$mapobject->subtype = 'mapobject';
	}
	
	$mapobject->title = $question;
	$mapobject->description = $answer;
	$mapobject->category = $category;
	$mapobject->access_id = $access_id;
	$mapobject->coordinate = $coordinate;
	
	$guid = $mapobject->save();
	if (!$guid) {
		return false;
	}

	return true;
}

/**
 * Get an array of categories.
 *
 * Array is of the form code => title
 *
 * @return array
 */
function mapobject_get_categories() {
	$codes = array(
		'1',
		'2',
	);
	$categories = array();
	foreach ($codes as $code) {
		$categories[$code] = elgg_echo("help:title:$code");
	}

	return $categories;
}

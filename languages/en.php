<?php
/**
 * Help language file
 */

$english = array(
	// titles
	'help:admin' => 'Help',
	'help:categories' => 'Help Categories',

	// menu items and instructions
	'help:admin:instruct' => "",
	'help:back' => "Back to help categories",
	'help:topics' => "Topics",

	// category titles
	'help:title:1' => 'Like',
	'help:title:2' => 'Dislike',
	

	// category blurbs
	'help:blurb:1' => 'Like',
	'help:blurb:2' => 'Dislike',

	// form
	'help:label:category' => 'Category',
	'help:label:issue' => 'Title',
	'help:label:description' => 'Description',
	'help:label:coordinate' => 'Coordinate',

	// status messages
	'help:status:deletequestion' => 'The help topic was deleted.',
	'help:error:nodelete' => 'Unable to delete help topic.',
	
	'mapobject:status:save' => 'The topic was saved.',
	'mapobject:error:nosave' => 'Unable to save the topic. You may need to fill out all the fields.',

	// Elgg's generic name for this object type
	'item:object:help' => 'Help topic',
);

add_translation("en", $english);

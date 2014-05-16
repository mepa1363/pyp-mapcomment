<?php
/**
 * Delete a topic
 */

// get the GUID
//$guid = get_input('guid');

// delete the object if we can get it
// $topic1 = get_entity('225');
 //$topic2 = get_entity('224');
 //$topic1->delete();
 //$topic2->delete();

$array = elgg_get_entities(array('type' => 'object', 'subtype' => 'mapobject'));
$i = 0;
foreach ($array as $ent)
{
 $ent->delete();
 $i++;
}

// if ($topic) {
	// $topic->delete();
	// system_message(elgg_echo('help:status:deletequestion'));
// } else {
	// register_error(elgg_echo('help:error:nodelete'));
// }

// send back to the same page
forward(REFERER);
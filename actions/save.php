<?php
/**
 * Save a topic
 */

// get the form values
$category = get_input('category');
$question = get_input('question');
$answer = get_input('answer');
$access_id = get_input('access_id');
$coordinate = get_input('coordinate');

// if editing, we will have a guid
$guid = get_input('guid', 0);
if ($category && $question && $answer && $coordinate)
{
	// save the question and queue status message
	$result = mapobject_save_topic($question, $answer, $category, $access_id, $coordinate, $guid);
}
if (!$result) {
	register_error(elgg_echo('mapobject:error:nosave'));
} else {
	system_message(elgg_echo('mapobject:status:save'));
}

forward(REFERER);

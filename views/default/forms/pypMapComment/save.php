<?php

// set default values for form
$category = '';
$question = '';
$answer = '';
$coordinate = '';
$access_id = ACCESS_DEFAULT; // pick up default access of site/user

// if we are editing, the GUID is sent to us
$guid = get_input('guid', 0);
$topic = get_entity($guid);
if ($topic) {
	$category = $topic->category;
	$question = $topic->title;
	$answer = $topic->description;
	$access_id = $topic->access_id;
	$coordinate = $topic->coordinate;
}

$category_label = elgg_echo('help:label:category');
$categories = mapobject_get_categories();
$category_input = elgg_view('input/radio', array(
	'name' => 'category',
	'align' => 'horizontal',
	//'value' => $category,
	'options' => array($categories[1] => '1', $categories[2] => '2'),
));

$question_label = elgg_echo('help:label:issue');
$question_input = elgg_view('input/text', array(
	'id' => 'title',
	'name' => 'question',
	'value' => $question,
	'placeholder'=>'Give your comment a title...',
));

$answer_label = elgg_echo('help:label:description');
$answer_input = elgg_view('input/plaintext', array(
	'name' => 'answer',
	'value' => $answer,
	'placeholder' => 'Describe your comment here...'
));

$coordinate_label = elgg_echo('help:label:coordinate');
$coordinate_input = elgg_view('input/text', array(
	'name' => 'coordinate',
	'value' => $coordinate,
	'id' => 'coord_id',
));

$access_label = elgg_echo('access');
$access_input = elgg_view('input/access', array(
	'name' => 'access_id',
	'value' => $access_id,
));

$button = elgg_view('input/submit', array(
	'value' => elgg_echo('save'),
	'class' => 'elgg-button elgg-button-action',
	'style' => 'height: 25px;'
));

$user = elgg_get_logged_in_user_entity();
$user_name = $user->name;
$user_profile_url = $user->getURL();
$user_image = $user->getIconURL('small');

//print_r($user_name.$user_profile_url.$user_image);

$base_url = 'pypMapComment/category';
$base_url = elgg_normalize_url($base_url);

echo "<div style='border-bottom: 1px solid #cccccc;margin-bottom: 5px;'><h4><a href='$base_url'>View Comments...</a><h4></div>";

echo "<div class='sidebar_form_content'>";
echo <<<HTML

<div style='margin-top: 10px;'>
<div class='class=elgg-avatar elgg-avatar-tiny'>
	<a href='$user_profile_url'><img src='$user_image' /></a>
</div>
<div style='margin-left:30px;margin-top:-35px'>
	<a href='$user_profile_url' style='font-size:10px'>$user_name</a>
	<h4>Add New Comment</h4>
</div>
</div>
<br />

<div>
	<label>$question_label</label><br />
	$question_input
</div>

<div>
	<label>$answer_label</label>
	$answer_input
</div>
<br />
<div>
	<!--<label>$category_label</label><br />-->
	$category_input
</div>

<br />
<div class="elgg-foot">
	$button
</div>

<div style='visibility:hidden'>
	<label>$coordinate_label</label>
	$coordinate_input
</div>

<div style='visibility:hidden'>
	<label>$access_label</label><br />
	$access_input
</div>
HTML;
echo "</div>";

// if editing we need GUID to save this correctly
echo elgg_view('input/hidden', array(
	'name' => 'guid',
	'value' => $guid,
));

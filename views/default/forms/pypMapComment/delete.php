<?php
/**
 * help/save form body
 *
 */

$button = elgg_view('input/submit', array('value' => elgg_echo('delete')));

$base_url = 'pypMapComment/category';
$base_url = elgg_normalize_url($base_url);

echo "<div class='sidebar_form_content'>";
echo <<<HTML

<div>
	<h4>Delete Comments</h4>
</div>
<hr/>

<br />
<div class="elgg-foot">
	$button
</div>
<br />
<div>
	<h4><a href="$base_url">View Comments</a><h4>
</div>
HTML;
echo "</div>";

// if editing we need GUID to save this correctly
echo elgg_view('input/hidden', array(
	'name' => 'guid',
	'value' => $guid,
));

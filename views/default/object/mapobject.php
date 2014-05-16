<?php
/**
 * Entity view for a topic
 * Type: object Subtype: mapobject
 *
 * @uses $vars['entity'] ElggObject
 */

$item = $vars['entity'];
$title = $item->title;
$description = $item->description;
$coordinate = $item->coordinate;
$category = $item->category;



// full view means we display the question and answer
if ($vars['full_view']) {
	$body = elgg_view('output/longtext', array(
		'value' => $description,//.$coordinate,
		'class' => 'mtn',
	));

	echo <<<HTML
<div class="mbl" id="$item->guid">
	$menu
	<h2>$title</h2>
	$body
</div>

HTML;

//$entity_array[$i] = array($ent->title,$ent->description,$ent->coordinate);
echo elgg_view_comments($item);


} else {
	// summary view is just a link
	//$url = "pypMapComment/category/$item->category#$item->guid";
	$url = "pypMapComment/category/$item->guid";
	echo elgg_view('output/url', array(
		'href' => $url,
		'text' => $title,
		'is_trusted' => true,
	));
}

?>


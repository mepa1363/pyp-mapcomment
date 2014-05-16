<?php
/**
 * List of all categories, rectangles
 */

$categories = mapobject_get_categories();

// create unorder list that we mark-up with CSS
echo "<ul class='help-categories'>";
foreach ($categories as $code => $title) {
	$blurb = elgg_echo("help:blurb:$code");

	// the output/url takes care of creating the full URL
	$url = "pypMapComment/category/$code";

	$text = "<h4>$title</h4><span>$blurb</span>";
	$link = elgg_view('output/url', array(
		'href' => $url,
		'text' => $text,
		'class' => 'help-category',
		'is_trusted' => true,
	));

	echo "<li>$link</li>";
}
echo "</ul>";

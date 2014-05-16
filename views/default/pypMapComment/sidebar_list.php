<?php
/**
 * Sidebar for a category's topics
 *
 * @uses $vars['category']
 */

$category = $vars['category'];
//$category = array('1','2');

$base_url = 'pypMapComment/index';
$base_url = elgg_normalize_url($base_url);

echo "<div style='border-bottom: 1px solid #cccccc;margin-bottom: 5px;'><h4><a href='$base_url'>Add New Comment...</a></h4></div>";
//echo "<div class='elgg-menu-page'><h4><a href='$base_url'>Add New Comment...</a></h4></div>";

$heading = elgg_echo('help:topics');

$options = array(
	'type' => 'object',
	'subtype' => 'mapobject',
	'metadata_name' => 'category',
	'metadata_value' => $category,
	'limit' => 10,
	'full_view' => false,
	'list_class' => 'issue-list',
);

//$body = elgg_view_form('pypMapComment/save');

$body = elgg_list_entities_from_metadata($options);

echo elgg_view_module('aside', $heading, $body);
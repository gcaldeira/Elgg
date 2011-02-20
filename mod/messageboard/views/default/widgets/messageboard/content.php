<?php
/**
 * Elgg messageboard widget view
 *
 *
 * @package ElggMessageBoard
 */

$owner = elgg_get_page_owner_entity();
$num_display = 5;

if (isset($vars['entity']->num_display)) {
	$num_display = $vars['entity']->num_display;
}

if (elgg_is_logged_in()) {
	echo elgg_view_form('messageboard/add', array('name' => 'elgg-messageboard'));
}

$options = array(
	'annotations_name' => 'messageboard',
	'guid' => $owner->getGUID(),
	'limit' => $num_display,
	'pagination' => false,
	'reverse_order_by' => true
);

echo elgg_list_annotations($options);

if ($owner instanceof ElggGroup) {
	$url = "pg/messageboard/group/$owner->guid/owner";
} else {
	$url = "pg/messageboard/owner/$owner->username";
}

echo elgg_view('output/url', array(
	'href' => $url,
	'text' => elgg_echo('messageboard:viewall')
));
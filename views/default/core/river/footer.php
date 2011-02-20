<?php
/**
 * River item footer
 */

$item = $vars['item'];
$object = $item->getObjectEntity();

// annotations do not have comments
if ($item->annotation_id != 0 || !$object) {
	return true;
}

$comment_count = $object->countComments();

$options = array(
	'guid' => $object->getGUID(),
	'annotation_name' => 'generic_comment',
	'limit' => 3,
	'order_by' => 'n_table.time_created desc'
);
$comments = elgg_get_annotations($options);

if ($comments) {
	// why is this reversing it? because we're asking for the 3 latest
	// comments by sorting desc and limiting by 3, but we want to display
	// these comments with the latest at the bottom.
	$comments = array_reverse($comments);

?>
	<span class="elgg-river-comments-tab"><?php echo elgg_echo('comments'); ?></span>

<?php

	echo elgg_view_annotation_list($comments, array('list_class' => 'elgg-river-comments'));

	if ($comment_count > count($comments)) {
		$num_more_comments = $comment_count - count($comments);
		$url = $object->getURL();
		$params = array(
			'href' => $url,
			'text' => elgg_echo('river:comments:more', array($num_more_comments)),
		);
		$link = elgg_view('output/url', $params);
		echo "<div class=\"elgg-river-more\">$link</div>";
	}
}

// inline comment form
echo elgg_view_form('comments/inline', array(
	'action' => 'action/comments/add',
	'id' => "elgg-togglee-{$object->getGUID()}",
), array('entity' => $object));
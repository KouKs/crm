<?php
/**
 * Functions file
 */

/**
 * Parsin URI data
 */
$orderby = @$_GET['orderby'] ? $_GET['orderby'] : '';
$order = @$_GET['order'] ? $_GET['order'] : '';

/**
 * Gettings posts
 */
$loop = new WP_Query([
	'post_type' => 'client',
	'orderby' => $orderby,
	'order' => $order,
]);

/**
 * Helper array to reverse sorting directions
 */
$reverse = [ 'asc' => 'desc', 'desc' => 'asc' ];
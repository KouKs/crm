<?php
/**
 * Functions file
 */

/**
 * Parsin URI data
 */
$order_meta_key = @$_GET['orderby'] ? $_GET['orderby'] : '';
$order = @$_GET['order'] ? $_GET['order'] : '';

$search = @$_GET['s'] ? $_GET['s'] : '';
$column = @$_GET['column'] ? $_GET['column'] : '';

/**
 * Helper function to assign order url
 *
 * @param $column Name of column to be ordered by
 */
function get_order_url($column) {

	global $order, $order_meta_key;

	$reverse = [ 'asc' => 'desc', 'desc' => 'asc' ];

	return esc_url(add_query_arg([ 'orderby' => $column, 'order' => $order_meta_key == $column ? $reverse[strtolower($order)] : 'asc'], $_SERVER['REQUEST_URI']));
}

/**
 * Helper function to assign css class
 *
 * @param $column Name of column to be ordered by
 */
function get_order_class($column) {

	global $order, $order_meta_key;
	
	return $order_meta_key == $column ? esc_html(strtolower($order)) : 'none';
}

/**
 * Editing query for custom searches
 */
add_filter('posts_clauses', function($clauses) use($search, $column) {

    global $wpdb;

    if (!is_search() || is_admin() || empty($search))
    	return $clauses;

    $clauses['where'] = $clauses['where'] . " AND (wp_posts.post_type = 'client' AND postmeta.meta_key = '{$column}' AND postmeta.meta_value REGEXP '{$search}')";

    $clauses['join'] = $clauses['join'] . " INNER JOIN {$wpdb->postmeta} AS postmeta ON ({$wpdb->posts}.ID = postmeta.post_id)";

    return $clauses;

});

/**
 * Editing query for custom post type
 */
add_action('pre_get_posts', function ($query) use($order, $order_meta_key) {

	if (is_admin())
		return $query;

	if($order_meta_key == 'post_date') {

		$query->query_vars =  [
			'orderby' 			=> 'date',
			'order' 			=> $order,
			'posts_per_page' 	=> 5,
			'paged'				=> get_query_var('paged') ? get_query_var('paged') : 1,
		];

	} else {

		$query->query_vars =  [
			'meta_key' 			=> $order_meta_key,
			'orderby' 			=> 'meta_value',
			'order' 			=> $order,
			'posts_per_page' 	=> 5,
			'paged'				=> get_query_var('paged') ? get_query_var('paged') : 1,
			'meta_query'		=> [
				'key' => $order_meta_key
			],
		];

	}

	if ($query->is_main_query())
		$query->set('post_type', 'client');

	return $query;
});
<?php

/**
 * Registers the `easel_series` taxonomy,
 * for use with 'easel_work'.
 */
function easel_series_init() {
	register_taxonomy( 'easel_series', array( 'easel_work' ), array(
		'hierarchical'      => false,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'			=> 'series',
		),
		'capabilities'      => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts',
		),
		'labels'            => array(
			'name'                       => __( 'Work Series', 'easel' ),
			'singular_name'              => _x( 'Work Series', 'taxonomy general name', 'easel' ),
			'search_items'               => __( 'Search Work Series', 'easel' ),
			'popular_items'              => __( 'Popular Work Series', 'easel' ),
			'all_items'                  => __( 'All Work Series', 'easel' ),
			'parent_item'                => __( 'Parent Work Series', 'easel' ),
			'parent_item_colon'          => __( 'Parent Work Series:', 'easel' ),
			'edit_item'                  => __( 'Edit Work Series', 'easel' ),
			'update_item'                => __( 'Update Work Series', 'easel' ),
			'view_item'                  => __( 'View Work Series', 'easel' ),
			'add_new_item'               => __( 'New Work Series', 'easel' ),
			'new_item_name'              => __( 'New Work Series', 'easel' ),
			'separate_items_with_commas' => __( 'Separate Work Series with commas', 'easel' ),
			'add_or_remove_items'        => __( 'Add or remove Work Series', 'easel' ),
			'choose_from_most_used'      => __( 'Choose from the most used Work Series', 'easel' ),
			'not_found'                  => __( 'No Work Series found.', 'easel' ),
			'no_terms'                   => __( 'No Work Series', 'easel' ),
			'menu_name'                  => __( 'Work Series', 'easel' ),
			'items_list_navigation'      => __( 'Work Series list navigation', 'easel' ),
			'items_list'                 => __( 'Work Series list', 'easel' ),
			'most_used'                  => _x( 'Most Used', 'easel_series', 'easel' ),
			'back_to_items'              => __( '&larr; Back to Work Series', 'easel' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'easel_series',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'easel_series_init' );

/**
 * Sets the post updated messages for the `easel_series` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `easel_series` taxonomy.
 */
function easel_series_updated_messages( $messages ) {

	$messages['easel_series'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Work Series added.', 'easel' ),
		2 => __( 'Work Series deleted.', 'easel' ),
		3 => __( 'Work Series updated.', 'easel' ),
		4 => __( 'Work Series not added.', 'easel' ),
		5 => __( 'Work Series not updated.', 'easel' ),
		6 => __( 'Work Series deleted.', 'easel' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'easel_series_updated_messages' );

function load_easel_series_template($template) {
    // If 'taxonomy-easel_series.php' file in the user's theme doesn't exist, load it from the plugin directory.
    if ( ! $template ) {
        $template = plugin_dir_path( __FILE__ ) . '/templates/taxonomy-easel_series.php';
    }

    return $template;
}
add_filter('taxonomy-easel_series_template', 'load_easel_series_template');

<?php

/**
 * Registers the `easel_medium` taxonomy,
 * for use with 'easel_work'.
 */
function easel_medium_init() {
	register_taxonomy( 'easel_medium', array( 'easel_work' ), array(
		'hierarchical'      => false,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'			=> 'medium',
		),
		'capabilities'      => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts',
		),
		'labels'            => array(
			'name'                       => __( 'Media', 'easel' ),
			'singular_name'              => _x( 'Medium', 'taxonomy general name', 'easel' ),
			'search_items'               => __( 'Search Media', 'easel' ),
			'popular_items'              => __( 'Popular Media', 'easel' ),
			'all_items'                  => __( 'All Media', 'easel' ),
			'parent_item'                => __( 'Parent Medium', 'easel' ),
			'parent_item_colon'          => __( 'Parent Medium:', 'easel' ),
			'edit_item'                  => __( 'Edit Medium', 'easel' ),
			'update_item'                => __( 'Update Medium', 'easel' ),
			'view_item'                  => __( 'View Medium', 'easel' ),
			'add_new_item'               => __( 'New Medium', 'easel' ),
			'new_item_name'              => __( 'New Medium', 'easel' ),
			'separate_items_with_commas' => __( 'Separate Media with commas', 'easel' ),
			'add_or_remove_items'        => __( 'Add or remove Media', 'easel' ),
			'choose_from_most_used'      => __( 'Choose from the most used Media', 'easel' ),
			'not_found'                  => __( 'No Media found.', 'easel' ),
			'no_terms'                   => __( 'No Media', 'easel' ),
			'menu_name'                  => __( 'Media', 'easel' ),
			'items_list_navigation'      => __( 'Media list navigation', 'easel' ),
			'items_list'                 => __( 'Media list', 'easel' ),
			'most_used'                  => _x( 'Most Used', 'easel_medium', 'easel' ),
			'back_to_items'              => __( '&larr; Back to Media', 'easel' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'easel_medium',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'easel_medium_init' );

/**
 * Sets the post updated messages for the `easel_medium` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `easel_medium` taxonomy.
 */
function easel_medium_updated_messages( $messages ) {

	$messages['easel_medium'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Medium added.', 'easel' ),
		2 => __( 'Medium deleted.', 'easel' ),
		3 => __( 'Medium updated.', 'easel' ),
		4 => __( 'Medium not added.', 'easel' ),
		5 => __( 'Medium not updated.', 'easel' ),
		6 => __( 'Media deleted.', 'easel' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'easel_medium_updated_messages' );

function load_easel_medium_template($template) {
    // If 'taxonomy-easel_medium.php' file in the user's theme doesn't exist, load it from the plugin directory.
    if ( ! $template ) {
        $template = plugin_dir_path( __FILE__ ) . '/templates/taxonomy-easel_medium.php';
    }

    return $template;
}
add_filter('taxonomy-easel_medium_template', 'load_easel_medium_template');

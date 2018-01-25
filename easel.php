<?php
/*
Plugin Name:  Easel
Plugin URI:   https://github.com/nyergler/easel
Description:  Opinionated portfolio management for artists
Version:      20180124
Author:       Nathan Yergler
Author URI:   https://yergler.net
License:      GPL3
License URI:  https://www.gnu.org/licenses/gpl-3.0.html
Text Domain:  easel
Domain Path:  /languages
*/

function easel_setup_post_type() {
    register_post_type(
        'easel-work',
        [
            'label' => 'Easel Works',
            'description' => 'Artistic works managed via Easel',
            'public' => 'true',
            'show_in_rest' => 'true',
            'register_meta_box_cb' => 'easel_setup_meta_box',
            'has_archive' => 'true',
            'capabilities'
            'supports'
            'taxonomies'
        ]
    );

    register_taxonomy(
        'easel-medium',
        'easel-work',
        [
            'public' => 'true',
            'meta_box_cb'
            'show_in_rest'
            'description'
            'labels'
            'rewrite'
        ]
    );
}
add_action( 'init', 'easel_setup_post_type' );

function easel_install() {
    easel_setup_post_type();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'easel_install' );


function easel_deactivation() {
    unregister_post_type( 'easel-work' );
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'easel_deactivation' );

function easel_setup_meta_box() {

}

function eazel_enqueue_styles() {

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    if ( is_post_type_archive( 'easel-work' ) || is_tax( 'easel-medium' ) || is_tax( 'easel-series' ) ) {
        wp_enqueue_style( 'eazel-style',
            get_stylesheet_directory_uri() . '/style.css'
        );
    }
}
add_action( 'wp_enqueue_scripts', 'eazel_enqueue_styles' );

// function eazel_post_formats(){
//     add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'status', 'image', 'quote' ) );
// }
// add_action( 'after_setup_theme', 'eazel_post_formats', 11 );

function eazel_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'prints', array(
        'title' => __( 'Prints' ),
        'description' => __( 'Customize the Print archives here' ),
        'panel' => '', // Not typically needed.
        'priority' => 160,
        'capability' => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    $wp_customize->add_setting( 'prints_title', array(
        'default' => 'Prints',
    ) );
    $wp_customize->add_control( 'prints_title', array(
        'section' => 'prints',
        'label' => __( 'Archive Title' ),
        'description' => __( 'Page title for Print Archive page(s)' ),
      ) );

    $wp_customize->add_setting( 'prints_content', array(
        'default' => '',
    ) );
    $wp_customize->add_control( 'prints_content', array(
        'section' => 'prints',
        'label' => __( 'Archive Content' ),
        'description' => __( 'Page content for Print Archive page.' ),
        'type' => 'textarea',
    ) );
    }
add_action( 'customize_register', 'eazel_customize_register' );

function eazel_print_posts_per_page( $query ) {
    if ( !is_admin() && $query->is_main_query() && (
            $query->is_post_type_archive('easel-work') ||
            $query->is_tax('easel-series') ||
            $query->is_tax('easel-medium')
        ) ) {
        $query->set( 'posts_per_page', 12 );
    }
}
add_action( 'pre_get_posts', 'eazel_print_posts_per_page' );

?>
<?php
/*
Plugin Name:  Easel
Plugin URI:   https://github.com/nyergler/easel
Description:  Opinionated portfolio management for artists
Version:      20180205
Author:       Nathan Yergler
Author URI:   https://yergler.net
License:      GPL3
License URI:  https://www.gnu.org/licenses/gpl-3.0.html
Text Domain:  easel
Domain Path:  /languages

@package      Easel
*/

require_once( __DIR__ . '/post-types/easel_work.php' );
require_once( __DIR__ . '/taxonomies/easel_medium.php' );
require_once( __DIR__ . '/taxonomies/easel_series.php' );
require_once( __DIR__ . '/taxonomies/templates.php' );

function easel_install() {
    easel_work_init();
    easel_medium_init();
    easel_series_init();

    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'easel_install' );

function easel_deactivation() {
    unregister_post_type( 'easel-work' );
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'easel_deactivation' );

function eazel_enqueue_styles() {

    // wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    if ( is_post_type_archive( 'easel-work' ) || is_tax( 'easel-medium' ) || is_tax( 'easel-series' ) ) {
        wp_enqueue_style( 'eazel-style',
            get_stylesheet_directory_uri() . '/style.css'
        );
    }
}
add_action( 'wp_enqueue_scripts', 'eazel_enqueue_styles' );

function easel_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'easel', array(
        'title' => __( 'Easel' ),
        'description' => __( 'Customize the Easel archives here' ),
        'panel' => '',
        'priority' => 160,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
    ) );

    $wp_customize->add_setting( 'easel_title', array(
        'default' => 'Art Portfolio',
    ) );
    $wp_customize->add_control( 'easel_title', array(
        'section' => 'easel',
        'label' => __( 'Portfolio Title' ),
        'description' => __( 'Page title for Work archive page(s)' ),
      ) );

    $wp_customize->add_setting( 'easel_intro_content', array(
        'default' => '',
    ) );
    $wp_customize->add_control( 'easel_intro_content', array(
        'section' => 'easel',
        'label' => __( 'Portfolio Intro Content' ),
        'description' => __( 'Page content for Work archive page.' ),
        'type' => 'textarea',
    ) );
    }
add_action( 'customize_register', 'easel_customize_register' );

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
<?php
/*
Plugin Name:  Easel
Plugin URI:   https://github.com/nyergler/easel
Description:  Opinionated portfolio management for artists.
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

function easel_enqueue_styles() {
    $plugin_url = plugin_dir_url( __FILE__ );

    if ( is_admin() ) {
        wp_enqueue_style( 'easel-admin-style',
            $plugin_url . 'admin-style.css'
        );
    }
    if ( get_post_type() == 'easel_work' || is_post_type_archive( 'easel_work' ) || is_tax( 'easel_medium' ) || is_tax( 'easel_series' ) ) {

        wp_enqueue_style( 'easel-style',
            $plugin_url . 'style.css'
        );
    }
}
add_action( 'wp_enqueue_scripts', 'easel_enqueue_styles' );
add_action( 'admin_enqueue_scripts', 'easel_enqueue_styles' );

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
        'default' => 'Portfolio',
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

function easel_print_posts_per_page( $query ) {
    if ( !is_admin() && $query->is_main_query() && (
            $query->is_post_type_archive('easel_work') ||
            $query->is_tax('easel_series') ||
            $query->is_tax('easel_medium')
        ) ) {
        $query->set( 'posts_per_page', 12 );
    }
}
add_action( 'pre_get_posts', 'easel_print_posts_per_page' );

function easel_settings_init()
{
    register_setting('reading', 'easel_archive_prefix');
    add_settings_section(
        'easel_settings_section',
        'Easel Settings',
        'easel_settings_section_cb',
        'reading'
    );
    add_settings_field(
        'easel_archive_prefix',
        'Archive Prefix',
        'easel_archive_prefix_field_cb',
        'reading',
        'easel_settings_section'
    );
}

/**
 * register easel_settings_init to the admin_init action hook
 */
add_action( 'admin_init', 'easel_settings_init' );

/**
 * callback functions
 */
function easel_settings_section_cb()
{
    echo '<p>Configure display of your Easel portfolio.</p>';
}

function easel_archive_prefix_field_cb()
{
    $setting = get_option('easel_archive_prefix');
    ?>
    <input type="text" id="easel_archive_prefix" name="easel_archive_prefix" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <p class="description" id="easel_archive_prefix-description">
        Customize the archive prefix for your portfolio. This setting will be
        inserted after the archive prefix.
    </p>
    <?php
}

add_action( 'update_option_easel_archive_prefix', 'easel_archive_prefix_updated' );

function easel_archive_prefix_updated( $old_value, $value ) {
    // re-register the post type so the rewrite prefix is updated
    easel_work_init();

    // flush the rewrite rules
    flush_rewrite_rules();
}
?>
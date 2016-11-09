<?php
/*
 * WordPress theme
 * Functions
 *
 * @package    wp-product-theme
 * @subpackage wordpress theme
 * @author     pacomoreau
 *
 */

// helpers
require_once('helpers/helpers.php');
require_once('helpers/class-tgm-plugin-activation.php');

// cpt / tax
require_once('custom-post-types/range.php');
require_once('custom-post-types/product.php');

// hooks
if (is_super_admin()) {
  add_action('init', 'wppt_load_textdomain', 1);
  add_action('tgmpa_register', 'wppt_theme_register_required_plugins');
}
remove_action('wp_head', 'rest_output_link_wp_head');
add_action('wp_enqueue_scripts', 'wppt_add_my_stylesheet');
add_action('admin_enqueue_scripts', 'wppt_add_my_admin_stylesheet');
add_filter('pre_option_image_default_link_type', function () { return 'none'; });
add_action('after_setup_theme', 'wppt_theme_init');
remove_filter('widget_title', 'esc_html');
add_filter('the_generator', function () { return ''; });
// specific login styles
add_action('login_enqueue_scripts', 'wppt_custom_login_css');
add_filter('login_headerurl', function () { return get_bloginfo('url'); });
add_filter('login_headertitle', function () { return get_bloginfo('name'); });
// clean header
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'wp_generator');

function wppt_custom_login_css()  {
  wp_enqueue_style('wppt_login', get_template_directory_uri() . '/styles/login.css', false);
}

// theme setup
function wppt_theme_init() {
  add_theme_support('post-thumbnails');
  add_theme_support('title-tag');
  load_theme_textdomain('wp-product-theme', get_template_directory() . '/languages');

  add_theme_support('html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ));
}

// enqueue css, js
function wppt_add_my_stylesheet() {
  // styles
  wp_enqueue_style('screen', get_template_directory_uri() . '/styles/screen.css', array(), '1.0', 'all');

  // js
  wp_enqueue_script('jquery');
  wp_enqueue_script('scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
}

// admin enqueue js
function wppt_add_my_admin_stylesheet() {
  wp_enqueue_media();
  wp_enqueue_script('admin', get_template_directory_uri() . '/js/admin.js', array('jquery'));
}

// menus
register_nav_menus(
  array(
    'main-menu'         =>  __('Menu principal', 'wp-product-theme'),
  )
);
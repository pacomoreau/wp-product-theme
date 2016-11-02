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

// hooks
if (is_super_admin()) {
  add_action('init', 'wppt_load_textdomain', 1);
  add_action('tgmpa_register', 'wppt_theme_register_required_plugins');
}
remove_action('wp_head', 'rest_output_link_wp_head');
add_action('wp_enqueue_scripts', 'wppt_add_my_stylesheet');
add_filter('pre_option_image_default_link_type', function () { return 'none'; });
add_action('after_setup_theme', 'wppt_theme_init');
remove_filter('widget_title', 'esc_html');
add_filter('the_generator', function () { return ''; });
add_filter('status_header', 'wppt_no_redirect_guess_404_permalink');
add_filter('login_errors', 'wppt_login_message');
// clean header
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'wp_generator');

function wppt_no_redirect_guess_404_permalink($header){
  global $wp_query;

  if( is_404() )
    unset( $wp_query->query_vars['name'] );

  return $header;
}

// theme setup
function wppt_theme_init() {
  add_theme_support('post-thumbnails');
  add_theme_support('title-tag');

  add_theme_support('html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ));
}

function wppt_add_my_stylesheet() {
  // styles
  wp_enqueue_style('screen', get_template_directory_uri() . '/styles/screen.css', array(), '1.0', 'all');

  // js
  wp_enqueue_script('jquery');
  wp_enqueue_script('scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
}

// menus
register_nav_menus(
  array(
    'main-menu'         =>  __('Menu principal', 'wp-product-theme'),
  )
);

function wppt_theme_register_required_plugins() {
  $plugins = array(
    array(
      'name'              => 'WordPress SEO',
      'slug'              => 'wordpress-seo',
      'required'          => false,
      'force_activation'  => false,
    ),
    array(
      'name'              => 'Meta Box',
      'slug'              => 'meta-box',
      'required'          => true,
      'force_activation'  => false,
    ),
    array(
      'name'              => 'Jetpack par WordPress.com',
      'slug'              => 'jetpack',
      'required'          => false,
      'force_activation'  => false,
    ),
    array(
      'name'              => 'EWWW Image Optimizer',
      'slug'              => 'ewww-image-optimizer',
      'required'          => false,
      'force_activation'  => false,
    ),
  );

  $config = array(
    'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
    'default_path' => '',                      // Default absolute path to pre-packaged plugins.
    'menu'         => 'tgmpa-install-plugins', // Menu slug.
    'has_notices'  => true,                    // Show admin notices or not.
    'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
    'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
    'is_automatic' => false,                   // Automatically activate plugins after installation or not.
    'message'      => '',                      // Message to output right before the plugins table.
    'strings'      => array(
      'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
      'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
      'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
      'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
      'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
      'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
      'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'tgmpa' ), // %1$s = plugin name(s).
      'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
      'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
      'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'tgmpa' ), // %1$s = plugin name(s).
      'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
      'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'tgmpa' ), // %1$s = plugin name(s).
      'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'tgmpa' ),
      'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'tgmpa' ),
      'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
      'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
      'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
      'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
    )
  );

  tgmpa( $plugins, $config );
}
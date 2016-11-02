<?php
/*
 * WordPress theme
 * Helpers
 *
 * @package    wp-product-theme
 * @subpackage wordpress theme
 * @author     pacomoreau
 *
 */

/**
 * For security.
 * @param $header
 * @return mixed
 */
function wppt_no_redirect_guess_404_permalink($header){
  global $wp_query;

  if( is_404() )
    unset($wp_query->query_vars['name']);

  return $header;
}
add_filter('status_header', 'wppt_no_redirect_guess_404_permalink');

/**
 * Bad login message.
 * @return string|void
 */
function wppt_login_message() {
  return __("Votre identifiant et/ou votre mot de passe est invalide.", 'wp-product-theme');
}
add_filter('login_errors', 'wppt_login_message');

/**
 * Remove accents in media file name.
 * @param $filename
 * @return string
 */
function wppt_sanitize_file_name($filename) {
  return remove_accents($filename);
}
add_filter('sanitize_file_name', 'wppt_sanitize_file_name', 10);

/**
 * tgmpa locales.
 */
function wppt_load_textdomain() {
  load_theme_textdomain('tgmpa', get_template_directory() . '/languages/tgmpa');
}
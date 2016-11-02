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
 * Delete accents in medial file names.
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
  load_theme_textdomain('tgmpa', get_template_directory() . '/languages');
}
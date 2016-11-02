<?php
/*
 * WordPress theme
 * Header
 *
 * @package    wp-product-theme
 * @subpackage wordpress theme
 * @author     pacomoreau
 *
 */
?><!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <header id="header">
    <nav id="main-menu">
      <?php
        $menu_args = array(
          'container'       => '',
          'menu_class'      => 'main-menu',
          'fallback_cb'     => 'none',
          'theme_location'  => 'main-menu',
        );
        wp_nav_menu($menu_args);
      ?>
    </nav>
  </header>

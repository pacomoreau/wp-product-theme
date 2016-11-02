<?php
/*
 * WordPress theme
 * Product CPT
 *
 * @package    wp-product-theme
 * @subpackage wordpress theme
 * @author     pacomoreau
 *
 */

function wppt_register_produit() {

  $labels = array(
    'name'                => __('Produits', 'wp-product-theme'),
    'singular_name'       => __('Produit', 'wp-product-theme'),
    'add_new'             => __('Ajouter', 'wp-product-theme'),
    'add_new_item'        => __('Ajouter un nouveau produit', 'wp-product-theme'),
    'edit_item'           => __('Modifier le produit', 'wp-product-theme'),
    'new_item'            => __('nouveau produit', 'wp-product-theme'),
    'all_items'           => __('Tous les produits', 'wp-product-theme'),
    'view_item'           => __('Voir le produit', 'wp-product-theme'),
    'search_items'        => __('Rechercher un produit', 'wp-product-theme'),
    'not_found'           => __('Pas de produit produit', 'wp-product-theme'),
    'not_found_in_trash'  => __('Pas de produit trouvé dans la corbeille', 'wp-product-theme'),
    'parent_item_colon'   => '',
    'menu_name'           => __('Produits', 'wp-product-theme')
  );

  $args = array(
    'labels'              => $labels,
    'public'              => true,
    'publicly_queryable'  => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'capability_type'     => 'page',
    'hierarchical'        => false,
    'exclude_from_search' => true,
    'taxonomies'          => array('post_tag'),
    'menu_icon'           => 'dashicons-lightbulb',
    'supports'            => array('title', 'excerpt', 'editor', 'thumbnail', 'page-attributes'),
  );

  register_post_type('product', $args);

}
add_action('init', 'wppt_register_produit');

/**
 * Metas (meta-box).
 * @param $meta_boxes
 * @return array
 */
function wppt_produit_register_meta_boxes($meta_boxes) {
  $prefix = '_pr_';
  $meta_boxes[] = array(
    'id'        => 'product_infos',
    'title'     => __('Informations sur le produit', 'wp-product-theme'),
    'pages'     => array('product'),
    'context'   => 'normal',
    'priority'  => 'high',
    'fields'    => array(
      array(
        'name'              => __('Images produit', 'wp-product-theme'),
        'id'                => $prefix . 'images',
        'type'              => 'image_advanced',
        'max_file_uploads'  => 10,
      ),
      array(
        'name'              => __('Prix (€)', 'wp-product-theme'),
        'id'                => $prefix . 'price',
        'type'              => 'number',
        'step'              => 'any',
        'min'               => 0,
      ),
    ),
    'validation' => array(
      'rules'    => array(
        $prefix . 'price' => array(
          'required'  => true,
        ),
      ),
      'messages' => array(
        $prefix . 'price' => array(
          'required'  => __('Le prix du produit est obligatoire.', 'wp-product-theme'),
        ),
      )
    )
  );

  return $meta_boxes;
}
add_filter('rwmb_meta_boxes', 'wppt_produit_register_meta_boxes');
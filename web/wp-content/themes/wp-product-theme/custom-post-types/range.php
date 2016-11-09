<?php
/*
 * WordPress theme
 * Range Taxonomy
 *
 * @package    wp-product-theme
 * @subpackage wordpress theme
 * @author     pacomoreau
 *
 */

function wppt_register_range() {

  $labels = array(
    'name'              => __('Gammes', 'wp-product-theme'),
    'singular_name'     => __('Gamme', 'wp-product-theme'),
    'search_items'      => __('Chercher une gamme', 'wp-product-theme'),
    'all_items'         => __('Toutes les gammes', 'wp-product-theme'),
    'parent_item'       => __('Gamme parente', 'wp-product-theme'),
    'parent_item_colon' => __('Gamme parente : ', 'wp-product-theme'),
    'edit_item'         => __('Modifier la gamme', 'wp-product-theme'),
    'update_item'       => __('Mettre à jour la gamme', 'wp-product-theme'),
    'add_new_item'      => __('Ajouter une nouvelle gamme', 'wp-product-theme'),
    'new_item_name'     => __('Nouvelle gamme', 'wp-product-theme'),
    'menu_name'         => __('Gammes', 'wp-product-theme'),
  );

  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array('slug' => 'products', 'with_front' => false),
  );

  register_taxonomy('range', array('product'), $args);

}
add_action('init', 'wppt_register_range');

/**
 * Hide default description
 */
function wppt_range_remove_default_description() {
  global $current_screen;
  if ($current_screen->id == 'edit-range') {
  ?>
  <script type="text/javascript">
    jQuery(function($) {
      $('#tag-description').closest('div.form-field').remove();
      $('.form-field #description').closest('tr.form-field').remove();
    });
  </script>
  <?php
  }
}
add_action('admin_head', 'wppt_range_remove_default_description');

/**
 * Additional fields for range.
 */
function wppt_range_edit_meta_field($term) {
  $t_id = $term->term_id;
  $term_meta = get_option("taxonomy_$t_id"); ?>
<tr class="form-field">
  <th scope="row" valign="top">
    <label for="description_range"><?php _e("Description", 'wp-product-theme'); ?></label>
  </th>
  <td>
    <?php
      $value = isset($term_meta['description_range']) ? $term_meta['description_range'] : '';
      $settings = array('wpautop' => true, 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => '8', 'textarea_name' => 'description_range');
      wp_editor(wp_kses_post($value, ENT_QUOTES, 'UTF-8'), 'description_range', $settings);
    ?>
  </td>
</tr>  
<tr class="form-field">
  <th scope="row" valign="top">
    <label for="image_range"><?php _e("Image de la gamme", 'wp-product-theme'); ?></label>
  </th>
  <td>
    <?php
      $img = isset($term_meta['image_range']) ? esc_attr($term_meta['image_range']) : '';
      $id = uniqid();
      $imgsrc = '';
      if ($img) {
        $imgsrc = wp_get_attachment_image_src($img);
        $imgsrc = $imgsrc[0];
      }
    ?>
    <input class="wdg_img_file <?php echo $id; ?>" id="image_range" name="image_range" type="hidden" value="<?php echo $img; ?>" />
    <img class="wdg_img_src <?php echo $id; ?>" src="<?php echo $imgsrc; ?>"<?php if(!$imgsrc) echo ' style="display:none;"'; ?> width="200" />
    <br/>
    <input type="button" class="wdg_img_add button <?php echo $id; ?>" name="wdg_img_file_button" id="wdg_img_file_button" value="<?php _e("Sélectionnez une image", 'wp-product-theme') ?>" />
    <br />
    <input type="button" class="wdg_img_del button <?php echo $id; ?>" name="wdg_img_file_button_delete" id="wdg_img_file_button_delete" value="<?php _e("Supprimer l'image", 'wp-product-theme') ?>"<?php if (!$imgsrc) echo ' style="display:none;margin-top:5px;"'; else echo ' style="margin-top:5px;"'; ?> />
  </td>
</tr>

<?php
}
add_action('range_edit_form_fields', 'wppt_range_edit_meta_field', 10, 2);

/**
 * Update range metas.
 */
function wppt_save_range_custom_meta($term_id) {
  $t_id = $term_id;
  $term_meta = get_option("taxonomy_$t_id");

  if (isset($_POST['description_range'])) $term_meta['description_range'] = stripslashes($_POST['description_range']);
  if (isset($_POST['image_range'])) $term_meta['image_range'] = $_POST['image_range'];

  if ($term_meta)
    update_option("taxonomy_$t_id", $term_meta);
}
add_action('edited_range', 'wppt_save_range_custom_meta', 10, 2);
add_action('create_range', 'wppt_save_range_custom_meta', 10, 2);



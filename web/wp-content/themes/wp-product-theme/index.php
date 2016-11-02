<?php
/*
 * WordPress theme
 * Index
 *
 * @package    wp-product-theme
 * @subpackage wordpress theme
 * @author     pacomoreau
 *
 */

get_header();
?>

  <div id="primary">
    <main id="main" class="site-main" role="main">
      <?php
        if (have_posts()): ?>
          <?php if (is_home() && !is_front_page()): ?>
            <h1 class="page-title"><?php single_post_title(); ?></h1>
          <?php endif; ?>

          <?php
            while (have_posts()) {
              the_post();
              get_template_part('parts/content', get_post_format());
            }

            the_posts_pagination(array(
              'prev_text'          => __('Page précédente', 'wp-product-theme'),
              'next_text'          => __('Page suivante', 'wp-product-theme' ),
              'before_page_number' => '<span class="meta-nav">' . __('Page', 'wp-product-theme') . ' </span>',
            ));
        else :
          get_template_part('parts/content', 'none');
        endif;
      ?>
    </main>
  </div>

<?php
get_footer();

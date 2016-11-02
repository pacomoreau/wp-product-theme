<?php
/*
 * WordPress theme
 * Default template content
 *
 * @package    wp-product-theme
 * @subpackage wordpress theme
 * @author     pacomoreau
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			if (is_single()):
				the_title('<h1 class="entry-title">', '</h1>');
			else:
				the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');
			endif;
		?>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article>

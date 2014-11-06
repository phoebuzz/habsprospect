<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="entry-meta">
			<span class="cat-links">
				<?php
				if ( is_category() ):
					global $cat;
					$categories = get_the_category();
					foreach ( $categories as $category ):
						if ( $category->term_id == $cat ) continue;
					?>
					<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" title="<?php printf( _e( 'View all posts in %s', 'themeboy' ), $category->name ); ?>" rel="category tag"><?php echo $category->name; ?></a>
					<?php
					endforeach;
				else:
					echo get_the_category_list( ' ' );
				endif;
				?>
			</span>
		</div>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php
			the_content( '<span class="icon-book"></span>' . __( 'Read more', 'themeboy') );
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'themeboy' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>
</article><!-- #post-## -->

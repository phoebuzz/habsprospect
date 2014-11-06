	</div>
</section>

<footer id="footer" class="site-footer">
	<?php do_action('themeboy_before_footer'); ?>

	<div class="row">
		<?php
		$footer_widget_regions = apply_filters( 'tb_footer_widget_regions', 3 );
		for ( $i = 1; $i <= intval( $footer_widget_regions ); $i++ ) {
			if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
			<div class="medium-4 columns footer-widgets widget-area" role="complementary">
				<?php dynamic_sidebar( 'footer-' . $i ); ?>
			</div>
			<?php
			endif;
		}
		?>

		<div class="large-12 columns">
			<?php printf( __( 'Designed by %s', 'sportspress' ), '<a href="http://themeboy.com/">' . __( 'ThemeBoy', 'sportspress' ) . '</a>' ); ?>
		</div>
	</div>
	<?php do_action('themeboy_after_footer'); ?>
</footer>
<a class="exit-off-canvas"></a>
	
  <?php do_action('themeboy_layout_end'); ?>
  </div>
</div>
<?php wp_footer(); ?>
<?php do_action('themeboy_before_closing_body'); ?>
</body>
</html>
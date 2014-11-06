<?php if ( is_active_sidebar( 'primary' ) ) : ?>
<div id="sidebar" class="sidebar widget-area" role="complementary">
	<?php do_action('themeboy_before_sidebar'); ?>
	<?php $args = array(
	    'post_type' => 'sp_player',
	    'orderby' => 'name',
	    'order' => 'ASC',
	    'title_li'     => __(''), 
	); ?>

	<div class="dropdown"> <span class="dropdown-toggle" tabindex="0"></span>
	  <div class="dropdown-text">Player Search<i class="icon-user icon"></i></div>
	  <ul class="dropdown-content">
	    	<?php wp_list_pages($args); ?>
	  </ul>
	</div>
	<?php dynamic_sidebar( 'primary' ); ?>
	<?php do_action('themeboy_after_sidebar'); ?>
</div><!-- #sidebar -->
<?php endif; ?>
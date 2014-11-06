<?php 
	$sidebar = alx_sidebar_primary();
	$layout = alx_layout_class();
	if ( $layout != 'col-1c'):
?>

	<div class="sidebar s1">
		
		<a class="sidebar-toggle" title="<?php _e('Expand Sidebar','hueman'); ?>"><i class="fa icon-sidebar-toggle"></i></a>
		
		<div class="sidebar-content">
			
			<?php if ( ot_get_option('sidebar-top') != 'off' ): ?>
			<div class="sidebar-top group">
				<p><?php _e('Follow:','hueman'); ?></p>
				<?php alx_social_links() ; ?>
			</div>
			<?php endif; ?>
			
			<?php if ( ot_get_option( 'post-nav' ) == 's1') { get_template_part('inc/post-nav'); } ?>

			
				<?php $args = array(
				    'post_type' => 'players',
				    'orderby' => 'name',
				    'order' => 'ASC',
				    'title_li'     => __(''), 
				); ?>

			<div class="dropdown myDropDown"> <a class="dropdown-toggle" tabindex="0"></a>
			  <div class="dropdown-text"><?php _e('Player Search','habsprospect'); ?></div>
			  <ul class="dropdown-content">
			    	<?php wp_list_pages($args); ?>
			  </ul>
			</div>
			
			<?php if( is_page_template('page-templates/child-menu.php') ): ?>
			<ul class="child-menu group">
				<?php wp_list_pages('title_li=&sort_column=menu_order&depth=3'); ?>
			</ul>
			<?php endif; ?>
			
			<?php dynamic_sidebar($sidebar); ?>


			
		</div><!--/.sidebar-content-->
		
	</div><!--/.sidebar-->

	<?php if (
		( $layout == 'col-3cm' ) ||
		( $layout == 'col-3cl' ) ||
		( $layout == 'col-3cr' ) )
		{ get_template_part('sidebar-2'); } 
	?>
	
<?php endif; ?>
<?php
/**
 * Post Slider Widget 
 *
 * @since 1.0
 */

class TB_Widget_Post_Slider extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_post_slider widget_tb_post_slider', 'description' => __( 'Premier widget.', 'themeboy' ) );
		parent::__construct('tb_post_slider', __( 'ThemeBoy Post Slider', 'themeboy' ), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? null : $instance['title'], $instance, $this->id_base);
		$category = empty($instance['category']) ? null : $instance['category'];
		$number = empty($instance['number']) ? 5 : $instance['number'];
		echo $before_widget;
		echo '<div id="tb_post_slider_wrap"><ul class="latest-posts-orbit" data-orbit data-options="bullets_container_class:orbit-bullets hide-for-small-only;navigation_arrows:false;timer:false;slide_number:false;">';

		$args = array(
			'posts_per_page' => $number,
			'category' => $category
		);
		$posts = get_posts( $args );
		foreach( $posts as $post ):
			setup_postdata( $post );
		?>
		<li>
			<?php echo get_the_post_thumbnail( $post->ID, 'themeboy-square-thumbnail' ); ?>
			<div class="caption">
				<a href="<?php echo get_permalink( $post->ID ); ?>">
					<?php if ( $title ): ?>
					<?php echo $before_title . $title . $after_title; ?>
					<h5 class="post-title"><?php echo get_the_title( $post->ID ); ?></h5>
					<?php else: ?>
					<?php echo $before_title . get_the_title( $post->ID ) . $after_title; ?>
					<?php endif; ?>
					<?php the_excerpt( 10 ); ?>
				</a>
			</div>
		</li>
		<?php
		endforeach;
		wp_reset_postdata();
		echo '</ul></div>';
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = intval($new_instance['category']);
		$instance['number'] = intval($new_instance['number']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'number' => 5 ) );
		$title = strip_tags($instance['title']);
		$category = intval($instance['category']);
		$number = intval($instance['number']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'themeboy' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e( 'Category:', 'sportspress' ); ?></label>
		<?php
		$args = array(
			'name' => $this->get_field_name('category'),
			'id' => $this->get_field_id('category'),
			'selected' => $category,
			'show_option_all' => sprintf( __( 'All %s', 'sportspress' ), __( 'Categories', 'sportspress' ) ),
			'values' => 'term_id',
			'class' => 'postform widefat',
		);
		wp_dropdown_categories( $args );
		?>
		</p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of posts to show:', 'sportspress' ); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3"></p>
<?php
	}
}

register_widget( "TB_Widget_Post_Slider" );

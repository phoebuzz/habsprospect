<?php
class SP_Widget_Player_Gallery extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_player_gallery widget_sp_player_gallery', 'description' => __( 'Display a gallery of players.', 'sportspress' ) );
		parent::__construct('sp_player_gallery', __( 'Player Gallery', 'sportspress' ) . ' (' . __( 'SportsPress', 'sportspress' ) . ')', $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$id = empty($instance['id']) ? null : $instance['id'];
		$number = empty($instance['number']) ? null : $instance['number'];
		$columns = empty($instance['columns']) ? null : $instance['columns'];
		$orderby = empty($instance['orderby']) ? 'default' : $instance['orderby'];
		$order = empty($instance['order']) ? 'ASC' : $instance['order'];
		$show_all_players_link = empty($instance['show_all_players_link']) ? false : $instance['show_all_players_link'];
		$show_names_on_hover = empty($instance['show_names_on_hover']) ? false : $instance['show_names_on_hover'];
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		echo '<div id="sp_player_gallery_wrap">';
		sp_get_template( 'player-gallery.php', array( 'id' => $id, 'number' => $number, 'columns' => $columns, 'orderby' => $orderby , 'order' => $order, 'grouping' => 0, 'show_all_players_link' => $show_all_players_link, 'show_names_on_hover' => $show_names_on_hover ) );
		echo '</div>';
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['id'] = intval($new_instance['id']);
		$instance['number'] = intval($new_instance['number']);
		$instance['columns'] = intval($new_instance['columns']);
		$instance['orderby'] = strip_tags($new_instance['orderby']);
		$instance['order'] = strip_tags($new_instance['order']);
		$instance['show_all_players_link'] = $new_instance['show_all_players_link'];
		$instance['show_names_on_hover'] = $new_instance['show_names_on_hover'];

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'id' => '', 'number' => 5, 'columns' => 2, 'orderby' => 'default', 'order' => 'ASC', 'show_all_players_link' => true, 'show_names_on_hover' => false ) );
		$title = strip_tags($instance['title']);
		$id = intval($instance['id']);
		$number = intval($instance['number']);
		$columns = intval($instance['columns']);
		$orderby = strip_tags($instance['orderby']);
		$order = strip_tags($instance['order']);
		$show_all_players_link = $instance['show_all_players_link'];
		$show_names_on_hover = $instance['show_names_on_hover'];
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'sportspress' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('id'); ?>"><?php printf( __( 'Select %s:', 'sportspress' ), __( 'Player List', 'sportspress' ) ); ?></label>
		<?php
		$args = array(
			'post_type' => 'sp_list',
			'name' => $this->get_field_name('id'),
			'id' => $this->get_field_id('id'),
			'selected' => $id,
			'values' => 'ID',
			'class' => 'widefat',
		);
		if ( ! sp_dropdown_pages( $args ) ):
			sp_post_adder( 'sp_list', __( 'Add New', 'sportspress' ) );
		endif;
		?>
		</p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of players to show:', 'sportspress' ); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3"></p>

		<p><label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e( 'Columns:', 'sportspress' ); ?></label>
		<input id="<?php echo $this->get_field_id('columns'); ?>" name="<?php echo $this->get_field_name('columns'); ?>" type="text" value="<?php echo esc_attr($columns); ?>" size="3"></p>

		<p><label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e( 'Sort by:', 'sportspress' ); ?></label>
		<?php
		$args = array(
			'prepend_options' => array(
				'default' => __( 'Default', 'sportspress' ),
				'number' => __( 'Number', 'sportspress' ),
				'name' => __( 'Name', 'sportspress' ),
				'eventsplayed' => __( 'Played', 'sportspress' )
			),
			'post_type' => 'sp_performance',
			'name' => $this->get_field_name('orderby'),
			'id' => $this->get_field_id('orderby'),
			'selected' => $orderby,
			'values' => 'slug',
			'class' => 'sp-select-orderby widefat',
		);
		if ( ! sp_dropdown_pages( $args ) ):
			sp_post_adder( 'sp_list', __( 'Add New', 'sportspress' ) );
		endif;
		?>
		</p>

		<p><label for="<?php echo $this->get_field_id('order'); ?>"><?php _e( 'Sort Order:', 'sportspress' ); ?></label>
		<select name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>" class="sp-select-order widefat" <?php disabled( $orderby, 'default' ); ?>>
			<option value="ASC" <?php selected( 'ASC', $order ); ?>><?php _e( 'Ascending', 'sportspress' ); ?></option>
			<option value="DESC" <?php selected( 'DESC', $order ); ?>><?php _e( 'Descending', 'sportspress' ); ?></option>
		</select></p>

		<p><input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('show_all_players_link'); ?>" name="<?php echo $this->get_field_name('show_all_players_link'); ?>" value="1" <?php checked( $show_all_players_link, 1 ); ?>>
		<label for="<?php echo $this->get_field_id('show_all_players_link'); ?>"><?php _e( 'Display link to view all players', 'sportspress' ); ?></label></p>

		<p><input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('show_names_on_hover'); ?>" name="<?php echo $this->get_field_name('show_names_on_hover'); ?>" value="1" <?php checked( $show_names_on_hover, 1 ); ?>>
		<label for="<?php echo $this->get_field_id('show_names_on_hover'); ?>"><?php _e( 'Display player names on hover', 'sportspress' ); ?></label></p>
<?php
	}
}

register_widget( 'SP_Widget_Player_Gallery' );

<?php

/**
 * Adds Social media icons widget.
 */
class razz_random_posts extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'razz_random_posts', // Base ID
			RAZZ_THEME_NAME . esc_html__( ' Random posts', 'razz' ), // Name
			array( 'description' => esc_html__( 'add random posts widget', 'razz' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		if ( ! empty( $instance['recent_number'] ) ):
			$count_recent = $instance['recent_number'];
		else:
			$count_recent = 5;
		endif;
		$query_args = array(
			'posts_per_page'      => absint( $count_recent ),
			'ignore_sticky_posts' => 1,
			'orderby'             => 'rand',
			'no_found_rows'       => true
		);
		switch ( $instance['style'] ) {
			case 'slider':
				razz_widget_slider_loop( $query_args );
				break;
			case 'small_list' :
				razz_widget_small_list_loop( $query_args );
				break;
			case 'big_list' :
				razz_widget_big_list_loop( $query_args );
				break;
			case 'pics' :
				razz_widget_pics_loop( $query_args );
				break;
			default :
				razz_widget_small_list_loop( $query_args );
		}
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title         = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$recent_number = ! empty( $instance['recent_number'] ) ? absint( $instance['recent_number'] ) : 5;
		$style         = ! empty( $instance['style'] ) ? $instance['style'] : '';
		?>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'razz' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'style' ); ?>"><?php esc_html_e( 'Select style :', 'razz' );
				?></label>

			<select name="<?php echo $this->get_field_name( 'style' ); ?>"
			        id="<?php echo $this->get_field_id( 'style' ); ?>" class="widefat"
			        style="margin-bottom:10px">
				<option value=""><?php esc_html_e( 'Not selected', 'razz' ); ?></option>
				<option value="slider"<?php if ( 'slider' == $style ) { ?> selected="selected"<?php } ?>>
					<?php esc_html_e( 'Slider', 'razz' ); ?>
				</option>
				<option value="pics"<?php if ( 'pics' == $style ) { ?> selected="selected"<?php } ?>>
					<?php esc_html_e( 'Posts Pictures', 'razz' ); ?>
				</option>
				<option value="small_list"<?php if ( 'small_list' == $style ) { ?> selected="selected"<?php } ?>>
					<?php esc_html_e( 'Small list', 'razz' ); ?>
				</option>
				<option value="big_list"<?php if ( 'big_list' == $style ) { ?> selected="selected"<?php } ?>>
					<?php esc_html_e( 'Big list', 'razz' ); ?>
				</option>
			</select>
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'recent_number' ); ?>"><?php esc_html_e( 'Posts count :', 'razz' );
				?></label>
			<input id="<?php echo $this->get_field_id( 'recent_number' ); ?>"
			       name="<?php echo $this->get_field_name( 'recent_number' ); ?>" type="number" size="3"
			       value="<?php echo esc_attr( $recent_number ); ?>">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                  = array();
		$instance['title']         = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['recent_number'] = ( ! empty( $new_instance['recent_number'] ) ) ? strip_tags( $new_instance['recent_number'] ) : '';
		$instance['style']         = ( ! empty( $new_instance['style'] ) ) ? strip_tags( $new_instance['style'] ) : '';

		return $instance;
	}

}
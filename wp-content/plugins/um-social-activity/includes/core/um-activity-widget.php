<?php
if ( ! defined( 'ABSPATH' ) ) exit;


class um_activity_trending_tags extends WP_Widget {

	function __construct() {
		
		parent::__construct(
		
		// Base ID of your widget
		'um_activity_trending_tags', 

		// Widget name will appear in UI
		__('Ultimate Member - Trending Hashtags', 'um-activity'), 

		// Widget description
		array( 'description' => __( 'Shows your trending hashtags', 'um-activity' ), ) 
		
		);
	
	}

	// Creating widget front-end
	public function widget( $args, $instance ) {
		
		$title = apply_filters( 'widget_title', $instance['title'] );

		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		
		// This is where you run the code and display the output
		echo do_shortcode('[ultimatemember_trending_hashtags]');
		
		echo $args['after_widget'];
		
	}

	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'Trending', 'um-activity' );
		}

		// Widget admin form
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}

}
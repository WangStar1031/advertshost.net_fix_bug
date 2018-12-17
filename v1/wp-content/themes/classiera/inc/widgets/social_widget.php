<?php
class classiera_social_widget extends WP_Widget {
	public function __construct() {		
		$widget_ops = array( 'classname' => 'classiera_social_widget', 'description' => esc_html__('A widget that displays your social icons', 'classiera') );		
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'classiera_social_widget' );		
		parent::__construct( 'classiera_social_widget', esc_html__('Classiera: Social Icons', 'classiera'), $widget_ops, $control_ops );		
	}	
	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		global $redux_demo;
		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$facebook = $instance['facebook'];
		$twitter = $instance['twitter'];
		$googleplus = $instance['googleplus'];
		$bloglovin = $instance['bloglovin'];
		$youtube = $instance['youtube'];		
		$pinterest = $instance['pinterest'];
		$rss = $instance['rss'];
		$instagram = $instance['instagram'];
		
		/* Before widget (defined by themes). */
		echo wp_kses_post($before_widget);

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
		
			echo wp_kses_post($before_title) . $title . $after_title;
		?>
		
		
		<div class="widget-content">
			<div class="social-network">				
					<?php 
						$classieraFB = $redux_demo['facebook-link'];
						$classieraTw = $redux_demo['twitter-link'];
						$classieraPinterest = $redux_demo['pinterest-link'];
						$classieraFlicker = $redux_demo['flickr-link'];
						$classieraGooglePlus = $redux_demo['google-plus-link'];
						$classieraYouTube = $redux_demo['youtube-link'];
						$classieraVimeo = $redux_demo['vimeo-link'];
						
						$classieraDribbble = $redux_demo['dribbble-link'];						
						$classieraGitHub = $redux_demo['github-link'];
						$classieraLinkedin = $redux_demo['linkedin-link'];
						$classieraInstagram = $redux_demo['instagram-link'];
						
					?>
					<?php if($facebook) : ?>
						<a class="social-icon social-icon-sm footer-social" href="<?php echo esc_url($classieraFB); ?>" target="_blank">
							<i class="fab fa-facebook-f"></i>
						</a>
					<?php endif; ?>					
					<?php if($twitter) : ?>
						<a class="social-icon social-icon-sm footer-social" href="<?php echo esc_url($classieraTw); ?>" target="_blank">
							<i class="fab fa-twitter"></i>
						</a>
					<?php endif; ?>					
					<?php if($pinterest) : ?>
						<a class="social-icon social-icon-sm footer-social" href="<?php echo esc_url($classieraPinterest); ?>" target="_blank">
							<i class="fab fa-pinterest-p"></i>
						</a>
					<?php endif; ?>					
					<?php if($bloglovin) : ?>
						<a class="social-icon social-icon-sm footer-social" href="<?php echo esc_url($classieraFlicker); ?>" target="_blank">
							<i class="fab fa-flickr"></i>
						</a>
					<?php endif; ?>					
					<?php if($googleplus) : ?>
						<a class="social-icon social-icon-sm footer-social" href="<?php echo esc_url($classieraGooglePlus); ?>" target="_blank">
							<i class="fab fa-google-plus-g"></i>
						</a>
					<?php endif; ?>
					<?php if($youtube) : ?>
						<a class="social-icon social-icon-sm footer-social" href="<?php echo esc_url($classieraYouTube); ?>" target="_blank">
							<i class="fab fa-youtube"></i>
						</a>
					<?php endif; ?>
					<?php if($rss) : ?>
						<a class="social-icon social-icon-sm footer-social" href="<?php echo esc_url($classieraVimeo); ?>" target="_blank">
							<i class="fab fa-vimeo"></i>
						</a>
					<?php endif; ?>
					<?php if($instagram) : ?>
						<a class="social-icon social-icon-sm footer-social" href="<?php echo esc_url($classieraInstagram); ?>" target="_blank">
							<i class="fab fa-instagram"></i>
						</a>
					<?php endif; ?>
				
			</div>
		</div>	
			
		<?php

		/* After widget (defined by themes). */
		echo wp_kses_post($after_widget);
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		$instance['googleplus'] = strip_tags( $new_instance['googleplus'] );
		$instance['bloglovin'] = strip_tags( $new_instance['bloglovin'] );
		$instance['youtube'] = strip_tags( $new_instance['youtube'] );		
		$instance['pinterest'] = strip_tags( $new_instance['pinterest'] );
		$instance['rss'] = strip_tags( $new_instance['rss'] );
		$instance['instagram'] = strip_tags( $new_instance['instagram'] );

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Subscribe & Follow', 'facebook' => 'on', 'twitter' => 'on', 'pinterest' => 'on', 'bloglovin' => '', 'tumblr' => '', 'rss' => '', 'googleplus' => 'on', 'youtube' => 'on', );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'classiera' ); ?>:</label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:90%;" />
		</p>
		
		<p><?php esc_html_e( 'Note: Set your social links in the Theme Options', 'classiera' ); ?></p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'facebook' )); ?>"><?php esc_html_e( 'Show Facebook', 'classiera' ); ?>:</label>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'facebook' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'facebook' )); ?>" <?php checked( (bool) $instance['facebook'], true ); ?> />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'twitter' )); ?>"><?php esc_html_e( 'Show Twitter', 'classiera' ); ?>:</label>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'twitter' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'twitter' )); ?>" <?php checked( (bool) $instance['twitter'], true ); ?> />
		</p>
		
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'pinterest' )); ?>"><?php esc_html_e( 'Show Pinterest', 'classiera' ); ?>:</label>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'pinterest' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'pinterest' )); ?>" <?php checked( (bool) $instance['pinterest'], true ); ?> />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'bloglovin' )); ?>"><?php esc_html_e( 'Show Flicker', 'classiera' ); ?>:</label>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'bloglovin' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'bloglovin' )); ?>" <?php checked( (bool) $instance['bloglovin'], true ); ?> />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'googleplus' )); ?>"><?php esc_html_e( 'Show Google Plus', 'classiera' ); ?>:</label>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'googleplus' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'googleplus' )); ?>" <?php checked( (bool) $instance['googleplus'], true ); ?> />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'youtube' )); ?>"><?php esc_html_e( 'Show Youtube', 'classiera' ); ?>:</label>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'youtube' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'youtube' )); ?>" <?php checked( (bool) $instance['youtube'], true ); ?> />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'rss' )); ?>"><?php esc_html_e( 'Show vimeo', 'classiera' ); ?>:</label>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'rss' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'rss' )); ?>" <?php checked( (bool) $instance['rss'], true ); ?> />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'instagram' )); ?>"><?php esc_html_e( 'Show instagram', 'classiera' ); ?>:</label>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'instagram' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'instagram' )); ?>" <?php checked( (bool) $instance['instagram'], true ); ?> />
		</p>


	<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("classiera_social_widget");'));
?>
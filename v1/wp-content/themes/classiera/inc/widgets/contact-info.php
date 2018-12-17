<?php 

class classiera_Contact_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'classiera_Contact_Info',
			'description' => esc_html__( 'Contact Info Widget', 'classiera' ),
		);
		parent::__construct( 'classiera_Contact_Info', esc_html__( 'Contact Info Widget', 'classiera' ), $widget_ops );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $argz, $instance ) {
		echo wp_kses_post($argz['before_widget']);
		global $redux_demo;
		$classieraLOGOURL = $redux_demo['classiera_footer_logo']['url'];
		$classiera_logo = $instance['classiera_logo'];
		
		if ( ! empty( $instance['title'] ) ) {
			if($classiera_logo){
				?>
				<div class="widget-title">
				<img class="img-responsive" src="<?php echo esc_url($classieraLOGOURL); ?>" alt="<?php bloginfo( 'name' ); ?>">
				</div>
				<?php				
			}else{
				echo wp_kses_post($argz['before_title']) . apply_filters( 'widget_title', $instance['title'] ). $argz['after_title'];
			}
			
		}
		$classieraAddress = $instance['address'];
		$classiera_email = $instance['classiera_email'];
		$classiera_phone = $instance['classiera_phone'];
		$classiera_logo = $instance['classiera_logo'];
		$classiera_about_info = $instance['classiera_about_info'];
		$classiera_about = $instance['classiera_about'];
		?>
		<div class="widget-content">
			<?php if($classiera_about_info){?>
			<div class="textwidget"><?php echo esc_html($classiera_about); ?></div>
			<?php } ?>
			<?php if(!empty($classieraAddress)){?>
			<div class="contact-info">
				<div class="contact-info-box">
					<i class="fa fa-map-marker"></i>
				</div>
				<div class="contact-info-box">
					<p><?php echo esc_html($classieraAddress); ?></p>
					
				</div>
			</div>
			<?php } ?>
			<?php if(!empty($classiera_email)){?>
			<div class="contact-info">
				<div class="contact-info-box">
					<i class="fa fa-envelope"></i>
				</div>
				<div class="contact-info-box">
					<p><?php echo sanitize_email($classiera_email); ?></p>
				</div>
			</div>
			<?php } ?>
			<?php if(!empty($classiera_phone)){?>
			<div class="contact-info">
				<div class="contact-info-box">
					<i class="fa fa-phone"></i>
				</div>
				<div class="contact-info-box">
					<p><?php echo esc_html($classiera_phone); ?></p>
				</div>
			</div>
			<?php } ?>
		</div>
	<?php 			
		echo wp_kses_post($argz['after_widget']);
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Contact Info', 'classiera' );
		$classiera_about = ! empty( $instance['classiera_about'] ) ? $instance['classiera_about'] : esc_html__( 'About Description', 'classiera' );
		$address = ! empty( $instance['address'] ) ? $instance['address'] : esc_html__( 'Change Address', 'classiera' );
		$classiera_email = ! empty( $instance['classiera_email'] ) ? $instance['classiera_email'] : esc_html__( 'Put Your Email Here', 'classiera' );
		$classiera_phone = ! empty( $instance['classiera_phone'] ) ? $instance['classiera_phone'] : esc_html__( 'Change Phone', 'classiera' );
		
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'classiera_logo' )); ?>"><?php esc_html_e( 'Show Logo?', 'classiera' ); ?>:</label>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'classiera_logo' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'classiera_logo' )); ?>" <?php checked( (bool) $instance['classiera_logo'], true ); ?> />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'classiera_about_info' )); ?>"><?php esc_html_e( 'Show About Description?', 'classiera' ); ?>:</label>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'classiera_about_info' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'classiera_about_info' )); ?>" <?php checked( (bool) $instance['classiera_about_info'], true ); ?> />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'classiera' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'classiera_about' )); ?>"><?php esc_html_e( 'About Description:', 'classiera' ); ?></label>
			<textarea name="<?php echo esc_attr($this->get_field_name( 'classiera_about' )); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'classiera_about' )); ?>"><?php echo esc_html( $classiera_about ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'address' )); ?>"><?php esc_html_e( 'Address:', 'classiera' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'address' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'address' )); ?>" type="text" value="<?php echo esc_html($address) ; ?>">
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'classiera_email' )); ?>"><?php esc_html_e( 'Email:', 'classiera' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'classiera_email' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'classiera_email' )); ?>" type="text" value="<?php echo sanitize_email($classiera_email) ; ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'classiera_phone' )); ?>"><?php esc_html_e( 'Phone Number:', 'classiera' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'classiera_phone' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'classiera_phone' )); ?>" type="text" value="<?php echo esc_html($classiera_phone) ; ?>">
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
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['classiera_about'] = $new_instance['classiera_about'];
		$instance['classiera_email'] = $new_instance['classiera_email'];
		$instance['classiera_phone'] = $new_instance['classiera_phone'];
		$instance['address'] = $new_instance['address'];
		$instance['classiera_logo'] = strip_tags( $new_instance['classiera_logo'] );
		$instance['classiera_about_info'] = strip_tags( $new_instance['classiera_about_info'] );

		return $instance;
	}

} // class AdvanceSearch_Widget

function register_classiera_contact_widget() {
    register_widget( 'classiera_Contact_Widget' );
}
add_action( 'widgets_init', 'register_classiera_contact_widget' );
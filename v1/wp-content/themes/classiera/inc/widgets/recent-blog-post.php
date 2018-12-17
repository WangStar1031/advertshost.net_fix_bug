<?php

class WPSites_Recent_Posts extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'wpsites_recent_posts', 'description' => __( "Show Latest Blog Posts.", 'classiera') );
        parent::__construct('wpsites-recent-posts', __('Blog Recent Posts', 'classiera'), $widget_ops);
        $this->alt_option_name = 'wpsites_recent_posts';       
    }

    public function widget($args, $instance) {
        $cache = array();
        if ( ! $this->is_preview() ) {
            $cache = wp_cache_get( 'wpsites_widget_recent_posts', 'widget' );
        }

        if ( ! is_array( $cache ) ) {
            $cache = array();
        }

        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo esc_attr($cache[ $args['widget_id'] ]);
            return;
        }

        ob_start();

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts', 'classiera' );

        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;


        $r = new WP_Query( apply_filters( 'widget_posts_args', array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'post_type'           => array('blog',
            'ignore_sticky_posts' => true
        ) ) ) );

        if ($r->have_posts()) :
?>
        <?php echo wp_kses_post($args['before_widget']); ?>
        <?php if ( $title ) {
            echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
			echo '<div class="widget-content">';
        } ?>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
		<?php global $post; ?>
		<?php $post_id = $post->ID; ?>
		<div class="media footer-pr-widget-v2">
			<div class="media-left">
				<a class="media-img" href="<?php echo esc_url(get_permalink($post->ID)); ?>">
					<?php 
					if ( has_post_thumbnail()){
					$classieraThumSrc = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'full');
					$thumb_id = get_post_thumbnail_id($post_id);
					$classieraALT = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
					?>
					<img class="media-object img-rounded" src="<?php echo esc_url($classieraThumSrc[0]); ?>" alt="<?php echo esc_attr($classieraALT); ?>">
					<?php }else{
						$classieraDEFThumb = get_template_directory_uri() . '/images/nothumb.png'
					?>
					<img class="media-object img-rounded" src="<?php echo esc_url($classieraDEFThumb); ?>" alt="<?php echo esc_attr($classieraALT); ?>">	
						<?php
					}?>
				</a>
			</div>
			<div class="media-body">
				<?php $classieradateFormat = get_option( 'date_format' );?>
				<?php if ( $show_date ) : ?>
				<span><i class="far fa-clock"></i><?php echo get_the_date($classieradateFormat, $post_id); ?></span>
				<?php endif; ?>
				<h5 class="media-heading">
					<a href="<?php echo esc_url(get_permalink($post_id)); ?>"><?php echo get_the_title();?></a>
				</h5>
			</div>
		</div>
		<?php endwhile; ?>
		<?php echo '</div>'; ?>
        <?php echo wp_kses_post($args['after_widget']); ?>
<?php

        wp_reset_postdata();

        endif;

        if ( ! $this->is_preview() ) {
            $cache[ $args['widget_id'] ] = ob_get_flush();
            wp_cache_set( 'wpsites_widget_recent_posts', $cache, 'widget' );
        } else {
            ob_end_flush();
        }
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;        

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['wpsites_recent_posts']) )
            delete_option('wpsites_recent_posts');

        return $instance;
    }   

    public function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
        <p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:', 'classiera' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php _e( 'Number of posts to show:', 'classiera'); ?></label>
        <input id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_date' )); ?>" />
        <label for="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>"><?php _e( 'Display post date?', 'classiera' ); ?></label></p>
<?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("WPSites_Recent_Posts");'));
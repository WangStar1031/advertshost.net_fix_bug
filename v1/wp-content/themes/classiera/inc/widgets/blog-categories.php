<?php
class TWBlogcategoryWidget extends WP_Widget {
    public function __construct() {	
        $widget_ops = array('classname' => 'TWBlogcategoryWidget', 'description' => 'Blogs Categories.');
        //parent::__construct(false, 'Blogs Categories ', $widget_ops);
		parent::__construct( 'TWBlogcategoryWidget', esc_html__( 'Blogs Categories', 'classiera' ), $widget_ops );
		
    }
    function widget($args, $instance) {
        global $post;
		$title = apply_filters('widget_title', $instance['title']);
		?>
		<div class="col-lg-12 col-md-12 col-sm-6 match-height">
			<div class="widget-box">
				<?php if (isset($before_widget))
				echo wp_kses_post($before_widget);				
					if ($title != '')
						wp_kses_post($args['before_title']);
					?>
					<i class="far fa-folder-open"></i>
					<?php
					echo wp_kses_post($title). $args['after_title'];
				?>
				<div class="widget-content">
					<ul class="category">
					<?php
					$args = array(
						'parent' => 0,
						'orderby' => 'name',
						'order' => 'ASC',
						'pad_counts' => true,
						'hide_empty' => false,
					);
					$categories = get_terms('blog_category',$args);
					$current = -1;					      
					foreach ($categories as $category) {						
						$tag = $category->term_id;
						?>						
						<li>
							<a href="<?php echo esc_url(get_category_link( $category->term_id ))?>" title="View posts in <?php echo esc_html($category->name)?>"><?php echo esc_html($category->name) ?></a>

						</li>
					<?php
					}
					?>
					</ul>
		    	</div>
		    </div>
		</div>
		<?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
       
        return $instance;
    }

    function form($instance) {
	extract($instance);
       ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e("Title:", "classiera");?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>"  />
        </p>
        <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("TWBlogcategoryWidget");'));

?>
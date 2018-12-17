<?php
class ClassieracategoryWidget extends WP_Widget {
    public function __construct() {		
			$widget_ops = array('classname' => 'ClassieracategoryWidget', 'description' => 'Classiera Categories.');
			//parent::__construct(false, 'Classiera Categories ', $widget_ops);
			parent::__construct( 'ClassieracategoryWidget', esc_html__( 'Classiera Categories', 'classiera' ), $widget_ops );
    }
    function widget($args, $instance) {
        global $post;
		extract($instance);
		 $counter = $instance['counter'];
		 if(empty($counter)){
			 $counter = '';
		 }
		$title = apply_filters('widget_title', $instance['title']);
		
				?>
		<div class="col-lg-12 col-md-12 col-sm-6 match-height">
			<div class="widget-box">
				<?php if (isset($before_widget))
				echo wp_kses_post($before_widget);				
					if ($title != '')
					echo wp_kses_post($args['before_title']);
					?>
					<i class="far fa-folder-open"></i>
					<?php
					echo wp_kses_post($title) . $args['after_title']; 
				?>
						
				<div class="widget-content">
					<?php 
					global $redux_demo;
					$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
					$classieraPostCount = $redux_demo['classiera_cat_post_counter'];
					?>
						<ul class="category">
						<?php
						$args = array(
							'parent' => 0,
							'orderby' => 'name',
							'order' => 'ASC',
							'number' => $counter,							
						);
						$categories = get_terms('category', $args);						
						$current = -1;						
						$category_icon_code = "";
						$category_icon_color = "";
						$your_image_url = "";
						foreach ($categories as $category) {							
							$tag = $category->term_id;							
							$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
							if (isset($tag_extra_fields[$tag])) {
								$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
								$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
								$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
							}
							?>
							
							<li>
	
						  			<a href="<?php echo esc_url(get_category_link( $category->term_id ));?>" title="View posts in <?php echo esc_html($category->name)?>">										
										<?php 
										if($classieraIconsStyle == 'icon'){
											?>
											<i style="color:<?php echo esc_html($category_icon_color); ?>;" class="<?php echo esc_html($category_icon_code); ?>"></i>
											<?php
										}elseif($classieraIconsStyle == 'img'){
											?>
											<img src="<?php echo esc_url($classieraCatIcoIMG); ?>" alt="<?php echo esc_html(get_cat_name( $catName )); ?>">
											<?php
										}
										?>
										<?php echo esc_html($category->name) ?>
										<?php 
									$q = new WP_Query( array(
										'nopaging' => true,
										'tax_query' => array(
											array(
												'taxonomy' => 'category',
												'field' => 'id',
												'terms' => $tag,
												'include_children' => true,
											),
										),
										'fields' => 'ids',
									) );
									$allPosts = $q->post_count;
									?>
										<span class="pull-right flip">
										<?php if($classieraPostCount == 1){?>
										(<?php echo esc_attr($allPosts); ?>)
										<?php }else{?>
										&nbsp;
										<?php } ?>
										</span>
									</a>									
						  			

						  	</li>
								<?php
							}
						?>
						</ul>
					
		    	</div><!-- End widgetContent -->

		    </div>
		</div>
				<?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['counter'] = strip_tags($new_instance['counter']);
       
        return $instance;
    }

    function form($instance) {
	extract($instance);
       ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
				<?php esc_html_e('Title:', 'classiera');?>
			</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>"  />
        </p>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('counter')); ?>">
				<?php esc_html_e('Counter:', 'classiera');?>
			</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('counter')); ?>" name="<?php echo esc_attr($this->get_field_name('counter')); ?>" value="<?php echo esc_attr($instance['counter']); ?>"  />
        </p>
        <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("ClassieracategoryWidget");'));
 ?>
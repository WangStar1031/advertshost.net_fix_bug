<?php 
	global $redux_demo;
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$page_slider = get_post_meta($current_page_id, 'page_slider', true);
?>
<!-- layer slider -->
<section id="slider">
	<div id="full-slider-wrapper">
		<?php 
			$page_layer_slider_shortcode = get_post_meta($current_page_id, 'layerslider_shortcode', true);
			if(!empty($page_layer_slider_shortcode)){
				echo do_shortcode($page_layer_slider_shortcode);
			}else{
				echo do_shortcode('[layerslider id="1"]');
			}
		?>
	</div>
</section>
<!-- layer slider -->
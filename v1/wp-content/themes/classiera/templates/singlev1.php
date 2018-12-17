<!-- post title-->
<?php 
global $redux_demo;
$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
global $post;
$postID = '';
$current_user = wp_get_current_user();
$edit_post_page_id = $redux_demo['edit_post'];
if(function_exists('icl_object_id')){
	$templateEditAd = 'template-edit-post.php';		
	$edit_post_page_id = classiera_get_template_url($templateEditAd);
}
$postID = $post->ID;
global $wp_rewrite;
if ($wp_rewrite->permalink_structure == ''){
	$edit_post = $edit_post_page_id."&post=".$postID;
}else{
	$edit_post = $edit_post_page_id."?post=".$postID;
}
/*PostMultiCurrencycheck*/
$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
if(!empty($post_currency_tag)){
	$classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
}else{
	global $redux_demo;
	$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
}
/*PostMultiCurrencycheck*/
?>
<div class="single-post-title">
	<div class="post-price visible-xs visible-sm">
		<?php $post_price = get_post_meta($post->ID, 'post_price', true);  ?>
		<h4>
			<?php 
			if(is_numeric($post_price)){
				echo classiera_post_price_display($post_currency_tag, $post_price);
			}else{ 
				echo esc_attr($post_price); 
			}
			?>
		</h4>
	</div>
	<h4 class="text-uppercase">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		<?php 
		if($post->post_author == $current_user->ID && get_post_status ( $post->ID ) == 'publish'){			
			?>
			<a href="<?php echo esc_url($edit_post); ?>" class="edit-post btn btn-sm btn-default">
				<i class="far fa-edit"></i>
				<?php esc_html_e( 'Edit Post', 'classiera' ); ?>
			</a>
			<?php
		}elseif( current_user_can('administrator')){
			?>
			<a href="<?php echo esc_url($edit_post); ?>" class="edit-post btn btn-sm btn-default">
				<i class="far fa-edit"></i>
				<?php esc_html_e( 'Edit Post', 'classiera' ); ?>
			</a>
			<?php
		}
		?>		
		<!--Edit Ads Button-->
	</h4>
	<p class="post-category">
	<?php 
		$category = get_the_category();
	?>
		<i class="far fa-folder-open"></i>:
		<span>
		<?php classiera_Display_cat_level($post->ID); ?>
		</span>
		<?php 
			$locShownBy = $redux_demo['location-shown-by'];
			$post_location = get_post_meta($post->ID, $locShownBy, true);
		?>
		<i class="fas fa-map-marker-alt"></i>:<span><a href="#"><?php echo esc_attr($post_location); ?></a></span>
	</p>
</div>
<!-- post title-->
<!-- single post carousel-->
<?php 
		$attachments = get_children(array('post_parent' => $post->ID,
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => 'ASC',
			'orderby' => 'menu_order ID'
			)
		);
?>
<?php if ( has_post_thumbnail() || !empty($attachments)){?>
<div id="single-post-carousel" class="carousel slide single-carousel" data-ride="carousel" data-interval="3000">
	
	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
	<?php 
	if(empty($attachments)){
		if ( has_post_thumbnail()){
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			?>
		<div class="item active">
			<img class="img-responsive" src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title(); ?>">
		</div>
		<?php
		}else{
			$image = get_template_directory_uri().'/images/nothumb.png';
			?>
			<div class="item active">
				<img class="img-responsive" src="<?php echo esc_url($image); ?>" alt="<?php the_title(); ?>">
			</div>
			<?php
		}
	}else{
		$count = 1;
		foreach($attachments as $att_id => $attachment){
			$full_img_url = wp_get_attachment_url($attachment->ID);
			?>
		<div class="item <?php if($count == 1){ echo "active"; }?>">
			<img class="img-responsive" src="<?php echo esc_url($full_img_url); ?>" alt="<?php the_title(); ?>">
		</div>
		<?php
		$count++;
		}
	}
	?>
	</div>
	<!-- slides number -->
	<div class="num">
		<i class="fa fa-camera"></i>
		<span class="init-num"><?php esc_html_e('1', 'classiera') ?></span>
		<span><?php esc_html_e('of', 'classiera') ?></span>
		<span class="total-num"></span>
	</div>
	<!-- Left and right controls -->
	<div class="single-post-carousel-controls">
		<a class="left carousel-control" href="#single-post-carousel" role="button" data-slide="prev">
			<span class="fa fa-chevron-left" aria-hidden="true"></span>
			<span class="sr-only"><?php esc_html_e('Previous', 'classiera') ?></span>
		</a>
		<a class="right carousel-control" href="#single-post-carousel" role="button" data-slide="next">
			<span class="fa fa-chevron-right" aria-hidden="true"></span>
			<span class="sr-only"><?php esc_html_e('Next', 'classiera') ?></span>
		</a>
	</div>
	<!-- Left and right controls -->
</div>
<?php } ?>
<!-- single post carousel-->
<?php 
	global $redux_demo;
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraAdsView = $redux_demo['home-ads-view'];
	$primaryColor = $redux_demo['color-primary'];
	$classieraItemClass = "item-masonry";
	if($classieraAdsView == 'list'){
		$classieraItemClass = "item-list";
	}
	$ads_type_selected = get_post_meta($post->ID, 'ads_type_selected', true);
	$largeAds='';
	if($ads_type_selected=='double_sec' || $ads_type_selected=='double_top')
	{
		$largeAds='grid-item--width2';
		$image_size='advert_double';
	}
	else
	{
		$largeAds='grid-item';
		$image_size='advert';
	}
	$category_icon_code = "";
	$category_icon_color = "";
	$catIcon = "";
	$category = get_the_category();
	$catID = $category[0]->cat_ID;
	if ($category[0]->category_parent == 0) {
		$tag = $category[0]->cat_ID;
		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
		if (isset($tag_extra_fields[$tag])) {
			$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
			$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
			$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
		}
	}elseif(isset($category[1]->category_parent) && $category[1]->category_parent == 0){
		$tag = $category[0]->category_parent;
		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
		if (isset($tag_extra_fields[$tag])) {
			$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
			$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
			$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
		}
	}else{
		$tag = $category[0]->category_parent;
		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
		if (isset($tag_extra_fields[$tag])) {
			$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
			$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
			$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
		}
	}
	if(!empty($category_icon_code)) {
		$category_icon = stripslashes($category_icon_code);
	}
	if(!empty($category_icon_color)) {
		$category_icon_color = $primaryColor;
	}
	$post_price = get_post_meta($post->ID, 'post_price', true);
	$post_phone = get_post_meta($post->ID, 'post_phone', true);
	$theTitle = get_the_title();
	$postCatgory = get_the_category( $post->ID );
	$categoryLink = get_category_link($catID);
	$classieraPostAuthor = $post->post_author;
	$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
	$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
	$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
	$classiera_ads_statustime = get_post_meta($post->ID, 'classiera_ads_statustime', true);
	$current_time = date("Y-m-d H:i:s");		
	if($current_time >= $classiera_ads_statustime){ ?>

<div class="<?php echo $largeAds;?>">
	<div class="classiera-box-div classiera-box-div-v4">
		<figure class="clearfix">
			<div class="premium-img">
			<?php 
				$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
				if($classieraFeaturedPost == 1){
					?>
					<!-- <div class="featured-tag">
						<span class="left-corner"></span>
						<span class="right-corner"></span>
						<div class="featured">
							<p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
						</div>
					</div> -->
					<?php
				}
				?>

				<div class="premium-img-inner">
					<?php
						$discount_per=get_post_meta($post->ID,'discount_percentage',true);
						if(!empty($discount_per) && $discount_per>0)
						{
							?>
							<div class="discount_per_parent">
								<span class="discount_per">
									<?php esc_html_e('-'.$discount_per.'%','classiera');?>
								</span>
							</div>
							<?php
						}
					?>
				<!-- Get the image -->	
				<?php
				if( has_post_thumbnail()){
					$imageurl = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $image_size);
					$thumb_id = get_post_thumbnail_id($post->ID);
					?>
					<img class="img-responsive" src="<?php echo esc_url($imageurl[0]); ?>" alt="<?php echo esc_html($theTitle); ?>">
					<?php
				}else{
					?>
					<img class="img-responsive" src="<?php echo get_template_directory_uri() . '/images/nothumb.png' ?>" alt="No Thumb"/>
					<?php
				}
				?>
				<!-- / Get the Image -->
					<!-- Hover content -->
					<span class="hover-posts">
						<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-md btn-style-four"><?php esc_html_e('View advert', 'classiera'); ?></a>
					</span>
					<!-- / Hover Content -->
					<?php if(!empty($classiera_ads_type)){?>
					<!-- Display Ad type -->
					<!-- <span class="classiera-buy-sel">
						<?php classiera_buy_sell($classiera_ads_type); ?>
					</span> -->
					<!-- / Display Ad type -->
					<?php } ?>
					<div class="category">
						<span style="background:<?php echo esc_html($category_icon_color); ?>;">
						<?php 
						if($classieraIconsStyle == 'icon'){
							?>
							<i class="<?php echo esc_html($category_icon_code);?>"></i>
							<?php
						}elseif($classieraIconsStyle == 'img'){
							?>
							<img src="<?php echo esc_url($classieraCatIcoIMG); ?>" alt="<?php echo esc_html(get_cat_name( $catName )); ?>">
							<?php
						}
						?>
						</span>
						<a href="<?php echo esc_url($categoryLink); ?>"><?php echo esc_html($postCatgory[0]->name); ?></a>
						<!-- <a href="tel:<?php echo esc_html($post_phone); ?>"><?php echo esc_html($post_phone); ?></a> -->
						
					</div><!--category-->
				</div><!--premium-img-inner-->

			</div><!--premium-img-->
			<div class="detail text-center">
				<?php if(!empty($post_price)){?>
				<!-- Display Price -->
				<span class="amount">
					<?php 
					if(is_numeric($post_price)){
						echo classiera_post_price_display($post_currency_tag, $post_price);
					}else{ 
						echo esc_attr($post_price); 
					}
					?>
				</span>
				<!-- / Display Price -->
				<?php } ?>
				<div class="box-icon">
					<a href="mailto:<?php echo sanitize_email($classieraAuthorEmail); ?>?subject">
						<i class="fa fa-envelope"></i>
					</a>
					<?php if(!empty($post_phone)){?>
					<a href="tel:<?php echo esc_html($post_phone); ?>"><i class="fa fa-phone"></i></a>
					<?php } ?>
				</div>
				<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-md btn-style-four"><?php esc_html_e('View Ad', 'classiera'); ?></a>
			</div><!--detail text-center-->
			<!-- <figcaption>
				<h5><a href="<?php the_permalink(); ?>"><?php echo esc_html($theTitle); ?></a></h5>
				<div class="category">
					<span style="background:<?php echo esc_html($category_icon_color); ?>;">
					<?php 
						if($classieraIconsStyle == 'icon'){
							?>
							<i class="<?php echo esc_html($category_icon_code);?>"></i>
							<?php
						}elseif($classieraIconsStyle == 'img'){
							?>
							<img src="<?php echo esc_url($classieraCatIcoIMG); ?>" alt="<?php echo esc_html(get_cat_name( $catName )); ?>">
							<?php
						}
					?>
					</span>
					<a href="<?php echo esc_url($categoryLink); ?>"><?php echo esc_html($postCatgory[0]->name); ?></a>
				</div>
				<?php if(!empty($post_price)){?>
				<div class="price">
					<span class="amount">
						<?php 
						if(is_numeric($post_price)){
							echo classiera_post_price_display($post_currency_tag, $post_price);
						}else{ 
							echo esc_attr($post_price); 
						}
						?>
					</span>
				</div>
				<?php } ?>
				<p class="description"><?php echo substr(get_the_excerpt(), 0,260); ?></p>
			</figcaption> -->
		</figure>
	</div><!--row-->
</div>		<?php } ?><!--item item-grid item-masonry-->
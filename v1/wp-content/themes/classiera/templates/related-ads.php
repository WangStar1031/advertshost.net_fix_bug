<?php 
$post_ID = related_Post_ID();
global $redux_demo;
$classieraRelatedCount = $redux_demo['classiera_related_ads_count'];
$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
$autoPlay = $redux_demo['classiera_related_ads_autoplay'];
$primaryColor = $redux_demo['color-primary'];
$classiera_ads_typeOn = $redux_demo['classiera_ads_type'];
if($classiera_ads_typeOn == 1){
	$adstypeQuery = array(
		'key' => 'classiera_ads_type',
		'value' => 'sold',
		'compare' => '!='
	);
}else{
	$adstypeQuery = null;
}
?>
<!-- related blog post section -->
<section class="blog-post-section related-blog-post-section border-bottom">
    <div class="container" style="overflow: hidden;">
        <div class="row">
            <div class="col-sm-6 related-blog-post-head">
                <h4 class="text-uppercase"><?php esc_html_e( 'Related ads', 'classiera' ); ?></h4>
            </div><!--col-sm-6-->
            <div class="col-sm-6">
                <div class="navText text-right flip hidden-xs">
                    <a class="prev btn btn-primary sharp btn-style-one btn-sm"><i class="fa fa-chevron-left"></i></a>
                    <a class="next btn btn-primary sharp btn-style-one btn-sm"><i class="fa fa-chevron-right"></i></a>
                </div>
            </div><!--col-sm-6-->
        </div><!--row-->
        <div class="row">
            <div class="col-lg-12">
                <div class="owl-carousel premium-carousel-v1" data-car-length="4" data-items="4" data-loop="true" data-nav="false" data-autoplay="<?php if($autoPlay == true){echo "true" ;}else{ echo "false";}?>" data-autoplay-timeout="3000" data-dots="false" data-auto-width="false" data-auto-height="true" data-right="<?php if(is_rtl()){echo "true";}else{ echo "false";}?>" data-responsive-small="1" data-autoplay-hover="true" data-responsive-medium="2" data-responsive-xlarge="4" data-margin="30">
				<?php 
				$orig_post = $post; 
				global $post;
				$tags = wp_get_post_tags($post_ID);
				$relatedCat = wp_get_post_categories($post_ID);
				if ($tags || $relatedCat){
					
				$tag_ids = array();
				foreach($tags as $individual_tag)
				$tag_ids[] = $individual_tag->term_id;
				$args = array(  
					'tag__in' => $tag_ids,  
					'post__not_in' => array($post_ID),  
					'posts_per_page'=>$classieraRelatedCount, // Number of related posts to display.  
					'ignore_sticky_posts'=>1,
					'meta_query' => array(
						$adstypeQuery,
					),
				);
				$current = -1;
				$my_query = new wp_query( $args );
				$category_icon_code ="";
				$category_icon_color ="";
				$your_image_url ="";
				while( $my_query->have_posts() ) {
					$my_query->the_post();
					global $postID;
					$current++;
					$category = get_the_category();
					//print_r($category); 
					//exit();
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
					if(empty($category_icon_color)){
						$category_icon_color = $primaryColor;
					}else{
						$category_icon_color = $category_icon_color;
					}
					$post_price = get_post_meta($post->ID, 'post_price', true);
					$post_phone = get_post_meta($post->ID, 'post_phone', true);
					$theTitle = get_the_title();
					$postCatgory = get_the_category( $post->ID );					
					$categoryLink = get_category_link($tag);
					$classieraPostAuthor = $post->post_author;
					$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
					$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
					$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
				?>
					<!--SingleItem-->
                    <div class="classiera-box-div-v1 item match-height">
                        <figure>
                            <div class="premium-img">
								<?php if($classieraFeaturedPost == 1){?>
                                <div class="featured-tag">
                                    <span class="left-corner"></span>
                                    <span class="right-corner"></span>
                                    <div class="featured">
                                        <p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
                                    </div>
                                </div>
								<?php } ?>
                                <?php
									if( has_post_thumbnail()){
										$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'classiera-370');
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
                                <span class="hover-posts">
									<a href="<?php the_permalink(); ?>" class="btn btn-primary sharp btn-sm active"><?php esc_html_e( 'View Ad', 'classiera' ); ?></a>
								</span>
                            </div>
							<?php if(!empty($post_price)){?>
                            <span class="classiera-price-tag" style="background-color:<?php echo esc_html($category_icon_color); ?>; color:<?php echo esc_html($category_icon_color); ?>;">
                                <span class="price-text">
									<?php 
									if(is_numeric($post_price)){
										echo classiera_post_price_display($post_currency_tag, $post_price);
									}else{ 
										echo esc_attr($post_price); 
									}
									?>
								</span>
                            </span>
							<?php } ?>
                            <figcaption>
                                <h5><a href="<?php the_permalink(); ?>"><?php echo esc_html($theTitle); ?></a></h5>
                                <p> 
									<?php esc_html_e('Category', 'classiera'); ?> : 
									<a href="<?php echo esc_url($categoryLink); ?>"><?php echo esc_html($postCatgory[0]->name); ?></a>
								</p>
                                <span class="category-icon-box" style=" background:<?php echo esc_html($category_icon_color); ?>; color:<?php echo esc_html($category_icon_color); ?>; ">
									<?php 
									if($classieraIconsStyle == 'icon'){
										?>
										<i class="<?php echo esc_attr($category_icon_code); ?>"></i>
										<?php
									}elseif($classieraIconsStyle == 'img'){
										?>
										<img src="<?php echo esc_url($classieraCatIcoIMG); ?>" alt="<?php echo esc_html($postCatgory[0]->name); ?>">
										<?php
									}
									?>
								</span>
                            </figcaption>
                        </figure>
                    </div><!--item-->
					<?php }?><!--End while -->
					<?php }?><!--End Main tags if -->
					<!--SingleItem-->
                </div><!--owl-carousel-->
            </div><!--col-lg-12-->
        </div><!--row-->
    </div>
</section><!-- /.related blog post -->
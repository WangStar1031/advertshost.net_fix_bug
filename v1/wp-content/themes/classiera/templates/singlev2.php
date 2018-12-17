<?php 
global $redux_demo;
$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
$classieraAuthorInfo = $redux_demo['classiera_author_contact_info'];
$postID = '';
global $post;
$current_user = wp_get_current_user();
$edit_post_page_id = $redux_demo['edit_post'];
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
$locationTemplate = 'template-locations.php';
$locationTemplatePermalink = classiera_get_template_url($locationTemplate);
global $wp_rewrite;
if ($wp_rewrite->permalink_structure == ''){
//we are using ?page_id
$locationURL = $locationTemplatePermalink."&location=";
}else{
//we are using permalinks
$locationURL = $locationTemplatePermalink."?location=";
}
?>
<div class="row">
	<div class="col-lg-6 col-md-6">
		<div class="single-post">
			<!-- single post carousel-->
			<?php 
				global $post;
				$attachments = get_children(array('post_parent' => $post->ID,
					'post_status' => 'inherit',
					'post_type' => 'attachment',
					'post_mime_type' => 'image',
					'order' => 'ASC',
					'orderby' => 'menu_order ID'
					)
				);
			?>
			
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
			</div><!-- /.single post carousel-->
			
		</div>
	</div>
	<div class="col-lg-6 col-md-6">
		<div class="single-post">
			<!-- post title-->
			<div class="single-post-title">
				<h4 class="text-uppercase"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<p class="post-category">
				<?php $category = get_the_category(); ?>
					<i class="far fa-folder-open"></i>:
					<span>
						<?php classiera_Display_cat_level($post->ID); ?>
					</span>
					<?php 
						$locShownBy = $redux_demo['location-shown-by'];
						$post_location = get_post_meta($post->ID, $locShownBy, true);
					?>
					<i class="fas fa-map-marker-alt"></i>:
					<span>
						<a href="<?php echo esc_url($locationURL); ?><?php echo esc_attr($post_location); ?>">
							<?php echo esc_attr($post_location); ?>
						</a>
					</span>
				</p>
			</div><!-- /.post title-->
			<?php $post_price = get_post_meta($post->ID, 'post_price', true); ?>
			<?php $classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true); ?>
			<div class="price">
				<h3 class="price-title border-bottom">
					<?php 
					if(is_numeric($post_price)){
						echo classiera_post_price_display($post_currency_tag, $post_price);
					}else{ 
						echo esc_attr($post_price); 
					}
					if(!empty($classiera_ads_type)){
						?>
						<span class="ad_type_display">
							<?php classiera_buy_sell($classiera_ads_type); ?>
						</span>
						<?php
					}
					?>
				</h3>
				<!--Edit Ads Button-->
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
			</div>
			<div class="author-info border-bottom">
				<div class="row">
					<div class="col-lg-6 col-sm-6 col-md-12">
						<div class="author-info widget-content-post-area">
						<?php 
							$user_ID = $post->post_author;
							$authorName = get_the_author_meta('display_name', $user_ID );
							$author_avatar_url = get_user_meta($user_ID, "classify_author_avatar_url", true);
							$author_avatar_url = classiera_get_profile_img($author_avatar_url);
							$authorEmail = get_the_author_meta('user_email', $user_ID);
							$authorURL = get_the_author_meta('user_url', $user_ID);
							$authorPhone = get_the_author_meta('phone', $user_ID);
							if(empty($author_avatar_url)){										
								$author_avatar_url = classiera_get_avatar_url ($authorEmail, $size = '150' );
							}
							$UserRegistered = get_the_author_meta( 'user_registered', $user_ID );
							$dateFormat = get_option( 'date_format' );							
							$classieraRegDate = date_i18n($dateFormat,  strtotime($UserRegistered));
						?>
							<div class="media">
								<div class="media-left">
									<img class="media-object" src="<?php echo esc_url($author_avatar_url); ?>" alt="<?php echo esc_attr($authorName); ?>">
								</div>
								<div class="media-body">
									<h5 class="media-heading text-uppercase">
										<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo esc_attr($authorName); ?></a>
										<?php echo classiera_author_verified($user_ID);?>
									</h5>
									<p><?php esc_html_e('Member Since', 'classiera') ?>&nbsp;<?php echo esc_html($classieraRegDate);?></p>
									<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php esc_html_e( 'see all ads', 'classiera' ); ?></a>
									<?php if ( is_user_logged_in()){ 
										$current_user = wp_get_current_user();
										$user_id = $current_user->ID;
										if(isset($user_id)){
											if($user_ID != $user_id){							
												echo classiera_authors_follower_check($user_ID, $user_id);
											}
										}
									}												
									?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6 col-md-12">
						<?php if($classieraAuthorInfo == 1){?>
						<div class="contact-details widget-content-post-area">
							<h5 class="text-uppercase"><?php esc_html_e('Contact Details', 'classiera') ?> :</h5>
							<ul class="list-unstyled fa-ul c-detail">
								<?php if(!empty($authorPhone)){?>
								<li><i class="fa fa-li fa-phone-square"></i>&nbsp;
									<span class="phNum" data-replace="<?php echo esc_html($authorPhone);?>"><?php echo esc_html($authorPhone);?></span>
									<button type="button" id="showNum"><?php esc_html_e('Reveal', 'classiera') ?></button>
								</li>
								<?php } ?>
								<?php if(!empty($authorURL)){?>
								<li><i class="fa fa-li fa-globe"></i> 
									<a href="<?php echo esc_url($authorURL); ?>"><?php echo esc_url($authorURL); ?></a>
								</li>
								<?php } ?>
								<?php if(!empty($authorEmail)){?>
								<li><i class="fa fa-li fa-envelope"></i> 
									<a href="mailto:<?php echo sanitize_email($authorEmail); ?>">
									<?php echo sanitize_email($authorEmail); ?>
									</a>
								</li>
								<?php } ?>
							</ul>
						</div>
						<?php }else{ ?>
							&nbsp;
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="post-extra border-bottom">
				<div class="row">
					<div class="col-lg-4 col-sm-5">
					<?php if ( is_user_logged_in()){ 
						global $current_user;
						wp_get_current_user();
						$user_id = $current_user->ID;
					}?>
					<?php 
					if(isset($user_id)){
						echo classiera_authors_favorite_check($user_id,$post->ID); 
					}
					?>
					</div>
					<div class="col-lg-8 col-sm-7">
						<div class="post-share">
							<span class="text-uppercase"><?php esc_html_e( 'Share ad', 'classiera' ); ?>: </span>
							<div class="share-icon">
								<!--AccessPress Socil Login-->
								<?php								
								if ( class_exists( 'APSS_Class' ) ) {
									echo do_shortcode('[apss-share]');
								}								
								?>
								<!--AccessPress Socil Login-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
/**
 * Template name: Single User All Ads
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera
 */

if ( !is_user_logged_in() ) { 
	global $redux_demo; 
	$login = $redux_demo['login'];
	wp_redirect( $login ); exit;
}
global $redux_demo; 
$edit = $redux_demo['edit'];
$pagepermalink = get_permalink($post->ID);
if(isset($_GET['delete_id'])){
	$deleteUrl = $_GET['delete_id'];
	wp_delete_post($deleteUrl);
}
if(isset($_POST['unfavorite'])){
	$author_id = $_POST['author_id'];
	$post_id = $_POST['post_id'];
	echo classiera_authors_unfavorite($author_id, $post_id);	
}
if(isset($_GET['sold_id'])){
	$sold_post_id = $_GET['sold_id'];
	echo classiera_post_mark_as_sold($sold_post_id);
}if(isset($_GET['pause_id']))
{
	$pause_post_id = $_GET['pause_id'];	
	echo  classiera_post_mark_as_pause($pause_post_id);   
	echo classiera_post_mark_as_status($pause_post_id); 
	}
if(isset($_GET['un_sold_id'])){
	$un_sold_id = $_GET['un_sold_id'];
	echo classiera_post_mark_as_unsold($un_sold_id);
}
global $current_user, $user_id;
wp_get_current_user();
$user_info = get_userdata($user_ID);
$user_id = $current_user->ID;
get_header(); 
?>
<?php 
	global $redux_demo; 
	$profile = $redux_demo['profile']; //Output profile link
	$all_adds = $redux_demo['all-ads'];
	$allFavourite = $redux_demo['all-favourite'];
	$newPostAds = $redux_demo['new_post'];
	$bumpProductID = $redux_demo['classiera_bump_ad_woo_id'];
	$classiera_cart_url = $redux_demo['classiera_cart_url'];
	$caticoncolor="";
	$category_icon_code ="";
	$category_icon="";
	$category_icon_color=""; 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$iconClass = 'icon-left';
	if(is_rtl()){
		$iconClass = 'icon-right';
	}
?>
<!-- user pages -->
<section class="user-pages section-gray-bg">
	<div class="container">
        <div class="row">
			<div class="col-lg-3 col-md-4">
				<?php get_template_part( 'templates/profile/userabout' );?>
			</div><!--col-lg-3-->
			<div class="col-lg-9 col-md-8 user-content-height">
				<div class="user-detail-section section-bg-white">
					<!-- my ads -->
					<div class="user-ads user-my-ads">
						<h4 class="user-detail-section-heading text-uppercase">
						<?php esc_html_e("User Ads", 'classiera') ?>
						</h4>
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}
							$wp_query = null;
							$kulPost = array(
								'post_type'  => 'post',
								'author' => $user_id,
								'posts_per_page' => 12,
								'paged' => $paged,
								'post_status' => array( 'publish', 'pending', 'future', 'draft', 'private' ),
							);
							$wp_query = new WP_Query($kulPost);
							while ($wp_query->have_posts()) : $wp_query->the_post();
							$title = get_the_title($post->ID); 
							$classieraPstatus = get_post_status( $post->ID );
							$dateFormat = get_option( 'date_format' );
							$postDate = get_the_date($dateFormat, $post->ID);
							$postStatus = get_post_status($post->ID);
							$productID = get_post_meta($post->ID, 'pay_per_post_product_id', true);
							$days_to_expire = get_post_meta($post->ID, 'days_to_expire', true);
							$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
						$classiera_ads_status = get_post_meta($post->ID, 'classiera_ads_status', true);
						$classiera_ads_statustime = get_post_meta($post->ID, 'classiera_ads_statustime', true);
						$current_time = date("Y-m-d H:i:s");
						if($current_time >= $classiera_ads_statustime)
						{
							update_post_meta($post->ID, 'classiera_ads_status','1');
							}
							?>
						<div class="media border-bottom">
							<div class="media-left">
								<?php 
								if ( has_post_thumbnail()){								
								$imgURL = get_the_post_thumbnail_url();
								?>
                                <img class="media-object" src="<?php echo esc_url( $imgURL ); ?>" alt="<?php echo esc_attr( $title ); ?>">
								<?php } ?>
                            </div><!--media-left-->
							<div class="media-body">
								<h5 class="media-heading">
									<a href="<?php echo esc_url( get_permalink($post->ID) ); ?>">
										<?php echo esc_attr( $title ); ?>
									</a>
								</h5>
								
								<?php
								if($classiera_ads_status==0){ ?>
								<h5 class="media-heading tmerh">
								
								<!---<p class="timer<?=$post->ID ?>"></p>-->
								<script>

								initializeClock("timer<?= $post->ID?>","<?= $classiera_ads_statustime?> GMT+1");


								function initializeClock(cls,endtime){

								  var timeinterval = setInterval(function(){
									var t = getTimeRemaining(endtime);

								$('.'+cls).html( t.hours + ':' + t.minutes + ':' +t.seconds);


								   if(t.total<=0){
									  clearInterval(timeinterval);
									}
								  },1000);
								}

								function getTimeRemaining(endtime){
								  var t = Date.parse(endtime) - Date.parse(new Date());
								  var seconds = Math.floor( (t/1000) % 60 );
								  var minutes = Math.floor( (t/1000/60) % 60 );
								  var hours = Math.floor( (t/(1000*60*60)) % 24 );
								  var days = Math.floor( t/(1000*60*60*24) );
								  var sec = ("0" + seconds).slice(-2);
								  var mintue = ("0" + minutes).slice(-2);
								  var hour = ("0" + hours).slice(-2);

								  return {
									'total': t,
									'days': days,
									'hours': hour,
									'minutes': mintue,
									'seconds': sec
								  };
								}


								</script>

								</h5>
								<?php 
								}
								?>
								
								<p>
                                    <span class="published">
                                        <i class="fa fa-check-circle"></i>
                                        <?php classieraPStatusTrns($classieraPstatus); ?>
                                    </span>
                                    <span>
                                        <i class="fa fa-eye"></i>
                                        <?php echo classiera_get_post_views($post->ID); ?>
                                    </span>
                                    <span>
                                        <i class="fa fa-clock"></i>                                      
										<?php echo esc_html( $postDate ); ?>
                                    </span>
									<span>
										<i class="removeMargin fa fa-hashtag"></i>
										<?php esc_html_e( 'ID', 'classiera' ); ?> : 
										<?php echo esc_attr( $post->ID ); ?>
                                    </span>
                                </p>
								
								<!-- Print variable information -->
								<!-- <pre><?php //print_r ($$bumpProductID); ?></pre> -->
								
								
								<?php if($classiera_ads_status==0){ ?>
								<span>Your ad has been paused and will re-activate after</span>
								<span class="timer<?=$post->ID ?>"></span>
								<?php  } else{ ?>
								<!-- <p>Pausing the ad will stop it for 24 hours.</p> -->
								<?php } ?>
								
								
								
							</div><!--media-body-->
							<div class="classiera_posts_btns">
								<!--PayPerPostbtn-->
								<?php if(!empty($productID) && $postStatus == 'pending'){?>
								<div class="classiera_main_cart">
									<a href="#" class="btn btn-success btn-sm sharp btn-style-one classiera_ppp_btn" data-quantity="1" data-product_id="<?php echo esc_attr( $productID ); ?>" data-product_sku="">
										<?php esc_html_e( 'Pay to Publish', 'classiera' ); ?>
									</a>
									<form method="post" class="classiera_ppp_ajax">				
										<input type="hidden" class="product_id" name="product_id" value="<?php echo esc_attr( $productID ); ?>">
										<input type="hidden" class="post_id" name="post_id" value="<?php echo esc_attr( $post->ID ); ?>">
										<input type="hidden" class="post_title" name="post_title" value="<?php echo esc_html( the_title());?>">
										<input type="hidden" class="days_to_expire" name="days_to_expire" value="<?php echo esc_attr( $days_to_expire ); ?>">
									</form>
									<a class="btn btn-success btn-sm classiera_ppp_cart" href="<?php echo esc_url( $classiera_cart_url );?>">
										<?php esc_html_e( 'View Cart', 'classiera' ); ?>
									</a>
								</div>
								<?php } ?>
								<!--PayPerPostbtn-->
								<!--BumpAds-->
								<?php if(!empty($bumpProductID) && $postStatus == 'publish'){?>
								<div class="classiera_bump_ad">
									<a href="#" class="btn btn-success btn-sm sharp btn-style-one classiera_bump_btn" data-quantity="1" data-product_id="<?php echo esc_attr( $bumpProductID ); ?>" data-product_sku="">
											<?php esc_html_e( 'Bump Ad', 'classiera' ); ?>
									</a>
									<form class="classiera_bump_ad_form">
										<input type="hidden" class="product_id" name="product_id" value="<?php echo esc_attr( $bumpProductID ); ?>">
										<input type="hidden" class="post_id" name="post_id" value="<?php echo esc_attr( $post->ID ); ?>">
										<input type="hidden" class="post_title" name="post_title" value="<?php echo esc_html( the_title() ); ?>">
									</form>
									<a class="btn btn-success btn-sm sharp btn-style-one classiera_bump_cart" href="<?php echo esc_url($classiera_cart_url); ?>">
										<?php esc_html_e( 'View Cart', 'classiera' ); ?>
									</a>
								</div>
								<?php } ?>
								<!--BumpAds-->
								<?php 
									global $redux_demo;
									$edit_post_page_id = $redux_demo['edit_post'];
									if(function_exists('icl_object_id')){
										$templateEditAd = 'template-edit-post.php';		
										$edit_post_page_id = classiera_get_template_url($templateEditAd);
									}
									$postID = $post->ID;
									global $wp_rewrite;
									if ($wp_rewrite->permalink_structure == ''){
										//we are using ?page_id
										$edit_post = $edit_post_page_id."&post=".$post->ID;
										$del_post = $pagepermalink."&delete_id=".$post->ID;
										$soldpost = $pagepermalink."&sold_id=".$post->ID;
										$unsold = $pagepermalink."&un_sold_id=".$post->ID;
										$pausepost=$pagepermalink."?pause_id=".$post->ID;										
									}else{
										//we are using permalinks
										$edit_post = $edit_post_page_id."?post=".$post->ID;
										$del_post = $pagepermalink."?delete_id=".$post->ID;
										$soldpost = $pagepermalink."?sold_id=".$post->ID;
										$unsold = $pagepermalink."?un_sold_id=".$post->ID;
										$pausepost=$pagepermalink."?pause_id=".$post->ID;										
									}
								//if(get_post_status( $post->ID ) !== 'private'){ 	
								?>
								<a href="<?php echo esc_url($edit_post); ?>" class="btn btn-primary sharp btn-style-one btn-sm"><i class="<?php echo esc_attr($iconClass); ?> far fa-edit"></i><?php esc_html_e("Edit", 'classiera') ?></a>
								<?php //} ?>
								<a class="thickbox btn btn-primary sharp btn-style-one btn-sm" href="#TB_inline?height=150&amp;width=400&amp;inlineId=examplePopup<?php echo esc_attr($post->ID); ?>"><i class="<?php echo esc_attr($iconClass); ?> fa fa-trash-alt"></i><?php esc_html_e("Delete", 'classiera') ?></a>
								<div class="delete-popup" id="examplePopup<?php echo esc_attr($post->ID); ?>" style="display:none">
									<h4><?php esc_html_e("Are you sure you want to delete this?", 'classiera') ?></h4>
									<a class="btn btn-primary sharp btn-style-one btn-sm" href="<?php echo esc_url($del_post); ?>">
										<span class="button-inner">
											<?php esc_html_e("Confirm", 'classiera') ?>
										</span>
									</a>
								</div>
								<!--Mark As Sold-->
								<?php /*if($classiera_ads_type == 'sold'){																											?>
									<!--unsold-->
									<a class="thickbox btn btn-primary sharp btn-style-one btn-sm" href="#TB_inline?height=150&amp;width=400&amp;inlineId=unsoldPop<?php echo esc_attr($post->ID); ?>">
										<i class="<?php echo esc_attr($iconClass); ?> fas fa-check-square"></i>
										<?php esc_html_e("un sold", 'classiera') ?>
									</a>
									<div class="delete-popup" id="unsoldPop<?php echo esc_attr($post->ID); ?>" style="display:none">
										<h4>
											<?php esc_html_e("Are you sure you want to mark this as a un-sold ad?", 'classiera') ?>
										</h4>
										<a class="btn btn-primary sharp btn-style-one btn-sm" href="<?php echo esc_url($unsold); ?>">
											<span class="button-inner">
												<?php esc_html_e("Confirm", 'classiera') ?>
											</span>
										</a>
									</div>
									<!--unsold-->
								<?php }else{ ?>
								<a class="thickbox btn btn-primary sharp btn-style-one btn-sm" href="#TB_inline?height=150&amp;width=400&amp;inlineId=soldPop<?php echo esc_attr($post->ID); ?>">
									<i class="<?php echo esc_attr($iconClass); ?> far fa-check-square"></i>
									<?php esc_html_e("Mark as sold", 'classiera') ?>
								</a>
								<div class="delete-popup" id="soldPop<?php echo esc_attr($post->ID); ?>" style="display:none">
									<h4>
										<?php esc_html_e("Are you sure you want to mark this as a sold ad?", 'classiera') ?>
									</h4>
									<a class="btn btn-primary sharp btn-style-one btn-sm" href="<?php echo esc_url($soldpost); ?>">
										<span class="button-inner">
											<?php esc_html_e("Confirm", 'classiera') ?>
										</span>
									</a>
								</div>
								<?php } 																*/								?>																
								<!--Mark As Sold-->
								<?php if($classiera_ads_status==1)
								{
									
										?>
										<!-- set time pause-->
										<a class="thickbox btn btn-primary sharp btn-style-one btn-sm" href="#TB_inline?height=150&amp;width=400&amp;inlineId=soldPopp<?php echo esc_attr($post->ID); ?>">
										<i class="<?php echo esc_attr($iconClass); ?> far fa-check-square"></i>
										<?php esc_html_e("Pause", 'classiera');
										?>
										</a>
										<div class="delete-popup" id="soldPopp<?php echo esc_attr($post->ID); ?>" style="display:none">
										<h4>
										<?php esc_html_e("Are you sure you want to pause your ad for 24 hours? The ad will automatically activate itself after 24 hours and you will not loose your ad display time", 'classiera') ?>
										</h4>
										<a class="btn btn-primary sharp btn-style-one btn-sm" href="<?php echo esc_url($pausepost); ?>">
										<span class="button-inner">
										<?php esc_html_e("Confirm", 'classiera') ?>
										</span>
										</a>
										</div>
										<?php } ?>
										
										
							</div><!--classiera_posts_btns-->
						</div><!--media border-bottom-->
						<?php 					endwhile; ?>
						<?php									
						  if(function_exists('classiera_pagination')){
							classiera_pagination();
						  }
						?>
						<?php wp_reset_query(); ?>	
					</div><!--user-ads user-my-ads-->
					<!-- my ads -->
				</div><!--user-detail-section-->
			</div><!--col-lg-9-->
		</div><!--row-->
	</div><!-- container-->
</section>
<!-- user pages -->
<?php get_footer(); ?>






	
<?php
/**
 * Template name: Profile Page
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
}


if(isset($_GET['pause_id'])){	
$pause_post_id = $_GET['pause_id'];
	echo classiera_post_mark_as_pause($pause_post_id); 
	echo classiera_post_mark_as_status($pause_post_id);
	}
	
	
	
	
if(isset($_GET['un_sold_id'])){
	$un_sold_id = $_GET['un_sold_id'];
	echo classiera_post_mark_as_unsold($un_sold_id);
}
	global $current_user, $user_id;
	$current_user = wp_get_current_user();
	$user_info = get_userdata($user_ID);
	$user_id = $current_user->ID; 
	get_header(); 
?>
<?php 
	global $redux_demo; 
	$all_adds = $redux_demo['all-ads'];
	if (function_exists('icl_object_id')){
		$templateUSERAllAds = 'template-user-all-ads.php';
		$all_adds = classiera_get_template_url($templateAllAds);
	}
	$classiera_cart_url = $redux_demo['classiera_cart_url'];
	$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
	$bumpProductID = $redux_demo['classiera_bump_ad_woo_id'];
	$dateFormat = get_option( 'date_format' );
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$iconClass = 'icon-left';
	if(is_rtl()){
		$iconClass = 'icon-right';
	}
?>
<!-- user pages -->
<section class="user-pages">
	<div class="container">
        <div class="row">
			<div class="col-lg-3 col-md-4">
				<?php get_template_part( 'templates/profile/userabout' );?>
			</div><!--col-lg-3-->
			<div class="col-lg-9 col-md-8 user-content-height">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Panel title</h3>
					</div>
					<div class="panel-body">
						<div class="user-detail-section">
							<!-- about me -->
							<div class="about-me">
								<h4 class="user-detail-section-heading text-uppercase"><?php esc_html_e("About Me", 'classiera') ?></h4>
								<p>
									<?php 
									$user_id = $current_user->ID; 
									$author_desc = get_the_author_meta('description', $user_id);  
									echo esc_html( $author_desc );
									?>
								</p>
							</div>
							<!-- about me -->
							<!-- contact details -->
							<div class="user-contact-details">
								<h4 class="user-detail-section-heading text-uppercase">
									<?php esc_html_e("Contact Details", 'classiera') ?>
								</h4>
								<ul class="list-unstyled">
									<?php 
									$userPhone = get_the_author_meta('phone', $user_id);
									$userPhone2 = get_the_author_meta('phone2', $user_id);
									$userEmail = get_the_author_meta('user_email', $user_id);
									$userwebsite = get_the_author_meta('user_url', $user_id);
									?>
									<?php if(!empty($userPhone)){?>
		                            <li>
		                                <i class="fa fa-phone-square"></i>
		                                <?php echo esc_html( $userPhone ); ?>
		                            </li>
									<?php } ?>
									<?php if(!empty($userPhone2)){?>
		                            <li>
		                                <i class="fa fa-mobile-alt"></i>								
										<?php echo esc_html( $userPhone2 ); ?>
		                            </li>
									<?php } ?>
									<?php if(!empty($userwebsite)){?>
		                            <li>
		                                <i class="fa fa-globe"></i>
		                                <a href="<?php echo esc_url( $userwebsite ); ?>">
											<?php echo esc_url( $userwebsite ); ?>
										</a>
		                            </li>
									<?php } ?>
									<?php if(!empty($userEmail)){?>
		                            <li>
		                                <i class="fa fa-envelope"></i>
		                                <a href="mailto:<?php echo sanitize_email( $userEmail ); ?>"><?php echo sanitize_email( $userEmail ); ?></a>
		                            </li>
									<?php } ?>
		                        </ul>
							</div>
							<!-- contact details -->
							<!-- favorite ads -->
							<div class="user-ads favorite-ads">
								<h4 class="user-detail-section-heading text-uppercase">
								<?php esc_html_e("Favorite Ads", 'classiera') ?>
								</h4>
								<?php 
									global $paged, $wp_query, $wp;
									$args = wp_parse_args($wp->matched_query);
									if ( !empty ( $args['paged'] ) && 0 == $paged ) {
										$wp_query->set('paged', $args['paged']);
										$paged = $args['paged'];
									}
									$cat_id = get_cat_ID(single_cat_title('', false));
									$temp = $wp_query;
									$wp_query= null;
									$wp_query = new WP_Query();
									global $current_user;
									wp_get_current_user();
									$user_id = $current_user->ID;
									$myarray = classiera_authors_all_favorite($user_id);
									if(!empty($myarray)){
										$args = array(
										   'post_type' => 'post',
										   'posts_per_page' => 10,
										   'post__in' => $myarray,
										);
										// The Query
									$wp_query = new WP_Query( $args );
									while ($wp_query->have_posts()) : $wp_query->the_post();
									$postDate = get_the_date($dateFormat, $post->ID);
									$title = get_the_title($post->ID);
									$post_price = get_post_meta($post->ID, 'post_price', true);
									$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
								?>
								<div class="media border-bottom">
									<div class="media-left">
										<?php 
										if ( has_post_thumbnail()){								
										$imgURL = get_the_post_thumbnail_url();
										?>
		                                <img class="media-object" src="<?php echo esc_url($imgURL); ?>" alt="<?php echo esc_html($title); ?>">
										<?php } ?>
		                            </div><!--media-left-->
									<div class="media-body">
										<h5 class="media-heading">
											<a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
												<?php echo esc_html($title); ?>
											</a>
										</h5>
										<p>
											<?php $post_user_ID = $post->post_author; ?>
		                                    <span>
		                                        <i class="fa fa-user"></i>
		                                        <?php echo get_the_author_meta('display_name', $post_user_ID ); ?>
		                                    </span>                                    
		                                    <span>
		                                        <i class="fa fa-clock"></i>
												<?php echo esc_html($postDate); ?>
		                                    </span>
		                                </p>
									</div><!--media-body-->
									<div class="media-right">
										<?php  ?>
		                                <h4>
											<?php 
											if(is_numeric($post_price)){
												echo classiera_post_price_display($post_currency_tag, $post_price);
											}else{ 
												echo esc_html($post_price);
											}
											?>
										</h4>
		                                <?php echo classiera_authors_favorite_remove($user_id, $post->ID);?>
									</div><!--media-right-->
								</div><!--media border-bottom-->
								<?php endwhile; ?>
								<?php wp_reset_query(); ?>
								<?php }else{ ?>
									<p><?php esc_html_e("You do not have any favorite ad yet!", 'classiera') ?></p>
								<?php } ?>
							</div>
							<!-- favorite ads -->
						</div>
					</div>
				</div>
			</div>
		</div><!--row-->
	</div><!--container-->
</section>
<!-- user pages -->
<?php get_footer(); ?>
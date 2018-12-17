<?php
/**
 * Template name: Follow
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */
if ( !is_user_logged_in() ) { 

	global $redux_demo; 
	$login = $redux_demo['login'];
	wp_redirect( $login ); exit;

}
get_header(); 
if(isset($_POST['unfavorite'])){
	$author_id = $_POST['author_id'];
	$post_id = $_POST['post_id'];
	echo classiera_authors_unfavorite($author_id, $post_id);	
}
if(isset($_POST['unfollow'])){
	//print_r($_POST);
	//exit();
	$author_id = $_POST['author_id'];
	$follower_id = $_POST['follower_id'];
	echo classiera_authors_unfollow($author_id, $follower_id);
}

$current_user = wp_get_current_user();
$user_info = get_userdata($user_ID);
$user_id = $current_user->ID; // You can set $user_id to any users, but this gets the current users ID.
$edit = $redux_demo['edit'];
$pagepermalink = get_permalink($post->ID);

global $redux_demo;
$profile = $redux_demo['profile'];
$all_adds = $redux_demo['all-ads'];
$allFavourite = $redux_demo['all-favourite'];
$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
$newPostAds = $redux_demo['new_post'];
$caticoncolor="";
$category_icon_code ="";
$category_icon="";
$category_icon_color="";

?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
?>
<section class="user-pages section-gray-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-4">
			<?php get_template_part( 'templates/profile/userabout' );?>
			</div><!--col-lg-3-->
			<div class="col-lg-9 col-md-8 user-content-height">
				<div class="user-detail-section section-bg-white">
					<!-- followers -->
					<div class="user-ads follower">
						<h4 class="user-detail-section-heading text-uppercase">
							<?php esc_html_e("Followers", 'classiera') ?>
						</h4>
						<div class="row loop-content">
						<?php
							global $wpdb;
							$author_id = $user_id;
							$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_followers WHERE author_id = $author_id", OBJECT );
							if(!empty($results)){
								foreach ($results as $info){									
									$follower_id = $info->follower_id;
									$displayName = get_the_author_meta('display_name', $follower_id );
									$registered = get_the_author_meta('registered', $follower_id );
									$dateFormat = get_option( 'date_format' );
									$classieraRegDate = date_i18n($dateFormat,  strtotime($registered));
									$displayEmail = get_the_author_meta('email', $follower_id );
									$classieraAuthorIMG = get_user_meta($follower_id, "classify_author_avatar_url", true);
									$classieraAuthorIMG = classiera_get_profile_img($classieraAuthorIMG);
									if(empty($classieraAuthorIMG)){
										$classieraAuthorIMG = classiera_get_avatar_url ($displayEmail, $size = '150' );
									}
									?>
									
										<div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
											<div class="media">
												<div class="media-left">
													<img class="media-object" src="<?php echo esc_url( $classieraAuthorIMG ); ?>" alt="<?php echo esc_attr( $displayName ); ?>">
												</div>
												<div class="media-body">
													<h5 class="media-heading">
														<a href="<?php echo get_author_posts_url($follower_id); ?>">
															<?php echo esc_attr( $displayName ); ?>
														</a>
													</h5>
													<p>
													<?php esc_html_e('Member Since', 'classiera') ?>&nbsp;
													<?php echo esc_html( $classieraRegDate ); ?>
													</p>
													<a class="btn btn-primary btn-sm sharp btn-style-one" href="<?php echo get_author_posts_url($follower_id); ?>">
														<?php esc_html_e('View Profile', 'classiera') ?>
													</a>
												</div>
											</div>
										</div>
									
									<?php
								}
							}
						?>
						</div>
					</div>
					<!-- followers -->
					<!-- following -->
					<div class="user-ads follower">
						<h4 class="user-detail-section-heading text-uppercase">
						<?php esc_html_e('Following', 'classiera') ?>
						</h4>
						<div class="row loop-content">
							<?php
							$author_id = $user_id;
							$following = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_followers WHERE follower_id = $author_id", OBJECT );
							if(!empty($following)){
								foreach ($following as $info){									
									$author_id = $info->author_id;									
									$displayName = get_the_author_meta('display_name', $author_id );
									$registered = get_the_author_meta('registered', $author_id );
									$dateFormat = get_option( 'date_format' );
									$classieraRegDate = date_i18n($dateFormat,  strtotime($registered));
									$displayEmail = get_the_author_meta('email', $author_id );
									$classieraAuthorIMG = get_user_meta($author_id, "classify_author_avatar_url", true);
									$classieraAuthorIMG = classiera_get_profile_img($classieraAuthorIMG);
									if(empty($classieraAuthorIMG)){
										$classieraAuthorIMG = classiera_get_avatar_url ($displayEmail, $size = '150' );
									}
									?>
									<div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
										<div class="media">
											<div class="media-left">
												<img class="media-object" src="<?php echo esc_url( $classieraAuthorIMG ); ?>" alt="<?php echo esc_attr( $displayName ); ?>">
											</div>
											<div class="media-body">
												<h5 class="media-heading">
													<a href="<?php echo get_author_posts_url($author_id); ?>">
														<?php echo esc_attr( $displayName ); ?>
													</a>
												</h5>
												<p>
													<?php esc_html_e('Member Since', 'classiera') ?>&nbsp;
													<?php echo esc_html( $classieraRegDate ); ?>
												</p>
												<?php 
													$current_user = wp_get_current_user();
													$user_id = $current_user->ID;
													echo classiera_authors_follower_check($author_id, $user_id); 
												?>
											</div>
										</div>
									</div>
									<?php
								}
							}
							?>
						</div>
					</div>
					<!-- following -->
				</div><!--user-detail-->
			</div><!--col-lg-9-->
		</div><!--row-->
	</div><!--container-->
</section><!--user-pages-->
<?php get_footer(); ?>
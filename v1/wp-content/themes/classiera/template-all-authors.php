<?php
/**
 * Template name: All Authors
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */
 get_header(); ?>
 <?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	global $redux_demo;	
	$classieraSearchStyle = $redux_demo['classiera_search_style'];	
	$classiera_pagination = $redux_demo['classiera_pagination'];
?>
<?php 
	/*==========================
	 Here we will decide which search
	 style user want to use.
	===========================*/
	if($classieraSearchStyle == 1){
		get_template_part( 'templates/searchbar/searchstyle1' );
	}elseif($classieraSearchStyle == 2){
		get_template_part( 'templates/searchbar/searchstyle2' );
	}elseif($classieraSearchStyle == 3){
		get_template_part( 'templates/searchbar/searchstyle3' );
	}elseif($classieraSearchStyle == 4){
		get_template_part( 'templates/searchbar/searchstyle4' );
	}elseif($classieraSearchStyle == 5){
		get_template_part( 'templates/searchbar/searchstyle5' );
	}elseif($classieraSearchStyle == 6){
		get_template_part( 'templates/searchbar/searchstyle6' );
	}elseif($classieraSearchStyle == 7){
		get_template_part( 'templates/searchbar/searchstyle7' );
	}
?>
<section class="inner-page-content border-bottom">
	<div class="container">
		<!-- breadcrumb -->
		<?php classiera_breadcrumbs();?>
		<!-- breadcrumb -->
		<div class="row">
			<div class="col-md-8 col-lg-9 user-content-heigh">
				<div class="user-detail-section section-bg-white">
					<div class="user-ads follower">						
						<div class="row loop-content">
							<?php 
							$limit = 12;
							$current_page = max( 1, get_query_var('paged') );
							$offset = ($current_page - 1) * $limit;
							$defaultsauthors = array(
								'orderby' => 'display_name',
								'order' => 'ASC',
								'number' => $limit,
								'offset' => $offset,
								'exclude_admin' => true,							
							);
							$number_of_users = (int)count(get_users());
							$user_query = new WP_User_Query( $defaultsauthors );
							$total_pages =  ceil( $number_of_users / $limit ) ;
							$allAuthors = get_users();
							if( ! empty( $user_query->results ) ){
								foreach ( $user_query->results as $user ) {
									$authorDisplayName = $user->display_name;
									$authorEmail = $user->user_email;
									$profileName = $user->user_nicename;								
									$authorID = $user->ID;
									$profileURL = get_author_posts_url($authorID, $profileName);
									$authorAvatarURL = get_user_meta($authorID, "classify_author_avatar_url", true);
									$authorAvatarURL = classiera_get_profile_img($authorAvatarURL);
									if(empty($authorAvatarURL)){
										$classieraAuthorIMG = classiera_get_avatar_url($authorEmail, $size = '140' );
									}else{
										$classieraAuthorIMG = $authorAvatarURL;
									}
									$registered = get_the_author_meta('registered', $authorID );
									$dateFormat = get_option( 'date_format' );
									$classieraRegDate = date_i18n($dateFormat,  strtotime($registered));
									?>
									<!--Single user loop-->
									<div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
										<div class="media">
											<div class="media-left">
												<img class="media-object" src="<?php echo esc_url($classieraAuthorIMG); ?>" alt="<?php echo esc_attr($authorDisplayName); ?>">
											</div><!--medialeft-->
											<div class="media-body">
												<h5 class="media-heading">
													<a href="<?php echo esc_url($profileURL); ?>">
														<?php echo esc_attr($authorDisplayName); ?>
													</a>
												</h5>
												<p>
													<?php esc_html_e('Member Since', 'classiera') ?>&nbsp;
													<?php echo esc_html($classieraRegDate);?>
												</p>
												<a class="btn btn-primary btn-sm sharp btn-style-one" href="<?php echo esc_url($profileURL); ?>">
													<?php esc_html_e('View Profile', 'classiera'); ?>
												</a>
											</div><!--media-body-->
										</div><!--media-->
									</div>
									<!--Single user loop-->
									<?php
								}
							}else{
								esc_html__('No result found..!', 'classiera');
							}
							echo '<br clear=all />';
							echo '<div class="pagination">';
							echo paginate_links( array(
								'base' => get_pagenum_link(1) . '%_%',
								'format' => 'page/%#%/',
								'prev_text' => __('Previous Page', 'classiera'), // text for previous page
								'next_text' => __('Next Page', 'classiera'), // text for next page
								'current' => max( 1, get_query_var('paged') ),
								'total' => $total_pages,
							) );
							echo '</div>';
							?>
						</div>
					</div><!--user-ads-->
				</div><!--user-detail-section-->
			</div><!--col-md-8-->
		</div><!--row-->
	</div><!--container-->
</section>
<?php get_footer(); ?>
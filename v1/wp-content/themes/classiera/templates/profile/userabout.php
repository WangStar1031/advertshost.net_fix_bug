<?php 
	global $redux_demo;
	$classieraDisplayName = '';
	$templateProfile = '';
	$templateAllAds = '';
	$templateEditPost = '';
	$templateSubmitAd = '';
	$templateFollow = '';
	$templatePlans = '';
	$templateFavourite = '';
	$current_user = wp_get_current_user();
	$user_ID = $current_user->ID;
	$classieraAuthorEmail = $current_user->user_email;
	$classieraDisplayName = $current_user->display_name;
	if(empty($classieraDisplayName)){
		$classieraDisplayName = $current_user->user_nicename;
	}
	if(empty($classieraDisplayName)){
		$classieraDisplayName = $current_user->user_login;
	}
	$classieraAuthorIMG = get_user_meta($user_ID, "classify_author_avatar_url", true);
	$classieraAuthorIMG = classiera_get_profile_img($classieraAuthorIMG);
	if(empty($classieraAuthorIMG)){
		$classieraAuthorIMG = classiera_get_avatar_url ($classieraAuthorEmail, $size = '150' );
	}	
	$classieraOnlineCheck = classiera_user_last_online($user_ID);
	$UserRegistered = $current_user->user_registered;
	$dateFormat = get_option( 'date_format' );
	$classieraRegDate = date_i18n($dateFormat,  strtotime($UserRegistered));
	$classieraProfile = $redux_demo['profile'];
	$classieraAllAds = $redux_demo['all-ads'];
	$classieraEditProfile = $redux_demo['edit'];
	$classieraPostAds = $redux_demo['new_post'];
	$classieraInbox = $redux_demo['classiera_inbox_page_url'];
	$classieraFollowerPage = $redux_demo['classiera_user_follow'];
	$classieraUserPlansPage = $redux_demo['classiera_single_user_plans'];
	$classieraUserFavourite = $redux_demo['all-favourite'];
	$classiera_bid_system = $redux_demo['classiera_bid_system'];
	if (function_exists('icl_object_id')){ 		
		$templateProfile = 'template-profile.php';
		$templateAllAds = 'template-user-all-ads.php';
		$templateEditProfile = 'template-edit-profile.php';
		$templateSubmitAd = 'template-submit-ads.php';
		$templateFollow = 'template-follow.php';
		$templatePlans = 'template-user-plans.php';
		$templateFavourite = 'template-favorite.php';
		$templateMessage = 'template-message.php';
		
		$classieraProfile = classiera_get_template_url($templateProfile);
		$classieraAllAds = classiera_get_template_url($templateAllAds);
		$classieraEditProfile = classiera_get_template_url($templateEditProfile);
		$classieraPostAds = classiera_get_template_url($templateSubmitAd);
		$classieraFollowerPage = classiera_get_template_url($templateFollow);
		$classieraUserPlansPage = classiera_get_template_url($templatePlans);
		$classieraUserFavourite = classiera_get_template_url($templateFavourite);
		$classieraInbox = classiera_get_template_url($templateMessage);
	}
?>
<aside id="sideBarAffix" class="section-bg-white affix-top">
	<div class="author-info border-bottom">
		<div class="media">
			<div class="media-left">
				<img class="media-object" src="<?php echo esc_url( $classieraAuthorIMG ); ?>" alt="<?php echo esc_attr( $classieraDisplayName ); ?>">
			</div><!--media-left-->
			<div class="media-body">
				<h5 class="media-heading text-uppercase">
					<?php echo esc_attr( $classieraDisplayName ); ?>					
					<?php echo classiera_author_verified($user_ID); ?>
				</h5>
				<p><?php esc_html_e('Member Since', 'classiera') ?>&nbsp;<?php echo esc_html( $classieraRegDate ); ?></p>
				<?php if($classieraOnlineCheck == false){?>
				<span class="offline"><i class="fa fa-circle"></i><?php esc_html_e('Offline', 'classiera') ?></span>
				<?php }else{ ?>
				<span><i class="fa fa-circle"></i><?php esc_html_e('Online', 'classiera') ?></span>
				<?php } ?>
			</div><!--media-body-->
		</div><!--media-->
	</div><!--author-info-->
	<ul class="user-page-list list-unstyled">
		<li class="<?php if(is_page_template( 'template-profile.php' )){echo "active";}?>">
			<a href="<?php echo esc_url( $classieraProfile ); ?>">
				<span>
					<i class="fa fa-user"></i>
					<?php esc_html_e("About Me", 'classiera') ?>
				</span>
			</a>
		</li><!--About-->
		<li class="<?php if(is_page_template( 'template-user-all-ads.php' )){echo "active";}?>">
			<a href="<?php echo esc_url( $classieraAllAds ); ?>">
				<span><i class="fa fa-suitcase"></i><?php esc_html_e("My Ads", 'classiera') ?></span>
				<span class="in-count pull-right flip"><?php echo count_user_posts($user_ID);?></span>
			</a>
		</li><!--My Ads-->
		<li class="<?php if(is_page_template( 'template-favorite.php' )){echo "active";}?>">
			<a href="<?php echo esc_url( $classieraUserFavourite ); ?>">
				<span><i class="fa fa-heart"></i><?php esc_html_e("Watch later Ads", 'classiera') ?></span>
				<span class="in-count pull-right flip">
					<?php 
						global $current_user;
						wp_get_current_user();
						$user_id = $current_user->ID;
						$myarray = classiera_authors_all_favorite($user_id);
						if(!empty($myarray)){
							$args = array(
							   'post_type' => 'post',
							   'post__in'      => $myarray
							);
						$wp_query = new WP_Query( $args );
						$current = -1;
						$current2 = 0;
						while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; $current2++; 													
						endwhile;						
						echo esc_attr( $current2 );
						wp_reset_query();
						}else{
							echo "0";
						}
					?>
				</span>
			</a>
		</li><!--Watch later Ads-->
		<?php if($classiera_bid_system == true){ ?>
		<li class="<?php if(is_page_template( 'template-message.php' )){echo "active";}?>">
			<a href="<?php echo esc_url( $classieraInbox ); ?>">
				<span><i class="fa fa-envelope"></i><?php esc_html_e("Message", 'classiera') ?></span>
				<span class="in-count pull-right flip"><?php echo classiera_total_user_bids($user_ID);?></span>
			</a>
		</li><!--Message-->
		<?php } ?>
		<?php if($classieraUserPlansPage){?>
		<li class="<?php if(is_page_template( 'template-user-plans.php' )){echo "active";}?>">
			<a href="<?php echo esc_url( $classieraUserPlansPage ); ?>">
				<span><i class="fas fa-dollar-sign"></i><?php esc_html_e("Packages", 'classiera') ?></span>
			</a>
		</li><!--Packeges-->
		<?php } ?>
		<li class="<?php if(is_page_template( 'template-follow.php' )){echo "active";}?>">
			<a href="<?php echo esc_url( $classieraFollowerPage ); ?>">
				<span><i class="fa fa-users"></i><?php esc_html_e("Follower", 'classiera') ?></span>
			</a>
		</li><!--follower-->
		<li class="<?php if(is_page_template( 'template-edit-profile.php' )){echo "active";}?>">
			<a href="<?php echo esc_url( $classieraEditProfile ); ?>">
				<span><i class="fa fa-cog"></i><?php esc_html_e("Profile Settings", 'classiera') ?></span>
			</a>
		</li><!--Profile Setting-->
		<li>
			<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>">
				<span><i class="fas fa-sign-out-alt"></i><?php esc_html_e("Logout", 'classiera') ?></span>
			</a>
		</li><!--Logout-->
	</ul><!--user-page-list-->
	<div class="user-submit-ad">
		<a href="<?php echo esc_url( $classieraPostAds ); ?>" class="btn btn-primary sharp btn-block btn-sm btn-user-submit-ad">
			<i class="icon-left fa fa-plus-circle"></i>
			<?php esc_html_e("POST NEW AD", 'classiera') ?>
		</a>
	</div><!--user-submit-ad-->
</aside><!--sideBarAffix-->
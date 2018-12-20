<?php 
	global $redux_demo;
	$classieraDisplayName = '';
	$templateProfile = '';
	$templateAllAds = '';
	$templateEditPost = '';
	$templateSubmitAd = '';
	$templateFollow = '';
	//Get Credits
	$templateGetCredits ='';
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
	//Get Credits variable
	$classieraGetCredits = $redux_demo['get_credits'];
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
		// Get credits page template 
		$templateGetCredits = 'template-get-credits.php';
		$templatePlans = 'template-user-plans.php';
		$templateFavourite = 'template-favorite.php';
		$templateMessage = 'template-message.php';
		
		$classieraProfile = classiera_get_template_url($templateProfile);
		//Get credits
		$classieraGetCredits = calassiera_get_tremplate_url($templateGetCredits);
		$classieraAllAds = classiera_get_template_url($templateAllAds);
		$classieraEditProfile = classiera_get_template_url($templateEditProfile);
		$classieraPostAds = classiera_get_template_url($templateSubmitAd);
		$classieraFollowerPage = classiera_get_template_url($templateFollow);
		$classieraUserPlansPage = classiera_get_template_url($templatePlans);
		$classieraUserFavourite = classiera_get_template_url($templateFavourite);
		$classieraInbox = classiera_get_template_url($templateMessage);
	}
	$userAvatarUrl = get_avatar_url($user_ID);
?>
<aside id="sideBarAffix" class="affix-top">
	<?php if(!in_array( 'buyer', (array) $current_user->roles )): ?>
	<div class="panel panel-default">
	  <div class="panel-heading text-center">
	    <h3 class="panel-title">Wallet Ballance</h3>
	  </div>
	  <div class="panel-body">
	    <div class="wallet-info">
	    	<div class="media">
	    		<div class="media-body">
	    			<!-- Display User Wallet Ballance -->
	    			<div class="wallet-container">
	    				<h4><?php echo do_shortcode("[uw_balance]"); ?></h4>
	    			</div>
	    			<!--/Display User Wallet Ballance -->
	    		</div><!--media-body-->
	    	</div><!--media-->
	    </div><!--author-info-->
	  </div>
	</div>
	<?php endif;?>
	<div class="author-info">
		<div class="panel panel-default">
		  <div class="panel-heading text-center">
		    <h3 class="panel-title">
		    	<?php echo esc_attr( $classieraDisplayName ); ?>					
		    	<?php echo classiera_author_verified($user_ID); ?>
		    </h3>
		  </div>
		  <div class="panel-body">
		    <div class="media">
		    	<div class="media-center">
		    		<img class="media-object" src="<?php echo esc_url( $userAvatarUrl ); ?>" alt="<?php echo esc_attr( $classieraDisplayName ); ?>">
		    	</div><!--media-left-->
		    	<div class="media-body author-details">
		    		<p><?php esc_html_e('Member Since', 'classiera') ?></p>
		    		<p><?php echo esc_html( $classieraRegDate ); ?></p>
		    		<?php if($classieraOnlineCheck == false){?>
		    		<span class="offline"><i class="fa fa-circle"></i><?php esc_html_e('Offline', 'classiera') ?></span>
		    		<?php }else{ ?>
		    		<span><i class="fa fa-circle"></i><?php esc_html_e('Online', 'classiera') ?></span>
		    		<?php } ?>
		    	</div><!--media-body-->
		    </div><!--media-->
		  </div>
		</div>
		
	</div><!--author-info-->

	<div class="panel panel-default">
	  <div class="panel-heading text-center">
	    <h3 class="panel-title"><?php esc_html_e("Menu Options", 'classiera') ?></h3>
	  </div>
	  <div class="panel-body account-options">
	    <ul class="list-group"><!-- user-page-list list-unstyled -->
	    	<li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-profile.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraProfile ); ?>">
	    			<span>
	    				<!-- <i class="fa fa-user"></i> -->
	    				<?php esc_html_e("About Me", 'classiera') ?>
	    			</span>
	    		</a>
	    	</li><!--About-->
	    	<?php if(!in_array( 'buyer', (array) $current_user->roles )): ?>
	    	<li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-user-all-ads.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraAllAds ); ?>">
	    			<span>
	    				<!-- <i class="fa fa-suitcase"></i> -->
	    				<?php esc_html_e("My Ads", 'classiera') ?>
	    			</span>
	    			<span class="in-count pull-right flip badge"><?php echo count_user_posts($user_ID);?></span>
	    		</a>
	    	</li><!--My Ads-->
	    	<?php endif;?>
	    	<li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-favorite.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraUserFavourite ); ?>">
	    			<span>
	    				<!-- <i class="fa fa-heart"></i> -->
	    				<?php esc_html_e("Watch later Ads", 'classiera') ?>
	    			</span>
	    			<span class="in-count pull-right flip badge">
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
	    	<li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-message.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraInbox ); ?>">
	    			<span>
	    				<!-- <i class="fa fa-envelope"></i> -->
	    				<?php esc_html_e("Message", 'classiera') ?>
	    			</span>
	    			<span class="in-count pull-right flip badge"><?php echo count_user_message($user_ID);?></span>
	    		</a>
	    	</li><!--Message-->
	    	<?php } ?>
	    	<?php if($classieraUserPlansPage){?>
	    		<?php if(!in_array( 'buyer', (array) $current_user->roles )): ?>
	    	<li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-user-plans.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraUserPlansPage ); ?>">
	    			<span>
	    				<!-- <i class="fas fa-dollar-sign"></i> -->
	    				<?php esc_html_e("Packages", 'classiera') ?>
	    			</span>
	    		</a>
	    	</li><!--Packages-->
	    		<?php endif; ?>
	    	<?php } ?>
	    	<?php if(!in_array( 'buyer', (array) $current_user->roles )): ?>
	    	<li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-follow.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraFollowerPage ); ?>">
	    			<span>
	    				<!-- <i class="fa fa-users"></i> -->
	    				<?php esc_html_e("Follower", 'classiera') ?>
	    			</span>
	    		</a>
	    	</li><!--Get Credits-->
	    	<?php endif;?>
	    	<?php if(!in_array( 'buyer', (array) $current_user->roles )): ?>
	    	<li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-get-credits.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraGetCredits ); ?>">
	    			<span>
	    				<!-- <i class="fa fa-credit-card"></i> -->
	    				<?php esc_html_e("Get Credits", 'classiera') ?>
	    			</span>
	    		</a>
	    	</li><!-- Get Credits -->
	    	<?php endif;?>
	    	<li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-edit-profile.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraEditProfile ); ?>">
	    			<span>
	    				<!-- <i class="fa fa-cog"></i> -->
	    				<?php esc_html_e("Profile Settings", 'classiera') ?>
	    			</span>
	    		</a>
	    	</li><!--Profile Setting-->
	    	<li class="list-group-item userabout-list-group-item no-padding" >
	    		<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>">
	    			<span>
	    				<!-- <i class="fas fa-sign-out-alt"></i> -->
	    				<?php esc_html_e("Logout", 'classiera') ?>
	    			</span>
	    		</a>
	    	</li><!--Logout-->
	    </ul><!--user-page-list-->
	    <?php if(!in_array( 'buyer', (array) $current_user->roles )): ?>
	    <div class=""><!-- user-submit-ad -->
	    	<a href="<?php echo esc_url( $classieraPostAds ); ?>" class="btn btn-primary btn-block extra-padding">
	    		<!-- <i class="icon-left fa fa-plus-circle"></i> -->
	    		<?php esc_html_e("Create New Advert", 'classiera') ?>
	    	</a>
	    </div><!--user-submit-ad-->
	    <?php endif; ?>
	  </div>
	</div>
</aside><!--sideBarAffix-->
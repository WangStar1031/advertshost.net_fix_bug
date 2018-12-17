<?php 
	global $redux_demo;
	$classieraNavClass = '';
	$classieraColSM = '';
	$classieraColSM2 = '';
	$classieraContainer = 'container';
	$classieraRow = 'row';
	$classieraColLG = 'col-lg-6';
	$classieraColLG2 = 'col-lg-6';
	$classieraColMD = 'col-md-6';
	$classieraColMD2 = 'col-md-6';
	$classieraTopBar = '';
	$classieraLogo = $redux_demo['logo']['url'];
	$classieraContactEmail = $redux_demo['contact-email'];
	$classieraContactPhone = $redux_demo['contact-phone'];
	$classieraProfileURL = $redux_demo['profile'];
	$classieraLoginURL = $redux_demo['login'];
	$classieraSubmitPost = $redux_demo['new_post'];	
	$classieraProfileURL = $redux_demo['profile'];
	$classieraFacebook = $redux_demo['facebook-link'];
	$classieraTwitter = $redux_demo['twitter-link'];
	$classieraGoogle = $redux_demo['google-plus-link'];
	$classieraInstagram = $redux_demo['instagram-link'];
	$classieraRegisterURL = $redux_demo['register'];
	$classieraNavStyle = $redux_demo['nav-style'];
	if($classieraNavStyle == 1){
		$classieraColSM = 'col-sm-6';
		$classieraColSM2 = 'col-sm-6';
		$classieraContainer = 'container';
		$classieraRow = 'row';
		$classieraTopBar = true;
	}elseif($classieraNavStyle == 2){
		$classieraNavClass = 'topBar-v2';
		$classieraContainer = 'container';
		$classieraRow = 'row';
		$classieraColSM = 'col-sm-3';
		$classieraColSM2 = 'col-sm-9';
		$classieraColLG = 'col-lg-3';
		$classieraColLG2 = 'col-lg-9';
		$classieraColMD = 'col-md-3';
		$classieraColMD2 = 'col-md-9';
		$classieraTopBar = true;
	}elseif($classieraNavStyle == 3){
		$classieraNavClass = 'topBar-v3';
		$classieraContainer = 'container-fluid';
		$classieraRow = 'row-fluid';
		$classieraColSM = 'col-sm-8';
		$classieraColSM2 = 'col-sm-4';
		$classieraTopBar = true;
	}elseif($classieraNavStyle == 4){
		$classieraNavClass = 'topBar-v4';
		$classieraContainer = 'container';
		$classieraRow = 'row';
		$classieraColSM = 'col-sm-7';
		$classieraColLG = 'col-lg-6';
		$classieraColLG2 = 'col-lg-6';
		$classieraColSM2 = 'col-sm-5';
		$classieraTopBar = true;
	}elseif($classieraNavStyle == 5){
		$classieraNavClass = 'topBar-v4';
		$classieraTopBar = true;
	}elseif($classieraNavStyle == 6){
		$classieraTopBar = false;
	}elseif($classieraNavStyle == 7){
		$classieraTopBar = false;
	}
	if($classieraTopBar == true){
?>
<section class="topBar <?php echo esc_attr( $classieraNavClass ); ?> hidden-xs">
	<div class="<?php echo esc_attr( $classieraContainer ); ?>">
		<div class="<?php echo esc_attr( $classieraRow ); ?>">
			<div class="<?php echo esc_attr( $classieraColLG ); ?> <?php echo esc_attr( $classieraColMD ); ?> <?php echo esc_attr( $classieraColSM ); ?>">
			<?php if($classieraNavStyle == 1){?>
				<div class="contact-info">
					<?php if(!empty($classieraContactEmail)){?>
					<span>
						<i class="fa fa-envelope"></i>						
						<?php echo sanitize_email( $classieraContactEmail ); ?>
					</span>
					<?php } ?>
					<?php if(!empty($classieraContactPhone)){?>
					<span>
						<i class="fa fa-phone-square"></i>						
						<?php echo esc_html( $classieraContactPhone ); ?>
					</span>
					<?php } ?>
				</div>
			<?php }elseif($classieraNavStyle == 2){?>
				<div class="logo">					
					<a href="<?php echo home_url(); ?>">
						<?php if(empty($classieraLogo)){?>
							<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>">
						<?php }else{ ?>
							<img src="<?php echo esc_url( $classieraLogo ); ?>" alt="<?php bloginfo( 'name' ); ?>">
						<?php } ?>
					</a>
				</div>
			<?php }elseif($classieraNavStyle == 3){ ?>
				<p>
					<?php esc_html_e( 'Support', 'classiera' ); ?>:
					<span><i class="fa fa-envelope-square"></i><?php echo sanitize_email( $classieraContactEmail ); ?></span>
					<span><i class="fa fa-phone-square"></i><?php echo esc_html( $classieraContactPhone ); ?></span>
				</p>
			<?php }elseif($classieraNavStyle == 4){?>
				<div class="contact-info">
					<ul class="list-inline">
						<?php if(!empty($classieraContactEmail)){?>
						<li>
							<?php esc_html_e( 'Email', 'classiera' ); ?>: 
							<span><?php echo sanitize_email( $classieraContactEmail ); ?></span>
						</li>
						<?php } ?>
						<?php if(!empty($classieraContactPhone)){?>
						<li>
							<?php esc_html_e( 'Call', 'classiera' ); ?>: 
							<span><?php echo esc_html( $classieraContactPhone ); ?></span>
						</li>
						<?php } ?>
					</ul>
				</div>
			<?php } ?>
			</div>
			<div class="<?php echo esc_attr( $classieraColLG2 ); ?> <?php echo esc_attr( $classieraColMD2 ); ?> <?php echo esc_attr( $classieraColSM2 ); ?>">
			<?php if($classieraNavStyle == 1){?>	
				<div class="login-info text-right flip">
					<?php if(is_user_logged_in()){?>
						<a href="<?php echo esc_url( $classieraProfileURL ); ?>"><?php esc_html_e( 'My Account', 'classiera' ); ?></a>
						<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>" class="register">
							<i class="far fa-edit"></i>
							<?php esc_html_e( 'Log out', 'classiera' ); ?>
						</a>
					<?php }else{?>
						<a href="<?php echo esc_url( $classieraLoginURL ); ?>"><?php esc_html_e( 'Login', 'classiera' ); ?></a>
						<a href="<?php echo esc_url( $classieraRegisterURL ); ?>" class="register">
							<i class="far fa-edit"></i>
							<?php esc_html_e( 'Get Registered', 'classiera' ); ?>
						</a>
					<?php } ?>
				</div>
			<?php }elseif($classieraNavStyle == 2){?>
				<div class="topBar-v2-icons text-right flip">
					<span><?php esc_html_e( 'Follow Us', 'classiera' ); ?> :</span>
					<span class="top-icons">
						<?php if(!empty($classieraFacebook)){?>
						<a href="<?php echo esc_url( $classieraFacebook ); ?>" class="social-icon-v2 rounded">
							<i class="fab fa-facebook-f"></i>
						</a>
						<?php } ?>
						<?php if(!empty($classieraTwitter)){?>
						<a href="<?php echo esc_url( $classieraTwitter ); ?>" class="social-icon-v2 rounded">
							<i class="fab fa-twitter"></i>
						</a>
						<?php } ?>
						<?php if(!empty($classieraInstagram)){?>
						<a href="<?php echo esc_url( $classieraInstagram ); ?>" class="social-icon-v2 rounded">
							<i class="fab fa-instagram"></i>
						</a>
						<?php } ?>
					</span>
					<?php if(is_user_logged_in()){?>
						<a href="<?php echo esc_url( $classieraProfileURL ); ?>" class="btn btn-primary round btn-md btn-style-two">
							<?php esc_html_e( 'My Account', 'classiera' ); ?>
							<span><i class="fa fa-lock"></i></span>
						</a>
						<a href="<?php echo esc_url( $classieraSubmitPost ); ?>" class="btn btn-primary round btn-md btn-style-two">
							<?php esc_html_e( 'Submit Ad', 'classiera' ); ?>
							<span><i class="fa fa-plus"></i></span>
						</a>
						<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>" class="btn btn-primary round btn-md btn-style-two">
							<?php esc_html_e( 'Log out', 'classiera' ); ?>
							<span><i class="fa fa-lock"></i></span>
						</a>
					<?php }else{ ?>
						<a href="<?php echo esc_url( $classieraLoginURL ); ?>" class="btn btn-primary round btn-md btn-style-two">
							<?php esc_html_e( 'Login', 'classiera' ); ?>
							<span><i class="fa fa-lock"></i></span>
						</a>
						<a href="<?php echo esc_url( $classieraRegisterURL ); ?>" class="btn btn-primary round btn-md btn-style-two">
							<?php esc_html_e( 'Get Registered', 'classiera' ); ?>
							<span><i class="far fa-edit"></i></span>
						</a>
                        <a href="<?php echo esc_url( $classieraSubmitPost ); ?>" class="btn btn-primary round btn-md btn-style-two">
							<?php esc_html_e( 'Submit Ad', 'classiera' ); ?>
							<span><i class="fa fa-plus"></i></span>
						</a>
					<?php } ?>
					<!--LoginButton-->
				</div>
			<?php }elseif($classieraNavStyle == 3){?>
				<div class="login-info text-right text-uppercase flip">
					<?php if(is_user_logged_in()){?>
						<a href="<?php echo esc_url( $classieraProfileURL ); ?>"><?php esc_html_e( 'My Account', 'classiera' ); ?></a>
						<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>">
							<?php esc_html_e( 'Log out', 'classiera' ); ?>
						</a>
					<?php }else{?>
						<a href="<?php echo esc_url( $classieraLoginURL ); ?>"><?php esc_html_e( 'Login', 'classiera' ); ?></a>
						<a href="<?php echo esc_url( $classieraRegisterURL ); ?>">							
							<?php esc_html_e( 'Get Registered', 'classiera' ); ?>
						</a>
					<?php } ?>
				</div>
			<?php }elseif($classieraNavStyle == 4){ ?>
				<div class="follow">
					<ul class="login pull-right flip">
						<?php if(is_user_logged_in()){?>
						<li>
							<a href="<?php echo esc_url( $classieraProfileURL ); ?>">
								<i class="fa fa-user"></i>
								<?php esc_html_e( 'My Account', 'classiera' ); ?>
							</a>
						</li>
						<?php }else{?>
						<li>
							<a href="<?php echo esc_url( $classieraLoginURL ); ?>">
								<i class="fa fa-sign-in"></i>
								<?php esc_html_e( 'Login', 'classiera' ); ?>
							</a>
						</li>
						<?php } ?>
					</ul>
					<ul class="list-inline pull-right flip">
						<li><span><?php esc_html_e( 'Follow Us', 'classiera' ); ?> : </span></li>
						<?php if(!empty($classieraFacebook)){?>
						<li><a href="<?php echo esc_url( $classieraFacebook ); ?>"><i class="fab fa-facebook-f"></i></a></li>
						<?php } ?>
						<?php if(!empty($classieraTwitter)){?>
						<li><a href="<?php echo esc_url( $classieraTwitter ); ?>"><i class="fab fa-twitter"></i></a></li>
						<?php } ?>
						<?php if(!empty($classieraGoogle)){?>
						<li><a href="<?php echo esc_url( $classieraGoogle ); ?>"><i class="fab fa-google-plus-g"></i></a></li>
						<?php } ?>
						<?php if(!empty($classieraInstagram)){?>
						<li><a href="<?php echo esc_url( $classieraInstagram ); ?>"><i class="fab fa-instagram"></i></a></li>
						<?php } ?>
					</ul>
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
</section><!-- /.topBar -->
	<?php } ?>
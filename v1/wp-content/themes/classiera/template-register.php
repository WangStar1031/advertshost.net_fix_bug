<?php
/**
 * Template name: Register Page
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera
 */

if ( is_user_logged_in() ) { 
	global $redux_demo; 
	$profile = $redux_demo['profile'];
	if (function_exists('icl_object_id')){ 
		$templateProfile = 'template-profile.php';
		$profile = classiera_get_template_url($templateProfile);
	}
	wp_redirect( $profile ); exit;
}

	global $user_ID, $user_identity, $user_level, $registerSuccess;
	global $redux_demo;
	$termsandcondition = $redux_demo['termsandcondition'];
	$classieraEmailVerify = $redux_demo['registor-email-verify'];
	$classieraSocialLogin = $redux_demo['classiera_social_login'];
	$login = $redux_demo['login'];
	$registerSuccess = "";
if (!$user_ID) {
	if($_POST){
		//print_r($_POST);
		/*==========================
		Here we get values from 
		form submission
		===========================*/
		$message =  esc_html__( 'Registration successful.', 'classiera' );

		$username = $wpdb->escape($_POST['username']);

		$email = $wpdb->escape($_POST['email']);

		$password = $wpdb->escape($_POST['pwd']);

		$confirm_password = $wpdb->escape($_POST['confirm']);
		
		$remember = $wpdb->escape($_POST['remember']);

		$registerSuccess = 1;
		/*==========================
		 Google (reCAPTCHA) plugin
		 Here we will check if plugin is 
		 active and user have passed 
		 captcha test
		===========================*/
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( function_exists( "gglcptch_display" ) && isset($_POST['g-recaptcha-response'])){
			if(!empty($_POST['g-recaptcha-response'])){
				/*==========================
				If user have passed captcha test
				there we will will start registration
				based on user data.
				===========================*/
				if(!empty($remember)) {			
			
					if(empty($username)) {					
						$message =  esc_html__( 'User name should not be empty.', 'classiera' );
						$registerSuccess = 0;
					}					

					if(isset($email)) {

						if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email)){ 

							wp_update_user( array ('ID' => $user_ID, 'user_email' => $email) ) ;

						}else { 				 
							$message =  esc_html__( 'Please enter a valid email.', 'classiera' );
							$registerSuccess = 0;
						}						

					}else{
						$registerSuccess = 0;
						$message =  esc_html__( 'Please enter a valid email.', 'classiera' );
					}
					/*If Admin Turn Of Email Verification then this code will work*/
					if($classieraEmailVerify != 1){
						if($password) {

							if (strlen($password) < 5 || strlen($password) > 15) {
								
								$message =  esc_html__( 'Password must be 5 to 15 characters in length.', 'classiera' );
								$registerSuccess = 0;
								
							}elseif(isset($password) && $password != $confirm_password) {
								
								$message =  esc_html__( 'Password Mismatch', 'classiera' );

								$registerSuccess = 0;

							}elseif ( isset($password) && !empty($password) ) {

								$update = wp_set_password( $password, $user_ID );						
								$message =  esc_html__( 'Registration successful', 'classiera' );
								$registerSuccess = 1;

							}

						}
					}else{/*If Admin Turn Of Email Verification then this code will work*/
						$password = wp_generate_password( $length=12, $special_chars=false );
					}				

					
					$status = wp_create_user( $username, $password, $email );
					if ( is_wp_error($status) ) {
						$registerSuccess = 0;
						
						$message =  esc_html__( 'Username or E-mail already exists. Please try another one.', 'classiera' );
					}else{
						
						classieraUserNotification( $email, $password, $username );			
						global $redux_demo; 
						$newUsernotification = $redux_demo['newusernotification'];	
							if($newUsernotification == 1){
								classieraNewUserNotifiy($email, $username);	
							}

						$registerSuccess = 1;
					}
					
					/*If Turn OFF Email verification*/
					if($registerSuccess == 1 && $classieraEmailVerify != 1) {
						$login_data = array();
						$login_data['user_login'] = $username;
						$login_data['user_password'] = $password;
						$user_verify = wp_signon( $login_data, false );
						global $redux_demo; 
						$profile = $redux_demo['profile'];
						if (function_exists('icl_object_id')){ 
							$templateProfile = 'template-profile.php';
							$profile = classiera_get_template_url($templateProfile);
						}
						wp_redirect( $profile ); exit;

					}elseif($registerSuccess == 1) {					
						$message =  esc_html__( 'Check Your Inbox for User Name And Password', 'classiera' );
					}

				}else{			
					$message =  esc_html__( 'You Must Need to Agree With Terms And Conditions.', 'classiera' );
					$registerSuccess = 0;
				}
				
			}else{
				$registerSuccess = 0;
				$message = esc_html__( 'Please complete reCAPTCHA.', 'classiera' );
			}
		}else{
			/*==========================
			If you are not using Google reCAPTCHA
			Then here we will start user 
			Registration depends on user data.
			===========================*/
			
			if(!empty($remember)) {			
			
				if(empty($username)) {					
					$message =  esc_html__( 'User name should not be empty.', 'classiera' );
					$registerSuccess = 0;
				}			

				if(isset($email)) {

					if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email)){ 

						wp_update_user( array ('ID' => $user_ID, 'user_email' => $email) ) ;

					}else { 				 
						$message =  esc_html__( 'Please enter a valid email.', 'classiera' );
						$registerSuccess = 0;
					}				

				}else{
					$registerSuccess = 0;
					$message =  esc_html__( 'Please enter a valid email.', 'classiera' );
				}
				/*If Admin Turn Of Email Verification then this code will work*/
				if($classieraEmailVerify != 1){
					if($password) {

						if (strlen($password) < 5 || strlen($password) > 15) {
							
							$message =  esc_html__( 'Password must be 5 to 15 characters in length.', 'classiera' );
							$registerSuccess = 0;
							
						}elseif(isset($password) && $password != $confirm_password) {
							
							$message =  esc_html__( 'Password Mismatch', 'classiera' );

							$registerSuccess = 0;

						}elseif ( isset($password) && !empty($password) ) {

							$update = wp_set_password( $password, $user_ID );						
							$message =  esc_html__( 'Registration successful', 'classiera' );
							$registerSuccess = 1;

						}

					}
				}else{/*If Admin Turn Of Email Verification then this code will work*/
					$password = wp_generate_password( $length=12, $special_chars=false );
				}
				
				$status = wp_create_user( $username, $password, $email );
				if ( is_wp_error($status) ) {
					$registerSuccess = 0;
					
					$message =  esc_html__( 'Username or E-mail already exists. Please try another one.', 'classiera' );
				}else{
					
					classieraUserNotification( $email, $password, $username );			
					global $redux_demo; 
					$newUsernotification = $redux_demo['newusernotification'];	
						if($newUsernotification == 1){
							classieraNewUserNotifiy($email, $username);	
						}

					$registerSuccess = 1;
				}
				
				/*If Turn OFF Email verification*/
				if($registerSuccess == 1 && $classieraEmailVerify != 1) {
					$login_data = array();
					$login_data['user_login'] = $username;
					$login_data['user_password'] = $password;
					$user_verify = wp_signon( $login_data, false );
					global $redux_demo; 
					$profile = $redux_demo['profile'];
					if (function_exists('icl_object_id')){ 
						$templateProfile = 'template-profile.php';
						$profile = classiera_get_template_url($templateProfile);
					}
					wp_redirect( $profile ); exit;

				}elseif($registerSuccess == 1) {					
					$message =  esc_html__( 'Check Your Inbox for User Name And Password', 'classiera' );
				}

			}else{			
				$message =  esc_html__( 'You Must Need to Agree With Terms And Conditions.', 'classiera' );
				$registerSuccess = 0;
			}
			
		}		
	}

}

get_header(); ?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
?>
<section class="inner-page-content border-bottom top-pad-50">
	<div class="login-register login-register-v1">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-md-11 col-sm-12 center-block">
				<?php if(get_option('users_can_register')) { ?>
					<?php if($_POST){?>
						<?php 
						global $redux_demo;
						$login = $redux_demo['login'];
						if (function_exists('icl_object_id')){ 
							$templateLogin = 'template-login.php';
							$login = classiera_get_template_url($templateLogin);
						}
						if($registerSuccess == 1){
							?>
							<div class="alert alert-success" role="alert">
							  <strong><?php esc_html_e('Well done!', 'classiera') ?></strong> <?php esc_html_e('You successfully registered, check your email inbox for password.', 'classiera') ?> <a href="<?php echo esc_attr($login); ?>" class="alert-link"><?php esc_html_e('Click here', 'classiera') ?></a> <?php esc_html_e('for login', 'classiera') ?>.
							</div>
							<?php
						}else{
							?>
							<div class="alert alert-danger" role="alert">
							  <strong><?php esc_html_e('Oh snap!', 'classiera') ?></strong> <?php echo esc_html($message); ?>
							</div>
							<?php
						}
						?>
					<?php } ?>
					<div class="row">
                        <div class="col-lg-12">
                            <div class="classiera-login-register-heading border-bottom text-center">
                                <h3 class="text-uppercase"><?php the_title(); ?></h3>
                            </div>
							<!--SocialLogin-->
							<?php if($classieraSocialLogin == 1){?>
                            <div class="social-login border-bottom">
                                <h5 class="text-uppercase text-center">
									<?php esc_html_e('Login or Signup With Social Account', 'classiera') ?>
								</h5>
								<!--Nextend Facebook-->
								<?php if(class_exists('NextendSocialLogin', false)){ ?>
									<a class="loginSocialbtn fb" href="<?php echo get_site_url(); ?>/wp-login.php?loginFacebook=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginFacebook=1&redirect='+window.location.href; return false;"><i class="fa fa-facebook-f"></i><?php esc_html_e('Login with Facebook', 'classiera') ?></a>
							
								<!--Nextend Twitter-->
									<a class="loginSocialbtn twitter" href="<?php echo get_site_url(); ?>/wp-login.php?loginTwitter=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginTwitter=1&redirect='+window.location.href; return false;"><i class="fa fa-twitter"></i><?php esc_html_e('Login with Twitter', 'classiera') ?></a>
							
								<!--Nextend Google-->
									<a class="loginSocialbtn google" href="<?php echo get_site_url(); ?>/wp-login.php?loginGoogle=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginGoogle=1&redirect='+window.location.href; return false;"><i class="fa fa-google"></i><?php esc_html_e('Login with Google', 'classiera') ?></a>
								<?php } ?>
								<!--AccessPress Socil Login-->
								<?php 
								if( class_exists( 'APSL_Lite_Class' ) ) {
									echo do_shortcode('[apsl-login-lite]');
								}
								if ( class_exists( 'APSL_Class' ) ) {									
									echo do_shortcode('[apsl-login]');
								}
								?>
								<!--AccessPress Socil Login-->
								<div class="social-login-or">
                                    <span><?php esc_html_e('OR', 'classiera') ?></span>
                                </div>
                            </div>
							<?php } ?>
							<!--SocialLogin-->
                        </div><!--col-lg-12-->
                    </div><!--row-->
					<div class="row">
						<div class="col-lg-8 col-sm-11 col-md-9 center-block">
							<form data-toggle="validator" role="form" id="myform" action="" method="POST" enctype="multipart/form-data">
								<!--Username-->
								<div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-3 single-label">
                                            <label for="username"><?php esc_html_e('Username', 'classiera') ?> : 
												<span class="text-danger">*</span>
											</label>
                                        </div>
                                        <div class="col-lg-9 col-sm-9">
                                            <div class="inner-addon left-addon">
                                                <i class="left-addon form-icon fa fa-lock"></i>
                                                <input type="text" id="username" name="username" class="form-control form-control-md" placeholder="<?php esc_html_e('Enter username', 'classiera') ?>" data-error="<?php esc_html_e('username required', 'classiera') ?>" required>
												<div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<!--Username-->
								<!--EmailAddress-->
								<div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-3 single-label">
                                            <label for="email"><?php esc_html_e('Email Address', 'classiera') ?> : <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 col-sm-9">
                                            <div class="inner-addon left-addon">
                                                <i class="left-addon form-icon fa fa-lock"></i>
                                                <input id="email" type="email" name="email" class="form-control form-control-md sharp-edge" placeholder="<?php esc_html_e('example@example.com', 'classiera') ?>" data-error="<?php esc_html_e('Email required', 'classiera') ?>" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<!--EmailAddress-->
								<!--Password-->
								<?php if($classieraEmailVerify != 1){?>
								<div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-3 single-label">
                                            <label for="registerPass"><?php esc_html_e('Password', 'classiera') ?> : <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 col-sm-9">
                                            <div class="inner-addon left-addon">
                                                <i class="left-addon form-icon fa fa-lock"></i>
                                                <input type="password" name="pwd" data-minlength="5" class="form-control form-control-md sharp-edge" placeholder="<?php esc_html_e('enter password', 'classiera') ?>" id="registerPass" data-error="<?php esc_html_e('password required', 'classiera') ?>" required>
                                                <div class="help-block"><?php esc_html_e('Minimum of 5 characters', 'classiera') ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-3 single-label">
                                            <label for="confirmPass"><?php esc_html_e('Confirm', 'classiera') ?> : <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-9 col-sm-9">
                                            <div class="inner-addon left-addon">
                                                <i class="left-addon form-icon fa fa-lock"></i>
                                                <input id="confirmPass" type="password" name="confirm" class="form-control form-control-md sharp-edge" placeholder="<?php esc_html_e('re-enter password', 'classiera') ?>" data-match="#registerPass" data-match-error="<?php esc_html_e('Whoops, these dont match', 'classiera') ?>" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<?php } ?>
								<!--Password-->
								<!--terms-->
								<div class="col-lg-9 col-sm-9 pull-right flip">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <input type="checkbox" name="remember" id="remember" value="forever" data-error="<?php esc_html_e('you must need to agree with our terms and condition', 'classiera') ?>" required>
                                            <label for="remember"><?php esc_html_e('Agree to', 'classiera') ?> 
												<a target="_blank" href="<?php echo esc_url($termsandcondition); ?>">
													<?php esc_html_e('terms & Condition', 'classiera') ?>
												</a>
											</label>
                                            <div class="left-side help-block with-errors"></div>
                                        </div>
                                    </div>	
									<!--Google-->
									<?php
									if ( function_exists( 'gglcptch_display' ) ) {
										?>
										<div class="form-group">
										<?php 
										echo apply_filters( 'gglcptch_display_recaptcha', '', 'classiera_register_form');
										?>										
										</div>
										<?php
									}
									?>									
									<!--Google-->
                                    <div class="form-group">
										<input type="hidden" name="submit" value="Register" id="submit" />
                                        <button type="submit" name="op" class="btn btn-primary sharp btn-md btn-style-one"><?php esc_html_e('Register now', 'classiera') ?></button>
                                    </div>
                                    <div class="form-group">
                                        <p><?php esc_html_e('Already have account?', 'classiera') ?> <a href="<?php echo esc_url($login); ?>"><?php esc_html_e('Login here', 'classiera') ?></a></p>
                                    </div>
                                </div>
								<!--terms-->
							</form>
						</div><!--col-lg-8-->
					</div><!--row-->
				<?php }else{?>
					<div class="alert alert-info" role="alert">
						<i class="fa fa-exclamation-triangle"></i>
						<strong><?php esc_html_e('Registration!', 'classiera') ?></strong> : <?php esc_html_e( 'Registration is currently disabled. Please try again later.', 'classiera' ); ?>
					</div>
				<?php } ?>
				</div><!--col-lg-10-->
			</div><!--row-->
		</div><!--container-->
	</div><!--login-register-->
</section>
<?php get_footer(); ?>
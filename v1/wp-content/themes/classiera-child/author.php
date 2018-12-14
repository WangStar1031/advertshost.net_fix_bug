<?php
/**
 * Template name: Profile Page
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera
 */

global $user_ID;
$author = get_user_by( 'slug', get_query_var( 'author_name' ) ); $user_ID = $author->ID;
$user_info = get_userdata($user_ID);
get_header(); 
	
global $redux_demo;
$currentUser_ID = '';
global $current_user; wp_get_current_user(); $currentUser_ID == $current_user->ID;
$contact_email = get_the_author_meta( 'user_email', $currentUser_ID );
$classieraContactEmailError = $redux_demo['contact-email-error'];
$classieraContactNameError = $redux_demo['contact-name-error'];
$classieraConMsgError = $redux_demo['contact-message-error'];
$classieraContactThankyou = $redux_demo['contact-thankyou-message'];
$classieraAuthorStyle = $redux_demo['classiera_author_page_style'];
$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
$classieraAuthorInfo = $redux_demo['classiera_author_contact_info'];
$classieraAdsView = $redux_demo['home-ads-view'];
$classieraItemClass = "item-grid";
if($classieraAdsView == 'list'){
	$classieraItemClass = "item-list";
}
$classieraOnlineCheck = classiera_user_last_online($user_ID);
$UserRegistered = $current_user->user_registered;
$dateFormat = get_option( 'date_format' );
$classieraRegDate = date_i18n($dateFormat,  strtotime($UserRegistered));

global $nameError;
global $emailError;
global $commentError;
global $subjectError;
global $humanTestError;
$caticoncolor="";
$category_icon_code ="";
$category_icon="";
$category_icon_color="";

//If the form is submitted
if(isset($_POST['submitted'])) {
	
		//Check to make sure that the name field is not empty
		if(trim($_POST['contactName']) === '') {
			$nameError = $classieraContactNameError;
			$hasError = true;
		} elseif(trim($_POST['contactName']) === 'Name*') {
			$nameError = $classieraContactNameError;
			$hasError = true;
		}	else {
			$name = trim($_POST['contactName']);
		}

		//Check to make sure that the subject field is not empty
		if(trim($_POST['subject']) === '') {
			$subjectError = $classiera_contact_subject_error;
			$hasError = true;
		} elseif(trim($_POST['subject']) === 'Subject*') {
			$subjectError = $classiera_contact_subject_error;
			$hasError = true;
		}	else {
			$subject = trim($_POST['subject']);
		}
		
		//Check to make sure sure that a valid email address is submitted
		if(trim($_POST['email']) === '')  {
			$emailError = $classieraContactEmailError;
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
			$emailError = $classieraContactEmailError;
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}
			
		//Check to make sure comments were entered	
		if(trim($_POST['comments']) === '') {
			$commentError = $classieraConMsgError;
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}

		//Check to make sure that the human test field is not empty
		if(trim($_POST['humanTest']) != '8') {
			$humanTestError = "Not Human :(";
			$hasError = true;
		} else {

		}
			
		//If there is no error, send the email
		if(!isset($hasError)) {

			$emailTo = $contact_email;
			$subject = $subject;	
			$body = "Name: $name \n\nEmail: $email \n\nMessage: $comments";
			$headers = 'From <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;			
			if ( function_exists('classiera_send_mail_with_headers')) {
				classiera_send_mail_with_headers($emailTo, $subject, $body, $headers);
			}
			$emailSent = true;

	}
}

?>
<section class="author-box">
	<div class="container border author-box-bg">
		<div class="row">
			<div class="col-lg-12">
				<div class="row no-gutter removeMargin border-bottom author-first-row">
					<div class="col-lg-7 col-sm-7">
						<div class="author-info">
							<div class="media">
								<div class="media-left">
									<?php 
									$classieraAuthorIMGURL = get_user_meta($user_ID, "classify_author_avatar_url", true);
									$classieraAuthorIMGURL = classiera_get_profile_img($classieraAuthorIMGURL);
									$author_verified = get_the_author_meta('author_verified', $user_ID);
									if(empty($classieraAuthorIMGURL)){
										$author_id = get_the_author_meta('user_email', $user_ID);
										$classieraAuthorIMGURL = classiera_get_avatar_url ($author_id, $size = '150' );
									}
									?>
									<img class="media-object" src="<?php echo esc_url($classieraAuthorIMGURL); ?>" alt="<?php echo get_the_author_meta('display_name', $user_ID ); ?>">
								</div><!--media-left-->
								<div class="media-body">
									<h5 class="media-heading text-uppercase">
										<?php echo the_author_posts_link(); ?>
										<?php echo classiera_author_verified($user_ID);?>
									</h5>
									<p>
										<?php esc_html_e('Member Since', 'classiera') ?>&nbsp;
										<?php echo esc_html( $classieraRegDate ); ?>
									</p>
									<?php if($classieraOnlineCheck == false){?>
									<span class="offline"><i class="fa fa-circle"></i><?php esc_html_e('Offline', 'classiera') ?></span>
									<?php }else{ ?>
									<span><i class="fa fa-circle"></i><?php esc_html_e('Online', 'classiera') ?></span>
									<?php } ?>
								</div><!--media-body-->
							</div><!--media-->
						</div><!--author-info-->
					</div><!--col-lg-7-->
					<div class="col-lg-5 col-sm-5">
						<?php if($classieraAuthorInfo == 1){?>
						<div class="author-social">
							<h5 class="text-uppercase"><?php esc_html_e('Social profile Links', 'classiera') ?></h5>
							<div class="author-social-icons">
								<ul class="list-unstyled list-inline">
									<?php 
									$userFacebook = $user_info->facebook;
									$usertwitter = $user_info->twitter;
									$usergoogleplus = $user_info->googleplus;
									$userpinterest = $user_info->pinterest; 
									$userlinkedin = $user_info->linkedin;
									$userEmail = $user_info->user_email; 
									$userInsta = $user_info->instagram;	
									?>
									<?php if(!empty($userFacebook)){?>
									<li>
										<a href="<?php echo esc_url($userFacebook); ?>">
											<i class="fab fa-facebook-f"></i>
										</a>
									</li>
									<?php } ?>
									<?php if(!empty($usertwitter)){?>
									<li>
										<a href="<?php echo esc_url($usertwitter); ?>">
											<i class="fab fa-twitter"></i>
										</a>
									</li>
									<?php } ?>
									<?php if(!empty($usergoogleplus)){?>
									<li>
										<a href="<?php echo esc_url($usergoogleplus); ?>">
											<i class="fab fa-google-plus-g"></i>
										</a>
									</li>
									<?php } ?>
									<?php if(!empty($userpinterest)){?>
									<li>
										<a href="<?php echo esc_url($userpinterest); ?>">
											<i class="fab fa-pinterest-p"></i>
										</a>
									</li>
									<?php } ?>
									<?php if(!empty($userlinkedin)){?>
									<li>
										<a href="<?php echo esc_url($userlinkedin); ?>">
											<i class="fab fa-linkedin"></i>
										</a>
									</li>
									<?php } ?>
									<?php if(!empty($userInsta)){?>
									<li>
										<a href="<?php echo esc_url($userInsta); ?>">
											<i class="fab fa-instagram"></i>
										</a>
									</li>
									<?php } ?>
									<?php if(!empty($userEmail)){?>
									<li>
										<a href="mailto:<?php echo get_the_author_meta('user_email', $user_ID); ?>">
											<i class="fa fa-envelope"></i>
										</a>
									</li>
									<?php } ?>									
								</ul><!--list-unstyled-->
							</div><!--author-social-icons-->
						</div><!--author-social-->
						<?php }else{ ?>
							&nbsp;
						<?php } ?>
					</div><!--col-lg-5 col-sm-5-->
				</div><!--row-->
				<div class="row no-gutter removeMargin author-second-row">
					<div class="col-lg-7">
                        <div class="author-desc">
                            <p>
								<?php echo get_the_author_meta('description', $user_ID); ?>
							</p>
                        </div><!--author-desc-->
                    </div><!--col-lg-7-->
					<div class="col-lg-5">
						<?php if($classieraAuthorInfo == 1){?>
						<div class="author-contact-details">
							<h5 class="text-uppercase"><?php esc_html_e('Contact Details', 'classiera') ?></h5>
							<div class="contact-detail-row">
								<div class="contact-detail-col">
									<?php $userPhone = get_the_author_meta('phone', $user_ID); ?>
									<?php if(!empty($userPhone)){?>
                                    <span>
                                        <i class="fa fa-phone-square"></i>
                                        <a href="tel:<?php echo esc_html($userPhone); ?>">
											<?php echo esc_html($userPhone); ?>
										</a>
                                    </span>
									<?php } ?>
                                </div><!--contact-detail-col-->
								<div class="contact-detail-col">
									<?php $userWebsite = get_the_author_meta('user_url', $user_ID); ?>
									<?php if(!empty($userWebsite)){?>
                                    <span>
                                        <i class="fa fa-globe"></i>
                                        <a href="<?php echo esc_url($userWebsite); ?>">
											<?php echo esc_url($userWebsite); ?>
										</a>
                                    </span>
									<?php } ?>
                                </div><!--contact-detail-col-->
							</div><!--contact-detail-row-->
							<div class="contact-detail-row">
                                <div class="contact-detail-col">
									<?php $userMobile = get_the_author_meta('phone2', $user_ID); ?>
									<?php if(!empty($userMobile)){ ?>
                                    <span>
                                        <i class="fa fa-mobile-alt"></i>                                        
										<a href="tel:<?php echo esc_html($userMobile); ?>">
											<?php echo esc_html($userMobile); ?>
										</a>
                                    </span>
									<?php } ?>
                                </div><!--contact-detail-col-->
                                <div class="contact-detail-col">
									<?php if(!empty($userEmail)){?>
                                    <span>
                                        <i class="fa fa-envelope"></i>
                                        <a href="mailto:<?php echo sanitize_email($userEmail); ?>">
											<?php echo sanitize_email($userEmail); ?>
										</a>
                                    </span>
									<?php } ?>
                                </div><!--contact-detail-col-->
                            </div><!--contact-detail-row-->
						</div><!--author-contact-details-->
						<?php }else{ ?>
							&nbsp;
						<?php } ?>
					</div><!--col-lg-5-->
				</div><!--row no-gutter removeMargin author-second-row-->
			</div><!--col-lg-12-->
		</div><!--row-->
	</div><!--container border author-box-bg-->
</section><!--author-box-->
<?php if($classieraAuthorStyle == 'fullwidth'){?>
<section class="inner-page-content border-bottom">
	<section class="classiera-advertisement advertisement-v1">
		<div class="tab-divs section-light-bg">
			<div class="view-head">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-sm-6 col-xs-6">
                            <div class="total-post">
                                <p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
									<span>
									<?php echo count_user_posts($user_ID);?>&nbsp;
									<?php esc_html_e( 'Ads Posted', 'classiera' ); ?>
									</span>
								</p>
                            </div><!--total-post-->
                        </div><!--col-lg-6 col-sm-6 col-xs-6-->
						<div class="col-lg-6 col-sm-6 col-xs-6">
                            <div class="view-as text-right flip">
                                <span><?php esc_html_e( 'View As', 'classiera' ); ?>:</span>
                                <a id="grid" class="grid btn btn-sm sharp outline <?php if($classieraAdsView == 'grid'){ echo "active"; }?>" href="#"><i class="fa fa-th"></i></a>
                                <a id="list" class="list btn btn-sm sharp outline <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fa fa-bars"></i></a>
                            </div><!--view-as text-right flip-->
                        </div><!--col-lg-6 col-sm-6 col-xs-6-->
					</div><!--row-->
				</div><!--container-->
			</div><!--view-head-->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active" id="all">
					<div class="container">
						<div class="row">
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ){
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}
							$cat_id = get_cat_ID(single_cat_title('', false));
							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('post_type=post&posts_per_page=12&paged='.$paged.'&cat='.$cat_id.'&author='.$user_ID);
						while ($wp_query->have_posts()) : $wp_query->the_post();
							get_template_part( 'templates/classiera-loops/loop-lime');
						endwhile; 
						?>
						</div><!--row-->
						<?php
						if( function_exists('classiera_pagination') ){
							classiera_pagination();
						  }
						?>
					</div><!--container-->
					
				</div><!--tabpanel-->
				
				<?php wp_reset_query(); ?>
			</div><!--tab-content-->
		</div><!--tab-divs section-light-bg-->
	</section><!--classiera-advertisement advertisement-v1-->
</section><!--inner-page-content-->
<?php }elseif($classieraAuthorStyle == 'sidebar'){?>
<section class="inner-page-content border-bottom top-pad-50">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-lg-9">
				<section class="classiera-advertisement advertisement-v1">
					<div class="tab-divs section-light-bg">
						<div class="view-head">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 col-xs-6">
                                        <div class="total-post">
                                            <p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
												<span>
												<?php echo count_user_posts($user_ID);?>&nbsp;
												<?php esc_html_e( 'Ads Posted', 'classiera' ); ?>
												</span>
											</p>
                                        </div><!--total-post-->
                                    </div><!--col-lg-6 col-sm-6 col-xs-6-->
                                    <div class="col-lg-6 col-sm-6 col-xs-6">
                                        <div class="view-as text-right flip">
                                            <span><?php esc_html_e( 'View As', 'classiera' ); ?>:</span>
                                            <a id="grid" class="grid btn btn-sm sharp outline <?php if($classieraAdsView == 'grid'){ echo "active"; }?>" href="#"><i class="fa fa-th"></i></a>
                                            <a id="list" class="list btn btn-sm sharp outline <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fa fa-bars"></i></a>
                                        </div><!--view-as text-right flip-->
                                    </div><!--col-lg-6 col-sm-6 col-xs-6-->
                                </div><!--row-->
                            </div><!--container-->
                        </div><!--view-head-->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active" id="all">
								<div class="container">
									<div class="row">
									<?php 
									global $paged, $wp_query, $wp;
									$args = wp_parse_args($wp->matched_query);
									if ( !empty ( $args['paged'] ) && 0 == $paged ){
										$wp_query->set('paged', $args['paged']);
										$paged = $args['paged'];
									}
									$cat_id = get_cat_ID(single_cat_title('', false));
									$temp = $wp_query;
									$wp_query= null;
									$wp_query = new WP_Query();
									$wp_query->query('post_type=post&posts_per_page=12&paged='.$paged.'&cat='.$cat_id.'&author='.$user_ID);
									while ($wp_query->have_posts()) : $wp_query->the_post();
										get_template_part( 'templates/classiera-loops/loop-lime');
									endwhile; 
									?>
									</div><!--row-->
								</div><!--container-->
							</div><!--tabpanel-->
						</div><!--tab-content-->
					</div><!--tab-divs section-light-bg-->
				</section><!--classiera-advertisement advertisement-v1-->
				<?php
				  if ( function_exists('classiera_pagination') ){
					classiera_pagination();
				  }
				?>
				<?php wp_reset_query(); ?>
			</div><!--col-md-8 col-lg-9-->
			<!--Sidebar-->
			<div class="col-md-4 col-lg-3">
				<aside class="sidebar">
					<div class="row">
						<?php get_sidebar('pages'); ?>
					</div>
				</aside>
			</div>
			<!--Sidebar-->
		</div><!--row-->
	</div><!--container-->
</section>
<?php } ?>
<!-- Company Section Start-->
<?php 
	global $redux_demo; 
	$classieraCompany = $redux_demo['partners-on'];
	$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
	if($classieraCompany == 1){
		if($classieraPartnersStyle == 1){
			get_template_part('templates/members/memberv1');
		}elseif($classieraPartnersStyle == 2){
			get_template_part('templates/members/memberv2');
		}elseif($classieraPartnersStyle == 3){
			get_template_part('templates/members/memberv3');
		}elseif($classieraPartnersStyle == 4){
			get_template_part('templates/members/memberv4');
		}elseif($classieraPartnersStyle == 5){
			get_template_part('templates/members/memberv5');
		}elseif($classieraPartnersStyle == 6){
			get_template_part('templates/members/memberv6');
		}
	}
?>
<!-- Company Section End-->	
<?php get_footer(); ?>
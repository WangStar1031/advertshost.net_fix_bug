<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */
get_header(); ?>
	
	<?php while ( have_posts() ) : the_post(); ?>


<?php 

global $redux_demo; 
global $allowed_html; 
global $current_user; wp_get_current_user(); $user_ID == $current_user->ID;
$profileLink = get_the_author_meta( 'user_url', $user_ID );
$contact_email = get_the_author_meta('user_email');
$classieraContactEmailError = $redux_demo['contact-email-error'];
$classieraContactNameError = $redux_demo['contact-name-error'];
$classieraConMsgError = $redux_demo['contact-message-error'];
$classieraContactThankyou = $redux_demo['contact-thankyou-message'];
$classieraRelatedCount = $redux_demo['classiera_related_ads_count'];
$classieraSearchStyle = $redux_demo['classiera_search_style'];
$classieraSingleAdStyle = $redux_demo['classiera_single_ad_style'];
$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
$classieraComments = $redux_demo['classiera_sing_post_comments'];
$googleMapadPost = $redux_demo['google-map-adpost'];
$classieraToAuthor = $redux_demo['author-msg-box-off'];
$classieraReportAd = $redux_demo['classiera_report_ad'];
$locShownBy = $redux_demo['location-shown-by'];
$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
$classieraAuthorInfo = $redux_demo['classiera_author_contact_info'];
$classieraPriceSection = $redux_demo['classiera_sale_price_off'];
$classiera_bid_system = $redux_demo['classiera_bid_system'];
$category_icon_code = "";
$category_icon_color = "";
$your_image_url = "";

global $errorMessage;
global $emailError;
global $commentError;
global $subjectError;
global $humanTestError;
global $hasError;

//If the form is submitted
if(isset($_POST['submit'])) {
	if($_POST['submit'] == 'send_message'){
		//echo "send_message";

		//Check to make sure that the name field is not empty
		// if(trim($_POST['contactName']) === '') {
		// 	$errorMessage = $classieraContactNameError;
		// 	$hasError = true;
		// } elseif(trim($_POST['contactName']) === 'Name*') {
		// 	$errorMessage = $classieraContactNameError;
		// 	$hasError = true;
		// }	else {
		// 	$name = trim($_POST['contactName']);
		// }

		//Check to make sure that the subject field is not empty
		if(trim($_POST['subject']) === '') {
			$errorMessage = $classiera_contact_subject_error;
			$hasError = true;
		} elseif(trim($_POST['subject']) === 'Subject*') {
			$errorMessage = $classiera_contact_subject_error;
			$hasError = true;
		}	else {
			$subject = trim($_POST['subject']);
		}
		
		//Check to make sure sure that a valid email address is submitted
		// if(trim($_POST['email']) === ''){
		// 	$errorMessage = $classieraContactEmailError;
		// 	$hasError = true;		
		// }else{
		// 	$email = trim($_POST['email']);
		// }
			
		//Check to make sure comments were entered	
		if(trim($_POST['comments']) === '') {
			$errorMessage = $classieraConMsgError;
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}

		//Check to make sure that the human test field is not empty
		$classieraCheckAnswer = $_POST['humanAnswer'];
		if(trim($_POST['humanTest']) != $classieraCheckAnswer) {
			$errorMessage = esc_html__('Not Human', 'classiera');			
			$hasError = true;
		}
		$classieraPostTitle = $_POST['classiera_post_title'];	
		$classieraPostURL = $_POST['classiera_post_url'];
		
		//If there is no error, send the email		
		if(!isset($hasError)) {

			$emailTo = $contact_email;
			$subject = $subject;	
			$body = "Name: $name \n\nEmail: $email \n\nMessage: $comments";
			$headers = 'From <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
			
			//wp_mail($emailTo, $subject, $body, $headers);
			contactToAuthor($emailTo, $subject, $name, $email, $comments, $headers, $classieraPostTitle, $classieraPostURL);
			$emailSent = true;			

		}
	}
	if($_POST['submit'] == 'report_to_admin'){		
		$displayMessage = '';
		$report_ad = $_POST['report_ad_val'];
		if($report_ad == "illegal") {
			$message = esc_html__('This is illegal/fraudulent Ads, please take action.', 'classiera');
		}
		if($report_ad == "spam") {
			$message = esc_html__('This Ad is SPAM, please take action', 'classiera');			
		}
		if($report_ad == "duplicate") {
			$message = esc_html__('This ad is a duplicate, please take action', 'classiera');			
		}
		if($report_ad == "wrong_category") {
			$message = esc_html__('This ad is in the wrong category, please take action', 'classiera');			
		}
		if($report_ad == "post_rules") {
			$message = esc_html__('The ad goes against posting rules, please take action', 'classiera');			
		}
		if($report_ad == "post_other") {
			$message = $_POST['other_report'];				
		}		
		$classieraPostTitle = $_POST['classiera_post_title'];	
		$classieraPostURL = $_POST['classiera_post_url'];
		//print_r($message); exit();
		classiera_reportAdtoAdmin($message, $classieraPostTitle, $classieraPostURL);
		if(!empty($message)){
			$displayMessage = esc_html__('Thanks for report, Our Team will take action ASAP.', 'classiera');
		}
	}
	
}
if(isset($_POST['favorite'])){
	$author_id = $_POST['author_id'];
	$post_id = $_POST['post_id'];
	echo classiera_favorite_insert($author_id, $post_id);
}
if(isset($_POST['follower'])){	
	$author_id = $_POST['author_id'];
	$follower_id = $_POST['follower_id'];
	echo classiera_authors_insert($author_id, $follower_id);
}
if(isset($_POST['unfollow'])){
	$author_id = $_POST['author_id'];
	$follower_id = $_POST['follower_id'];
	echo classiera_authors_unfollow($author_id, $follower_id);
}

?>
<?php 
	//Search Styles//
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
<section class="inner-page-content single-post-page">
	<div class="container">
		<!-- breadcrumb -->
		<?php classiera_breadcrumbs();?>
		<!-- breadcrumb -->
		<!--Google Section-->
		<?php 
		$homeAd1 = '';
		//print_r($homeAd1);		
		global $redux_demo;
		$homeAdImg1 = $redux_demo['home_ad2']['url']; 
		$homeAdImglink1 = $redux_demo['home_ad2_url']; 
		$homeHTMLAds = $redux_demo['home_html_ad2'];		
		if(!empty($homeHTMLAds) || !empty($homeAdImg1)){
		?>
		<section id="classieraDv">
			<div class="container">
				<div class="row">							
					<div class="col-lg-12 col-md-12 col-sm-12 center-block text-center">						
						<?php 
						if(!empty($homeHTMLAds)){
							echo classiera_display_html_ad_code($homeHTMLAds);
						}else{
							echo '<a href="'.$homeAdImglink1.'" target="_blank"><img class="img-responsive" alt="image" src="'.$homeAdImg1.'" /></a>';
						}
						?>
					</div>
				</div>
			</div>	
		</section>
		<?php } ?>
		<?php if ( get_post_status ( $post->ID ) == 'private' || get_post_status ( $post->ID ) == 'pending' ) {?>
		<div class="alert alert-info" role="alert">
		  <p>
		  <strong><?php esc_html_e('Congratulations!', 'classiera') ?></strong> <?php esc_html_e('Your Ad has submitted and pending for review. After review your Ad will be live for all users. You may not preview it more than once.!', 'classiera') ?>
		  </p>
		</div>
		<?php } ?>
		<!--Google Section-->
		<?php if($classieraSingleAdStyle == 2){
			get_template_part( 'templates/singlev2' );
		}?>
		<div class="row">
			<div class="col-md-8">
				<!-- single post -->
				<div class="single-post">
					<?php if($classieraSingleAdStyle == 1){
						get_template_part( 'templates/singlev1');
					}?>
					<?php 
					$post_price = get_post_meta($post->ID, 'post_price', true); 
					$post_old_price = get_post_meta($post->ID, 'post_old_price', true);
					$postVideo = get_post_meta($post->ID, 'post_video', true);
					$dateFormat = get_option( 'date_format' );
					$postDate = get_the_date($dateFormat, $post->ID);
					$itemCondition = get_post_meta($post->ID, 'item-condition', true); 
					$post_location = get_post_meta($post->ID, 'post_location', true);
					$post_state = get_post_meta($post->ID, 'post_state', true);
					$post_city = get_post_meta($post->ID, 'post_city', true);
					$post_phone = get_post_meta($post->ID, 'post_phone', true);
					// My Additions
					$second_phone = get_post_meta($post->ID, 'second_phone', true);
					$nationality = get_post_meta($post->ID, 'nationality', true);
					$user_age = get_post_meta($post->ID, 'user_age', true);
					$hair_color = get_post_meta($post->ID, 'hair_color', true);
					$eyes_color = get_post_meta($post->ID, 'eyes_color', true);
					$ethnicity = get_post_meta($post->ID, 'ethnicity', true);
					$height_feet = get_post_meta($post->ID, 'height_feet', true);
					$height_inches = get_post_meta($post->ID, 'height_inches', true);
					$weight = get_post_meta($post->ID, 'weight', true);
					$breast_type = get_post_meta($post->ID, 'breast_type', true);
					$breast_size = get_post_meta($post->ID, 'breast_size', true);
					$breast_size_cup = get_post_meta($post->ID, 'breast_size_cup', true);
					$breast_size_cup = get_post_meta($post->ID, 'breast_size_cup', true);
					$waist_size = get_post_meta($post->ID, 'waist_size', true);
					$hips_size = get_post_meta($post->ID, 'hips_size', true);
					$dress_size = get_post_meta($post->ID, 'dress_size', true);
					$shoe_size = get_post_meta($post->ID, 'shoe_size', true);
					$pubic_area = get_post_meta($post->ID, 'pubic_area', true);
					$smoker = get_post_meta($post->ID, 'smoker', true);
					$native_language = get_post_meta($post->ID, 'native_language', true);
					$language_1 = get_post_meta($post->ID, 'language_1', true);
					$language_1_level = get_post_meta($post->ID, 'language_1_level', true);
					$language_2 = get_post_meta($post->ID, 'language_2', true);
					$language_2_level = get_post_meta($post->ID, 'language_2_level', true);
					$private_numbers = get_post_meta($post->ID, 'private_numbers', true);
					$sms_messages = get_post_meta($post->ID, 'sms_messages', true);
					$private_messages = get_post_meta($post->ID, 'private_messages', true);
					$disabled_friendly = get_post_meta($post->ID, 'disabled_friendly', true);
					$drinks_supplied = get_post_meta($post->ID, 'drinks_supplied', true);
					$showers_available = get_post_meta($post->ID, 'showers_available', true);
					$can_travel = get_post_meta($post->ID, 'can_travel', true);
					// / My Additions
					$post_latitude = get_post_meta($post->ID, 'post_latitude', true);
					$post_longitude = get_post_meta($post->ID, 'post_longitude', true);
					$post_address = get_post_meta($post->ID, 'post_address', true);
					$classieraCustomFields = get_post_meta($post->ID, 'custom_field', true);					
					$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
					

					?>
					<!-- ad deails -->
					<div class="border-section border details">
                        <h4 class="border-section-heading text-uppercase"><!-- <i class="<far fa-file-alt"></i> --><?php esc_html_e('Details', 'classiera') ?></h4>
                        <div class="post-details">
                            <ul class="list-unstyled clearfix">
								<!-- <li>
                                    <p><?php esc_html_e( 'Ad ID', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<i class="fa fa-hashtag IDIcon"></i>
										<?php echo esc_attr($post->ID); ?>
									</span>
									</p>
                                </li> -->
                                <li><!--PostDate
                                    <p><?php esc_html_e( 'Added', 'classiera' ); ?>: 
									<span class="pull-right flip"><?php echo esc_html($postDate); ?></span>
									</p>
                                </li> PostDate-->								
								<!--Price Section -->
								<?php 
								$classieraPriceSection = $redux_demo['classiera_sale_price_off'];
								if($classieraPriceSection == 1){
								?>
								<?php if(!empty($post_price)){
									$discount_percent=get_post_meta($post->ID,'discount_percentage',true);
									//print_r($discount_percent);
									if($discount_percent>0)
									{
										$post_discount_price=($post_price/100)*$discount_percent;
										$post_price=$post_price-$post_discount_price;
									}

									?>
								<li>
                                    <p><?php esc_html_e( 'Price', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<?php 
										if(is_numeric($post_price)){
											echo classiera_post_price_display($post_currency_tag, $post_price);
										}else{ 											
											echo esc_attr($post_price);
										}									
										?>
									</span>
									</p>
                                </li><!--Sale Price-->
								<?php } ?>
								<?php if(!empty($post_old_price)){?>
								<li>
                                    <p><?php esc_html_e( 'Regular Price', 'classiera' ); ?>: 
									<span class="pull-right flip">										
										<?php 
										if(is_numeric($post_old_price)){
											echo classiera_post_price_display($post_currency_tag, $post_old_price);
										}else{ 
											echo esc_attr($post_old_price); 
										}
										?>
									</span>
									</p>
                                </li><!--Regular Price-->
								<?php } ?>
								<!--Price Section -->
								<?php } ?>
								<?php if(!empty($itemCondition)){?>
								<li>
                                    <p><?php esc_html_e( 'Condition', 'classiera' ); ?>: 
									<span class="pull-right flip"><?php echo esc_attr($itemCondition); ?></span>
									</p>
                                </li><!--Condition-->
								<?php } ?>
								<?php if(!empty($post_location)){?>
								<li>
                                    <p><?php esc_html_e( 'Location', 'classiera' ); ?>: 
									<span class="pull-right flip"><?php echo esc_attr($post_location); ?></span>
									</p>
                                </li><!--Location-->
								<?php } ?>
								<?php if(!empty($post_state)){?>
								<li>
                                    <p><?php esc_html_e( 'County', 'classiera' ); ?>: 
									<span class="pull-right flip"><?php echo esc_attr($post_state); ?></span>
									</p>
                                </li><!--state-->
								<?php } ?>
								<?php if(!empty($post_city)){?>
								<li>
                                    <p><?php esc_html_e( 'City', 'classiera' ); ?>: 
									<span class="pull-right flip"><?php echo esc_attr($post_city); ?></span>
									</p>
                                </li><!--City-->
								<?php } ?>
								<?php if(!empty($post_phone)){?>
								<li>
                                    <p><?php esc_html_e( 'Phone', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($post_phone); ?>">
											<?php echo esc_html($post_phone); ?>
										</a>
									</span>
									</p>
                                </li><!--Phone-->
								<?php } ?>
								<?php if(!empty($second_phone)){?>
								<li>
                                    <p><?php esc_html_e( 'Phone', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($second_phone); ?>">
											<?php echo esc_html($second_phone); ?>
										</a>
									</span>
									</p>
                                </li><!--Phone-->
								<?php } ?>
								<?php if(!empty($nationality)){?>
								<li>
                                    <p><?php esc_html_e( 'Nationality', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($nationality); ?>">
											<?php echo esc_html($nationality); ?>
										</a>
									</span>
									</p>
                                </li><!--Phone-->
								<?php } ?>
								<?php if(!empty($user_age)){?>
								<li>
                                    <p><?php esc_html_e( 'Age', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($user_age); ?>">
											<?php echo esc_html($user_age); ?>
										</a>
									</span>
									</p>
                                </li><!--Phone-->
								<?php } ?>
								<?php if(!empty($hair_color)){?>
								<li>
                                    <p><?php esc_html_e( 'Hair Color', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($hair_color); ?>">
											<?php echo esc_html($hair_color); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($eyes_color)){?>
								<li>
                                    <p><?php esc_html_e( 'Eyes Color', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($eyes_color); ?>">
											<?php echo esc_html($eyes_color); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($ethnicity)){?>
								<li>
                                    <p><?php esc_html_e( 'Ethnicity', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($ethnicity); ?>">
											<?php echo esc_html($ethnicity); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($height_feet)){?>
								<li>
                                    <p><?php esc_html_e( 'Height in Feet', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($height_feet); ?>">
											<?php echo esc_html($height_feet); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($height_inches)){?>
								<li>
                                    <p><?php esc_html_e( 'Height in Inches', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($height_inches); ?>">
											<?php echo esc_html($height_inches); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($weight)){?>
								<li>
                                    <p><?php esc_html_e( 'Weight', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($weight); ?>">
											<?php echo esc_html($weight); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($breast_size)){?>
								<li>
                                    <p><?php esc_html_e( 'Breast Size', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($breast_size); ?>">
											<?php echo esc_html($breast_size); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($breast_size_cup)){?>
								<li>
                                    <p><?php esc_html_e( 'Breast Size Cup', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($breast_size_cup); ?>">
											<?php echo esc_html($breast_size_cup); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($breast_type)){?>
								<li>
                                    <p><?php esc_html_e( 'Breast Type', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($breast_type); ?>">
											<?php echo esc_html($breast_type); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($waist_size)){?>
								<li>
                                    <p><?php esc_html_e( 'Waist Size', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($waist_size); ?>">
											<?php echo esc_html($waist_size); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($hips_size)){?>
								<li>
                                    <p><?php esc_html_e( 'Hips Size', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($hips_size); ?>">
											<?php echo esc_html($hips_size); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($dress_size)){?>
								<li>
                                    <p><?php esc_html_e( 'Dress Size', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($dress_size); ?>">
											<?php echo esc_html($dress_size); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($shoe_size)){?>
								<li>
                                    <p><?php esc_html_e( 'Shoe Size', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($shoe_size); ?>">
											<?php echo esc_html($shoe_size); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($pubic_area)){?>
								<li>
                                    <p><?php esc_html_e( 'Pubic Area', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($pubic_area); ?>">
											<?php echo esc_html($pubic_area); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($smoker)){?>
								<li>
                                    <p><?php esc_html_e( 'Smoker', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($smoker); ?>">
											<?php echo esc_html($smoker); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($native_language)){?>
								<li>
                                    <p><?php esc_html_e( 'Native Language', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($native_language); ?>">
											<?php echo esc_html($native_language); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($language_1)){?>
								<li>
                                    <p><?php esc_html_e( 'Language 1', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($language_1); ?>">
											<?php echo esc_html($language_1); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($language_1_level)){?>
								<li>
                                    <p><?php esc_html_e( 'Language 1 Level', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($language_1_level); ?>">
											<?php echo esc_html($language_1_level); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($language_2)){?>
								<li>
                                    <p><?php esc_html_e( 'Language 2', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($language_2); ?>">
											<?php echo esc_html($language_2); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($language_2_level)){?>
								<li>
                                    <p><?php esc_html_e( 'Language 2 Level', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($language_2_level); ?>">
											<?php echo esc_html($language_2_level); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($private_numbers)){?>
								<li>
                                    <p><?php esc_html_e( 'Private Numbers', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($private_numbers); ?>">
											<?php echo esc_html($private_numbers); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($sms_messages)){?>
								<li>
                                    <p><?php esc_html_e( 'SMS Messages', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($sms_messages); ?>">
											<?php echo esc_html($sms_messages); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($private_messages)){?>
								<li>
                                    <p><?php esc_html_e( 'Private Messages', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($private_messages); ?>">
											<?php echo esc_html($private_messages); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($disabled_friendly)){?>
								<li>
                                    <p><?php esc_html_e( 'Disabled Friendly', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($disabled_friendly); ?>">
											<?php echo esc_html($disabled_friendly); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($drinks_supplied)){?>
								<li>
                                    <p><?php esc_html_e( 'Drinks Supplied', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($drinks_supplied); ?>">
											<?php echo esc_html($drinks_supplied); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($showers_available)){?>
								<li>
                                    <p><?php esc_html_e( 'Showers Available', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($showers_available); ?>">
											<?php echo esc_html($showers_available); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>
								<?php if(!empty($can_travel)){?>
								<li>
                                    <p><?php esc_html_e( 'Available to Travel', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<a href="tel:<?php echo esc_html($can_travel); ?>">
											<?php echo esc_html($can_travel); ?>
										</a>
									</span>
									</p>
                                </li>
								<?php } ?>

								<li>
                                    <p><?php esc_html_e( 'Views', 'classiera' ); ?>: 
									<span class="pull-right flip">
										<?php echo classiera_get_post_views(get_the_ID()); ?>
									</span>
									</p>
                                </li><!--Views-->
								<?php 
								if(!empty($classieraCustomFields)) {
									for ($i = 0; $i < count($classieraCustomFields); $i++){
										if($classieraCustomFields[$i][2] != 'dropdown' && $classieraCustomFields[$i][2] != 'checkbox'){
											if(!empty($classieraCustomFields[$i][1]) && !empty($classieraCustomFields[$i][0]) ) {
												?>
											<li>
												<p><?php echo esc_attr($classieraCustomFields[$i][0]); ?>: 
												<span class="pull-right flip">
													<?php echo esc_attr($classieraCustomFields[$i][1]); ?>
												</span>
												</p>
											</li><!--test-->	
												<?php
											}
										}
									}
									for ($i = 0; $i < count($classieraCustomFields); $i++){
										if($classieraCustomFields[$i][2] == 'dropdown'){
											if(!empty($classieraCustomFields[$i][1]) && !empty($classieraCustomFields[$i][0]) ){
											?>
											<li>
												<p><?php echo esc_attr($classieraCustomFields[$i][0]); ?>: 
												<span class="pull-right flip">
													<?php echo esc_attr($classieraCustomFields[$i][1]); ?>
												</span>
												</p>
											</li><!--dropdown-->
											<?php
											}
										}
									}
									for ($i = 0; $i < count($classieraCustomFields); $i++){
										if($classieraCustomFields[$i][2] == 'checkbox'){
											if(!empty($classieraCustomFields[$i][1]) && !empty($classieraCustomFields[$i][0]) ){
											?>
											<li>
												<p><?php echo esc_attr($classieraCustomFields[$i][0]); ?>: 
												<span class="pull-right flip">
													<i class="fas fa-check"></i>
												</span>
												</p>
											</li><!--dropdown-->
											<?php	
											}
										}
									}
								}
								?>
                            </ul>
                        </div><!--post-details-->
                    </div>
					<!-- ad details -->

					<!--PostVideo-->
					<?php if(!empty($postVideo)) { ?>
					<div class="border-section border postvideo">
						<h4 class="border-section-heading text-uppercase">
						<?php esc_html_e( 'Video', 'classiera' ); ?>
						</h4>
						<?php 
						if(preg_match("/youtu.be\/[a-z1-9.-_]+/", $postVideo)) {
							preg_match("/youtu.be\/([a-z1-9.-_]+)/", $postVideo, $matches);
							if(isset($matches[1])) {
								$url = 'https://www.youtube.com/embed/'.$matches[1];
								$video = '<iframe class="embed-responsive-item" src="'.$url.'" frameborder="0" allowfullscreen></iframe>';
							}
						}elseif(preg_match("/youtube.com(.+)v=([^&]+)/", $postVideo)) {
							preg_match("/v=([^&]+)/", $postVideo, $matches);
							if(isset($matches[1])) {
								$url = 'https://www.youtube.com/embed/'.$matches[1];
								$video = '<iframe class="embed-responsive-item" src="'.$url.'" frameborder="0" allowfullscreen></iframe>';
							}
						}elseif(preg_match("#https?://(?:www\.)?vimeo\.com/(\w*/)*(([a-z]{0,2}-)?\d+)#", $postVideo)) {
							preg_match("/vimeo.com\/([1-9.-_]+)/", $postVideo, $matches);
							//print_r($matches); exit();
							if(isset($matches[1])) {
								$url = 'https://player.vimeo.com/video/'.$matches[1];
								$video = '<iframe class="embed-responsive-item" src="'.$url.'" frameborder="0" allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>';
							}
						}else{
							$video = $postVideo;
						}
						?>
						<div class="embed-responsive embed-responsive-16by9">
							<?php echo wpautop($video); ?>
						</div>
					</div>
					<?php } ?>
					<!--PostVideo-->
					<!-- post description -->
					<div class="border-section border description">
						<h4 class="border-section-heading text-uppercase">
						<?php esc_html_e( 'Description', 'classiera' ); ?>
						</h4>
						<?php echo the_content(); ?>
						<div class="tags">
                            <span>
                                <i class="fa fa-tags"></i>
                                <?php esc_html_e( 'Tags', 'classiera' ); ?> :
                            </span>
							<?php the_tags('','',''); ?>
                        </div>
					</div>
					<!-- post description -->

					<!-- classiera bid system -->
					<?php if($classiera_bid_system == true){ ?>
					<!-- <div class="border-section border bids"> -->
						<?php 
							global $wpdb;
							$classieraMaxOffer = null;
							$classieraTotalBids = null;
							$post_id = $post->ID;
							$currentPostOffers = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_inbox WHERE offer_post_id = $post_id ORDER BY id DESC" );							
							$classieraMaxOffer = classiera_max_offer_price($post_id);
							$classieraMaxOffer = classiera_post_price_display($post_currency_tag, $classieraMaxOffer);
							$classieraMinOffer = classiera_min_offer_price($post_id);
							$classieraMinOffer = classiera_post_price_display($post_currency_tag, $classieraMinOffer);
							$classieraTotalBids = classiera_bid_count($post_id);
						?>
						<!-- <h4 class="border-section-heading text-uppercase"><?php esc_html_e( 'Send Message', 'classiera' ); ?></h4> -->
						<!-- <div class="classiera_bid_stats">
							<p class="classiera_bid_stats_text"> 
								<strong><?php esc_html_e( 'BID Stats', 'classiera' ); ?> :</strong> 
								<?php echo esc_attr($classieraTotalBids); ?>&nbsp;
								<?php esc_html_e( 'Bids posted on this ad', 'classiera' ); ?>
							</p>
							<div class="classiera_bid_stats_prices">
								<?php if($currentPostOffers){?>
								<p class="classiera_bid_price_btn high_price"> 
									<span><?php esc_html_e( 'Highest Bid', 'classiera' ); ?>:</span>
									<?php echo esc_attr($classieraMaxOffer);?>
								</p>
								<?php } ?>
								<?php if($currentPostOffers){?>
                                <p class="classiera_bid_price_btn"> 
									<span><?php esc_html_e( 'Lowest Bid', 'classiera' ); ?>:</span> 
									<?php echo esc_attr($classieraMinOffer);?>
								</p>
								<?php } ?>
							</div>
						</div> --><!--classiera_bid_stats-->

						<!-- <div class="comment-form classiera_bid_comment_form"> -->
							<!-- <div class="comment-form-heading">
                                <h4 class="text-uppercase"><?php esc_html_e( 'Let’s send a message, but be nice', 'classiera' ); ?></h4>
                                <p><?php esc_html_e( 'Only registered user can post offer', 'classiera' ); ?>
                                    <span class="text-danger">*</span>
                                </p>
                            </div> --><!--comment-form-heading-->
							
						<!-- </div> --><!--comment-form classiera_bid_comment_form-->
						<!-- Tab panes -->
						
					<!-- </div> -->
					<?php } ?>
					<!-- classiera bid system -->
					<!--comments-->
					<?php if($classieraComments == 1){?>
					<div class="border-section border comments">
						<h4 class="border-section-heading text-uppercase"><?php esc_html_e( 'Comments', 'classiera' ); ?></h4>
						<?php 
						$file ='';
						$separate_comments ='';
						comments_template( $file, $separate_comments );
						?>
					</div>
					<?php } ?>
					<!--comments-->
				</div>
				<!-- single post -->
			</div><!--col-md-8-->
			<div class="col-md-4">
				<aside class="sidebar">
					<div class="row">
						<?php if($classieraSingleAdStyle == 1){?>
						<!--Widget for style 1-->
						<div class="col-lg-12 col-md-12 col-sm-6 match-height">
							<div class="widget-box <?php if($classieraSingleAdStyle == 2){echo "border-none";}?>">
								<?php 
								$classieraPriceSection = $redux_demo['classiera_sale_price_off'];
								if($classieraPriceSection == 1){									
									$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
								?>
								<div class="widget-title price">
                                    <h3 class="post-price">										
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
                                </div><!--price-->
								<?php } ?>	
								<div class="widget-content widget-content-post">
                                    <div class="author-info border-bottom widget-content-post-area">
									<?php 
									$user_ID = $post->post_author;
									$authorName = get_the_author_meta('display_name', $user_ID );
									if(empty($authorName)){
										$authorName = get_the_author_meta('user_nicename', $user_ID );
									}
									if(empty($authorName)){
										$authorName = get_the_author_meta('user_login', $user_ID );
									}
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
                                            </div><!--media-left-->
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
												
                                            </div><!--media-body-->
                                        </div><!--media-->
                                    </div><!--author-info-->
                                </div><!--widget-content-->
								<?php if($classieraAuthorInfo == 1){?>
								<div class="widget-content widget-content-post">
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
												<a href="<?php echo esc_url($authorURL); ?>">
													<?php echo esc_url($authorURL); ?>
												</a>
											</li>
											<?php } ?>
											<?php if(!empty($authorEmail)){?>
                                            <!-- <li><i class="fa fa-li fa-envelope"></i> 
												<a href="mailto:<?php echo sanitize_email($authorEmail); ?>">
													<?php echo sanitize_email($authorEmail); ?>
												</a>
											</li> -->
											<?php } ?>
                                        </ul>
                                    </div><!--contact-details-->
                                </div><!--widget-content-->
								<?php } ?>
							</div><!--widget-box-->
						</div><!--col-lg-12 col-md-12 col-sm-6 match-height-->
						<?php } ?>
						<!--Widget for style 1-->
						<div class="col-lg-12 col-md-12 col-sm-6 match-height">
							<div class="widget-box <?php if($classieraSingleAdStyle == 2){echo "border-none";}?>">
								<?php 
								$classieraWidgetClass = "widget-content-post";
								$classieraMakeOffer = "user-make-offer-message widget-content-post-area";
								if($classieraSingleAdStyle == 1){
									$classieraWidgetClass = "widget-content-post";
									$classieraMakeOffer = "user-make-offer-message widget-content-post-area";
								}elseif($classieraSingleAdStyle == 2){
									$classieraWidgetClass = "removePadding";
									$classieraMakeOffer = "user-make-offer-message widget-content-post-area border-none removePadding";
								}
								?>
								<div class="widget-content <?php echo esc_attr($classieraWidgetClass); ?>">
									<div class="<?php echo esc_attr($classieraMakeOffer); ?>">
										<ul class="nav nav-tabs" role="tablist">
											<?php if($classieraToAuthor == 1){?>
                                            <li role="presentation" class="active">
                                                <a href="#message" aria-controls="message" role="tab" data-toggle="tab"><i class="fa fa-envelope"></i><?php esc_html_e('Send Email', 'classiera') ?></a>
                                            </li>
											<?php } ?>
                                        </ul><!--nav nav-tabs-->
                                        <form data-toggle="validator" id="classiera_offer_form" method="post">
											<span class="classiera--loader"><img src="<?php echo get_template_directory_uri().'/images/loader.gif' ?>" alt="classiera loader"></span>
											<div class="form-group">
			                                    <div class="form-inline row">
			                                        <div class="form-group col-sm-12">
			                                            <!-- <label class="text-capitalize">
															<?php esc_html_e( 'Enter your subject here', 'classiera' ); ?> :
			                                            </label> -->
			                                            <div class="inner-addon left-addon">
			                                                <input type="text" class="form-control form-control-sm offer_price" name="offer_price" placeholder="<?php esc_html_e( 'Subject', 'classiera' ); ?>">
			                                                <div class="help-block with-errors"></div>
			                                            </div>
			                                        </div><!--form-group col-sm-12-->                                    
			                                        <div class="form-group col-sm-12">
			                                            <!-- <label class="text-capitalize">
															<?php esc_html_e( 'Your message', 'classiera' ); ?> :
			                                                <span class="text-danger">*</span>
			                                            </label> -->
			                                            <div class="inner-addon">
			                                                <textarea class="offer_comment" data-error="<?php esc_html_e( 'You need to enter some information', 'classiera' ); ?>" name="offer_comment" placeholder="<?php esc_html_e( 'Message', 'classiera' ); ?>" required></textarea>
			                                                <div class="help-block with-errors"></div>
			                                            </div>
			                                        </div><!--form-group col-sm-12-->
			                                    </div><!--form-inline row-->
			                                </div><!--form-group-->
											<?php 
											$postAuthorID = $post->post_author;
											$currentLoggedAuthor = wp_get_current_user();
											$offerAuthorID = $currentLoggedAuthor->ID;
											?>
											<input type="hidden" class="offer_post_id" name="offer_post_id" value="<?php echo esc_attr($post->ID);?>">
											<input type="hidden" class="post_author_id" name="post_author_id" value="<?php echo esc_attr($postAuthorID); ?>">
											<input type="hidden" class="offer_author_id" name="offer_author_id" value="<?php echo esc_attr($offerAuthorID); ?>">
											<input type="hidden" class="offer_post_price" name="offer_post_price" value="<?php if(is_numeric($post_price)){ echo classiera_post_price_display($post_currency_tag, $post_price); }else{ echo esc_attr($post_price); }?>">
											<?php 
													$classieraFirstNumber = rand(1,9);
													$classieraLastNumber = rand(1,9);
													$classieraNumberAnswer = $classieraFirstNumber + $classieraLastNumber;
												?>
											<div class="form-group clearfix">
													<label class="col-sm-12 control-label"><?php esc_html_e("Please input the result of ", "classiera"); ?>
													<?php echo esc_attr($classieraFirstNumber); ?> + <?php echo esc_attr($classieraLastNumber);?> = </label>
												<div class="inner-addon">
				                                    <label class="col-sm-4 control-label" for="humanTest"><?php esc_html_e('Answer', 'classiera') ?> :</label>
				                                    <div class="col-sm-8">
				                                        <input id="humanTest" type="text" class="form-control form-control-xs" name="humanTest" placeholder="<?php esc_html_e('Your answer', 'classiera') ?>" required>
														<input type="hidden" name="humanAnswer" id="humanAnswer" value="<?php echo esc_attr($classieraNumberAnswer); ?>" />
														<input type="hidden" name="classiera_post_title" id="classiera_post_title" value="<?php the_title(); ?>" />
														<input type="hidden" name="classiera_post_url" id="classiera_post_url" value="<?php the_permalink(); ?>"  />
				                                    </div>
				                                </div><!--answer-->
											</div>
											
											<div class="form-group">
			                                    <button type="submit" name="submit_bid" class="btn btn-primary sharp btn-md btn-style-one submit_bid">
													<?php esc_html_e( 'Send message', 'classiera' ); ?>
												</button>
			                                </div>
											<div class="form-group">
												<div class="classieraOfferResult bg-success text-center"></div>
											</div>
										</form>
                                    </div>
                                </div>
							</div><!--widget-box-->
						</div><!--col-lg-12 col-md-12 col-sm-6 match-height-->
						<?php if($classieraReportAd == 1){ ?>
						<div class="col-lg-12 col-md-12 col-sm-6 match-height">
							<div class="widget-box <?php if($classieraSingleAdStyle == 2){echo "border-none";}?>">
								<!--ReportAd-->
								<div class="widget-content widget-content-post">
									<div class="user-make-offer-message border-bottom widget-content-post-area">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="btnWatch">    
											<?php if ( is_user_logged_in()){ 
													$current_user = wp_get_current_user();
													$user_id = $current_user->ID;
												}
												if(isset($user_id)){
													echo classiera_authors_favorite_check($user_id,$post->ID); 
												}
												?>
                                            </li>
                                            <li role="presentation" class="active">
                                                <a href="#report" aria-controls="report" role="tab" data-toggle="tab"><i class="fa fa-exclamation-triangle"></i> <?php esc_html_e( 'Report', 'classiera' ); ?></a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
<!--                                         <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="report">
												<form method="post" class="form-horizontal" data-toggle="validator">
													<?php if(!empty($displayMessage)){?>
													<div class="alert alert-success">
														<?php echo esc_html($displayMessage); ?>
													</div>
													<?php } ?>
                                                    <div class="radio">
                                                        <input id="illegal" value="illegal" type="radio" name="report_ad_val">
                                                        <label for="illegal"><?php esc_html_e( 'This is illegal/fraudulent', 'classiera' ); ?></label>
                                                        <input id="spam" value="spam" type="radio" name="report_ad_val">
                                                        <label for="spam"><?php esc_html_e( 'This ad is spam', 'classiera' ); ?></label>
                                                        <input id="duplicate" value="duplicate" type="radio" name="report_ad_val">
                                                        <label for="duplicate"><?php esc_html_e( 'This ad is a duplicate', 'classiera' ); ?></label>
                                                        <input id="wrong_category" value="wrong_category" type="radio" name="report_ad_val">
                                                        <label for="wrong_category"><?php esc_html_e( 'This ad is in the wrong category', 'classiera' ); ?></label>
                                                        <input id="post_rules" value="post_rules" type="radio" name="report_ad_val">
                                                        <label for="post_rules"><?php esc_html_e( 'The ad goes against posting rules', 'classiera' ); ?></label>
														<input id="post_other" value="post_other" type="radio" name="report_ad_val">
                                                        <label for="post_other"><?php esc_html_e( 'Other', 'classiera' ); ?></label>														
                                                    </div>
													<div class="otherMSG">
														<textarea id="other_report" name="other_report" class="form-control"placeholder="<?php esc_html_e( 'Type here..!', 'classiera' ); ?>"></textarea>
													</div>
													<input type="hidden" name="classiera_post_title" id="classiera_post_title" value="<?php the_title(); ?>" />
													<input type="hidden" name="classiera_post_url" id="classiera_post_url" value="<?php the_permalink(); ?>"  />
													<input type="hidden" name="submit" value="report_to_admin" />
                                                    <button class="btn btn-primary btn-block btn-sm sharp btn-style-one" name="report_ad" value="report_ad" type="submit"><?php esc_html_e( 'Report', 'classiera' ); ?></button>
                                                </form>
                                            </div><!--tabpanel-->
                                        </div><!--tab-content--> -->
                                    </div><!--user-make-offer-message-->
								</div><!--widget-content-->
								<!--ReportAd-->
							</div><!--widget-box-->
						</div><!--col-lg-12 col-md-12 col-sm-6 match-height-->
						<?php } ?>
						<!--Social Widget-->
						<?php 				
						if ( class_exists( 'APSS_Class' ) && $classieraSingleAdStyle == 1) {
						?>
						<div class="col-lg-12 col-md-12 col-sm-6 match-height">
							<div class="widget-box <?php if($classieraSingleAdStyle == 2){echo "border-none";}?>">
								<!--Share-->
								<div class="widget-content widget-content-post">
                                    <div class="share border-bottom widget-content-post-area">
                                        <h5><?php esc_html_e( 'Share ad', 'classiera' ); ?>:</h5>
										<!--AccessPress Socil Login-->
										<?php echo do_shortcode('[apss-share]'); ?>
										<!--AccessPress Socil Login-->
                                    </div>
                                </div>
								<!--Share-->
							</div><!--widget-box-->
						</div><!--col-lg-12 col-md-12 col-sm-6 match-height-->
						<?php } ?>
						<!--Social Widget-->
						<div class="col-lg-12 col-md-12 col-sm-6 match-height">
							<div class="widget-box <?php if($classieraSingleAdStyle == 2){echo "border-none";}?>">
								<!--GoogleMAP-->
								<?php 
								global $redux_demo;
								$googleMapadPost = $redux_demo['google-map-adpost'];
								$locShownBy = $redux_demo['location-shown-by'];
								$post_location = get_post_meta($post->ID, $locShownBy, true);
								$post_latitude = get_post_meta($post->ID, 'post_latitude', true);
								$post_longitude = get_post_meta($post->ID, 'post_longitude', true);
								$post_address = get_post_meta($post->ID, 'post_address', true);
								$classieraMapStyle = $redux_demo['map-style'];
								$postCatgory = get_the_category( $post->ID );
								$postCurCat = $postCatgory[0]->name;
								if( has_post_thumbnail()){
									$classieraIMG = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
									$classieraIMGURL = $classieraIMG[0];
								}else{
									$classieraIMGURL = get_template_directory_uri() . '/images/nothumb.png';
								}								
								$iconPath = get_template_directory_uri() .'/images/icon-services.png';
								if($googleMapadPost == 1){
									if(is_numeric($post_price)){
										$classieraPostPrice = classiera_post_price_display($post_currency_tag, $post_price);
									}else{ 
										$classieraPostPrice = esc_attr($post_price); 
									}
								?>
								<div class="widget-content widget-content-post">
                                    <div class="share widget-content-post-area">
                                        <h5><?php echo esc_attr($post_location); ?></h5>
                                        <?php if(!empty($post_latitude)){?>
										<div id="classiera_single_map">
										<!--<div id="single-page-main-map" id="details_adv_map">-->
										<div class="details_adv_map" id="details_adv_map">
											<script type="text/javascript">
											jQuery(document).ready(function(){
												var addressPoints = [							
													<?php 
													$content = '<a class="classiera_map_div" href="'.get_the_permalink().'"><img class="classiera_map_div__img" src="'.$classieraIMGURL.'" alt="images"><div class="classiera_map_div__body"><p class="classiera_map_div__price">'.__( "Price", 'classiera').' : <span>'.$classieraPostPrice.'</span></p><h5 class="classiera_map_div__heading">'.get_the_title().'</h5><p class="classiera_map_div__cat">'.__( "Category", 'classiera').' : '.$postCurCat.'</p></div></a>';
													?>
													[<?php echo esc_attr($post_latitude); ?>, <?php echo esc_attr($post_longitude); ?>, '<?php echo wp_kses_post($content); ?>', "<?php echo esc_url($iconPath); ?>"],							
												];
												var mapopts;
												if(window.matchMedia("(max-width: 1024px)").matches){
													var mapopts =  {
														dragging:false,
														tap:false,
													};
												};
												var map = L.map('details_adv_map', mapopts).setView([<?php echo esc_attr($post_latitude); ?>,<?php echo esc_attr($post_longitude); ?>],13);
												map.scrollWheelZoom.disable();
												var roadMutant = L.gridLayer.googleMutant({
												<?php if($classieraMapStyle){?>styles: <?php echo wp_kses_post($classieraMapStyle); ?>,<?php }?>
													maxZoom: 13,
													type:'roadmap'
												}).addTo(map);
												var markers = L.markerClusterGroup({
													spiderfyOnMaxZoom: true,
													showCoverageOnHover: true,
													zoomToBoundsOnClick: true,
													maxClusterRadius: 60
												});
												var markerArray = [];
												for (var i = 0; i < addressPoints.length; i++){
													var a = addressPoints[i];
													var newicon = new L.Icon({iconUrl: a[3],
														iconSize: [50, 50], // size of the icon
														iconAnchor: [20, 10], // point of the icon which will correspond to marker's location
														popupAnchor: [0, 0] // point from which the popup should open relative to the iconAnchor                                 
													});
													var title = a[2];
													var marker = L.marker(new L.LatLng(a[0], a[1]));
													marker.setIcon(newicon);
													marker.bindPopup(title);
													marker.title = title;
													marker.on('click', function(e) {
														map.setView(e.latlng, 13);
														
													});				
													markers.addLayer(marker);
													markerArray.push(marker);
													if(i==addressPoints.length-1){//this is the case when all the markers would be added to array
														var group = L.featureGroup(markerArray); //add markers array to featureGroup
														map.fitBounds(group.getBounds());   
													}
												}
												map.addLayer(markers);
											});
											</script>
										</div>
										<div id="ad-address">
											<span>
											<i class="fas fa-map-marker-alt"></i>
											<a href="http://maps.google.com/maps?saddr=&daddr=<?php echo esc_html($post_address); ?>" target="_blank">
												<?php esc_html_e( 'Get Directions on Google MAPS to', 'classiera' ); ?>: <?php echo esc_html($post_address); ?>
											</a>
											</span>
										</div>
									</div>
										<?php } ?>
                                    </div>
                                </div>
								<?php } ?>
								<!--GoogleMAP-->
							</div><!--widget-box-->
						</div><!--col-lg-12-->
						<!--SidebarWidgets-->
						<?php dynamic_sidebar('single'); ?>
						<!--SidebarWidgets-->
					</div><!--row-->
				</aside><!--sidebar-->
			</div><!--col-md-4-->
		</div><!--row-->
	</div><!--container-->
</section>
<?php endwhile; ?>
<!-- related post section -->
<?php 
global $redux_demo;
$relatedAdsOn = $redux_demo['related-ads-on'];
if($relatedAdsOn == 1){
	function related_Post_ID(){
		global $post;
		$post_Id = $post->ID;
		return $post_Id;
	}
	get_template_part( 'templates/related-ads' );
}
?>
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
<!-- related post section -->
<?php get_footer(); ?>
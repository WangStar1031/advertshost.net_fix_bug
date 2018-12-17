<?php
/**
 * Template Name: Contact
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */

global $redux_demo; 
$contactMAP = $redux_demo['contact-map'];
$contact_email = $redux_demo['contact-email'];
$classieraContactEmailError = $redux_demo['contact-email-error'];
$classieraContactNameError = $redux_demo['contact-name-error'];
$classieraConMsgError = $redux_demo['contact-message-error'];
$classieraContactThankyou = $redux_demo['contact-thankyou-message'];
$classieraPrimaryColor = $redux_demo['color-primary'];
$classieraSecondaryColor = $redux_demo['color-secondary'];
$classieraContactLatitude = $redux_demo['contact-latitude'];
$classieraContactLongitude = $redux_demo['contact-longitude'];
$ClassieraContactZoomLevel = $redux_demo['contact-zoom'];
$classieraMAPStyle = $redux_demo['map-style'];
$classieraContactRadius = $redux_demo['contact-radius'];
$iconPath = get_template_directory_uri() .'/images/icon-services.png';
$contactAddress = $redux_demo['contact-address'];
$contactPhone = $redux_demo['contact-phone'];
$contactPhone2 = $redux_demo['contact-phone2'];
$classieraDisplayEmail = $redux_demo['classiera_display_email'];
$caticoncolor="";
$category_icon_code ="";
$category_icon="";
$category_icon_color="";

$hasError = false;
$errorMessage = "";
$emailSent = false;


//If the form is submitted
if(isset($_POST['submitted'])) {		
		//Check to make sure that the name field is not empty
		if(trim($_POST['contactName']) === '') {
			$errorMessage = $classieraContactNameError;
			$hasError = true;
		} elseif(trim($_POST['contactName']) === 'Name*') {
			$errorMessage = $classieraContactNameError;
			$hasError = true;
		}	else {
			$name = trim($_POST['contactName']);
		}
		//Check to make sure that the subject field is not empty
		if(trim($_POST['subject']) === '') {
			$errorMessage = $classieraConMsgError;
			$hasError = true;
		} elseif(trim($_POST['subject']) === 'Subject*') {
			$errorMessage = $classieraConMsgError;
			$hasError = true;
		}	else {
			$subject = trim($_POST['subject']);
		}		
		//Check to make sure sure that a valid email address is submitted
		if(trim($_POST['email']) === '')  {
			$errorMessage = $classieraContactEmailError;
			$hasError = true;
		} else if (!preg_match("/^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$/i", trim($_POST['email']))) {
			$errorMessage = $classieraContactEmailError;
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}		
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
		$classierahumanTest = trim($_POST['humanTest']);		
		if($classierahumanTest != $classieraCheckAnswer) {
			$errorMessage = esc_html__('Not Human', 'classiera');
			$hasError = true;
		}
		$submitMobile = $_POST['phone'];
		//If there is no error, send the email
		if($hasError == false){			
			$emailTo = $contact_email;
			$subject = $subject;			
			classiera_contact_us_page($name, $email, $submitMobile, $emailTo, $subject, $comments);
			$emailSent = true;
		}		
}

get_header(); ?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php if($contactMAP == 1){?>
<div id="classiera_map">
    <div id="classiera-main-map" style="width:100%; height:600px;">
		<script type="text/javascript">			
			jQuery(document).ready(function(){					
				var mapopts;
				if(window.matchMedia("(max-width: 1024px)").matches){
					var mapopts =  {
						dragging:false,
						tap:false,
					};
				};
				var map = L.map('classiera-main-map', mapopts).setView([<?php echo esc_attr( $classieraContactLatitude );?>,<?php echo esc_attr($classieraContactLongitude); ?>],<?php echo esc_attr($ClassieraContactZoomLevel); ?>);
				map.dragging.disable;
				map.scrollWheelZoom.disable();
				var roadMutant = L.gridLayer.googleMutant({
				<?php if($classieraMAPStyle){?>styles: <?php echo wp_kses_post($classieraMAPStyle); ?>,<?php }?>
					maxZoom: <?php echo esc_attr($ClassieraContactZoomLevel); ?>,
					type:'roadmap'
				}).addTo(map);
				<?php if(!empty($classieraContactRadius)){?>
				var circle = L.circle([<?php echo esc_attr($classieraContactLatitude); ?>,<?php echo esc_attr($classieraContactLongitude); ?>], {
					color: '<?php echo esc_html($classieraPrimaryColor); ?>',
					fillColor: '<?php echo esc_html($classieraSecondaryColor); ?>',
					fillOpacity: 0.5,
					radius: <?php echo esc_attr($classieraContactRadius); ?>
				}).addTo(map);
				<?php } ?>
				var greenIcon = L.icon({
					iconUrl: '<?php echo esc_url($iconPath); ?>',
					//shadowUrl: 'leaf-shadow.png',/
					iconSize:     [60, 60], // size of the icon
					//shadowSize:   [50, 64], // size of the shadow
					iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
					//shadowAnchor: [4, 62],  // the same for the shadow
					//popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
				});
				L.marker([<?php echo esc_attr($classieraContactLatitude); ?>,<?php echo esc_attr($classieraContactLongitude); ?>], {icon: greenIcon}).addTo(map);
			});
		</script>
	</div>
</div>
<?php } ?>
<!--PageContent-->
<section class="contact-us border-bottom section-pad">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<?php the_content(); ?>
			</div>
		</div><!--row-->
	</div><!--container-->
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<h4 class="text-uppercase"><?php esc_html_e('Contact Form', 'classiera') ?></h4>
				<?php if(isset($_POST['submitted'])){?>				
				<div class="row">
					<div class="col-lg-12">
						<?php if(!empty($errorMessage)){ ?>
						<div class="alert alert-warning">
							<?php echo esc_html($errorMessage); ?>
						</div>
						<?php } ?>
						<?php if($emailSent == true){ ?>
						<div class="alert alert-success">
							<?php echo esc_html($classieraContactThankyou); ?>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
				<form name="contactForm" action="<?php the_permalink(); ?>" id="contact-form" method="post" data-toggle="validator">
					<div class="form-group">
						<div class="form-inline row">
							<div class="form-group col-sm-6">
                                <label class="text-capitalize" for="name"><?php esc_html_e( 'Full name', 'classiera' ); ?> : <span class="text-danger">*</span> </label>
                                <div class="inner-addon left-addon">
                                    <i class="left-addon form-icon fa fa-font"></i>
                                    <input id="name" type="text" name="contactName" class="form-control form-control-md" placeholder="<?php esc_html_e( 'Enter your full name', 'classiera' ); ?>" data-error="<?php esc_html_e( 'Name Requried', 'classiera' ); ?>" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div><!--Name Div-->
							<div class="form-group col-sm-6">
                                <label class="text-capitalize" for="email"><?php esc_html_e( 'Email', 'classiera' ); ?> : <span class="text-danger">*</span></label>
                                <div class="inner-addon left-addon">
                                    <i class="left-addon form-icon fa fa-envelope"></i>
                                    <input id="email" type="text" name="email" class="form-control form-control-md" placeholder="<?php esc_html_e( 'Enter your email', 'classiera' ); ?>" data-error="<?php esc_html_e( 'Email required', 'classiera' ); ?>" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div><!--Email-->
							<div class="form-group col-sm-6">
                                <label class="text-capitalize" for="phone"><?php esc_html_e( 'Phone', 'classiera' ); ?> : <span class="text-danger">*</span> </label>
                                <div class="inner-addon left-addon">
                                    <i class="left-addon form-icon fa fa-phone"></i>
                                    <input id="phone" type="text" name="phone" class="form-control form-control-md" placeholder="<?php esc_html_e( 'Enter your phone number', 'classiera' ); ?>">
                                </div>
                            </div><!--Phone Div-->
							<div class="form-group col-sm-6">
                                <label class="text-capitalize" for="subject"><?php esc_html_e( 'Subject', 'classiera' ); ?> : <span class="text-danger">*</span></label>
                                <div class="inner-addon left-addon">
                                    <i class="left-addon form-icon fa fa-book"></i>
                                    <input id="subject" name="subject" type="text" class="form-control form-control-md" placeholder="<?php esc_html_e( 'Enter Subject', 'classiera' ); ?>" data-error="<?php esc_html_e( 'Subject Requried', 'classiera' ); ?>" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div><!--Subject Div-->
							<div class="form-group col-sm-12">
                                <label class="text-capitalize" for="text"><?php esc_html_e( 'Message', 'classiera' ); ?> : <span class="text-danger">*</span></label>
                                <div class="inner-addon">
                                    <textarea data-error="<?php esc_html_e( 'Please type message', 'classiera' ); ?>" name="comments" id="text" placeholder="<?php esc_html_e( 'Type your message here...!', 'classiera' ); ?>" required></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div><!--Message Div-->
							<?php 
								$classieraFirstNumber = rand(1,9);
								$classieraLastNumber = rand(1,9);
								$classieraNumberAnswer = $classieraFirstNumber + $classieraLastNumber;
							?>
							<div class="form-group col-sm-12">
								<div class="inner-addon left-addon">
									<h3>
									<?php esc_html_e('Human test. Please input the result of', 'classiera'); ?>
									<?php echo esc_attr($classieraFirstNumber) ?>&nbsp; + <?php echo esc_attr($classieraLastNumber) ?>
									</h3>
								</div>
							</div>
							<div class="form-group col-sm-6">
                                <label class="text-capitalize" for="humanTest"><?php esc_html_e( 'Security Question', 'classiera' ); ?> : <span class="text-danger">*</span></label>
                                <div class="inner-addon left-addon">
                                    <i class="left-addon form-icon fa fa-eye"></i>
                                    <input id="humanTest" type="text" name="humanTest" class="form-control form-control-md" placeholder="<?php esc_html_e('Your Answer', 'classiera'); ?>" data-error="<?php esc_html_e( 'Security Answer Requried', 'classiera' ); ?>" required>
                                    <div class="help-block with-errors"></div>
									<input type="hidden" name="humanAnswer" id="humanAnswer" value="<?php echo esc_attr($classieraNumberAnswer); ?>" />
                                </div>
                            </div><!--Question Div-->
						</div><!--form-inline row-->
					</div><!--form-group-->
					<div class="form-group">
						<input type="hidden" name="submit" value="contact_form" id="submit" />
						<button class="btn btn-primary sharp btn-md btn-style-one" type="submit" value="submit" name="submitted"><?php esc_html_e('Send Message','classiera'); ?></button>
                    </div>
				</form>
			</div><!--col-lg-8-->
			<div class="col-lg-4">
                <h4 class="text-uppercase"><?php esc_html_e('Contact Info', 'classiera'); ?></h4>
                <ul class="contact-us-info list-unstyled fa-ul">
				<?php if(!empty($contactAddress)){ ?>
                    <li><i class="fa-li fas fa-map-marker-alt"></i>
					<?php echo esc_html($contactAddress); ?>
					</li>
				<?php } ?>
				<?php if($classieraDisplayEmail == 1){?>
				<?php if(!empty($contact_email)){ ?>
                    <li><i class="fa-li fa fa-envelope"></i>
						<?php echo sanitize_email($contact_email); ?>
					</li>
				<?php } ?>
				<?php } ?>
				<?php if(!empty($contactPhone)){ ?>
                    <li><i class="fa-li fa fa-phone"></i>
						<?php echo esc_html($contactPhone); ?>
					</li>
				<?php } ?>	
				<?php if(!empty($contactPhone2)){ ?>
                    <li><i class="fa-li fa fa-phone"></i>
						<?php echo esc_html($contactPhone2); ?>
					</li>
				<?php } ?>
                </ul>
            </div><!--col-lg-4-->
		</div><!--row-->
	</div><!--container-->
</section>
<!--PageContent-->
<?php endwhile; endif; ?>
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
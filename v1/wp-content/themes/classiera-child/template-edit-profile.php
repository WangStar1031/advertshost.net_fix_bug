<?php
/**
 * Template name: Profile Settings
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
global $user_ID, $user_identity, $user_level;
global $redux_demo;
$caticoncolor="";
$category_icon_code ="";
$category_icon="";
$category_icon_color="";
$profile = $redux_demo['profile'];
$current_user = wp_get_current_user();
$user_ID = $current_user->ID;
if ($user_ID){
	
	if($_POST){
		
		$message =  esc_html__( 'Your profile updated successfully.', 'classiera' );

		$first = esc_sql($_POST['first_name']);

		$last = esc_sql($_POST['last_name']);

		$email = esc_sql($_POST['email']);
		$current_email = esc_sql($_POST['current_email']);

		//$user_url = esc_sql($_POST['website']);

		$user_phone = esc_sql($_POST['phone']);
		
		$user_phone2 = esc_sql($_POST['phone2']);
		//$facebook = esc_sql($_POST['facebook']);
		//$twitter = esc_sql($_POST['twitter']);
		//$googleplus = esc_sql($_POST['google-plus']);
		//$linkedin = esc_sql($_POST['linkedin']);
		//$pinterest = esc_sql($_POST['pinterest']);
		//$instagram = esc_sql($_POST['instagram']);
		//$youtube = esc_sql($_POST['youtube']);
		//$vimeo = esc_sql($_POST['vimeo']);
		
		$country = esc_sql($_POST['country']);
		$state = esc_sql($_POST['state']);
		$city = esc_sql($_POST['city']);
		//$post_code = esc_sql($_POST['post_code']);
		//$user_address = esc_sql($_POST['address']);

		//$description = esc_sql($_POST['desc']);
		$description = $_POST['desc'];

		$password = esc_sql($_POST['pwd']);

		$confirm_password = esc_sql($_POST['confirm']);

		
		$your_image_url = esc_sql($_POST['your_author_image_url']);

		update_user_meta( $user_ID, 'first_name', $first );

		update_user_meta( $user_ID, 'last_name', $last );

		update_user_meta( $user_ID, 'phone', $user_phone );
		update_user_meta( $user_ID, 'phone2', $user_phone2 );
		
		//update_user_meta( $user_ID, 'facebook', $facebook );
		//update_user_meta( $user_ID, 'twitter', $twitter );
		//update_user_meta( $user_ID, 'googleplus', $googleplus );
		//update_user_meta( $user_ID, 'linkedin', $linkedin );
		//update_user_meta( $user_ID, 'pinterest', $pinterest );
		//update_user_meta( $user_ID, 'instagram', $instagram );
		//update_user_meta( $user_ID, 'youtube', $youtube );
		//update_user_meta( $user_ID, 'vimeo', $vimeo );

		update_user_meta( $user_ID, 'country', $country );
		update_user_meta( $user_ID, 'state', $state );
		update_user_meta( $user_ID, 'city', $city );
		//update_user_meta( $user_ID, 'postcode', $post_code );
		//update_user_meta( $user_ID, 'address', $user_address );

		update_user_meta( $user_ID, 'description', $description );

		wp_update_user( array ('ID' => $user_ID, 'user_url' => $user_url) );		
		
		if($email != $current_email){
			wp_update_user( array ('ID' => $user_ID, 'user_email' => $email) ) ;
			update_user_meta( $user_ID, 'author_verified', 'unverified');
			$verify_code = '';
			update_user_meta( $user_ID, 'author_vcode', $verify_code );
		}
		if($password){

			if (strlen($password) < 5 || strlen($password) > 25) {
				$message =  esc_html__( 'Password must be 5 to 25 characters in length.', 'classiera' );
				}

			//elseif( $password == $confirm_password ) {
			$confirmPWD = $_POST['confirm'];
			$confirmPWD2 = $_POST['confirm2'];
			if(isset($confirmPWD) && $confirmPWD != $confirmPWD2) {

				$message =  esc_html__( 'Password Mismatch', 'classiera' );

			} elseif ( isset($confirmPWD) && !empty($password) ) {

				$update = wp_set_password( $confirmPWD, $user_ID );				
				$message =  esc_html__( 'Your profile updated successfully.', 'classiera' );

			}
		}
	}
	/*ImageUploading*/
	if ( isset($_FILES['upload_attachment']) ) {
		$count = '0';
		$files = $_FILES['upload_attachment'];
		foreach ($files['name'] as $key => $value) {				
			if ($files['name'][$key]) {
				$file = array(
					'name'     => $files['name'][$key],
					'type'     => $files['type'][$key],
					'tmp_name' => $files['tmp_name'][$key],
					'error'    => $files['error'][$key],
					'size'     => $files['size'][$key]
				);
				$_FILES = array("upload_attachment" => $file);				
				foreach ($_FILES as $file => $array) {					
					$newupload = classiera_insert_userIMG($file);
					$count++;
					$profileImage = $newupload;
					if(!empty($profileImage )){
						update_user_meta( $user_ID, 'classify_author_avatar_url', $profileImage );
					}
				}
			}
		}/*Foreach*/
	}
}

get_header();

$profile = $redux_demo['profile'];
$user_info = get_userdata($user_ID);
 ?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	
?>
<!-- user pages -->
<section class="user-pages">
    <div class="container">
        <div class="row">
			<div class="col-lg-3 col-md-4">
				<?php get_template_part( 'templates/profile/userabout' );?>
			</div><!--col-lg-3-->
			<div class="col-lg-9 col-md-8">

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title text-uppercase"><?php esc_html_e("Profile Settings", 'classiera') ?></h3>
					</div>
					<div class="panel-body">

						<?php if($_POST){?>
						<div class="alert alert-success" role="alert">					
							<?php echo esc_html( $message ); ?>
						</div>
						<?php } ?>
						
						<div class="user-detail-section">
							<div class="user-ads user-profile-settings">
								<form data-toggle="validator" role="form" method="POST" id="primaryPostForm" action="" enctype="multipart/form-data">

									<div id="smartwizard">
									    <ul class="nav nav-pills">
									        <li><a href="#step-1">Step Title</a></li>
									        <li><a href="#step-2">Step Title</a></li>
									        <li><a href="#step-3">Step Title</a></li>
									    </ul>

									    <div>
									        <div id="step-1" class="">
									        	<div class="row">
									        		<div class="col-sm-12">
									        			<div class="form-group">
									        				<h4 class="text-uppercase text-center">
																<?php esc_html_e( 'Update Your Profile Picture', 'classiera' ); ?>
															</h4>
									        			</div>
									        		</div>
	    											<div class="col-sm-12 col-lg-3">
	    												<div class="form-group">
															<!-- upload avatar -->
															<?php 
															$profileIMGID = get_user_meta($user_ID, "classify_author_avatar_url", true);
															$profileIMG = classiera_get_profile_img($profileIMGID);
															$authorName = get_the_author_meta('display_name', $user_ID);
															$author_verified = get_the_author_meta('author_verified', $user_ID);
															if(empty($profileIMG)){
																$profileIMG = classiera_get_avatar_url ( get_the_author_meta('user_email', $user_ID), $size = '255' );
																?>
															<img class="media-object author-avatar img-responsive" src="<?php echo esc_url( $profileIMG ); ?>" alt="<?php echo esc_attr( $authorName ); ?>">	
															<?php
															}else{ ?>
															<img class="media-object author-avatar img-responsive" src="<?php echo esc_url( $profileIMG ); ?>" alt="<?php echo esc_attr( $authorName ); ?>" width="255" height="343">	
															<?php } ?>
															<input class="criteria-image-url" id="your_image_url" type="text" size="36" name="your_author_image_url" style="display: none;" value="" />
															 <input type="file" id="file-1" name="upload_attachment[]" class="inputfile inputfile-1 author-UP" data-multiple-caption="{count} files selected" multiple />
					                                        <label for="file-1" class="upload-author-image btn btn-primary btn-block" style="display: block">
																<!-- <span class="btn btn-primary"><?php esc_html_e( 'Upload photo', 'classiera' ); ?></span> -->
																<span class="text-uppercase"><?php esc_html_e( 'Upload photo', 'classiera' ); ?><span>
															</label>
	    												</div>
	    											</div>
	    											<div class="col-sm-12 col-lg-9">
	    												<div class="form-group">
															<!-- verify profile btn-->
															<!-- <?php if($author_verified != 'verified'){ ?>										
					                                        <button class="btn btn-primary classiera_verify_btn" data-toggle="modal" data-target="#verifyModal" type="button"><?php esc_html_e( 'Verify your account', 'classiera' ); ?></button>
															<?php } ?> -->
															<!-- verify profile btn-->

															<div class="row">
																<div class="col-sm-12 col-lg-6">
								                                    <label for="first-name"><?php esc_html_e( 'First Name', 'classiera' ); ?></label>
								                                    <div class="inner-addon">
								                                        <input type="text" id="first-name" name="first_name" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'Update first Name..', 'classiera' ); ?>" value="<?php echo esc_attr( $user_info->first_name ); ?>">
								                                    </div>
							                                	</div>
															
																<div class="col-sm-12 col-lg-6">
																	<label for="last-name"><?php esc_html_e( 'Last Name', 'classiera' ); ?></label>
																	<div class="inner-addon">
																		<input type="text" id="last-name" name="last_name" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'update last Name', 'classiera' ); ?>" value="<?php echo esc_attr( $user_info->last_name ); ?>">
																	</div>
																</div>

				    											<div class="col-sm-12">
								                                    <label for="bio"><?php esc_html_e( 'About Me', 'classiera' ); ?></label>
								                                    <div class="inner-addon">
								                                        <textarea name="desc" id="bio" placeholder="<?php esc_html_e( 'enter your short info.', 'classiera' ); ?>"><?php echo esc_html( $user_info->description ); ?></textarea>
								                                    </div>
				    											</div>
															</div>
	    												</div>
	    											</div>

									        	</div>
									        </div>
									        <div id="step-2" class="">
									        	<div class="row">
									        		<div class="col-sm-12">
									        			<div class="form-group">
									        				<h4 class="text-uppercase text-center">
																<?php esc_html_e( 'Contact Details', 'classiera' ); ?>
															</h4>
									        			</div>
									        		</div>
			        								<div class="col-sm-12">
			        									<!-- Contact Details -->
			        									<div class="form-group">
															<div class="row">
				        										<div class="col-sm-12 col-lg-6">
				        		                                    <label for="phone"><?php esc_html_e( 'Phone Number', 'classiera' ); ?></label>
				        		                                    <div class="inner-addon">
				        		                                        <input type="tel" id="phone" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'Your Phone No', 'classiera' ); ?>" name="phone" value="<?php echo esc_html( $user_info->phone ); ?>">
				        		                                    </div>
				        		                                </div>
				        		                                <!--Phone Number-->
				        										<div class="col-sm-12 col-lg-6">
				        		                                    <label for="mobile"><?php esc_html_e( 'Mobile Number', 'classiera' ); ?></label>
				        		                                    <div class="inner-addon">
				        		                                        <input type="tel" id="mobile" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'update your mobile number', 'classiera' ); ?>" name="phone2" value="<?php echo esc_html( $user_info->phone2 ); ?>">
				        		                                    </div>
				        		                                </div><!--Mobile Number-->
				        										<div class="col-sm-12 col-lg-6">
				        		                                    <label for="email"><?php esc_html_e( 'Your Email', 'classiera' ); ?></label>
				        		                                    <div class="inner-addon">
				        		                                        <input type="text" id="email" name="email" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'enter your email address', 'classiera' ); ?>" value="<?php echo sanitize_email( $user_info->user_email ); ?>">
				        												<input type="hidden" name="current_email" value="<?php echo sanitize_email( $user_info->user_email ); ?>">
				        		                                    </div>
				        		                                </div><!--Your Email-->
				        										<div class="col-sm-12 col-lg-6">
				        		                                    <label for="email"><?php esc_html_e( 'Your Country', 'classiera' ); ?></label>
				        		                                    <div class="inner-addon">
				        		                                        <input type="text" id="country" name="country" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'enter your country', 'classiera' ); ?>" value="<?php echo esc_attr( $user_info->country ); ?>">
				        		                                    </div>
				        		                                </div><!--Your Country-->
				        										<div class="col-sm-12 col-lg-6">
				        		                                    <label for="email"><?php esc_html_e( 'Your County', 'classiera' ); ?></label>
				        		                                    <div class="inner-addon">
				        		                                        <input type="text" id="state" name="state" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'enter your County', 'classiera' ); ?>" value="<?php echo esc_attr( $user_info->state ); ?>">
				        		                                    </div>
				        		                                </div><!--Your County-->
				        										<div class="col-sm-12 col-lg-6">
				        		                                    <label for="email"><?php esc_html_e( 'Your City', 'classiera' ); ?></label>
				        		                                    <div class="inner-addon">
				        		                                        <input type="text" id="city" name="city" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'enter your City', 'classiera' ); ?>" value="<?php echo esc_attr( $user_info->city ); ?>">
				        		                                    </div>
				        		                                </div><!--Your City-->
															</div>
			        									</div>
			        								</div>
									        	</div>
									        </div>
									        <div id="step-3" class="">
									        	<div class="row">
									        		<div class="col-sm-12">
									        			<div class="form-group">
								        					<h4 class="text-uppercase text-center"><?php esc_html_e( 'Update your Password', 'classiera' ); ?></h4>
								        					<p class="text-center"><?php esc_html_e( 'If you would like to change your current password, please fill in all fields, otherwise leave blank.', 'classiera' ); ?></p>
									        			</div>
									        		</div>

									        		<div class="col-sm-12">
									        			<div class="form-group">
								        					<div class="row">
	        													<!-- Update your Password -->
	    						                                <div class="col-sm-6 col-lg-6">
	    						                                    <label for="current-pass">
	    																<?php esc_html_e( 'Enter Current Password', 'classiera' ); ?>
	    															</label>
	    						                                    <div class="inner-addon">
	    						                                        <input type="password" id="current-pass" name="pwd" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'Enter your current password', 'classiera' ); ?>">
	    						                                    </div>
	    						                                </div>
	    						                                <div class="col-sm-6 col-lg-6">
	    						                                    <label for="new-pass">
	    																<?php esc_html_e( 'Enter New Password', 'classiera' ); ?>
	    															</label>
	    						                                    <div class="inner-addon">
	    						                                        <input type="password" name="confirm" data-minlength="5" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'Enter Password', 'classiera' ); ?>" id="new-pass" data-error="<?php esc_html_e( 'Password required', 'classiera' ); ?>">
	    						                                        <div class="help-block">
	    																	<?php esc_html_e( 'Minimum of 5 characters', 'classiera' ); ?>
	    																</div>
	    						                                    </div>
	    						                                </div>
	    						                                <div class="col-sm-6 col-lg-6">
	    						                                    <label for="re-enter">
	    																<?php esc_html_e( 'Re-enter New Password', 'classiera' ); ?>
	    															</label>
	    						                                    <div class="inner-addon">
	    						                                        <input type="password" id="re-enter" name="confirm2" class="form-control form-control-sm sharp-edge" placeholder="<?php esc_html_e( 'Re-enter New Password', 'classiera' ); ?>" data-match="#new-pass" data-match-error="<?php esc_html_e( 'Whoops, these dont match', 'classiera' ); ?>">
	    						                                        <div class="help-block with-errors"></div>
	    						                                    </div>
	    						                                </div>
	    						                                <div class="col-sm-12">
		        													<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
		        													<input type="hidden" name="submitted" id="submitted" value="true" />
		        													<button type="submit" name="op" value="update_profile" class="btn btn-primary"><?php esc_html_e('Update Now', 'classiera') ?></button>
		        													<!-- Update your Password -->
	    						                                </div>
								        					</div>
									        			</div>
									        		</div>

									        	</div>
									        </div>
									    </div>
									</div><!-- / Smartwizard -->

								</form>
							</div><!--user-ads user-profile-settings-->
						</div><!--user-detail-section-->
					</div>
				</div>
			</div><!--col-lg-9-->
		</div><!--row-->
	</div><!--container-->	
</section><!--user-pages section-gray-bg-->	
<!-- user pages -->
<!--Verify Profile Modal-->
<div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<?php 
	$authorEmail = $user_info->user_email;
	$dbcode = get_the_author_meta('author_vcode', $user_ID);
	$classieraVerifyCode = md5($authorEmail);
	?>
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-uppercase text-center" id="myModalLabel">
					<?php esc_html_e('Verify Your Account Now', 'classiera') ?>
				</h4>
				<p class="text-uppercase text-center">
					<?php esc_html_e('Following these Steps', 'classiera') ?>
				</p>
			</div><!--modal-header-->
			<div class="modal-body">
				<form method="post" class="form-inline row classiera_get_code_form">
					<span class="classiera--loader"><img src="<?php echo get_template_directory_uri().'/images/loader.gif' ?>" alt="classiera loader"></span>
					<div class="form-group col-sm-9">
						<input type="text" class="form-control verify_email" placeholder="<?php esc_html_e('example@email.com', 'classiera') ?>" value="<?php echo sanitize_email( $authorEmail ); ?>" disabled>
						<input type="hidden" value="<?php echo esc_html( $classieraVerifyCode ); ?>" name="" class="verify_code">
						<input type="hidden" value="<?php echo esc_attr( $user_ID ); ?>" name="" class="verify_user_id">
					</div>
					<div class="form-group col-sm-3">
						<button type="submit" class="btn btn-primary sharp btn-sm btn-style-one verify_get_code">
							<?php esc_html_e('Get verification Code', 'classiera') ?>
						</button>
					</div>
				</form><!--classiera_get_code_form-->			
				<form method="post" class="form-inline row classiera_verify_form" <?php if($dbcode){ ?>style="display:block;" <?php } ?>>
					<span class="classiera--loader"><img src="<?php echo get_template_directory_uri().'/images/loader.gif' ?>" alt="classiera loader"></span>
					<h5 class="text-center text-uppercase">
						<?php esc_html_e('Check your email inbox and paste code below', 'classiera') ?>
					</h5>
					<div class="form-group col-sm-9">
						<input type="text" class="form-control verification_code" placeholder="<?php esc_html_e('Enter your verified code', 'classiera') ?>" value="" required>
						<input type="hidden" value="<?php echo esc_attr( $user_ID ); ?>" name="" class="verify_user_id">
						<input type="hidden" value="<?php echo sanitize_email( $authorEmail ); ?>" name="" class="verify_email">
					</div>
					<div class="form-group col-sm-3">
						<button type="submit" class="btn btn-primary sharp btn-sm btn-style-one verify_code_btn">
							<?php esc_html_e('Verify Now', 'classiera') ?>
						</button>
					</div>
				</form><!--classiera_verify_form-->
				<div class="classiera_verify_congrats text-center">
					
				</div><!--classiera_verify_congrats-->
			</div><!--modal-body-->
		</div><!--modal-content-->
	</div><!--modal-dialog modal-lg-->
</div><!--modal fade-->
<!--Verify Profile Modal-->

<script>
	jQuery(document).ready(function($) {

	    $('#smartwizard').smartWizard({
		      transitionEffect: 'fade',
		      toolbarButtonPosition: 'right',
		      autoAdjustHeight: true,
		      useURLhash: true,
		      anchorSettings: {
	                anchorClickable: true, // Enable/Disable anchor navigation
	                enableAllAnchors: true, // Activates all anchors clickable all times
	                markDoneStep: true, // add done css
	                enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
	            },  

		      toolbarSettings: {
		        toolbarPosition: 'bottom', // none, top, bottom, both
		        toolbarButtonPosition: 'right', // left, right
		        showNextButton: true, // show/hide a Next button
		      }
		    });
		});
</script>
<?php get_footer(); ?>
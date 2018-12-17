<?php
/*==========================
 Classiera Email Filter
 1- Filter content type.
 2- Filter Name
 3- Filter Email
 ===========================*/
add_filter ("wp_mail_content_type", "classiera_mail_content_type");
function classiera_mail_content_type() {
	return "text/html";
}
add_filter('wp_mail_from_name', 'classiera_blog_name_from_name');
function classiera_blog_name_from_name($name = '') {
    return get_bloginfo('name');
}
add_filter ("wp_mail_from", "classiera_mail_from");
function classiera_mail_from() {
	$sendemail =  get_bloginfo('admin_email');
	return $sendemail;
}
/*==========================
 Email template which sent When Email is Published
 ===========================*/	
if(!function_exists('classiera_publish_post_email')) { 
	add_action( 'transition_post_status', 'classiera_publish_post_email', 10, 3 );
	function classiera_publish_post_email( $new_status, $old_status, $post ){
		if($new_status == 'publish' && $old_status != 'publish' && $post->post_type == 'post'){
			$post = get_post($post->ID);
			$author = get_userdata($post->post_author);
			global $redux_demo;
			$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
			$trns_listing_published = $redux_demo['trns_listing_published'];
			$email_subject = $trns_listing_published;
			$author_email = $author->user_email;
			ob_start();
			include(TEMPLATEPATH . '/templates/email/email-header.php');
			?>
			<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
				<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_html($trns_listing_published); ?></h4>
				<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
				<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
					<?php esc_html_e( 'Hi', 'classiera' ); ?>, <?php echo esc_attr($author->display_name) ?>. <?php esc_html_e( 'Congratulations your item has been listed', 'classiera' ); ?>!
				</h3>
			</div>
			<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
				<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
					<?php esc_html_e( 'Hi', 'classiera' ); ?>, <?php echo esc_attr($author->display_name) ?>. <?php esc_html_e( 'Congratulations your item has been listed', 'classiera' ); ?>! 
					<strong>(<?php echo esc_html($post->post_title) ?>)</strong> <?php esc_html_e( 'on', 'classiera' ); ?> <?php echo  $blog_title = get_bloginfo('name'); ?>!
				</p>
				<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
					<?php esc_html_e( 'You have successfully listed your item on', 'classiera' ); ?> <strong><?php echo  $blog_title = get_bloginfo('name'); ?></strong>, <?php esc_html_e( 'now sit back and let us do the hard work.', 'classiera' ); ?>
				</p>
				<p>
					<span style="display: block;font-family: 'Lato', sans-serif; font-size: 16px; font-weight: bold; color: #232323; margin-bottom: 10px;"><?php esc_html_e( 'If you like to take a look', 'classiera' ); ?> : </span>
					<a href="<?php echo get_permalink($post->ID) ?>" style="color: #0d7cb0; font-family: 'Lato', sans-serif; font-size: 14px; ">
						<?php esc_html_e( 'Click Here', 'classiera' ); ?>
					</a>
				</p>
			</div>
			<?php
			include(TEMPLATEPATH . '/templates/email/email-footer.php');	
			$message = ob_get_contents();
			ob_end_clean();	
			if( function_exists('classiera_send_wp_mail')){
				classiera_send_wp_mail($author_email, $email_subject, $message);
			}
		}    
	}
}
/*==========================
 Email template New User Registration Function
 ===========================*/
if(!function_exists('classieraUserNotification')) {  
	function classieraUserNotification($email, $password, $username){
		$blog_title = get_bloginfo('name');
		$blog_url = esc_url( home_url() ) ;
		$adminEmail =  get_bloginfo('admin_email');
		global $redux_demo;
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
		$welComeUser = $redux_demo['trns_welcome_user_title'];	
		$email_subject = $welComeUser." ".$username."!";
		
		ob_start();	
		include(get_template_directory() . '/templates/email/email-header.php');
		
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_html($welComeUser); ?></h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
				<?php esc_html_e( 'A very special welcome to you', 'classiera' ); ?>, <?php echo esc_attr($username) ?>
			</h3>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; font-weight: normal; text-transform: capitalize;">
				<?php esc_html_e( 'A very special welcome to you', 'classiera' ); ?>, <?php echo esc_attr($username) ?>. <?php esc_html_e( 'Thank you for joining', 'classiera' ); ?> <?php echo esc_html($blog_title); ?>!
			</h3>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Your username is', 'classiera' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
				<?php echo esc_attr($username); ?>
				</span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Your password is', 'classiera' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php echo esc_attr($password) ?>
				</span>
			</p>
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
				<?php esc_html_e( 'We hope you enjoy your stay at', 'classiera' ); ?> <a href="<?php echo esc_url($blog_url); ?>"><?php echo esc_html($blog_title); ?></a>. <?php esc_html_e( 'If you have any problems, questions, opinions, praise, comments, suggestions, please feel free to contact us at', 'classiera' ); ?> 
			 <strong><?php echo sanitize_email($adminEmail); ?> </strong><?php esc_html_e( 'any time!', 'classiera' ); ?>
			</p>
		</div>
		<?php
		
		include(get_template_directory() . '/templates/email/email-footer.php');
		
		$message = ob_get_contents();
		ob_end_clean();
		if( function_exists('classiera_send_wp_mail')){
			classiera_send_wp_mail($email, $email_subject, $message);
		}
	}
}
/*==========================
 Email to Admin On New User Registration
 ===========================*/
if(!function_exists('classieraNewUserNotifiy')) { 
	function classieraNewUserNotifiy($email, $username){
		$blog_title = get_bloginfo('name');
		$blog_url = esc_url( home_url() ) ;
		$adminEmail =  get_bloginfo('admin_email');
		global $redux_demo;
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
		
		$email_subject = "New User Has been Registered On ".$blog_title;
		
		ob_start();	
		include(get_template_directory() . '/templates/email/email-header.php');
		
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php esc_html_e( 'New User has been Registered !', 'classiera' ); ?></h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
				<?php esc_html_e( 'Hello Admin, New User Registred on', 'classiera' ); ?>, <?php echo esc_html($blog_title) ?>
			</h3>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
				<?php esc_html_e( 'Hello, New User has been Registred on', 'classiera' ); ?>, <?php echo esc_html($blog_title) ?>. <?php esc_html_e( 'By using this email', 'classiera' ); ?> <?php echo sanitize_email($email); ?>!
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'His User name is:', 'classiera' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php echo esc_attr($username); ?>
				</span>
			</p>
		</div>	
		<?php
		
		include(get_template_directory() . '/templates/email/email-footer.php');
		
		$message = ob_get_contents();
		ob_end_clean();
		if( function_exists('classiera_send_wp_mail')){
			classiera_send_wp_mail($adminEmail, $email_subject, $message);
		}
	}
}
/*==========================
	Pending Post Status Function
 ===========================*/	
if(!function_exists('classieraPendingPost')) {  
	function classieraPendingPost( $new_status, $old_status, $post ) {
		if ( $new_status == 'private' ) {
			$author = get_userdata($post->post_author);
			global $redux_demo;
			$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
			$trns_new_post_posted = $redux_demo['trns_new_post_posted'];
			$email_subject = $trns_new_post_posted;
			$adminEmail =  get_bloginfo('admin_email');	
			ob_start();
			include(TEMPLATEPATH . '/templates/email/email-header.php');
			?>
			<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
				<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_html($trns_new_post_posted); ?></h4>
				<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
				<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
					<?php esc_html_e( 'Hello Admin, New Ads Posted on', 'classiera' ); ?>, <?php echo esc_html($blog_title); ?>
				</h3>
			</div>
			<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
				<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
					<?php esc_html_e( 'Hi', 'classiera' ); ?>, <?php echo esc_attr($author->display_name); ?>. <?php esc_html_e( 'Have Post New Ads', 'classiera' ); ?><strong>(<?php echo esc_html($post->post_title); ?>)</strong> <?php esc_html_e( 'on', 'classiera' ); ?> <?php echo get_bloginfo('name'); ?>!
				</p>
				 <p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;"><?php esc_html_e( 'Please Approve or Reject this Post from WordPress Dashboard.', 'classiera' ); ?> </p>
			</div>
			<?php
			include(TEMPLATEPATH . '/templates/email/email-footer.php');
			$message = ob_get_contents();
			ob_end_clean();
			
			if( function_exists('classiera_send_wp_mail')){
				classiera_send_wp_mail($adminEmail, $email_subject, $message);
			}
		}
	}
	add_action(  'transition_post_status',  'classieraPendingPost', 10, 3 );
}
/*==========================
	Rejected Post Status Function
 ===========================*/
if(!function_exists('classieraRejectedPost')) {  
	function classieraRejectedPost( $new_status, $old_status, $post ){
		if ($new_status == 'rejected'){		
			$author = get_userdata($post->post_author);		
			$author_email = $author->user_email;
			$author_display = $author->user_login;
			$blog_title = get_bloginfo('name');
			global $redux_demo;
			$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
			$email_subject = esc_html__( 'Your Ad is Rejected..!', 'classiera' );
			$adminEmail =  get_bloginfo('admin_email');	
			ob_start();
			include(TEMPLATEPATH . '/templates/email/email-header.php');
			?>
			<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
				<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_html($email_subject); ?></h4>
				<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
				<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
					<?php esc_html_e( 'Hello', 'classiera' ); ?>, <?php echo esc_attr($author_display); ?>
				</h3>
			</div>
			<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
				<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
					<?php esc_html_e( 'We want to inform you, your ad is rejected, which you have posts on', 'classiera' ); ?> &nbsp;<?php echo get_bloginfo('name'); ?>!
				</p>
				<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;"><?php esc_html_e( 'Please visit your Dashboard to see post status, For more information contact with website admin at this email.', 'classiera' ); ?> <a href="mailto:<?php echo sanitize_email($adminEmail); ?>"><?php echo sanitize_email($adminEmail); ?></a> </p>
			</div>
			<?php
			include(TEMPLATEPATH . '/templates/email/email-footer.php');
			$message = ob_get_contents();
			ob_end_clean();		
			
			if( function_exists('classiera_send_wp_mail')){
				classiera_send_wp_mail($author_email, $email_subject, $message);
			}
		}
	}
	add_action(  'transition_post_status',  'classieraRejectedPost', 10, 3 );
}
/*==========================
	Email to Post Author
 ===========================*/
if(!function_exists('contactToAuthor')) { 
	function contactToAuthor($emailTo, $subject, $name, $email, $comments, $headers, $classieraPostTitle, $classieraPostURL) {	

		$blog_title = get_bloginfo('name');
		$blog_url = esc_url( home_url() ) ;
		$adminEmail =  get_bloginfo('admin_email');
		global $redux_demo;
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
		
		$email_subject = $subject;
		
		ob_start();	
		include(get_template_directory() . '/templates/email/email-header.php');
		
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_attr($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_attr($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_attr($email_subject); ?></h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
				<?php esc_html_e( 'You have received email from', 'classiera' ); ?>, <?php echo esc_attr($name); ?>
			</h3>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; font-weight: normal; text-transform: capitalize;">
				<?php esc_html_e( 'Your have received this email from', 'classiera' ); ?>
			</h3>
			<p><?php echo esc_html($comments); ?></p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Sender Name', 'classiera' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
				<?php echo esc_attr($name);?></span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Sender Email', 'classiera' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
				<?php echo sanitize_email($email);?></span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Your Post Title', 'classiera' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
				<?php echo esc_html($classieraPostTitle);?></span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Your Post URL', 'classiera' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;"><?php echo esc_url($classieraPostURL);?></span>
			</p>
		</div>	
		<?php
		
		include(get_template_directory() . '/templates/email/email-footer.php');
		
		$message = ob_get_contents();
		ob_end_clean();
		
		if (function_exists('classiera_send_mail_with_headers')) {
			classiera_send_mail_with_headers($emailTo, $email_subject, $message, $headers);
		}
	}
}
/*==========================
	Reset Password email
 ===========================*/	
if(!function_exists('classiera_reset_password')) {  
	function classiera_reset_password($new_password, $userName, $userEmail ){
		$blog_title = get_bloginfo('name');
		$blog_url = esc_url( home_url() ) ;
		$emailTo = $userEmail;
		$adminEmail =  get_bloginfo('admin_email');
		global $redux_demo;
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
		$email_subject = esc_html__( 'Password Reset', 'classiera' );
		
		ob_start();
		include(get_template_directory() . '/templates/email/email-header.php');
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_attr($email_subject); ?></h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
				<?php esc_html_e( 'Keep Your Password Always safe..!', 'classiera' ); ?>, <?php echo esc_attr($name); ?>
			</h3>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Your UserName Was', 'classiera' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
				<?php echo esc_attr($userName); ?></span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Your New Password is', 'classiera' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
				<?php echo esc_attr($new_password); ?></span>
			</p>
		</div>
		<?php
		include(get_template_directory() . '/templates/email/email-footer.php');
		$message = ob_get_contents();
		ob_end_clean();	
		if( function_exists('classiera_send_wp_mail')){
			classiera_send_wp_mail($emailTo, $email_subject, $message);
		}
	}	
}
/*==========================
	Send OFF to Author Email
 ===========================*/
if(!function_exists('classiera_send_offer_to_author')) {  
	function classiera_send_offer_to_author($offer_price, $offer_comment, $offer_post_id, $post_author_id, $offer_author_id, $offer_post_price){
		global $post;
		$classieraPT = get_the_title($offer_post_id);
		//Offer Author data//
		$offerAuthor = get_the_author_meta('display_name', $offer_author_id );
		if(empty($offerAuthor)){
			$offerAuthor = get_the_author_meta('user_nicename', $offer_author_id );
		}
		if(empty($offerAuthor)){
			$offerAuthor = get_the_author_meta('user_login', $offer_author_id );
		}
		//Offer Author data//
		//Post Author data//
		$postAuthor = get_the_author_meta('display_name', $post_author_id );
		if(empty($postAuthor)){
			$postAuthor = get_the_author_meta('user_nicename', $post_author_id );
		}
		if(empty($postAuthor)){
			$postAuthor = get_the_author_meta('user_login', $post_author_id );
		}
		$authorEmail = get_the_author_meta('user_email', $post_author_id);
		//Post Author data//
		$blog_title = get_bloginfo('name');
		$blog_url = esc_url( home_url() ) ;
		$emailTo = $userEmail;
		$adminEmail =  get_bloginfo('admin_email');
		global $redux_demo;
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
		$email_subject = esc_html__( 'New BID Offer Received..!', 'classiera' );
		
		ob_start();
		include(get_template_directory() . '/templates/email/email-header.php');
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_html($email_subject); ?></h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
				<?php esc_html_e( 'Congratulations you have received new offer for your post', 'classiera' ); ?>:
			</h3>
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
				<?php echo esc_html($classieraPT); ?>
			</h3>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 18px; color: #232323;"><?php esc_html_e( 'Your Price was', 'classiera' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 16px; color: #0d7cb0;">
				<?php echo esc_attr($offer_post_price); ?></span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 18px; color: #232323;"><?php esc_html_e( 'Offered Price', 'classiera' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 16px; color: #0d7cb0;">
				<?php echo esc_attr($offer_price); ?></span>
			</p>		
			<p style="font-family: 'Ubuntu', sans-serif; font-size: 18px; color: #232323;">
				<?php esc_html_e( 'Visit your profile inbox to reply to user.', 'classiera' ); ?>
			</p>
		</div>
		<?php
		include(get_template_directory() . '/templates/email/email-footer.php');
		$message = ob_get_contents();
		ob_end_clean();
		
		if( function_exists('classiera_send_wp_mail')){
			classiera_send_wp_mail($authorEmail, $email_subject, $message);
		}
	}
}	
/*==========================
	Report Ad to Admin
 ===========================*/
if(!function_exists('classiera_reportAdtoAdmin')) { 
	function classiera_reportAdtoAdmin($message, $classieraPostTitle, $classieraPostURL){
		$blog_title = get_bloginfo('name');
		$blog_url = esc_url( home_url() ) ;	
		$adminEmail =  get_bloginfo('admin_email');
		global $redux_demo;
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
		$email_subject = esc_html__( 'Report Ad Notification!', 'classiera' );
		
		ob_start();
		include(get_template_directory() . '/templates/email/email-header.php');
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_html($email_subject); ?></h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
				<?php esc_html_e( 'Hello Admin, DMCA/Copyright', 'classiera' ); ?>
			</h3>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
				<?php esc_html_e( 'Hi Someone Report an Ad which is posted on your website.', 'classiera' ); ?>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;">
					<?php esc_html_e( 'Post Title Is', 'classiera' ); ?> : 
				</span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php echo esc_html($classieraPostTitle); ?>
				</span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;">
					<?php esc_html_e( 'Post Link', 'classiera' ); ?> : 
				</span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php echo esc_url($classieraPostURL); ?>
				</span>
			</p>
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
				<?php echo esc_html($message); ?>
			</p>
		</div>
		<?php
		include(get_template_directory() . '/templates/email/email-footer.php');
		$emilbody = ob_get_contents();
		ob_end_clean();
		if( function_exists('classiera_send_wp_mail')){
			classiera_send_wp_mail($adminEmail, $email_subject, $emilbody);
		}
	}	
}
/*==========================
	Contact us Page email
 ===========================*/
if(!function_exists('classiera_contact_us_page')) {  
	function classiera_contact_us_page($name, $email, $submitMobile, $emailTo, $subject, $comments){
		$blog_title = get_bloginfo('name');
		$blog_url = esc_url( home_url() ) ;	
		$adminEmail =  $emailTo;
		global $redux_demo;
		$headers = 'From <'.$adminEmail.'>' . "\r\n" . 'Reply-To: ' . $email;
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
		$email_subject = $subject;
		
		ob_start();
		include(get_template_directory() . '/templates/email/email-header.php');
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_html($email_subject); ?></h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
				<?php echo esc_html($comments); ?>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;">
					<?php esc_html_e( 'Sender Name', 'classiera' ); ?> : <?php echo esc_attr($name); ?>
				</span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php esc_html_e( 'Sender Email', 'classiera' ); ?> : <?php echo sanitize_email($email); ?>
				</span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php esc_html_e( 'Sender Phone', 'classiera' ); ?> : <?php echo esc_attr($submitMobile); ?>
				</span>
			</p>		
		</div>
		<?php
		include(get_template_directory() . '/templates/email/email-footer.php');
		$emilbody = ob_get_contents();
		ob_end_clean();
		if (function_exists('classiera_send_mail_with_headers')) {
			classiera_send_mail_with_headers($adminEmail, $email_subject, $emilbody, $headers);
		}
	}
}
?>
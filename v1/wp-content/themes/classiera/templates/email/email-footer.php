		<?php 
			global $redux_demo;
			$classieraLogo = $redux_demo['classiera_email_logo']['url'];
			$classieraCopyRight = $redux_demo['footer_copyright'];
			$classieraFacebook = $redux_demo['facebook-link'];
			$classieraTwitter = $redux_demo['twitter-link'];
			$classieraDribbble = $redux_demo['dribbble-link'];
			$classieraFlickr = $redux_demo['flickr-link'];
			$classieraGithub = $redux_demo['github-link'];
			$classieraPinterest = $redux_demo['pinterest-link'];	
			$classieraYouTube = $redux_demo['youtube-link'];
			$classieraGoogle = $redux_demo['google-plus-link'];
			$classieraLinkedin = $redux_demo['linkedin-link'];
			$classieraInstagram = $redux_demo['instagram-link'];
			$classieraVimeo = $redux_demo['vimeo-link'];
		?>
			<div class="classiera-email-footer" style="padding: 50px 0; background: #232323; text-align: center;">
				<img style="margin-bottom: 40px;" src="<?php echo esc_url($classieraLogo); ?>" alt="<?php bloginfo( 'name' ); ?>">
				<div style="text-align: center;">
					<?php if(!empty($classieraFacebook)){?>
					<?php $facebookIMG = get_template_directory_uri() . '/images/social/facebook.png'; ?>
					<a class="classiera-email-social-icon" href="<?php echo esc_url($classieraFacebook); ?>" style="background: #444444; height: 40px; width: 40px; text-align: center; display: inline-block; line-height:40px;">
						<img src="<?php echo esc_url($facebookIMG); ?>" style="width:14px;" alt="facebook">
					</a>
					<?php } ?>
					<?php if(!empty($classieraTwitter)){?>
					<?php $twiiterIMG = get_template_directory_uri() . '/images/social/twiiter.png'; ?>
					<a class="classiera-email-social-icon" href="<?php echo esc_url($classieraTwitter); ?>" style="background: #444444; height: 40px; width: 40px; text-align: center; display: inline-block; line-height:40px;">
						<img src="<?php echo esc_url($twiiterIMG); ?>" style="width:14px;" alt="twitter">
					</a>
					<?php } ?>
					<?php if(!empty($classieraGoogle)){?>
					<?php $googleIMG = get_template_directory_uri() . '/images/social/google-plus.png'; ?>
					<a class="classiera-email-social-icon" href="<?php echo esc_url($classieraGoogle); ?>" style="background: #444444; height: 40px; width: 40px; text-align: center; display: inline-block; line-height:40px;">
						<img src="<?php echo esc_url($googleIMG); ?>" style="width:14px;" alt="google">
					</a>
					<?php } ?>
					<?php if(!empty($classieraPinterest)){?>
					<?php $pinterestIMG = get_template_directory_uri() . '/images/social/pinterest.png'; ?>
					<a class="classiera-email-social-icon" href="<?php echo esc_url($classieraPinterest); ?>" style="background: #444444; height: 40px; width: 40px; text-align: center; display: inline-block; line-height:40px;">
						<img src="<?php echo esc_url($pinterestIMG); ?>" style="width:14px;" alt="pinterest">
					</a>
					<?php } ?>
					<?php if(!empty($classieraInstagram)){?>
					<?php $instagramIMG = get_template_directory_uri() . '/images/social/instagram.png'; ?>
					<a class="classiera-email-social-icon" href="<?php echo esc_url($classieraInstagram); ?>" style="background: #444444; height: 40px; width: 40px; text-align: center; display: inline-block; line-height:40px;">
						<img src="<?php echo esc_url($instagramIMG); ?>" style="width:14px;" alt="instagram">
					</a>
					<?php } ?>
					<?php if(!empty($classieraLinkedin)){?>
					<?php $linkedinIMG = get_template_directory_uri() . '/images/social/linkedin.png'; ?>
					<a class="classiera-email-social-icon" href="<?php echo esc_url($classieraLinkedin); ?>" style="background: #444444; height: 40px; width: 40px; text-align: center; display: inline-block; line-height:40px;">
						<img src="<?php echo esc_url($linkedinIMG); ?>" style="width:14px;" alt="linkedin">
					</a>
					<?php } ?>
				</div>
			</div><!--classiera-email-footer-->
			<div class="cassiera-footer-bottom" style="padding: 10px 0; text-align: center; background: #303030;">
				<p style="font-family: 'Lato', sans-serif; font-size:14px; color: #8e8e8e">
				<?php echo wp_kses($classieraCopyRight, $allowed_html); ?>
				</p>
			</div><!--cassiera-footer-bottom-->
		</div>
	</body>
</html>
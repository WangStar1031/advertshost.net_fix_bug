<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "off-canvas-wrap" div and all content after.
 *
 * @package WordPress
 * @subpackage ClassiEra
 * @since ClassiEra 1.0
 */

?>
<?php 
	global $redux_demo;
	global $allowed_html;	
	$classieraCopyRight = $redux_demo['footer_copyright'];
	$classierabackToTop = $redux_demo['backtotop'];
	$classieraGoogleAnalytics = $redux_demo['google_analytics'];
	$classieraFooterWidgets = $redux_demo['footer_widgets_area_on'];
	$classieraFooterStyle = $redux_demo['classiera_footer_style'];
	$classieraFooterBottomStyle = $redux_demo['classiera_footer_bottom_style'];
	$footerStyleClass = 'section-bg-black section-bg-light-img';
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
	$classieraInbox = $redux_demo['classiera_inbox_page_url'];
	if($classieraFooterStyle == 'three'){
		$footerStyleClass = 'section-bg-black section-bg-light-img';
	}elseif($classieraFooterStyle == 'four'){
		$footerStyleClass = 'section-bg-black four-columns-footer';
	}
	if (function_exists('icl_object_id')){
		$templateMessage = 'template-message.php';
		$classieraInbox = classiera_get_template_url($templateMessage);
	}
	if($classieraGoogleAnalytics){
		echo sprintf($classieraGoogleAnalytics);
	}
?>
<footer class="<?php if($classieraFooterWidgets == 1){ echo "section-pad"; }?> <?php echo esc_attr($footerStyleClass); ?>">
	<div class="container">
		<div class="row">
			<?php if($classieraFooterWidgets == 1){ ?>
			<?php dynamic_sidebar( 'footer-one' ); ?>
			<?php } ?>
		</div><!--row-->
	</div><!--container-->
</footer>
<section class="footer-bottom">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-sm-6">
				<p><?php echo wp_kses($classieraCopyRight, $allowed_html); ?></p>
			</div>
			<div class="col-lg-6 col-sm-6">
				<?php if($classieraFooterBottomStyle == 'menu'){?>
				<?php classieraFooterNav(); ?>
				<?php }elseif($classieraFooterBottomStyle == 'icon'){
					?>
					<ul class="footer-bottom-social-icon">
						<li><span><?php esc_html_e( 'Follow Us', 'classiera' ); ?> :</span></li>
						
						<?php if(!empty($classieraFacebook)){?>
						<li>
							<a href="<?php echo esc_url($classieraFacebook); ?>" class="rounded text-center" target="_blank">
								<i class="fab fa-facebook-f"></i>
							</a>
						</li>
						<?php } ?>
						<?php if(!empty($classieraTwitter)){?>
						<li>
							<a href="<?php echo esc_url($classieraTwitter); ?>" class="rounded text-center" target="_blank">
								<i class="fab fa-twitter"></i>
							</a>
						</li>
						<?php } ?>
						<?php if(!empty($classieraGoogle)){?>
						<li>
							<a href="<?php echo esc_url($classieraGoogle); ?>" class="rounded text-center" target="_blank">
								<i class="fab fa-google-plus-g"></i>
							</a>
						</li>
						<?php } ?>
						<?php if(!empty($classieraYouTube)){?>
						<li>
							<a href="<?php echo esc_url($classieraYouTube); ?>" class="rounded text-center" target="_blank">
								<i class="fab fa-youtube"></i>
							</a>
						</li>
						<?php } ?>
						<?php if(!empty($classieraPinterest)){?>
						<li>
							<a href="<?php echo esc_url($classieraPinterest); ?>" class="rounded text-center" target="_blank">
								<i class="fab fa-pinterest-p"></i>
							</a>
						</li>
						<?php } ?>
						<?php if(!empty($classieraInstagram)){?>
						<li>
							<a href="<?php echo esc_url($classieraInstagram); ?>" class="rounded text-center" target="_blank">
								<i class="fab fa-instagram"></i>
							</a>
						</li>
						<?php } ?>
					</ul>
					<?php
				}?>
			</div>
		</div><!--row-->
	</div><!--container-->
</section>
<?php 
if(is_user_logged_in()){
	$current_user = wp_get_current_user();
	$user_ID = $current_user->ID;
	$classieraRead = classiera_unread_message_by_user($user_ID);	
	if($classieraRead > 0 && $classieraRead != 0){
?>
	<a href="<?php echo esc_url($classieraInbox); ?>" class="bid_notification">
		<span class="bid_notification__icon"><i class="fa fa-bell"></i></span>
		<span class="bid_notification__count"><?php echo esc_attr($classieraRead); ?></span>
	</a>
<?php
	}
}
?>
<?php if($classierabackToTop == 1){?>
	<!-- back to top -->
	<a href="#" id="back-to-top" title="<?php esc_html_e( 'Back to top', 'classiera' ); ?>" class="social-icon social-icon-md"><i class="fa fa-angle-double-up removeMargin"></i></a>
<?php } ?>
<?php wp_footer(); ?>
</body>
</html>
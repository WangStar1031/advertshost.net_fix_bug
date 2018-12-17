<?php
/**
 * The Template for displaying all single pricing plans.
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 2.0.19
 */
get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<section class="inner-page-content single-post-page">
	<div class="container">
		<!-- breadcrumb -->
		<?php classiera_breadcrumbs();?>
		<!-- breadcrumb -->
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<section class="pricing-plan section-light-bg">
					<div class="pricing-plan-content">
						<?php 
						global $redux_demo;
						$classieraCartURL = $redux_demo['classiera_cart_url'];
						$classieraExpiry = $redux_demo['ad_expiry'];
						$login = $redux_demo['login'];
						$current_user = wp_get_current_user();
						$user_ID = $current_user->ID;	
						$popular_plan = get_post_meta($post->ID, 'popular_plan', true);
						$free_plans = get_post_meta($post->ID, 'free_plans', true);
						$wooID = get_post_meta($post->ID, 'woo_id', true);
						$post_price = get_post_meta($post->ID, 'plan_price', true);
						$plan_text = get_post_meta($post->ID, 'plan_text', true);
						$plan_days = get_post_meta($post->ID, 'plan_time', true);
						$planFeaturedTXT = get_post_meta($post->ID, 'plan_free_text', true);
						$planSecureTXT = get_post_meta($post->ID, 'plan_secure_text', true);
						$plan_ads = get_post_meta($post->ID, 'featured_ads', true);
						$regular_ads = get_post_meta($post->ID, 'regular_ads', true);
						if($free_plans == 1){
							$classieraPlansType =  esc_html__( 'Free', 'classiera' );
							$plan_days = $classieraExpiry;
						}else{
							$classieraPlansType =  get_the_title();
							$plan_days = $plan_days;
						}
						$redirect = classiera_Plans_URL($free_plans);
						?>
							<div class="col-lg-6 col-md-6 col-sm-6 price-plan">
								<div class="pricing-plan-box border <?php if($popular_plan == 'true'){echo "popular";} ?>">
									<?php if($popular_plan == 'true'){
										?>
										<div class="featured-tag">
											<span class="left-corner"></span>
											<span class="right-corner"></span>
											<div class="featured">
												<p><?php esc_html_e('Popular', 'classiera') ?></p>
											</div>
										</div>
										<?php
									}?>
									<div class="pricing-plan-heading">
										<h4><?php echo esc_html($classieraPlansType); ?></h4>
										<p>
										<?php esc_html_e('For', 'classiera') ?>
										<?php echo esc_attr($plan_days); ?>
										<?php if($plan_days != 'lifetime') { esc_html_e('Days Only', 'classiera'); }?>
										</p>
									</div><!--pricing-plan-heading-->
									<div class="pricing-plan-price">
										<h1>
											<?php 
												if($free_plans == 1){
													echo classiera_currency_sign()."0.00";										
												}else{
													echo classiera_currency_sign().$post_price;
												}
											?>
										</h1>
									</div>
									<div class="pricing-plan-text">
										<ul>
											<li><?php echo esc_html($planFeaturedTXT); ?></li>
											<li>
												<?php echo esc_attr($plan_ads) ?>&nbsp;
												<?php esc_html_e( 'Featured ads availability', 'classiera' ); ?>
											</li>
											<li>
												<?php echo esc_attr($regular_ads) ?>&nbsp;
												<?php esc_html_e( 'Regular ads availability', 'classiera' ); ?>
											</li>
											<li>
												<?php esc_html_e( 'For', 'classiera' ); ?>&nbsp;
												<?php echo esc_attr($plan_days) ?>&nbsp;
												<?php if($plan_days != 'lifetime') { esc_html_e('Days', 'classiera'); }?>
											</li>
											<li><?php echo esc_html($planSecureTXT); ?></li>
										</ul>
									</div><!--pricing-plan-text-->
									<!--FormSection-->
									<form method="post" class="planForm">
										<input type="hidden" class="AMT" name="AMT" value="<?php echo esc_attr($post_price); ?>" />
										
										<input type="hidden" class="wooID" name="id" value="<?php echo esc_attr($wooID); ?>" />
										<input type="hidden" class="plan_id" name="plan_id" value="<?php echo esc_attr($post->ID); ?>" />
										
										<input type="hidden" class="CURRENCYCODE" name="CURRENCYCODE" value="<?php echo classiera_currency_sign(); ?>">
										
										<input type="hidden" class="user_ID" name="user_ID" value="<?php echo esc_attr($user_ID); ?>">
										
										<input type="hidden" class="plan_name" name="plan_name" value="<?php the_title(); ?>">
										
										<?php $plan_ads = get_post_meta($post->ID, 'featured_ads', true); ?>
										<input type="hidden" class="plan_ads" name="plan_ads" value="<?php echo esc_attr($plan_ads); ?>">
										<input type="hidden" class="regular_ads" name="regular_ads" value="<?php echo esc_attr($regular_ads); ?>">
										
										<?php $plan_time = get_post_meta($post->ID, 'plan_time', true); ?>
										<input type="hidden" class="plan_time" name="plan_time" value="<?php echo esc_attr($plan_time); ?>">
										<div class="pricing-plan-button">
										<?php 
										if($free_plans == 1){
											$link = classiera_Plans_URL();
											?>
										<a class="btn btn-primary sharp btn-sm btn-style-one" href="<?php echo esc_url($link); ?>">
											<?php esc_html_e( 'Post Ad', 'classiera' ); ?>
										</a>	
											<?php
										}else{
											if (is_user_logged_in()){
											?>
										<a rel="nofollow" href="#" data-quantity="1" data-product_id="<?php echo esc_attr($wooID); ?>" data-product_sku="" class="classiera_plan_add_to_cart btn btn-primary sharp btn-sm btn-style-one button">
										<?php esc_html_e( 'Purchase Now', 'classiera' ); ?>
										</a>
											<?php
											}else{
												?>
												<a rel="nofollow" href="<?php echo esc_url($login); ?>" class="btn btn-primary sharp btn-sm btn-style-one button">
												<?php esc_html_e( 'Purchase Now', 'classiera' ); ?>
												</a>
												<?php
											}
										}
										?>
										</div>							
									</form>
									<div class="viewcart">
										<a class="btn btn-primary sharp btn-sm btn-style-one" href="<?php echo esc_url($classieraCartURL); ?>">
										<?php esc_html_e( 'View Cart', 'classiera' ); ?>
										</a>
									</div>
									<!--FormSection-->
								</div><!--pricing-plan-box-->
							</div><!--col-lg-3-->
					</div><!--pricing-plan-content-->
				</section>
			</div><!--col-md-12-->
		</div><!--row-->
	</div><!-- container -->
</section>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
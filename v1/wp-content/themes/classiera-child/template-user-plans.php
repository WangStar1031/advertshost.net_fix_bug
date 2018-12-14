<?php
/**
 * Template name: Single User All Plans
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera
 */

if ( !is_user_logged_in() ) { 
	global $redux_demo; 
	$login = $redux_demo['login'];
	wp_redirect( $login ); exit;
}

global $redux_demo; 
$edit = $redux_demo['edit'];
$profile = $redux_demo['profile'];
$all_adds = $redux_demo['all-ads'];
$allFavourite = $redux_demo['all-favourite'];
$pricingPlans = $redux_demo['featured_plans'];
$getCredits = $redux_demo['get_credits'];
if(function_exists('icl_object_id')){ 
	$templatePlans = 'template-pricing-plans.php';
	$pricingPlans = classiera_get_template_url($templatePlans);
}
$newPostAds = $redux_demo['new_post'];
$current_user = wp_get_current_user();
$user_info = get_userdata($user_ID);
$user_id = $current_user->ID; // You can set $user_id to any users, but this gets the current users ID.
get_header();
?>
<!-- user pages -->
<section class="user-pages">
	<div class="container">
        <div class="row">
			<div class="col-lg-3 col-md-4">
				<?php get_template_part( 'templates/profile/userabout' );?>
			</div><!--col-lg-3-->
			<div class="col-lg-9 col-md-8 user-content-height">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title text-uppercase"><?php esc_html_e("Order History", 'classiera') ?></h3>
					</div>
					<div class="panel-body">
						<div class="user-detail-section">
							<!-- Oder History -->
							<div class="user-ads user-packages">
								<?php
								if (class_exists( 'woocommerce' ) ):
								if (!class_exists('woocommerce')) :
									require ABSPATH . 'wp-content/plugins/woocommerce/woocommerce.php';
									$orders = get_all_orders();
								endif;
								?>
								<div class="table-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th><?php esc_html_e("Package Name", 'classiera') ?></th>
												<th><?php esc_html_e("Duration", 'classiera') ?></th>
												<th><?php esc_html_e("Featured Ads", 'classiera') ?></th>
												<th><?php esc_html_e("Regular Ads", 'classiera') ?></th>
												<th><?php esc_html_e("Price", 'classiera') ?></th>
												<th><?php esc_html_e("Status", 'classiera') ?></th>
												<th><?php esc_html_e("Details", 'classiera') ?></th>
												<th><?php esc_html_e("Payment Method", 'classiera') ?></th>
												
											</tr>
										</thead>
										<tbody>
										<?php					
										$args = array(
											'numberposts' => -1,
											'meta_key' => '_customer_user',
											'meta_value' => get_current_user_id(),
											'post_type' => 'shop_order',
											'post_status' => array_keys(wc_get_order_statuses()),
										);							
										$customer_orders = get_posts($args);							
										$loop = new WP_Query($customer_orders);
										  foreach ($customer_orders as $orderItem){								  
												$order = wc_get_order($orderItem->ID);
												$items = $order->get_items();
												$current = 0;
												foreach ( $items as $item_id => $item_data ) {
													//print_r($item_data);
													$plan_name = wc_get_order_item_meta($item_id, 'plan_name', true);
													$plan_time = wc_get_order_item_meta($item_id, 'plan_time', true);
													$plan_ads = wc_get_order_item_meta($item_id, 'plan_ads', true);
													$regular_ads = wc_get_order_item_meta($item_id, 'regular_ads', true);
													$payment = wc_get_order_item_meta($item_id, 'payment_method_title', true);
													$days_to_expire = wc_get_order_item_meta($item_id, 'days_to_expire', true);
													$bump_ads = wc_get_order_item_meta($item_id, 'bump_ads', true);
													?>
													<tr><?php
													if(empty($days_to_expire) && empty($bump_ads)){
													?>										
													<td><?php echo esc_attr( $plan_name ); ?></td>
													<td><?php echo esc_attr( $plan_time ); ?>&nbsp;<?php esc_html_e("Days", 'classiera') ?></td>
													<td><?php echo esc_attr( $plan_ads ); ?></td>			
													<td><?php echo esc_attr( $regular_ads ); ?></td>			
													<td>
														<?php echo esc_html( get_woocommerce_currency_symbol()); ?>
														<?php echo esc_attr( $item_data['total']); ?>
													</td>
													<?php } ?>
													<?php if(empty($days_to_expire) && empty($bump_ads)){?>
														<td class="text-success">
															<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
														</td>
														<td>
															<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
																<?php esc_html_e("View order details", 'classiera') ?>
															</a>
														</td>
														<td>
															<?php echo esc_html( $order->get_payment_method_title() ); ?>
														</td>
													<?php } ?>
												<?php } ?>
												</tr>
												<?php
											}
										?>
										</tbody>
									</table>
								</div><!--table-responsive-->
								<!--Bump Ads details -->
								<h4 class="user-detail-section-heading text-uppercase">
									<?php esc_html_e("Order History for Bump Ads", 'classiera') ?>
								</h4>
								<div class="table-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th><?php esc_html_e("Post Name", 'classiera') ?></th>
												<th><?php esc_html_e("Post ID", 'classiera') ?></th>
												<th><?php esc_html_e("Price", 'classiera') ?></th>
												<th><?php esc_html_e("Status", 'classiera') ?></th>
												<th><?php esc_html_e("Details", 'classiera') ?></th>
												<th><?php esc_html_e("Payment Method", 'classiera') ?></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($customer_orders as $orderItem){?>
												<tr>
													<?php 
													$order = wc_get_order($orderItem->ID);
													$items = $order->get_items();
													$current = 0;
													foreach ( $items as $item_id => $item_data ) {
														//print_r($item_data);
														$days_to_expire = wc_get_order_item_meta($item_id, 'days_to_expire', true);
														$post_id = wc_get_order_item_meta($item_id, 'post_id', true);
														$post_title = wc_get_order_item_meta($item_id, 'post_title', true);
														$payment = wc_get_order_item_meta($item_id, 'payment_method_title', true);
														$bump_ads = wc_get_order_item_meta($item_id, 'bump_ads', true);
														if(!empty($bump_ads) && empty($days_to_expire)){
															?>
															<td>
																<?php echo esc_html($post_title); ?>
															</td>
															<td>
																<?php echo esc_attr( $post_id ); ?>
															</td>
															<td>
																<?php echo esc_html( get_woocommerce_currency_symbol() ); ?>
																<?php echo esc_attr( $item_data['total']); ?>
															</td>
															<?php
														}
													}
													if(!empty($bump_ads) && empty($days_to_expire)){
													?>
													<td class="text-success">
														<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
													</td>
													<td>
														<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
															<?php esc_html_e("View order details", 'classiera') ?>
														</a>
													</td>
													<td>
														<?php echo esc_html( $order->get_payment_method_title() ); ?>
													</td>
													<?php } ?>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div><!--table-responsive-->
								<!--Bump Ads details -->
								<h4 class="user-detail-section-heading text-uppercase">
									<?php esc_html_e("Order History for Single Featured Posts", 'classiera') ?>
								</h4>
								<div class="table-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th><?php esc_html_e("Post Name", 'classiera') ?></th>
												<th><?php esc_html_e("Post ID", 'classiera') ?></th>
												<th><?php esc_html_e("Duration", 'classiera') ?></th>
												<th><?php esc_html_e("Price", 'classiera') ?></th>
												<th><?php esc_html_e("Status", 'classiera') ?></th>
												<th><?php esc_html_e("Details", 'classiera') ?></th>
												<th><?php esc_html_e("Payment Method", 'classiera') ?></th>
												
											</tr>
										</thead>
										<tbody>
											<?php foreach ($customer_orders as $orderItem){?>
												<tr>
													<?php 
													$order = wc_get_order($orderItem->ID);
													//print_r($order);
													$items = $order->get_items();
													$current = 0;
													foreach ( $items as $item_id => $item_data ) {
														//print_r($item_data);
														$days_to_expire = wc_get_order_item_meta($item_id, 'days_to_expire', true);
														$post_id = wc_get_order_item_meta($item_id, 'post_id', true);
														$post_title = wc_get_order_item_meta($item_id, 'post_title', true);
														$payment = wc_get_order_item_meta($item_id, 'payment_method_title', true);
														$bump_ads = wc_get_order_item_meta($item_id, 'bump_ads', true);
														if(!empty($days_to_expire)){
													?>
														<td><?php echo esc_html($post_title); ?></td>
														<td><?php echo esc_attr($post_id); ?></td>
														<td>
															<?php echo esc_attr($days_to_expire); ?>&nbsp;
															<?php esc_html_e("Days", 'classiera') ?>
														</td>
														<td>
															<?php echo esc_html(get_woocommerce_currency_symbol()); ?>
															<?php echo esc_attr($item_data['total']); ?>
														</td>
														<?php }?>
														<!--BumpAds-->
													<?php } ?>
														<?php if(!empty($days_to_expire) && empty($bump_ads)){?>
														<td class="text-success">
															<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
														</td>
														<td>
															<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
																<?php esc_html_e("View order details", 'classiera') ?>
															</a>
														</td>
														<td>
															<?php echo esc_html($order->get_payment_method_title()); ?>
														</td>
													<?php } ?>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
								<?php else:?>
									<?php esc_html_e("Currently you have no order details.", 'classiera') ?>
								<?php endif;?>
							</div><!--user-ads user-packages-->
							<!-- Oder History -->
							<!--Package Details-->
							<div class="user-ads user-packages">
								<h4 class="user-detail-section-heading text-uppercase">
								<?php esc_html_e("Ads Plans Details", 'classiera') ?>
								</h4>
								<div class="table-responsive">
									<table class="table table-striped table-center">
										<thead>
											<tr>
												<th><?php esc_html_e("Plan Name", 'classiera') ?></th>
												<th><?php esc_html_e("Price", 'classiera') ?></th>
												<th><?php esc_html_e("Feature Ads", 'classiera') ?></th>
												<th><?php esc_html_e("Used Featured", 'classiera') ?></th>
												<th><?php esc_html_e("Regular Ads", 'classiera') ?></th>
												<th><?php esc_html_e("Used Regular", 'classiera') ?></th>
												<th><?php esc_html_e("Available Featured", 'classiera') ?></th>
												<th><?php esc_html_e("Available Regular", 'classiera') ?></th>
												<th><?php esc_html_e("Featured ads expiry in days", 'classiera') ?></th>
												<th><?php esc_html_e("status", 'classiera') ?></th>
											</tr>
										</thead>
										<tbody>
										<?php 
										$current_user = wp_get_current_user();
										$userID = $current_user->ID;
										$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id = $userID ORDER BY id DESC" );
										//print_r($result);
										$totalAds = '';
										$usedAds = '';
										$availableADS = '';
										$availableRegularADS = '';
										if(!empty($result)){
											foreach ( $result as $info ) {
												$totalAds = $info->ads;
												$regular_ads = $info->regular_ads;
												$regular_used = $info->regular_used;
												$usedAds = $info->used;
												if (is_numeric($totalAds)){	
													$availableADS = $totalAds-$usedAds;
												}else{
													$availableADS = 'unlimited';
												}
												if (is_numeric($regular_ads)){	
													$availableRegularADS = $regular_ads-$regular_used;
												}
												
												$plan_name = $info->plan_name;
												$price = $info->price;
												$days = $info->days;
												$status = $info->status;
												?>
												<tr>
													<td><?php echo esc_attr( $plan_name ); ?></td>
													<td><?php echo classiera_currency_sign().$price; ?></td>
													<td><?php echo esc_attr( $totalAds ); ?></td>
													<td><?php echo esc_attr( $usedAds ); ?></td>
													<td><?php echo esc_attr( $regular_ads ); ?></td>
													<td><?php echo esc_attr( $regular_used ); ?></td>
													<td><?php echo esc_attr( $availableADS ); ?></td>
													<td><?php echo esc_attr( $availableRegularADS ); ?></td>
													<td><?php echo esc_attr( $days ); ?></td>
													<td><?php echo esc_attr( $status ); ?></td>
												</tr>
												<?php
											}
										}
										?>
										</tbody>
									</table>
								</div><!--table-responsive-->
							</div>
							<!--Package Details-->
							<!--PlansButton-->
							<div class="row">
								<div class="col-sm-12 text-center">
									<a href="<?php echo esc_url( $getCredits ); ?>" class="btn btn-primary extra-padding"><?php esc_html_e("Get More Credits", 'classiera') ?></a>
								</div>
							</div>
							<!--PlansButton-->
						</div><!--user-detail-section-->
					</div>
				</div>
			</div><!--col-lg-9-->
		</div><!--row-->
	</div><!-- container-->
</section>
<!-- user pages -->

<?php get_footer(); ?>
<?php 
global $redux_demo;
$classieraCTABG = $redux_demo['classiera_call_to_action_background']['url'];
$classieraCTAAboutIcon = $redux_demo['classiera_call_to_action_about_icon']['url'];
$classieraCTAAboutTitle = $redux_demo['classiera_call_to_action_about'];
$classieraCTAAboutDesc = $redux_demo['classiera_call_to_action_about_desc'];
$classieraCTASellIcon = $redux_demo['classiera_call_to_action_sell_icon']['url'];
$classieraCTASellTitle = $redux_demo['classiera_call_to_action_sell'];
$classieraCTASellDesc = $redux_demo['classiera_call_to_action_sell_desc'];
$classieraCTABuyIcon = $redux_demo['classiera_call_to_action_buy_icon']['url'];
$classieraCTABuyTitle = $redux_demo['classiera_call_to_action_buy'];
$classieraCTABuyDesc = $redux_demo['classiera_call_to_action_buy_desc'];
$classieraParallax = $redux_demo['classiera_parallax'];
?>
<section class="call-to-action <?php if($classieraParallax == 1){ echo 'parallax__400'; }?>" style="background-image:url(<?php echo esc_url($classieraCTABG); ?>)">
	<div class="container">
		<div class="row gutter-15">
			<div class="col-lg-4 col-md-4 col-sm-6">
                <div class="call-to-action-box match-height">
                    <div class="action-box-heading">
                        <div class="heading-content">
                            <img src="<?php echo esc_url($classieraCTAAboutIcon); ?>" alt="<?php echo esc_html($classieraCTAAboutTitle); ?>">
                        </div>
                        <div class="heading-content">
                            <h3><?php echo esc_html($classieraCTAAboutTitle); ?></h3>
                        </div>
                    </div>
                    <div class="action-box-content">
                        <p>
                            <?php echo esc_html($classieraCTAAboutDesc); ?>
                        </p>
                    </div>
                </div>
            </div><!--End About Section-->
			<div class="col-lg-4 col-md-4 col-sm-6">
                <div class="call-to-action-box match-height">
                    <div class="action-box-heading">
                        <div class="heading-content">
                            <img src="<?php echo esc_url($classieraCTASellIcon); ?>" alt="<?php echo esc_html($classieraCTASellTitle); ?>">
                        </div>
                        <div class="heading-content">
                            <h3><?php echo esc_html($classieraCTASellTitle); ?></h3>
                        </div>
                    </div>
                    <div class="action-box-content">
                        <p>
                            <?php echo esc_html($classieraCTASellDesc); ?>
                        </p>
                    </div>
                </div>
            </div><!--End Sell Safely Section-->
			<div class="col-lg-4 col-md-4 col-sm-6">
                <div class="call-to-action-box match-height">
                    <div class="action-box-heading">
                        <div class="heading-content">
                            <img src="<?php echo esc_url($classieraCTABuyIcon); ?>" alt="<?php echo esc_html($classieraCTABuyTitle); ?>">
                        </div>
                        <div class="heading-content">
                            <h3><?php echo esc_html($classieraCTABuyTitle); ?></h3>
                        </div>
                    </div>
                    <div class="action-box-content">
                        <p>
                            <?php echo esc_html($classieraCTABuyDesc); ?>
                        </p>
                    </div>
                </div>
            </div><!--End Buy Safely Section-->
		</div><!--row gutter-15-->
	</div><!--container-->
</section><!--call-to-action-->
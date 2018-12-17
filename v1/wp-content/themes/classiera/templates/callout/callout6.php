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
$calloutbg = $redux_demo['callout-bg']['url'];
$calloutbgV2 = $redux_demo['callout-bg-version2']['url'];
$calloutTitle = $redux_demo['callout_title'];
$calloutTitlesecond = $redux_demo['callout_title_second'];
$calloutDesc = $redux_demo['callout_desc'];
$calloutBtnTxt = $redux_demo['callout_btn_text'];
$calloutBtnURL = $redux_demo['callout_btn_url'];
$featuredAdsPage = $redux_demo['featured_plans'];
$calloutBtnIcon = $redux_demo['callout_btn_icon_code'];
$calloutBtnIconTwo = $redux_demo['callout_btn_icon_code_two'];
$calloutBtnTxtTwo = $redux_demo['callout_btn_text_two'];
$calloutBtnURLTwo = $redux_demo['callout_btn_url_two'];
?>
<section class="members-v4 section-bg-light-img" style="background-image:url(<?php echo esc_url($calloutbg); ?>)">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-sm-5 hidden-xs hidden-sm">
                <div class="member-img">
					<?php if(!empty($calloutbgV2)){?>
                    <img src="<?php echo esc_url($calloutbgV2); ?>" alt="<?php echo esc_html($calloutTitle); ?>">
					<?php } ?>
                </div>
            </div>
			<div class="col-lg-6 col-md-7 col-sm-12">
				<div class="member-content">
					<h3><?php echo esc_html($calloutTitle); ?></h3>
					<p><?php echo esc_html($calloutDesc); ?></p>
					<ul class="fa-ul list-unstyled">
						<?php if(!empty($classieraCTAAboutIcon)){?>
						<li>
							<span><img class="svg" src="<?php echo esc_url($classieraCTAAboutIcon); ?>"></span>
							<?php echo esc_html($classieraCTAAboutTitle); ?>
						</li>
						<?php } ?>
						<?php if(!empty($classieraCTASellIcon)){?>
						<li>
							<span><img class="svg" src="<?php echo esc_url($classieraCTASellIcon); ?>"></span>
							<?php echo esc_html($classieraCTASellTitle); ?>
						</li>
						<?php } ?>
						<?php if(!empty($classieraCTABuyIcon)){?>
						<li>
							<span><img class="svg" src="<?php echo esc_url($classieraCTABuyIcon); ?>"></span>
							<?php echo esc_html($classieraCTABuyTitle); ?>
						</li>
						<?php } ?>
					</ul>
					<h4><?php echo esc_html($calloutTitlesecond); ?></h4>
					
					<?php if(!empty($calloutBtnTxt)){?>
					<a href="<?php echo esc_url($calloutBtnURL); ?>" class="btn btn-primary round outline btn-style-six">
						<?php echo esc_html($calloutBtnTxt); ?>
					</a>
					<?php } ?>
					<?php if(!empty($calloutBtnTxtTwo)){?>
					<a href="<?php echo esc_url($calloutBtnURLTwo); ?>" class="btn btn-primary round outline btn-style-six">
						<?php echo esc_html($calloutBtnTxtTwo); ?>
					</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>
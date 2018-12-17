<?php 
global $redux_demo;
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
$classieraParallax = $redux_demo['classiera_parallax'];
?>
<section class="members-v3 <?php if($classieraParallax == 1){ echo 'parallax__400'; }?>" style="background-image:url(<?php echo esc_url($calloutbg); ?>)">
	<div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-12">
                <div class="members-text text-left flip">
                    <h1><?php echo wp_kses_post($calloutTitle); ?></h1>
                    <h2><?php echo wp_kses_post($calloutTitlesecond); ?></h2>
                    <p><?php echo esc_html($calloutDesc); ?></p>
					
					<?php if(!empty($calloutBtnTxt)){?>
                    <a href="<?php echo esc_url($calloutBtnURL); ?>" class="btn btn-primary outline btn-md">
						<?php echo esc_html($calloutBtnTxt); ?>
					</a>
					<?php } ?>
					
					<?php if(!empty($calloutBtnTxtTwo)){?>
                    <a href="<?php echo esc_url($calloutBtnURLTwo); ?>" class="btn btn-primary outline btn-md">
						<?php echo esc_html($calloutBtnTxtTwo); ?>
					</a>
					<?php } ?>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 visible-lg">
                <div class="member-img text-center">
					<?php if(!empty($calloutbgV2 )){?>
						<img src="<?php echo esc_url($calloutbgV2); ?>">
					<?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
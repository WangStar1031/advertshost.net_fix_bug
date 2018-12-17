<?php 
global $redux_demo;
global $allowed_html;
$calloutbg = $redux_demo['callout-bg']['url'];
$calloutbgV2 = $redux_demo['callout-bg-version2']['url'];
$calloutTitle = $redux_demo['callout_title'];
$calloutTitlesecond = $redux_demo['callout_title_second'];
$calloutDesc = $redux_demo['callout_desc'];
$calloutBtnTxt = $redux_demo['callout_btn_text'];
$calloutBtnIcon = $redux_demo['callout_btn_icon_code'];
$calloutBtnURL = $redux_demo['callout_btn_url'];
$featuredAdsPage = $redux_demo['featured_plans'];
$calloutBtnTxtTwo = $redux_demo['callout_btn_text_two'];
$calloutBtnIconTwo = $redux_demo['callout_btn_icon_code_two'];
$calloutBtnURLTwo = $redux_demo['callout_btn_url_two'];
?>	
<section class="members" style="background-image:url(<?php echo esc_url($calloutbg); ?>)">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="members-text">
                    <h2><?php echo wp_kses($calloutTitle, $allowed_html); ?></h2>
                    <h3><?php echo wp_kses_post($calloutTitlesecond); ?></h3>
                    <p><?php echo esc_html($calloutDesc); ?></p>
                    <a href="<?php echo esc_url($calloutBtnURL); ?>" class="btn sharp btn-primary btn-style-one btn-sm">
						<?php if(is_rtl()){?>
							<?php echo esc_html($calloutBtnTxt); ?>
							<i class="icon-left <?php echo esc_html($calloutBtnIcon); ?>"></i>
						<?php }else{ ?>
							<i class="icon-left <?php echo esc_html($calloutBtnIcon); ?>"></i>
							<?php echo esc_html($calloutBtnTxt); ?>
						<?php } ?>
					</a>
                    <a href="<?php echo esc_url($calloutBtnURLTwo); ?>" class="btn sharp btn-primary btn-style-one btn-sm">
						<?php if(is_rtl()){?>
							<?php echo esc_html($calloutBtnTxtTwo); ?>
							<i class="icon-left <?php echo esc_html($calloutBtnIconTwo); ?>"></i>
						<?php }else{ ?>
							<i class="icon-left <?php echo esc_html($calloutBtnIconTwo); ?>"></i>
							<?php echo esc_html($calloutBtnTxtTwo); ?>
						<?php } ?>
					</a>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 hidden-xs hidden-sm">
                <div class="people-img pull-right flip">
                    <img class="img-responsive" src="<?php echo esc_url($calloutbgV2); ?>">
                </div>
            </div>
        </div>
    </div>
</section><!-- /.Memebers -->
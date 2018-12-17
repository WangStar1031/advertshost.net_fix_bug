<?php 
	global $redux_demo;
	$partner1 = $redux_demo['partner1']['url'];
	$partner2 = $redux_demo['partner2']['url'];
	$partner3 = $redux_demo['partner3']['url'];
	$partner4 = $redux_demo['partner4']['url'];
	$partner5 = $redux_demo['partner5']['url'];
	$partner6 = $redux_demo['partner6']['url'];
	$partner7 = $redux_demo['partner7']['url'];
	$partner8 = $redux_demo['partner8']['url'];
	$partner1URL = $redux_demo['partner1-url'];
	$partner2URL = $redux_demo['partner2-url'];
	$partner3URL = $redux_demo['partner3-url'];
	$partner4URL = $redux_demo['partner4-url'];
	$partner5URL = $redux_demo['partner5-url'];
	$partner6URL = $redux_demo['partner6-url'];	
	$partner7URL = $redux_demo['partner7-url'];	
	$partner8URL = $redux_demo['partner8-url'];	
	$classiera_partners_title = $redux_demo['classiera_partners_title'];	
	$classiera_partners_desc = $redux_demo['classiera_partners_desc'];	
?>
<section class="partners-v3 section-gray-bg">	
	<div class="container" style="overflow: hidden;">
		<div class="row">	
			<div class="col-lg-12">
				<div class="owl-carousel partner-carousel-v3 partner-carousel-v4" data-car-length="6" data-items="6" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="2000" data-dots="true" data-auto-width="false" data-auto-height="true" data-right="<?php if(is_rtl()){echo "true";}else{ echo "false";}?>" data-responsive-small="2" data-autoplay-hover="true" data-responsive-medium="4" data-responsive-xlarge="6" data-margin="30">
					<?php if(!empty($partner1)){?>
						<div class="item partner-img match-height">
							<span class="helper"></span>
							<a href="<?php echo esc_url($partner1URL); ?>" target="_blank">
								<img src="<?php echo esc_url($partner1); ?>" alt="<?php esc_html_e('partner', 'classiera') ?>">
							</a>
						</div>
					<?php } ?>
					<?php if(!empty($partner2)){?>
						<div class="item partner-img match-height">
							<span class="helper"></span>
							<a href="<?php echo esc_url($partner2URL); ?>" target="_blank">
								<img src="<?php echo esc_url($partner2); ?>" alt="<?php esc_html_e('partner', 'classiera') ?>">
							</a>
						</div>
					<?php } ?>
					<?php if(!empty($partner3)){?>
						<div class="item partner-img match-height">
							<span class="helper"></span>
							<a href="<?php echo esc_url($partner3URL); ?>" target="_blank"><img src="<?php echo esc_url($partner3); ?>" alt="<?php esc_html_e('partner', 'classiera') ?>"></a>
						</div>
					<?php } ?>
					<?php if(!empty($partner4)){?>
						<div class="item partner-img match-height">
							<span class="helper"></span>
							<a href="<?php echo esc_url($partner4URL); ?>" target="_blank"><img src="<?php echo esc_url($partner4); ?>" alt="<?php esc_html_e('partner', 'classiera') ?>"></a>
						</div>
					<?php } ?>
					<?php if(!empty($partner5)){?>
						<div class="item partner-img match-height">
							<span class="helper"></span>
							<a href="<?php echo esc_url($partner5URL); ?>" target="_blank"><img src="<?php echo esc_url($partner5); ?>" alt="<?php esc_html_e('partner', 'classiera') ?>"></a>
						</div>
					<?php } ?>
					<?php if(!empty($partner6)){?>
						<div class="item partner-img match-height">
							<span class="helper"></span>
							<a href="<?php echo esc_url($partner6URL); ?>" target="_blank"><img src="<?php echo esc_url($partner6); ?>" alt="<?php esc_html_e('partner', 'classiera') ?>"></a>
						</div>
					<?php } ?>
					<?php if(!empty($partner7)){?>
						<div class="item partner-img match-height">
							<span class="helper"></span>
							<a href="<?php echo esc_url($partner7URL); ?>" target="_blank"><img src="<?php echo esc_url($partner7); ?>" alt="<?php esc_html_e('partner', 'classiera') ?>"></a>
						</div>
					<?php } ?>
					<?php if(!empty($partner8)){?>
						<div class="item partner-img match-height">
							<span class="helper"></span>
							<a href="<?php echo esc_url($partner8URL); ?>" target="_blank"><img src="<?php echo esc_url($partner8); ?>" alt="<?php esc_html_e('partner', 'classiera') ?>"></a>
						</div>
					<?php } ?>
				</div>
			</div><!--col-lg-12-->	
		</div><!--row-->
	</div><!--container-->
</section>
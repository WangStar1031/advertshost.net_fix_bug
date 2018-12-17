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
<section class="partners-v2 section-pad">
	<div class="section-heading-v1">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 center-block">
                    <h3 class="text-uppercase"><?php echo esc_html($classiera_partners_title); ?></h3>
                    <p><?php echo esc_html($classiera_partners_desc); ?></p>
                </div>
            </div>
        </div>
    </div>
	<div class="container">
		<div class="row">				
				<?php if(!empty($partner1)){?>
					<div class="col-sm-3 match-height col-lg-3 partners-v2-border border-bottom">
						<div class="partner-img">
							<span class="helper"></span>
							<a href="<?php echo esc_url($partner1URL); ?>" target="_blank">
								<img src="<?php echo esc_url($partner1); ?>" alt="<?php esc_html_e('partner', 'classiera') ?>">
							</a>
						</div>
                    </div>
				<?php } ?>
				<?php if(!empty($partner2)){?>
					<div class="col-sm-3 match-height col-lg-3 partners-v2-border border-bottom">
						<div class="partner-img">
							<span class="helper"></span>
							<a href="<?php echo esc_url($partner2URL); ?>" target="_blank">
								<img src="<?php echo esc_url($partner2); ?>" alt="<?php esc_html_e('partner', 'classiera') ?>">
							</a>
						</div>
                    </div>
				<?php } ?>
				<?php if(!empty($partner3)){?>
					<div class="col-sm-3 match-height col-lg-3 partners-v2-border border-bottom">
						<div class="partner-img">
							<span class="helper"></span>
							<a href="<?php echo esc_url($partner3URL); ?>" target="_blank">
								<img src="<?php echo esc_url($partner3); ?>" alt="<?php esc_html_e('partner', 'classiera') ?>">
							</a>
						</div>
                    </div>
				<?php } ?>
				<?php if(!empty($partner4)){?>
					<div class="col-sm-3 match-height col-lg-3 partners-v2-border border-bottom">
						<div class="partner-img">
							<span class="helper"></span>
							<a href="<?php echo esc_url($partner4URL); ?>" target="_blank">
								<img src="<?php echo esc_url($partner4); ?>" alt="<?php esc_html_e('partner', 'classiera') ?>">
							</a>
						</div>
                    </div>
				<?php } ?>
				<?php if(!empty($partner5)){?>
					<div class="col-sm-3 match-height col-lg-3 partners-v2-border border-bottom">
						<div class="partner-img">
							<span class="helper"></span>
							<a href="<?php echo esc_url($partner5URL); ?>" target="_blank">
								<img src="<?php echo esc_url($partner5); ?>" alt="<?php esc_html_e('partner', 'classiera') ?>">
							</a>
						</div>
                    </div>
				<?php } ?>
				<?php if(!empty($partner6)){?>
					<div class="col-sm-3 match-height col-lg-3 partners-v2-border border-bottom">
						<div class="partner-img">
							<span class="helper"></span>
							<a href="<?php echo esc_url($partner6URL); ?>" target="_blank">
								<img src="<?php echo esc_url($partner6); ?>" alt="<?php esc_html_e('partner', 'classiera') ?>">
							</a>
						</div>
                    </div>
				<?php } ?>
				<?php if(!empty($partner7)){?>
					<div class="col-sm-3 match-height col-lg-3 partners-v2-border border-bottom">
						<div class="partner-img">
							<span class="helper"></span>
							<a href="<?php echo esc_url($partner7URL); ?>" target="_blank">
								<img src="<?php echo esc_url($partner7); ?>" alt="<?php esc_html_e('partner', 'classiera') ?>">
							</a>
						</div>
                    </div>
				<?php } ?>
				<?php if(!empty($partner8)){?>
					<div class="col-sm-3 match-height col-lg-3 partners-v2-border border-bottom">
						<div class="partner-img">
							<span class="helper"></span>
							<a href="<?php echo esc_url($partner8URL); ?>" target="_blank">
								<img src="<?php echo esc_url($partner8); ?>" alt="<?php esc_html_e('partner', 'classiera') ?>">
							</a>
						</div>
                    </div>
				<?php } ?>
		</div><!--row-->
	</div><!--container-->
</section>
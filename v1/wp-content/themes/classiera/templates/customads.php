<section id="classieraDv">
	<div class="container">
		<div class="row">
		<?php 
			$homeAd1 = '';		
			global $redux_demo;
			global $allowed_html;
			$homeAdImg1 = $redux_demo['home_ad1']['url']; 
			$homeAdImglink1 = $redux_demo['home_ad1_url']; 
			$homeHTMLAds = $redux_demo['home_html_ad'];
			?>
			<div class="col-lg-12 col-md-12 col-sm-12 center-block text-center">
				<?php
				if(!empty($homeHTMLAds) || !empty($homeAdImg1)){
					if(!empty($homeHTMLAds)){
						echo classiera_display_html_ad_code($homeHTMLAds);
					}else{
						echo '<a href="'.$homeAdImglink1.'" target="_blank"><img class="img-responsive" alt="image" src="'.$homeAdImg1.'" /></a>';
					}
				}
				?>
			</div>
		</div>
	</div>	
</section>
<?php 
	global $redux_demo;
	$locationTitle = $redux_demo['locations-sec-title'];
	$locationDesc = $redux_demo['locations-desc'];
	$locShownBy = $redux_demo['location-shown-by'];
	$homeLocCounter = $redux_demo['home-location-counter'];
	$locationCounter = $redux_demo['classiera_loc_post_counter'];
	/*Get Locations Data Start */
	$locationTemplate = 'template-locations.php';
	$locationTemplatePermalink = classiera_get_template_url($locationTemplate);
	global $wp_rewrite;
	if ($wp_rewrite->permalink_structure == ''){
	//we are using ?page_id
		$locationURL = $locationTemplatePermalink."&location=";
	}else{
	//we are using permalinks
		$locationURL = $locationTemplatePermalink."?location=";
	}
	$classiera_ads_typeOn = $redux_demo['classiera_ads_type'];
	if($classiera_ads_typeOn == 1){
		$adstypeQuery = array(
			'key' => 'classiera_ads_type',
			'value' => 'sold',
			'compare' => '!='
		);
	}else{
		$adstypeQuery = null;
	}
?>
<section class="locations locations-v6 section-pad">
	<div class="section-heading-v6">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 center-block">
                    <h3 class="text-capitalize"><?php echo esc_html($locationTitle); ?></h3>
                    <p><?php echo esc_html($locationDesc); ?></p>
                </div>
            </div>
        </div>
    </div><!--section-heading-v6-->
	<div class="location-content-v6">
		<div class="container">
			<div class="row">
				<?php 
					$classieraClass = 'col-lg-6';
					$args = array(
						'posts_per_page'   => $homeLocCounter,
						'post_type'        => 'countries',
						'suppress_filters' => false,
						'post_status'      => 'publish',
					);
					$classieraAllCountries =  get_posts( $args );
					if(!empty($classieraAllCountries)){
						$current = 1;
						foreach ( $classieraAllCountries as $country ) : setup_postdata( $country );
							$countryName = $country->post_title;							
							if($current == 1 || $current == 2){
								$classieraClass = 'col-lg-6';
							}elseif($current == 3 || $current == 4 || $current == 5){
								$classieraClass = 'col-lg-4';
							}
							if($current == 5){
								$current = 0;
							}
							?>
							<div class="<?php echo esc_attr($classieraClass);?> col-sm-6">
								<figure class="location">
									<?php echo get_the_post_thumbnail($country->ID);?>
									<figcaption>
										<div class="location-caption">
											<span><i class="fas fa-map-marker-alt"></i></span>
										</div>
										<div class="location-caption">
											<h4><a href="#"><?php echo esc_attr($countryName); ?></a></h4>
											<p>
												<?php 
												$countargs = array(
													'posts_per_page'   => -1,
													'post_type'        => 'post',
													'post_status'      => 'publish',
													'suppress_filters' => true,
													'meta_query' => array(
														array(
															'key' => 'post_location',
															'value' => $countryName,
														),
														$adstypeQuery,
													)
												);												
												$classieraAllPCount =  get_posts($countargs);
												$totalPosts = count($classieraAllPCount);
												if($locationCounter == true){
												?>
												<?php echo esc_attr($totalPosts); ?>&nbsp;<?php esc_html_e( 'ads posted in this location', 'classiera' ); ?>
												<?php } ?>
											</p>
											<a href="<?php echo esc_attr($locationURL.$countryName);?>"><?php esc_html_e( 'View all ads', 'classiera' ); ?> <i class="fa fa-long-arrow-alt-<?php if(is_rtl()){echo "left";}else{echo "right";}?>"></i></a>
										</div>
									</figcaption>
								</figure>
							</div>
							<?php
							$current++;
						endforeach; 
						wp_reset_postdata();
					}
				?>
			</div>
		</div>
	</div>
</section>
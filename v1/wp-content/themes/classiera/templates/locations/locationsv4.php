<?php 
	global $redux_demo;	
	$locationTitle = $redux_demo['locations-sec-title'];
	$locationDesc = $redux_demo['locations-desc'];
	$locShownBy = $redux_demo['location-shown-by'];
	$locationCounter = $redux_demo['classiera_loc_post_counter'];
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
<section class="locations locations-v5 section-pad-80 border-bottom">
	<div class="section-heading-v5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 center-block">
                    <h3 class="text-capitalize"><?php echo esc_html($locationTitle); ?></h3>
                    <p><?php echo esc_html($locationDesc); ?></p>
                </div><!--col-lg-8 col-md-8 center-block-->
            </div><!--row-->
        </div><!--container-->
    </div><!--section-heading-v1-->
	<div class="location-content-v5">
		<div class="container">
			<ul class="list-inline list-unstyled">
				<?php 
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
				$args_location = array( 'posts_per_page' => -1 );
				$lastposts = get_posts( $args_location );
				$all_post_location = array();
				foreach( $lastposts as $post ) {
					$all_post_location[] = get_post_meta( $post->ID, $locShownBy, true );
				}
				//print_r($all_post_location);
				$directors = array_unique($all_post_location);
				$count = 1;
				foreach ($directors as $director) {				
					if(!empty($director) && $count < 7){
				/*Get Locations Data End */
			?>
				<li>			
					<div class="location-content match-height">						
						<i class="fas fa-map-marker-alt fa-4x"></i>
						<?php
						$args = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'meta_query' => array(								
								array(
									'key' => $locShownBy,
									'value' => $director,
									'type' => 'LIKE'
								),
								$adstypeQuery,
							),
						);
						$myQuery = new WP_Query($args);
						$countposts = $myQuery->found_posts;
						?>
						<h5>
							<a href="<?php echo esc_url($locationURL); ?><?php echo esc_attr($director); ?>">
							<?php echo esc_attr($director); ?>
							</a>
						</h5>
                    </div>
				</li>
			<?php 
				}
				$count++;
			}
			?>
			<?php wp_reset_query(); ?>
			</ul><!--container-->
		</div><!--container-->
	</div><!--location-content-->	
</section>
<?php 

	global $redux_demo;	

	$classieraAdsSecDesc = $redux_demo['ad-desc'];

	$ads_counter = $redux_demo['home-ads-counter'];

	$classieraCurrencyTag = $redux_demo['classierapostcurrency'];

	$classieraFeaturedAdsCounter = $redux_demo['classiera_featured_ads_count'];

	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];

	$classieraAdsView = $redux_demo['home-ads-view'];

	$classieraItemClass = "item-masonry";

	if($classieraAdsView == 'list'){

		$classieraItemClass = "item-list";

	}

	$category_icon_code = "";

	$category_icon_color = "";

	$catIcon = "";

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
	$bumpAds=array('relation' => 'OR',
		array(
			'kay'=>'bump_ads',
			'value'=>'1',
			'compare'=>'=',
		),
		array(
			'kay'=>'bump_ads',
			'compare'=>'NOT EXISTS',
		));
	$adsTypeMetaDouble= array('relation' => 'OR',
	    array(
	        'key'     => 'ads_type_selected',
	        'value'	=>'standard_top',
	        'compare' => '=',
	    	),
		array(
            'key'   => 'ads_type_selected',
            'value'=>'double_top',
            'compare' => '=',
        ),
        // array(
        //     'key'   => 'ads_type_selected',
        //     'compare' => 'NOT EXISTS',
        // ),

	);
	$adsTypeMetaSec=array('relation' => 'OR',
			array('relation' => 'AND',
				array(
					'key'=>'bump_ads',
					'value'=>'1',
					'compare'=>'=',
				),
				array('relation' => 'OR',
					array(
		            'key'   => 'ads_type_selected',
		            'value'=>'double_top',
		            'compare' => '=',
		        	),
		        	array(
		            'key'   => 'ads_type_selected',
		            'value'=>'standard_top',
		            'compare' => '=',
		       	 	),
				
				), 
			),
			array('relation' => 'AND',
				array(
					'key'=>'bump_ads',
					'compare'=>'NOT EXISTS',
				),
				array('relation' => 'OR',
					array(
			            'key'   => 'ads_type_selected',
			            'value'=>'standard_top',
			            'compare' => '=',
			        ),
			        array(
		            'key'   => 'ads_type_selected',
		            'value'=>'double_top',
		            'compare' => '=',
		        	),
				),
			),
		);


$adsTypeMetaFirst=array('relation' => 'OR',
			array('relation' => 'AND',
				array(
					'key'=>'bump_ads',
					'value'=>'1',
					'compare'=>'=',
				),
				array('relation' => 'OR',
		       	 	array(
		            'key'   => 'ads_type_selected',
		            'value'=>'standard',
		            'compare' => '=',
		        	),
		        	array(
		            'key'   => 'ads_type_selected',
		            'value'=>'double_sec',
		            'compare' => '=',
		        	),
				),
				
			), 
			array('relation' => 'AND',
				array(
					'key'=>'bump_ads',
					'compare'=>'NOT EXISTS',
				),
				array('relation' => 'OR',
		        	array(
		            'key'   => 'ads_type_selected',
		            'value'=>'double_sec',
		            'compare' => '=',
		        	),
		        	array(
		            'key'   => 'ads_type_selected',
		            'value'=>'standard',
		            'compare' => '=',
		        	),
				),
			),
		);

	$adsTypeMeta= array('relation' => 'OR',
	    array(
	        'key'     => 'ads_type_selected',
	        'value'	=>'standard',
	        'compare' => '=',
	    	),
		array(
            'key'   => 'ads_type_selected',
            'value'	=>'double_sec',
            'compare' => '=',
        ),
        array(
            'key'   => 'ads_type_selected',
            'compare' => 'NOT EXISTS',
        ),

	);

?>

<section class="classiera-advertisement advertisement-v4 section-pad-top-100">

	<div class="tab-divs">

		<div class="tab-content">

			<div role="tabpanel" class="tab-pane fade in active" id="all">

				<div class="container">
					<div class="row double_size">
						<div class="grid">
						
						<!--FeaturedAds-->

						<?php 

							global $paged, $wp_query, $wp;

							$args = wp_parse_args($wp->matched_query);

							if ( !empty ( $args['paged'] ) && 0 == $paged ){

								$wp_query->set('paged', $args['paged']);

								$paged = $args['paged'];

							}

							$featuredPosts = array();

							$arags = array(

								'post_type' => 'post',

								'posts_per_page' => $classieraFeaturedAdsCounter,

								'paged' => $paged,

								'meta_query' => array(
									$bumpAds,
									$adsTypeMetaDouble,
									// array(

									// 	'key' => 'featured_post',

									// 	'value' => '1',

									// 	'compare' => '=='

									// ),

									$adstypeQuery,
									

								),
								'meta_key' => 'bump_ads',
								'orderby' =>  array( 'meta_value' => 'DESC', 'date' => 'DESC' ),
								'order' => 'DESC',
							);

							$wsp_query = new WP_Query($arags);
							// echo '</pre>';
							// print_r($wsp_query);
							// echo '</pre>';
							while ($wsp_query->have_posts()) : $wsp_query->the_post();

								$featuredPosts[] = $post->ID;

								get_template_part( 'templates/classiera-loops/loop-canary');

							endwhile;

							wp_reset_postdata();

							wp_reset_query(); ?>

						<!--FeaturedAds-->

						<?php 

							global $paged, $wp_query, $wp;

							$args = wp_parse_args($wp->matched_query);

							if ( !empty ( $args['paged'] ) && 0 == $paged ){

								$wp_query->set('paged', $args['paged']);

								$paged = $args['paged'];

							}

							$arags = array(

								'post_type' => 'post',

								'posts_per_page' => $ads_counter,

								'paged' => $paged,

								'post__not_in' => $featuredPosts,

								'meta_query' => array(
									$bumpAds,
									$adstypeQuery,
									$adsTypeMetaDouble,

								),
								'orderby' => 'date',
							);

							$wsp_query = new WP_Query($arags);

							while ($wsp_query->have_posts()) : $wsp_query->the_post();

								get_template_part( 'templates/classiera-loops/loop-canary');

							endwhile;

							wp_reset_postdata(); ?>
						</div>
					</div>
						<div class="row standard_type_size">
							<div class="grid">
						<!--FeaturedAds-->

						<?php 

							global $paged, $wp_query, $wp;

							$args = wp_parse_args($wp->matched_query);

							if ( !empty ( $args['paged'] ) && 0 == $paged ){

								$wp_query->set('paged', $args['paged']);

								$paged = $args['paged'];

							}

							$featuredPosts = array();

							$arags = array(

								'post_type' => 'post',

								'posts_per_page' => $classieraFeaturedAdsCounter,

								'paged' => $paged,

								'meta_query' => array(
									$bumpAds,
									$adsTypeMeta,
									// array(

									// 	'key' => 'featured_post',

									// 	'value' => '1',

									// 	'compare' => '=='

									// ),

									$adstypeQuery,
									

								),
								'meta_key' => 'bump_ads',
								'orderby' =>  array( 'meta_value' => 'DESC', 'date' => 'DESC' ),
								'order' => 'DESC',
							);

							$wsp_query = new WP_Query($arags);
							// echo '</pre>';
							// print_r($wsp_query);
							// echo '</pre>';
							while ($wsp_query->have_posts()) : $wsp_query->the_post();

								$featuredPosts[] = $post->ID;

								get_template_part( 'templates/classiera-loops/loop-canary');

							endwhile;

							wp_reset_postdata();

							wp_reset_query(); ?>

						<!--FeaturedAds-->

						<?php 

							global $paged, $wp_query, $wp;

							$args = wp_parse_args($wp->matched_query);

							if ( !empty ( $args['paged'] ) && 0 == $paged ){

								$wp_query->set('paged', $args['paged']);

								$paged = $args['paged'];

							}

							$arags = array(

								'post_type' => 'post',

								'posts_per_page' => $ads_counter,

								'paged' => $paged,

								'post__not_in' => $featuredPosts,

								'meta_query' => array(
									$bumpAds,
									$adstypeQuery,
									$adsTypeMeta,

								),
								'orderby' => 'date',
							);

							$wsp_query = new WP_Query($arags);

							while ($wsp_query->have_posts()) : $wsp_query->the_post();

								get_template_part( 'templates/classiera-loops/loop-canary');

							endwhile;

							wp_reset_postdata(); ?>
						</div>
					</div><!--row-->

				</div><!--container-->

			</div><!--tabpanel-->

			<div role="tabpanel" class="tab-pane fade" id="random">

				<div class="container">

						<div class="double_size row">
							<div class="grid">
						<?php 

							global $paged, $wp_query, $wp;

							$args = wp_parse_args($wp->matched_query);

							if ( !empty ( $args['paged'] ) && 0 == $paged ) {

								$wp_query->set('paged', $args['paged']);

								$paged = $args['paged'];

							}

							$argas = array(

								'orderby' => 'title',

								'post_type' => 'post',

								'posts_per_page' => $ads_counter,

								'paged' => $paged,

								'meta_query' => array(
									$bumpAds,
									$adstypeQuery,
									$adsTypeMetaDouble,

								),
								'orderby' => array( 'meta_value_num' => 'ASC', 'date' => 'DESC' ),
							);

							$wdp_query = new WP_Query($argas);

						while ($wdp_query->have_posts()) : $wdp_query->the_post();	

							get_template_part( 'templates/classiera-loops/loop-canary');

						endwhile;

						wp_reset_postdata(); ?>
						</div>
					</div>
						<div class="standard_type_size row">
							<div class="grid">
							<?php 

							global $paged, $wp_query, $wp;

							$args = wp_parse_args($wp->matched_query);

							if ( !empty ( $args['paged'] ) && 0 == $paged ) {

								$wp_query->set('paged', $args['paged']);

								$paged = $args['paged'];

							}

							global $cat_id;

							$args = array(							

								'post_type' => 'post',

								'posts_per_page' => $ads_counter,

								'cat' => $cat_id,

								'paged' => $paged,

								'meta_key' => 'wpb_post_views_count',

								'orderby' => 'meta_value_num',

								'order' => 'DESC',

								'meta_query' => array(
									$bumpAds,
									$adstypeQuery,
									$adsTypeMeta,

									),
								'orderby' => array( 'meta_value_num' => 'ASC', 'title' => 'ASC' ),

							);

							$wp_query= null;

							$wp_query = new WP_Query( $args );
							while ( $wp_query->have_posts() ) : $wp_query->the_post();

								get_template_part( 'templates/classiera-loops/loop-canary');

							endwhile; 

							wp_reset_postdata(); ?>
						</div>
					</div><!--row-->

				</div><!--container-->

			</div><!--tabpanel Random-->

			<div role="tabpanel" class="tab-pane fade" id="popular">

				<div class="container">

				<!-- 	<div class="row masonry-content"> -->
						<div class="double_size row">
							<div class="grid">
						<?php 

						global $paged, $wp_query, $wp;

						$args = wp_parse_args($wp->matched_query);

						if ( !empty ( $args['paged'] ) && 0 == $paged ) {

							$wp_query->set('paged', $args['paged']);

							$paged = $args['paged'];

						}

						global $cat_id;

						$args = array(							

							'post_type' => 'post',

							'posts_per_page' => $ads_counter,

							'cat' => $cat_id,

							'paged' => $paged,

							'meta_key' => 'wpb_post_views_count',

							'orderby' => 'meta_value_num',

							'order' => 'DESC',

							'meta_query' => array(
								$bumpAds,
								$adstypeQuery,
								$adsTypeMetaDouble,

								),
								'orderby' => array( 'meta_value_num' => 'ASC', 'title' => 'ASC' ),

						);

						$wp_query= null;

						$wp_query = new WP_Query( $args );
						while ( $wp_query->have_posts() ) : $wp_query->the_post();

							get_template_part( 'templates/classiera-loops/loop-canary');

						endwhile; 

						wp_reset_postdata(); ?>
						</div></div>
						<div class="standard_type_size row">
							<div class="grid">
							<?php 

							global $paged, $wp_query, $wp;

							$args = wp_parse_args($wp->matched_query);

							if ( !empty ( $args['paged'] ) && 0 == $paged ) {

								$wp_query->set('paged', $args['paged']);

								$paged = $args['paged'];

							}

							global $cat_id;

							$args = array(							

								'post_type' => 'post',

								'posts_per_page' => $ads_counter,

								'cat' => $cat_id,

								'paged' => $paged,

								'meta_key' => 'wpb_post_views_count',

								'orderby' => 'meta_value_num',

								'order' => 'DESC',

								'meta_query' => array(
									$bumpAds,
									$adstypeQuery,
									$adsTypeMeta,

									),
									'orderby' => array( 'meta_value_num' => 'ASC', 'title' => 'ASC' ),

							);

							$wp_query= null;

							$wp_query = new WP_Query( $args );
							while ( $wp_query->have_posts() ) : $wp_query->the_post();

								get_template_part( 'templates/classiera-loops/loop-canary');

							endwhile; 

							wp_reset_postdata(); ?>
						</div>
					</div><!--row-->

				</div><!--container-->

			</div><!--tabpanel popular-->

			<?php $viewAllAds = $redux_demo['all-ads-page-link']; ?>

<!-- 			<div class="view-all text-center">               

				<a href="<?php echo esc_url($viewAllAds); ?>" class="btn btn-primary radius btn-md btn-style-four">

					<?php esc_html_e('View All Ads', 'classiera'); ?>

				</a>

            </div> -->

		</div><!--tab-content-->

	</div><!--tab-divs-->

</section>
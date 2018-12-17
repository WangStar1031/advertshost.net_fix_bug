<?php 
	global $redux_demo;	
	$classieraAdsSecDesc = $redux_demo['ad-desc'];
	$ads_counter = $redux_demo['home-ads-counter'];
	$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
	$classieraFeaturedAdsCounter = $redux_demo['classiera_featured_ads_count'];
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraAdsView = $redux_demo['home-ads-view'];
	$classieraItemClass = "item-grid";
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
?>
<section class="classiera-advertisement advertisement-v2 section-pad-top-100">
	<div class="section-heading-v1">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7 center-block">
                    <h3 class="text-uppercase"><?php esc_html_e( 'ADVERTISEMENTS', 'classiera' ); ?></h3>
                    <p><?php echo esc_html($classieraAdsSecDesc); ?></p>
                </div>
            </div>
        </div>
    </div>
	<div class="tab-divs">
		<div class="view-head">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-sm-8">
                        <div class="tab-button">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#all" class="btn btn-labeled btn-primary radius" aria-controls="all" role="tab" data-toggle="tab"><span class="btn-label"><i class="fa fa-bars"></i></span> <span class="btn-label-text"><?php esc_html_e( 'All Ads', 'classiera' ); ?></span></a>
                                </li>
                                <li role="presentation">
                                    <a href="#random" class="btn btn-labeled btn-primary radius" aria-controls="random" role="tab" data-toggle="tab"><span class="btn-label"><i class="fa fa-clock"></i></span><span class="btn-label-text"><?php esc_html_e( 'Random Ads', 'classiera' ); ?></span></a>
                                </li>
                                <li role="presentation">
                                    <a href="#popular" class="btn btn-labeled btn-primary radius" aria-controls="popular" role="tab" data-toggle="tab"><span class="btn-label"><i class="fa fa-star"></i></span><span class="btn-label-text"><?php esc_html_e( 'Popular Ads', 'classiera' ); ?></span></a>
                                </li>
                            </ul><!--nav nav-tabs-->
                        </div><!--tab-button-->
                    </div><!--col-lg-6 col-sm-8-->
					<div class="col-lg-6 col-sm-4">
						<div class="view-as text-right flip">
                            <span><?php esc_html_e( 'View as', 'classiera' ); ?>:</span>
                            <div class="btn-group">
                                <a id="grid" class="grid btn btn-primary radius btn-md <?php if($classieraAdsView == 'grid'){ echo "active"; }?>" href="#"><i class="fa fa-th"></i></a>
                                <a id="list" class="list btn btn-primary btn-md radius <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fa fa-th-list"></i></a>
                            </div>
                        </div>
					</div><!--col-lg-6 col-sm-4-->
				</div><!--row-->
			</div><!--container-->
		</div><!--view-head-->
		<div class="tab-content section-gray-bg">
			<div role="tabpanel" class="tab-pane fade in active" id="all">
				<div class="container">
					<div class="row">
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
							'posts_per_page' => $classieraFeaturedAdsCounter,
							'paged' => $paged,
							'meta_query' => array(
								array(
									'key' => 'featured_post',
									'value' => '1',
									'compare' => '=='
								),
								$adstypeQuery,
							),
						);
						$featuredPosts = array();
						$wsp_query = new WP_Query($arags);
						while ($wsp_query->have_posts()) : $wsp_query->the_post();
							$featuredPosts[] = $post->ID;
							get_template_part( 'templates/classiera-loops/loop-strobe');
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
								$adstypeQuery,
							),
						);
						$wsp_query = new WP_Query($arags);
						while ($wsp_query->have_posts()) : $wsp_query->the_post();
							get_template_part( 'templates/classiera-loops/loop-strobe');
						endwhile;
						wp_reset_postdata(); ?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel-->
			<div role="tabpanel" class="tab-pane fade" id="random">
				<div class="container">
					<div class="row">
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
									$adstypeQuery,
								),
							);
							$wdp_query = new WP_Query($argas);
						while ($wdp_query->have_posts()) : $wdp_query->the_post();
							get_template_part( 'templates/classiera-loops/loop-strobe');
						endwhile;
						wp_reset_postdata(); ?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel Random-->
			<div role="tabpanel" class="tab-pane fade" id="popular">
				<div class="container">
					<div class="row">
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
								$adstypeQuery,
							),
						);
						$wp_query= null;
						$wp_query = new WP_Query( $args );
						while ( $wp_query->have_posts() ) : $wp_query->the_post();
							get_template_part( 'templates/classiera-loops/loop-strobe');
						endwhile;
						wp_reset_postdata(); ?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel popular-->
			<?php $viewAllAds = $redux_demo['all-ads-page-link']; ?>
			<div class="view-all text-center">
                <a href="<?php echo esc_url($viewAllAds); ?>" class="btn btn-primary round btn-md btn-style-two"><span><i class="fa fa-refresh"></i></span><?php esc_html_e('View All Ads', 'classiera'); ?></a>
            </div>
		</div><!--tab-content-->
		
	</div><!--tab-divs-->
</section>
<?php 
	global $redux_demo;	
	$classieraAdsSecDesc = $redux_demo['ad-desc'];
	$ads_counter = $redux_demo['home-ads-counter'];
	$classieraFeaturedAdsCounter = $redux_demo['classiera_featured_ads_count'];	
	$classieraAdsView = $redux_demo['home-ads-view'];
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
<section class="classiera-advertisement advertisement-v1">
	<div class="section-heading-v1">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 center-block">
                    <h3 class="text-uppercase"><?php esc_html_e( 'ADVERTISEMENTS', 'classiera' ); ?></h3>
                    <p><?php echo esc_html($classieraAdsSecDesc); ?></p>
                </div><!--col-lg-8-->
            </div><!--row-->
        </div><!--container-->
    </div><!--section-heading-v1-->
	<div class="tab-button">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#all" aria-controls="all" role="tab" data-toggle="tab"><?php esc_html_e( 'All Ads', 'classiera' ); ?></a>
                        </li>
                        <li role="presentation">
                            <a href="#random" aria-controls="random" role="tab" data-toggle="tab"><?php esc_html_e( 'Random Ads', 'classiera' ); ?></a>
                        </li>
                        <li role="presentation">
                            <a href="#popular" aria-controls="popular" role="tab" data-toggle="tab"><?php esc_html_e( 'Popular Ads', 'classiera' ); ?></a>
                        </li>
                    </ul><!--nav nav-tabs-->
                </div><!--col-md-12-->
            </div><!--row-->
        </div><!--container-->
    </div><!--tab-button-->
	<div class="tab-divs section-light-bg">
		<div class="view-head">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-xs-6">
                        <div class="total-post">
							<?php 
								$classieraPostCount = wp_count_posts();
								$classieraPublishPCount = $classieraPostCount->publish;
							?>
                            <p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
								<span>
								<?php echo esc_attr($classieraPublishPCount); ?> 
								<?php esc_html_e( 'ads posted', 'classiera' ); ?>
								</span>
							</p>
                        </div>
                    </div><!--col-lg-6-->
                    <div class="col-lg-6 col-sm-6 col-xs-6">
                        <div class="view-as text-right flip">
                            <span><?php esc_html_e( 'View as', 'classiera' ); ?>:</span>
                            <a id="grid" class="grid btn btn-sm sharp outline <?php if($classieraAdsView == 'grid'){ echo "active"; }?>" href="#"><i class="fa fa-th"></i></a>
                            <a id="list" class="list btn btn-sm sharp <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fa fa-bars"></i></a>

                        </div><!--view-as-->
                    </div><!--col-lg-6-->
                </div><!--row-->
            </div><!--container-->
        </div><!--view-head-->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="all">
				<div class="container">
					<div class="row">
						<!--Featured Ads-->
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
						$wsp_query = new WP_Query($arags);
						$featuredPosts = array();
						while ($wsp_query->have_posts()) : $wsp_query->the_post();
							$featuredPosts[] = $post->ID;
							get_template_part( 'templates/classiera-loops/loop-lime');
						endwhile; 
						wp_reset_postdata();
						wp_reset_query();
						?>
						<!--Featured Ads-->
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
							get_template_part( 'templates/classiera-loops/loop-lime');
						endwhile;
						wp_reset_postdata();
						wp_reset_query();
						?>
					</div><!--container-->
				</div><!--container-->
			</div><!--tabpanel-->
			<!--LatestAdsSection-->
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
							get_template_part( 'templates/classiera-loops/loop-lime');
						endwhile;
						wp_reset_postdata(); 
						wp_reset_query();
						?>
					</div><!--row-->
				</div><!--container-->
			</div>
			<!--LatestAdsSection-->
			<!--popularAdsSection-->
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
						get_template_part( 'templates/classiera-loops/loop-lime');
					endwhile;
					wp_reset_postdata(); 
					wp_reset_query();
					?>
					</div><!--row-->
				</div><!--container-->
			</div>
			<!--popularAdsSection-->
		</div><!--tab-content-->
		<!--ViewAllButton-->
		<?php $viewAllAds = $redux_demo['all-ads-page-link']; ?>
		<div class="view-all text-center">
            <a href="<?php echo esc_url($viewAllAds); ?>" class="btn btn-primary sharp btn-sm btn-style-one">
				<?php if(is_rtl()){?>
					<?php esc_html_e('View All Ads', 'classiera'); ?>
					<i class="icon-left fa fa-refresh"></i>
				<?php }else{ ?>
					<i class="icon-left fa fa-refresh"></i>
					<?php esc_html_e('View All Ads', 'classiera'); ?>
				<?php } ?>
			</a>
        </div>
		<!--ViewAllButton-->
	</div><!--tab-divs-->
</section>
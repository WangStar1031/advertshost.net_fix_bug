<?php
global $redux_demo;
$classieraFeaturedAdsCounter = $redux_demo['classiera_featured_ads_count'];
$classiera_pagination = $redux_demo['classiera_pagination'];
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
							<p><?php esc_html_e( 'Total Ads', 'classiera' ); ?>: <span><?php echo classiera_Cat_Ads_Count(); ?>&nbsp;<?php esc_html_e( 'ads found', 'classiera' ); ?></span></p>
						</div><!--total-post-->
					</div><!--col-lg-6-->
					<div class="col-lg-6 col-sm-6 col-xs-6">
						<div class="view-as text-right flip">
							<span><?php esc_html_e( 'View As', 'classiera' ); ?>:</span>
							<a id="grid" class="grid btn btn-sm sharp outline <?php if($classieraAdsView == 'grid'){ echo "active"; }?>" href="#">
								<i class="fa fa-th"></i>
							</a>
							<a id="list" class="list btn btn-sm sharp outline <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#">
								<i class="fa fa-bars"></i>
							</a>
						</div><!--view-as-->
					</div><!--col-lg-6-->
				</div><!--row-->
			</div><!--container-->
		</div><!--view-head-->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="all">
				<div class="container">
					<div class="row">
						<!--FeaturedPosts-->
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}							
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$featuredPosts = array();
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => $classieraFeaturedAdsCounter,
								'paged' => $paged,								
								'cat' => $cat_id,
								'meta_query' => array(
									array(
										'key' => 'featured_post',
										'value' => '1',
										'compare' => '=='
									),
									$adstypeQuery,
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								$featuredPosts[] = $post->ID;
								get_template_part( 'templates/classiera-loops/loop-lime');
							endwhile;
							wp_reset_postdata();
							wp_reset_query();
						?>
						<!--FeaturedPosts-->
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}							
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => 10,
								'paged' => $paged,
								'post__not_in' => $featuredPosts,
								'cat' => $cat_id,
								'meta_query' => array(
									$adstypeQuery,
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								get_template_part( 'templates/classiera-loops/loop-lime');
							endwhile; 
							wp_reset_postdata();
							wp_reset_query();
						?>
					</div><!--row-->
						<?php
							if($classiera_pagination == 'pagination'){
								classiera_pagination();
							}
						?>
				</div><!--container-->
				<?php
					if($classiera_pagination == 'infinite'){
						echo infinite($wp_query);
					}
				?>
				<?php wp_reset_query(); ?>
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
						$cat_id = get_queried_object_id();
						$args = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							'posts_per_page' => 12,
							'paged' => $paged,							
							'cat' => $cat_id,
							'meta_key' => 'wpb_post_views_count',
							'orderby' => 'meta_value_num',
							'order' => 'DESC',
							'meta_query' => array(
								$adstypeQuery,
							),
						);
						$wp_query= null;
						$wp_query = new WP_Query($args);
						while ( $wp_query->have_posts() ) : $wp_query->the_post();
							get_template_part( 'templates/classiera-loops/loop-lime');
						endwhile;
						wp_reset_postdata();
						wp_reset_query(); 
					?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel random-->
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
						$cat_id = get_queried_object_id();
						$temp = $wp_query;
						$args = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							'posts_per_page' => 12,
							'paged' => $paged,
							'cat' => $cat_id,							
							'orderby' => 'title',
							'meta_query' => array(
								$adstypeQuery,
							),
						);
						$wp_query= null;
						$wp_query = new WP_Query($args);
						while ($wp_query->have_posts()) : $wp_query->the_post();
							get_template_part( 'templates/classiera-loops/loop-lime');
						endwhile;
						wp_reset_query();
						wp_reset_postdata();
						?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel popular-->
		</div><!--tab-content-->
	</div><!--tab-divs-->
</section>
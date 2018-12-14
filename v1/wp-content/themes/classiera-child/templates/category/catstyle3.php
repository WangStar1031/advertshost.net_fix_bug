<?php 
	global $redux_demo;
	$category_icon_code = "";
	$category_icon_color = "";
	$catIcon = "";	
	$classieraCatSECTitle = $redux_demo['cat-sec-title'];
	$classieraCatSECDESC = $redux_demo['cat-sec-desc'];
	$allCatURL = $redux_demo['all-cat-page-link'];	
	$cat_counter = $redux_demo['home-cat-counter'];
	$primaryColor = $redux_demo['color-primary'];
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraPostCount = $redux_demo['classiera_cat_post_counter'];
?>
<section class="section-pad category-v3 border-bottom">
	<!-- <div class="section-heading-v1">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7 center-block">
                    <h3 class="text-uppercase"><?php echo esc_html($classieraCatSECTitle); ?></h3>
                    <p><?php echo esc_html($classieraCatSECDESC); ?></p>
                </div>
            </div>
        </div>
    </div> -->
	<div class="container">
		<div class="row">
			<?php 
			$categories = get_terms('category', array(
					'hide_empty' => 0,
					'parent' => 0,
					'number' => $cat_counter,
					'order'=> 'ASC'
				)	
			);

			$current = -1;
			foreach ($categories as $category) {
				$tag = $category->term_id;
				$classieraCatFields = get_option(MY_CATEGORY_FIELDS);
				//print_r($classieraCatFields);
				if (isset($classieraCatFields[$tag])){
					$classieraCatIconCode = $classieraCatFields[$tag]['category_icon_code'];
					$classieraCatIcoIMG = $classieraCatFields[$tag]['your_image_url'];
					$classieraCatIconClr = $classieraCatFields[$tag]['category_icon_color'];						
				}
				$cat = $category->count;
				$catName = $category->term_id;
				$mainID = $catName;
				if(empty($classieraCatIconClr)){
					$iconColor = $primaryColor;
				}else{
					$iconColor = $classieraCatIconClr;
				}
				$current++;
				$allPosts = 0;
				$categoryLink = get_category_link( $category->term_id );
				$categories = get_categories('child_of='.$catName);
				foreach ($categories as $category) {
					$allPosts += $category->category_count;
				}
				$classieraTotalPosts = $allPosts + $cat;
				$category_icon = stripslashes($classieraCatIconCode);
				?>
			<div class="col-lg-2 col-sm-6">
				<div class="category-box border-bottom match-height">
					<div class="category-content">
						<!-- <span class="category-icon" style="border: 1px solid <?php echo esc_html($iconColor); ?>">
                            <?php 
							if($classieraIconsStyle == 'icon'){
								?>
								<i style="background:<?php echo esc_html($iconColor); ?>" class="<?php echo esc_html($category_icon); ?>"></i>
								<?php
							}elseif($classieraIconsStyle == 'img'){
								?>
								<img src="<?php echo esc_url($classieraCatIcoIMG); ?>" alt="<?php echo esc_html(get_cat_name( $catName )); ?>">
								<?php
							}
							?>
                        </span> -->
					</div><!--category-content-->
					<div class="category-content">
						<h4>
						<a href="<?php echo esc_url($categoryLink); ?>">
							<?php echo esc_html(get_cat_name( $catName )); ?>
						</a>
						</h4>
						<?php if($classieraPostCount == 1){?>
							<p><?php echo esc_attr($classieraTotalPosts); ?>&nbsp;
							<?php esc_html_e( 'items posted', 'classiera' ); ?></p>
						<?php }?>
						<!-- <p class="category-description">
						<?php $desc = category_description( $catName ); ?>
						<?php echo wp_trim_words( $desc, 10, '...' );?>
						</p> -->
						<!-- <a class="view-all" href="<?php echo esc_url(get_category_link( $mainID )); ?>">
							<?php esc_html_e( 'VIEW ALL', 'classiera' ); ?>&nbsp;
							<i class="fa fa-long-arrow-alt-<?php if(is_rtl()){echo "left";}else{echo "right";}?>"></i>
						</a> -->
					</div><!--category-content-->					
				</div><!--category-box-->
			</div><!--col-lg-4-->
			<?php } ?>
			<!-- <div class="col-lg-12 col-md-12 col-sm-12">
				<div class="view-all text-center">
					<a href="<?php echo esc_url($allCatURL); ?>" class="btn btn-primary btn-style-three btn-md"><?php esc_html_e( 'View All Categories', 'classiera' ); ?></a>
				</div>
			</div> -->
		</div>
	</div>
</section>
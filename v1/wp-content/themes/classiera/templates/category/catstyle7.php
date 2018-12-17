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
<section class="section-pad category-v7 border-bottom">
	<div class="section-heading-v6">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 center-block">
                    <h3 class="text-capitalize"><?php echo esc_html($classieraCatSECTitle); ?></h3>
                    <p><?php echo esc_html($classieraCatSECDESC); ?></p>
                </div><!--col-lg-7-->
            </div><!--row-->
        </div><!--container-->
    </div><!--section-heading-v1-->
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
					$categoryIMG = $classieraCatFields[$tag]['category_image'];
				}
				$cat = $category->count;
				$catName = $category->term_id;
				$mainID = $catName;
				if(empty($classieraCatIconClr)){
					$iconColor = $primaryColor;
				}else{
					$iconColor = $classieraCatIconClr;
				}
				if(empty($categoryIMG)){
					$classieracatIMG = get_template_directory_uri().'/images/category.png';
				}else{
					$classieracatIMG = $categoryIMG;
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
			<div class="col-lg-4 col-sm-6 col-md-4 match-height">
				<div class="category-box">
					<figure>
						<div class="cat-img">
							<img src="<?php echo esc_url($classieracatIMG); ?>" alt="<?php echo esc_html(get_cat_name( $catName )); ?>">
							<span class="cat-icon" style="background: <?php echo esc_html($iconColor); ?>;">
								<?php 
								if($classieraIconsStyle == 'icon'){
									?>
									<i class="<?php echo esc_html($category_icon); ?>"></i>
									<?php
								}elseif($classieraIconsStyle == 'img'){
									?>
									<img src="<?php echo esc_url($classieraCatIcoIMG); ?>" alt="<?php echo esc_html(get_cat_name( $catName )); ?>">
									<?php
								}
								?>
							</span>
						</div>
						<figcaption>
							<h4>
							<a href="<?php echo esc_url($categoryLink); ?>">
								<?php echo esc_html(get_cat_name( $catName )); ?>
							</a>
							</h4>
							<p>
							<?php if($classieraPostCount == 1){?>
								<?php echo esc_attr($classieraTotalPosts);?>&nbsp;
								<?php esc_html_e( 'Ads posted', 'classiera' ); ?>
							<?php }?>
							</p>
							<ul class="list-unstyled fa-ul">
								<?php 
							$args = array(
								'type' => 'post',
								'child_of' => $catName,
								'parent' => get_query_var(''),
								'orderby' => 'name',
								'order' => 'ASC',
								'hide_empty' => 0,
								'hierarchical' => 1,
								'exclude' => '',
								'include' => '',
								'number' => '5',
								'taxonomy' => 'category',
								'pad_counts' => true 
							);
							$subcategories = get_categories($args);
							foreach($subcategories as $subcat) {
								$categoryTitle = $subcat->name;
								$categoryLinkChild = get_category_link( $subcat->term_id );
								?>
								<li>
									<a href="<?php echo esc_url($categoryLinkChild); ?>">
										<i class="fa-li fa fa-angle-<?php if(is_rtl()){echo "left";}else{echo "right";}?>"></i>
										<?php echo esc_html($categoryTitle); ?>
									</a>
								</li>
								<?php
							}
							?>
							</ul>
							<a href="<?php echo esc_url($categoryLink); ?>"><?php esc_html_e( 'View All Ads', 'classiera' ); ?> <i class="fa fa-long-arrow-alt-<?php if(is_rtl()){echo "left";}else{echo "right";}?>"></i></a>
						</figcaption>
					</figure>
				</div>
			</div>			
			<?php } ?>
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="view-all text-center">
					<a href="<?php echo esc_url($allCatURL); ?>" class="btn btn-primary radius outline btn-style-six"><?php esc_html_e( 'View All Categories', 'classiera' ); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
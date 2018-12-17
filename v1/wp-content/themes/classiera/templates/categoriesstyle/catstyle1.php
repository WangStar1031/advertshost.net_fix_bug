<?php 
	global $redux_demo;
	$category_icon_code = "";
	$category_icon_color = "";
	$catIcon = "";	
	$classieraCatSECTitle = $redux_demo['cat-sec-title'];
	$classieraCatSECDESC = $redux_demo['cat-sec-desc'];
	$allCatURL = $redux_demo['all-cat-page-link'];	
	$cat_counter = $redux_demo['classiera_no_of_cats_all_page'];
	$primaryColor = $redux_demo['color-primary'];
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraPostCount = $redux_demo['classiera_cat_post_counter'];
?>
<section class="section-pad category-v1 border-bottom">
	<div class="section-heading-v1">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 center-block">
                    <h3 class="text-uppercase"><?php echo esc_html($classieraCatSECTitle); ?></h3>
                    <p><?php echo esc_html($classieraCatSECDESC); ?></p>
                </div>
            </div>
        </div>
    </div>
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
				foreach ($categories as $category){
					$tag = $category->term_id;
					$classieraCatFields = get_option(MY_CATEGORY_FIELDS);					
					if (isset($classieraCatFields[$tag])){
						$classieraCatIconCode = $classieraCatFields[$tag]['category_icon_code'];
						$classieraCatIcoIMG = $classieraCatFields[$tag]['your_image_url'];
						$classieraCatIconClr = $classieraCatFields[$tag]['category_icon_color'];						
					}
					$catCount = $category->count;
					$catName = $category->term_id;
					$mainID = $catName;
					if(empty($classieraCatIconClr)){
						$iconColor = $primaryColor;
					}else{
						$iconColor = $classieraCatIconClr;
					}
					$current++;
					$allPosts = 0;
					$categories = get_categories('child_of='.$catName);
					foreach ($categories as $category) {
						$allPosts += $category->category_count;
					}
					$classieraTotalPosts = $allPosts + $catCount;
					$category_icon = stripslashes($classieraCatIconCode);
					?>
					<!--Categorybox-->
					<div class="col-lg-4 col-md-4 col-sm-6 match-height">
						<div class="category-box border">
							<div class="category-heading border-bottom">
								<h4><?php echo esc_html(get_cat_name( $catName )); ?></h4>
								<p>
								<?php if($classieraPostCount == 1){?>
								<?php echo esc_attr($catCount); ?> <?php esc_html_e( 'ads posted', 'classiera' ); ?>
								<?php }else{?>
									&nbsp;
								<?php } ?>
								</p>
								<span class="category-icon-box" style="background-color:<?php echo esc_html($iconColor); ?>; color: <?php echo esc_html($iconColor); ?>;">
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
									<span class="category-icon-box-border" style="background-color:<?php echo esc_html($iconColor); ?>;"></span>
								</span>
							</div>
							<div class="category-content">
								<ul>
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
									foreach($subcategories as $category) {
										$categoryTitle = $category->name;
										$categoryLink = get_category_link( $category->term_id );
										?>
										<li>
											<a href="<?php echo esc_url($categoryLink); ?>" title="<?php echo esc_html($categoryTitle); ?>">
												<?php echo esc_html($categoryTitle); ?>
												<?php if($classieraPostCount == 1){?>
												<span>(<?php echo esc_attr($category->count) ?>)</span>
												<?php } ?>
											</a>
										</li>
										<?php
									}
								?>
								</ul>
								<div class="view-button">
									<a href="<?php echo esc_url(get_category_link( $mainID )) ?>" class="btn btn-primary sharp btn-style-one btn-sm"><?php esc_html_e( 'VIEW ALL', 'classiera' ); ?><i class="fa fa-chevron-right icon-right"></i></a>
								</div>
							</div>
						</div>
					</div>
					<!--Categorybox-->
			<?php } ?>	
		</div><!--row-->
	</div><!--container-->
</section>
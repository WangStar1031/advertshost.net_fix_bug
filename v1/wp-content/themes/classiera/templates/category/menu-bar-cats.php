<?php 
	global $redux_demo;
	$category_icon_code = "";
	$category_icon_color = "";
	$catIcon = "";
	$classieraCatSECTitle = $redux_demo['cat-sec-title'];
	$classieraCatSECDESC = $redux_demo['cat-sec-desc'];
	$allCatURL = $redux_demo['all-cat-page-link'];
	$classieraCatMenuCount = $redux_demo['classiera_cat_menu_count'];
	$cat_counter = $redux_demo['home-cat-counter'];
	$primaryColor = $redux_demo['color-primary'];
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
?>
<section class="menu-category">
	<nav>
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#categories-navbar" aria-expanded="false">
                    <span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'classiera' ); ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button><!--button-->
				<span class="navbar-brand"><?php esc_html_e( 'Browse Category', 'classiera' ); ?></span>
			</div><!--navbar-header-->
			<div class="collapse navbar-collapse" id="categories-navbar">
				<ul class="nav navbar-nav">
					<?php 
					$categories = get_terms('category', array(
							'hide_empty' => 0,
							'parent' => 0,
							'number' => $classieraCatMenuCount,
							'order'=> 'ASC'
						)	
					);
					$current = 1;
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
						$allPosts = 0;
						$categoryLink = get_category_link( $category->term_id );
						$categories = get_categories('child_of='.$catName);
						foreach ($categories as $category) {
							$allPosts += $category->category_count;
						}
						$classieraTotalPosts = $allPosts + $cat;
						$category_icon = stripslashes($classieraCatIconCode);				
						if($current <= $classieraCatMenuCount){
						?>
							<li class="dropdown">
								<a href="<?php echo esc_url($categoryLink); ?>" class="dropdown-toggle disabled" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
									<?php 
									if($classieraIconsStyle == 'icon'){
										?>
										<i class="<?php echo esc_html($category_icon); ?>" style="color:<?php echo esc_html($iconColor); ?>;"></i>
										<?php
									}elseif($classieraIconsStyle == 'img'){
										?>
										<img src="<?php echo esc_url($classieraCatIcoIMG); ?>" alt="<?php echo esc_html(get_cat_name( $catName )); ?>">
										<?php
									}
									?>
									<?php echo esc_html(get_cat_name( $catName )); ?>
								</a>
								<?php 
								$classieraHasChild = classiera_cat_has_child($mainID);
								if($classieraHasChild == true){
								?>
								<ul class="dropdown-menu" style="border-top:2px solid <?php echo esc_html($iconColor); ?>;">
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
										$childcategoryLink = get_category_link( $category->term_id );
										?>
										<li>
											<a href="<?php echo esc_url($childcategoryLink); ?>">
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
												<?php echo esc_html($categoryTitle); ?> <span>(<?php echo esc_attr($category->count); ?>)</span>
											</a>
										</li>
									<?php } ?>
									<li class="text-center btn btn-default btn-xs btn-block"><a href="<?php echo esc_url($categoryLink); ?>"><?php esc_html_e( 'View all subcategories', 'classiera' ); ?></a></li>
								</ul>
								<?php } ?>
							</li>
						<?php } ?>
							<?php $current++; ?>
						<?php } ?>
						<li>
							<a href="<?php echo esc_url($allCatURL); ?>">
								<?php esc_html_e( 'View All Categories', 'classiera' ); ?>
							</a>
						</li>
				</ul>
			</div><!--collapse navbar-collapse-->
		</div><!--container-->
	</nav><!--nav-->
</section><!--menu-category-->
<?php 
	global $redux_demo;
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$page_slider = get_post_meta($current_page_id, 'page_slider', true);
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
	$classieraIMGheaderTitle = $redux_demo['homepage-v2-title'];
	$classieraIMGheaderDesc = $redux_demo['homepage-v2-desc'];
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraLocationSearch = $redux_demo['classiera_search_location_on_off'];
?>
<section class="classiera-simple-bg-slider">
	<div class="classiera-simple-bg-slider-content text-center">
		<h1><?php echo wp_kses_post($classieraIMGheaderTitle); ?></h1>
		<h4><?php echo wp_kses_post($classieraIMGheaderDesc); ?></h4>
		<div class="category-slider-small-box  text-center">
			<ul class="list-inline list-unstyled">
			<?php 
			$categories = get_terms('category', array(
					'hide_empty' => 0,
					'parent' => 0,
					'number' => $cat_counter,
					'order'=> 'ASC'
				)	
			);
			$current = 1;
			foreach ($categories as $category) {
				$tag = $category->term_id;
				$classieraCatFields = get_option(MY_CATEGORY_FIELDS);
				if(isset($classieraCatFields[$tag])){
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
				foreach($categories as $category){
					$allPosts += $category->category_count;
				}
				$classieraTotalPosts = $allPosts + $cat;
				$category_icon = stripslashes($classieraCatIconCode);
				if($current <= $classieraCatMenuCount){
					?>
					<li>
						<a class="match-height" href="<?php echo esc_url($categoryLink); ?>">
							<?php 
							if($classieraIconsStyle == 'icon'){
								?>
								<i class="<?php echo esc_html($category_icon); ?>"></i>
								<?php
							}elseif($classieraIconsStyle == 'img'){
								?>
								<img src="<?php echo esc_url($classieraCatIcoIMG); ?>" alt="<?php echo get_cat_name( $catName ); ?>">
								<?php
							}
							?>
							<p><?php echo get_cat_name( $catName ); ?></p>
						</a>
					</li>
					<?php
				}
				$current++;
			}
			?>
			</ul><!--list-inline list-unstyled-->
		</div><!--category-slider-small-box-->
	</div><!--classiera-simple-bg-slider-content-->
</section><!--classiera-simple-bg-slider-->
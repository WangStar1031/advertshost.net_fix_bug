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
	$classieraLocationType = $redux_demo['classiera_search_location_type'];
	$locShownBy = $redux_demo['location-shown-by'];
	$classieraLocationName = 'post_location';
	if($locShownBy == 'post_location'){
		$classieraLocationName = 'post_location';
	}elseif($locShownBy == 'post_state'){
		$classieraLocationName = 'post_state';
	}elseif($locShownBy == 'post_city'){
		$classieraLocationName = 'post_city';
	}
?>
<section class="classiera-static-slider">
	<div class="container">
		<div class="row">
			<div class="classiera-static-slider-content text-center">
				<h1><?php echo wp_kses_post($classieraIMGheaderTitle); ?></h1>
				<h2><?php echo wp_kses_post($classieraIMGheaderDesc); ?></h2>
			</div>
		</div>
	</div><!--container-->
	<section class="search-section search-section-v6">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<form data-toggle="validator" role="form" class="search-form search-form-v2 form-inline" action="<?php echo home_url(); ?>" method="get">
						<div class="form-v6-bg">
							<div class="form-group clearfix">
								<div class="inner-addon left-addon right-addon">
									<i class="form-icon form-icon-size-small left-form-icon zmdi zmdi-sort-amount-desc"></i>
									<i class="form-icon form-icon-size-small fa fa-sort"></i>
									<select class="form-control form-control-lg" data-placeholder="<?php esc_html_e('Select Category..', 'classiera'); ?>" name="category_name" id="ajaxSelectCat">
										<option value="-1" selected disabled="disabled"><?php esc_html_e('All Categories', 'classiera'); ?></option>
										<?php 
										$args = array(
											'hierarchical' => '0',
											'hide_empty' => '0'
										);
										$categories = get_categories($args);
										foreach ($categories as $cat) {
											if($cat->category_parent == 0){
												$catID = $cat->cat_ID;
												?>
											<option value="<?php echo esc_attr($cat->slug); ?>">
												<?php echo esc_html($cat->cat_name); ?>
											</option>	
												<?php
												$args2 = array(
													'hide_empty' => '0',
													'parent' => $catID
												);
												$categories = get_categories($args2);
												foreach($categories as $cat){
													?>
												<option value="<?php echo esc_attr($cat->slug); ?>">- 
													<?php echo esc_html($cat->cat_name); ?>
												</option>	
													<?php
												}
											}
										}
										?>
									</select>
								</div>
							</div><!--form-group-->
							<div class="form-group classieraAjaxInput">
								<div class="input-group inner-addon left-addon">
									<i class="form-icon form-icon-size-small left-form-icon zmdi zmdi-border-color"></i>
									<input type="text" id="classieraSearchAJax" name="s" class="form-control form-control-lg" placeholder="<?php esc_html_e( 'Enter keyword...', 'classiera' ); ?>" data-error="<?php esc_html_e( 'Please Type some words..!', 'classiera' ); ?>">
									<div class="help-block with-errors"></div>
									<span class="classieraSearchLoader"><img src="<?php echo get_template_directory_uri().'/images/loader.gif' ?>" alt="classiera loader"></span>
									<div class="classieraAjaxResult"></div>
								</div>
							</div><!--form-group-->
							<!--Searchlocation-->
							<?php if($classieraLocationSearch == 1){?>
							<div class="form-group">
								<div class="input-group inner-addon left-addon">
									<i class="form-icon form-icon-size-small left-form-icon zmdi zmdi-pin-drop"></i>
									<?php if($classieraLocationType == 'input'):?>
										<input type="text" id="getCity" name="<?php echo esc_attr($classieraLocationName); ?>" class="form-control form-control-lg" placeholder="<?php esc_html_e('Please type your location', 'classiera'); ?>">
										<a id="getLocation" href="#" class="form-icon form-icon-size-small" title="<?php esc_html_e('Click here to get your own location', 'classiera'); ?>">
											<i class="fa fa-crosshairs"></i>
										</a>
									<?php elseif($classieraLocationType == 'dropdown'):?>
									<!--Locations dropdown-->	
										<?php get_template_part( 'templates/classiera-locations-dropdown' );?>
										<!--Locations dropdown-->
									<?php endif; ?>
								</div>
							</div><!--form-group-->
							<?php } ?>
							<!--Searchlocation-->
							<div class="form-group">
								<button type="submit" name="search" value="<?php esc_html_e( 'Search', 'classiera' ); ?>"><?php esc_html_e( 'Search', 'classiera' ); ?></button>
							</div><!--form-group-->
						</div><!--form-v6-bg-->
					</form>
				</div><!--col-md-12-->
			</div><!--row-->
		</div><!--container-->
	</section><!--search-section-->
</section><!--classiera-simple-bg-slider-->
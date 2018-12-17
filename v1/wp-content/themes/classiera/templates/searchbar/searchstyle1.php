<?php 
	global $redux_demo;
	$classieraLocationName = 'post_location';
	$classieraLocationSearch = $redux_demo['classiera_search_location_on_off'];
	$classieraLocationType = $redux_demo['classiera_search_location_type'];
	$locShownBy = $redux_demo['location-shown-by'];
	if($locShownBy == 'post_location'){
		$classieraLocationName = 'post_location';
	}elseif($locShownBy == 'post_state'){
		$classieraLocationName = 'post_state';
	}elseif($locShownBy == 'post_city'){
		$classieraLocationName = 'post_city';
	}
?>
<section class="search-section" style="background: #f0f0f0;">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<form data-toggle="validator" role="form" class="search-form search-form-v1 form-inline" action="<?php echo home_url(); ?>" method="get">
					<div class="form-group classieraAjaxInput">
                        <input type="text" name="s" id="classieraSearchAJax" class="form-control form-control-sm sharp-edge " placeholder="<?php esc_html_e( 'Enter keyword...', 'classiera' ); ?>" data-error="<?php esc_html_e( 'Please Type some words..!', 'classiera' ); ?>">
                        <div class="help-block with-errors"></div>
						<span class="classieraSearchLoader"><img src="<?php echo get_template_directory_uri().'/images/loader.gif' ?>" alt="classiera loader"></span>
						<div class="classieraAjaxResult"></div>
                    </div>
					<!--Select Category-->					
					<div class="form-group">
                        <div class="inner-addon right-addon">
                            <i class="form-icon form-icon-size-small fa fa-sort"></i>
                            <select class="form-control form-control-sm sharp-edge" data-placeholder="<?php esc_html_e('Select Category..', 'classiera'); ?>" id="ajaxSelectCat" name="category_name">
                                <option value="-1" selected disabled><?php esc_html_e('All Categories', 'classiera'); ?></option>
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
									<option value="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->cat_name); ?></option>	
										<?php
										$args2 = array(
											'hide_empty' => '0',
											'parent' => $catID
										);
										$categories = get_categories($args2);
										foreach($categories as $cat){											
											?>
										<option value="<?php echo esc_attr($cat->slug); ?>">- <?php echo esc_html($cat->cat_name); ?></option>	
											<?php
										}
									}
								}
								?>
                            </select>
                        </div>
                    </div>
					<!--Select Category-->
					<!--Locations-->
					<?php if($classieraLocationSearch == 1){?>
					<div class="form-group">
                        <div class="inner-addon right-addon">
						<?php if($classieraLocationType == 'input'):?>
							<!--Locations Input-->
                            <a id="getLocation" href="#" class="form-icon form-icon-size-small" title="<?php esc_html_e('Click here to get your own location', 'classiera'); ?>">
                                <i class="fa fa-crosshairs"></i>
                            </a>
                            <input type="text" id="getCity" name="<?php echo esc_attr($classieraLocationName); ?>" class="form-control form-control-sm sharp-edge" placeholder="<?php esc_html_e('Please type your location', 'classiera'); ?>">
							<!--Locations Input-->
						<?php elseif($classieraLocationType == 'dropdown'):?>
							<!--Locations dropdown-->
							<i class="form-icon form-icon-size-small fa fa-sort"></i>
							<?php get_template_part( 'templates/classiera-locations-dropdown' );?>
							<!--Locations dropdown-->
						<?php endif; ?>
                        </div>
                    </div>
					<?php } ?>
					<!--Locations-->
					<div class="form-group">
                        <button type="submit" name="search" value="Search"><i class="fa fa-search"></i><?php esc_html_e( 'Search', 'classiera' ); ?></button>
                    </div>
				</form>
			</div><!--col-md-12-->
		</div><!--row-->
	</div><!--container-->
</section><!--search-section-->
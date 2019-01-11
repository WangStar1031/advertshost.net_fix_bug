<?php 
	global $redux_demo;
	$classieraPriceRange = $redux_demo['classiera_pricerange_on_off'];
	$classieraPriceRangeStyle = $redux_demo['classiera_pricerange_style'];
	$postCurrency = $redux_demo['classierapostcurrency'];
	$classieraMultiCurrency = $redux_demo['classiera_multi_currency'];
	$classieraTagDefault = $redux_demo['classiera_multi_currency_default'];
	$classieraMaxPrice = $redux_demo['classiera_max_price_input'];
	$classieraLocationSearch = $redux_demo['classiera_search_location_on_off'];
	// $classieraItemCondation = $redux_demo['adpost-condition'];
	$locationsStateOn = $redux_demo['location_states_on'];
	$classiera_ads_type = $redux_demo['classiera_ads_type'];	
	$locationsCityOn= $redux_demo['location_city_on'];
	if($classieraMultiCurrency == 'multi'){
		$classieraPriceTagForSearch = classiera_Display_currency_sign($classieraTagDefault);
	}elseif(!empty($postCurrency) && $classieraMultiCurrency == 'single'){
		$classieraPriceTagForSearch = $postCurrency;
	}
	$adsTypeShow = $redux_demo['classiera_ads_type_show'];
	$classieraShowSell = $adsTypeShow[1];
	$classieraShowBuy = $adsTypeShow[2];
	$classieraShowRent = $adsTypeShow[3];
	$classieraShowHire = $adsTypeShow[4];
	$classieraShowFound = $adsTypeShow[5];
	$classieraShowFree = $adsTypeShow[6];
	$classieraShowEvent = $adsTypeShow[7];
	$classieraShowServices = $adsTypeShow[8];
?>
<!--SearchForm-->
<form method="get" action="<?php echo home_url(); ?>">
	<div class="search-form border">
		<div class="search-form-main-heading">
			<a href="#innerSearch" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="innerSearch">
				<i class="fa fa-search"></i>
				<?php esc_html_e( 'Advanced Search', 'classiera' ); ?>
			</a>
		</div><!--search-form-main-heading-->
		<div id="innerSearch" class="collapse in classiera__inner">
			<!--Price Range-->
			<?php if($classieraPriceRange == 1){?>
			<div class="inner-search-box">
				<h5 class="inner-search-heading">
					<span class="currency__symbol">
					<?php 
					if (!empty($postCurrency) && $classieraMultiCurrency == 'single'){
						echo esc_attr($postCurrency);
						$currencySign = $postCurrency;
					}elseif($classieraMultiCurrency == 'multi'){
						echo classiera_Display_currency_sign($classieraTagDefault);
						$currencySign = classiera_Display_currency_sign($classieraTagDefault);
					}else{
						echo "&dollar;";
						$currencySign = "&dollar;";
					}
					?>	
					</span>
				<?php esc_html_e( 'Price Range', 'classiera' ); ?>
				</h5>
				<?php if($classieraPriceRangeStyle == 'slider'){?>
					<?php 
					$startPrice = $classieraMaxPrice*10/100; 
					$secondPrice = $startPrice+$startPrice; 
					$thirdPrice = $startPrice+$secondPrice; 
					$fourthPrice = $startPrice+$thirdPrice; 
					$fivePrice = $startPrice+$fourthPrice; 
					$sixPrice = $startPrice+$fivePrice; 
					$sevenPrice = $startPrice+$sixPrice; 
					$eightPrice = $startPrice+$sevenPrice; 
					$ninePrice = $startPrice+$eightPrice; 
					$tenPrice = $startPrice+$ninePrice;
					?>
					<div class="radio">
						<!--PriceFirst-->
						<input id="price-range-1" type="radio" value="<?php echo "0,".$startPrice; ?>" name="price_range">
						<label for="price-range-1">
							0&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($startPrice); ?>
						</label>
						<!--PriceSecond-->
						<input id="price-range-2" type="radio" value="<?php echo esc_attr($startPrice).','.esc_attr($secondPrice); ?>" name="price_range">
						<label for="price-range-2">
							<?php echo esc_attr($startPrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($secondPrice); ?>
						</label>
						<!--PriceThird-->
						<input id="price-range-3" type="radio" value="<?php echo esc_attr($secondPrice).','.esc_attr($thirdPrice); ?>" name="price_range">
						<label for="price-range-3">
							<?php echo esc_attr($secondPrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($thirdPrice); ?>
						</label>
						<!--PriceFourth-->
						<input id="price-range-4" type="radio" value="<?php echo esc_attr($thirdPrice).','.esc_attr($fourthPrice); ?>" name="price_range">
						<label for="price-range-4">
							<?php echo esc_attr($thirdPrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($fourthPrice); ?>
						</label>
						<!--PriceFive-->
						<input id="price-range-5" type="radio" value="<?php echo esc_attr($fourthPrice).','.esc_attr($fivePrice); ?>" name="price_range">
						<label for="price-range-5">
							<?php echo esc_attr($fourthPrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($fivePrice); ?>
						</label>
						<!--PriceSix-->
						<input id="price-range-6" type="radio" value="<?php echo esc_attr($fivePrice).','.esc_attr($sixPrice); ?>" name="price_range">
						<label for="price-range-6">
							<?php echo esc_attr($fivePrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($sixPrice); ?>
						</label>
						<!--PriceSeven-->
						<input id="price-range-7" type="radio" value="<?php echo esc_attr($sixPrice).','.esc_attr($sevenPrice); ?>" name="price_range">
						<label for="price-range-7">
							<?php echo esc_attr($sixPrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($sevenPrice); ?>
						</label>
						<!--PriceEight-->
						<input id="price-range-8" type="radio" value="<?php echo esc_attr($sevenPrice).','.esc_attr($eightPrice); ?>" name="price_range">
						<label for="price-range-8">
							<?php echo esc_attr($sevenPrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($eightPrice); ?>
						</label>
						<!--PriceNine-->
						<input id="price-range-9" type="radio" value="<?php echo esc_attr($eightPrice).','.esc_attr($ninePrice); ?>" name="price_range">
						<label for="price-range-9">
							<?php echo esc_attr($eightPrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($ninePrice); ?>
						</label>
						<!--Max Price-->
						 <input id="price-range-10" type="radio" value="<?php echo esc_attr($ninePrice).','.esc_attr($classieraMaxPrice); ?>" name="price_range">
						<label for="price-range-10">
							<?php echo esc_attr($ninePrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($classieraMaxPrice); ?>
						</label>
					</div><!--radio-->
					<div class="classiera_price_slider">
						<p>
						  <label for="amount"><?php esc_html_e( 'Price range', 'classiera' ); ?>:</label>
						  <input data-cursign="<?php echo sprintf($currencySign); ?>" type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
						</p>					 
						<div id="slider-range"></div>
						<input type="hidden" id="classieraMaxPrice" value="<?php echo esc_attr($classieraMaxPrice); ?>">
						<input type="hidden" id="range-first-val" name="search_min_price" value="">
						<input type="hidden" id="range-second-val" name="search_max_price" value="">
					</div>					
					
				<?php }else{?>
					<!--Price Range input-->
					<div class="inner-addon right-addon">
						<input type="text" name="search_min_price" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'Min price', 'classiera' ); ?>">
					</div>
					<div class="inner-addon right-addon">
						<input type="text" name="search_max_price" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'Max price', 'classiera' ); ?>">
					</div>
					<!--Price Range input-->
				<?php } ?>
			</div>
			<?php } ?>
			<!--Price Range-->
			<div class="inner-search-box">
				<h5 class="inner-search-heading"><i class="fa fa-tag"></i>
				<?php esc_html_e( 'Keywords', 'classiera' ); ?>
				</h5>
				<div class="inner-addon right-addon">
					<i class="right-addon form-icon fa fa-search"></i>
					<input type="search" name="s" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'Enter Keyword', 'classiera' ); ?>">
				</div>
			</div><!--Keywords-->
			<!--Locations-->
			<?php if($classieraLocationSearch == 1){?>
			<div class="inner-search-box">
				<h5 class="inner-search-heading"><i class="fas fa-map-marker-alt"></i>
				<?php esc_html_e( 'Location', 'classiera' ); ?>
				</h5>
				<!--SelectCountry-->
				<?php
				$args = array(
					'post_type' => 'countries',
					'posts_per_page'   => -1,
					'orderby'          => 'title',
					'order'            => 'ASC',
					'post_status'      => 'publish',
					'suppress_filters' => false 
				);
				$country = get_posts($args);
				if(!empty($country)){
				?>
				<div class="inner-addon right-addon">
					<i class="right-addon form-icon fa fa-sort"></i>
					<select name="post_location" class="form-control form-control-sm" id="post_location">
						<option value="-1" selected disabled>
							<?php esc_html_e('Select Country', 'classiera'); ?>
						</option>
						<?php foreach( $country as $singleCountry ){?>
						<option value="<?php echo esc_attr($singleCountry->ID); ?>">
							<?php echo esc_html($singleCountry->post_title); ?>
						</option>
						<?php } ?>
					</select>
				</div>
				<?php } ?>
				 <?php wp_reset_postdata(); ?>
				<!--SelectCountry-->
				<!--Select State-->
				<?php if($locationsStateOn == 1){?>
				<div class="inner-addon right-addon post_sub_loc">
					<i class="right-addon form-icon fa fa-sort"></i>
					<select name="post_state" class="form-control form-control-sm" id="post_state">
						<option value=""><?php esc_html_e('Select State', 'classiera'); ?></option>
					</select>
				</div>
				<?php } ?>
				<!--Select State-->
				<!--Select City-->
				<?php if($locationsCityOn == 1){?>
				<div class="inner-addon right-addon post_sub_loc">
					<i class="right-addon form-icon fa fa-sort"></i>
					<select name="post_city" class="form-control form-control-sm" id="post_city">
						<option value=""><?php esc_html_e('Select City', 'classiera'); ?></option>
					</select>
				</div>
				<?php } ?>
				<!--Select City-->
			</div>
			<?php } ?>
			<!--Locations-->
			<!--Categories-->
			<div class="inner-search-box">
				<h5 class="inner-search-heading"><i class="far fa-folder-open"></i>
				<?php esc_html_e( 'Categories', 'classiera' ); ?>
				</h5>
				<!--SelectCategory-->
				<div class="inner-addon right-addon">
					<i class="right-addon form-icon fa fa-sort"></i>
					<?php 
					$args = array(												
						'show_option_none' => esc_html__( 'Select category', 'classiera' ),
						'show_count' => 0,
						'orderby' => 'name',											  
						'selected' => -1,
						'depth' => 1,
						'hierarchical' => 1,						  
						'hide_if_empty'  => false,
						'hide_empty' => 0,
						'name' => 'category_name',
						'parent' => 0,
						'value_field' => 'slug',
						'id' => 'main_cat',
						'class' => 'form-control form-control-sm',
						'disabled' => '',
					);
					wp_dropdown_categories($args);
					?>
				</div>
				<!--Select Sub Category-->
				<div class="inner-addon right-addon classiera_adv_subcat">
					<i class="right-addon form-icon fa fa-sort"></i>
					<select name="sub_cat" class="form-control form-control-sm" id="sub_cat" disabled="disabled">
					</select>
				</div>
				<!--CustomFields-->
				<?php
				$args = array(
				  'hide_empty' => false,
				  'orderby' => 'name',
				  'order' => 'ASC'
				);
				$inum = 0;
				$categories = get_categories($args);
				global $wpdb;
				$shabir = $wpdb->get_results( "select * from ".$wpdb->prefix."postmeta where meta_key='custom_field'", OBJECT );
				$field_values = array();
				foreach ( $shabir as $r ) {			
					$values = maybe_unserialize($r->meta_value);
					if(!empty($values)){
						$post_categories = wp_get_post_categories( $r->post_id );
						if(!empty($post_categories)){
							foreach($post_categories as $c){
								$cat = $c;
							}
							$cat = intval($cat);
							foreach($values as $val) {
								$key= $val[0];
								$field_values[$cat][$key][] = $val[1];					
							}
						}	
					}
				}
				foreach($categories as $category) {
					$inum++;
					$cat_id = $category->cat_ID;
					$cat_slug = $category->slug;
					$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);	
					if(isset($tag_extra_fields[$cat_id]['category_custom_fields'])) :
					$fields = $tag_extra_fields[$cat_id]['category_custom_fields'];
					$fieldsType = $tag_extra_fields[$cat_id]['category_custom_fields_type'];
					/*Display Text Fields*/
					for ($i = 0; $i < (count($fields)); $i++) {
						if($fieldsType[$i][1] == 'text'){
							?>
							<div class="inner-addon right-addon custom-field-cat custom-field-cat-<?php echo esc_attr($cat_slug); ?>" style="display: none;">
								<i class="right-addon form-icon fa fa-sort"></i>
								<select name="custom_fields[]" class="form-control form-control-sm autoHide hide-<?php echo esc_attr($cat_slug); ?>">
									<option value=""><?php echo esc_attr($fields[$i][0]); ?>...</option>
									<?php $key = $fields[$i][0];
									if(!empty($field_values[$cat_id][$key])) : 
										foreach($field_values[$cat_id][$key] as $val) : ?>
										<option value="<?php echo esc_attr($val); ?>"><?php echo esc_attr($val); ?></option>
									<?php endforeach; endif; ?>
								</select>
							</div>
							<?php
						}
					}
					/*Display Dropdown Fields*/
					for ($i = 0; $i < (count($fields)); $i++) {
						if($fieldsType[$i][1] == 'dropdown'){
							?>
							<div class="inner-addon right-addon custom-field-cat custom-field-cat-<?php echo esc_attr($cat_slug); ?>" style="display: none;">
								<i class="right-addon form-icon fa fa-sort"></i>
								<select name="custom_fields[]" class="form-control form-control-sm autoHide hide-<?php echo esc_attr($cat_slug); ?>">
									<option value=""><?php echo esc_attr($fields[$i][0]); ?>...</option>
									<?php 
									$options = $fieldsType[$i][2]; 
									$optionsarray = explode(',',$options);
									?>
									<?php 
										foreach($optionsarray as $option){
												echo '<option value="'.esc_attr($option).'">'.esc_attr($option).'</option>';
											}
									?>
								</select>
							</div>
							<?php
						}
					}
					/*Display Checkbox Fields*/
					for ($i = 0; $i < (count($fields)); $i++) {
						if($fieldsType[$i][1] == 'checkbox'){
							?>
							<div class="inner-addon right-addon custom-field-cat custom-field-cat-<?php echo esc_attr($cat_slug); ?>" style="display: none;">
								<div class="checkbox custom-field-cat-<?php echo esc_attr($cat_slug); ?>">
									<input type="checkbox" id="<?php echo esc_attr($cat_id.$i); ?>" name="custom_fields[]" value="<?php echo esc_attr($fields[$i][0]); ?>">
									<label for="<?php echo esc_attr($cat_id.$i); ?>"><?php echo esc_attr($fields[$i][0]); ?></label>
								</div>
							</div>
							<?php
						}
					}
					endif;
				}
				?>
				<!--CustomFields-->
				<!--Select Ads Type-->
				<?php if($classiera_ads_type == 1){?>
				<div class="inner-search-box-child">
					<p><?php esc_html_e( 'Type of Ad', 'classiera' ); ?></p>
					<div class="radio">
						<input id="type_all" type="radio" name="classiera_ads_type" value="All" checked>
						<label for="type_all"><?php esc_html_e( 'All', 'classiera' ); ?></label>
						<?php if($classieraShowSell == 1){ ?>
							<input id="sell" type="radio" name="classiera_ads_type" value="sell">
							<label for="sell"><?php esc_html_e( 'For Sale', 'classiera' ); ?></label>
						<?php } ?>
						<?php if($classieraShowBuy == 1){ ?>
							<input id="buy" type="radio" name="classiera_ads_type" value="buy">
							<label for="buy"><?php esc_html_e( 'Wanted', 'classiera' ); ?></label>
						<?php } ?>
						<?php if($classieraShowRent == 1){ ?>
							<input id="rent" type="radio" name="classiera_ads_type" value="rent">
							<label for="rent"><?php esc_html_e( 'For Rent', 'classiera' ); ?></label>
						<?php } ?>
						<?php if($classieraShowHire == 1){ ?>
							<input id="hire" type="radio" name="classiera_ads_type" value="hire">
							<label for="hire"><?php esc_html_e( 'For hire', 'classiera' ); ?></label>
						<?php } ?>
						<?php if($classieraShowFound == 1){ ?>
							<input id="lostfound" type="radio" name="classiera_ads_type" value="lostfound">
							<label for="lostfound"><?php esc_html_e( 'Lost & Found', 'classiera' ); ?></label>
						<?php } ?>
						<?php if($classieraShowFree == 1){ ?>
							<input id="typefree" type="radio" name="classiera_ads_type" value="free">
							<label for="typefree"><?php esc_html_e( 'Free', 'classiera' ); ?></label>
						<?php } ?>
						<?php if($classieraShowEvent == 1){ ?>
							<input id="event" type="radio" name="classiera_ads_type" value="event">
							<label for="event"><?php esc_html_e( 'Event', 'classiera' ); ?></label>
						<?php } ?>
						<?php if($classieraShowServices == 1){ ?>
							<input id="service" type="radio" name="classiera_ads_type" value="service">
							<label for="service"><?php esc_html_e( 'Professional service', 'classiera' ); ?></label>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
				<!--Select Ads Type-->
			</div><!--inner-search-box-->
			<button type="submit" name="search" class="btn btn-primary btn-block" value="<?php esc_html_e( 'Search', 'classiera') ?>"><?php esc_html_e( 'Search', 'classiera') ?></button>
		</div><!--innerSearch-->
	</div><!--search-form-->
</form>
<!--SearchForm-->
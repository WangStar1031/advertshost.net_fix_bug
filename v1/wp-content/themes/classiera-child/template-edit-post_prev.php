<?php
/**
 * Template name: Edit Ads
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */

if ( !is_user_logged_in() ) {
	wp_redirect( home_url() );exit;
}

global $redux_demo;
$featuredADS = '';
$googleFieldsOn = $redux_demo['google-lat-long'];
$classieraLatitude = $redux_demo['contact-latitude'];
$classieraLongitude = $redux_demo['contact-longitude'];
$postCurrency = $redux_demo['classierapostcurrency'];
$classieraAddress = $redux_demo['classiera_address_field_on'];
$classiera_ads_typeOn = $redux_demo['classiera_ads_type'];
$termsandcondition = $redux_demo['termsandcondition'];
$postContent = '';
$caticoncolor="";
$category_icon_code ="";
$category_icon="";
$category_icon_color="";
global$current_user;
wp_get_current_user();
$hasError = false;
$userID = $current_user->ID;
$query = new WP_Query(array('post_type' => 'post', 'posts_per_page' =>'-1', 'p' => $_GET['post']));
$allowed='';
if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
	
	if(isset($_GET['post'])) {			
		if($_GET['post'] == $post->ID)

		{
			$posts_id = $_GET['post'];
			$author = get_post_field( 'post_author', $posts_id );
			if(current_user_can('administrator') ){

			}else{
				if($author != $userID) {
					wp_redirect( home_url() ); exit;
				}
			}
			$current_post = $post->ID;
			$title = get_the_title();
			$content = get_the_content();			
			$posttags = get_the_tags($current_post);
			if ($posttags) {
			  foreach($posttags as $tag) {
				$tags_list = $tag->name . ' '; 
			  }
			}
			$postcategory = get_the_category( $current_post );
			$customCate = $postcategory[0]->cat_ID;

			$category_id = $postcategory[0]->cat_ID;			
			$post_category_type = get_post_meta($post->ID, 'post_category_type', true);
			$classieraPostDate = get_the_date('Y-m-d H:i:s', $posts_id);
			$post_price = get_post_meta($post->ID, 'post_price', true);
			$post_old_price = get_post_meta($post->ID, 'post_old_price', true);
			$classieraTagDefault = get_post_meta($post->ID, 'post_currency_tag', true);

			$post_phone = get_post_meta($post->ID, 'post_phone', true);

			$post_main_cat = get_post_meta($post->ID, 'post_perent_cat', true);
			$post_child_cat = get_post_meta($post->ID, 'post_child_cat', true);
			$post_inner_cat = get_post_meta($post->ID, 'post_inner_cat', true);
			if(empty($post_inner_cat)){
				$category_id = $post_child_cat;
			}else{
				$category_id = $post_inner_cat;
			}
			if(empty($category_id)){
				$category_id = $post_main_cat;
			}
			$post_location = get_post_meta($post->ID, 'post_location', true);

			$post_state = get_post_meta($post->ID, 'post_state', true);
			$post_city = get_post_meta($post->ID, 'post_city', true);

			$post_latitude = get_post_meta($post->ID, 'post_latitude', true);

			$post_longitude = get_post_meta($post->ID, 'post_longitude', true);

			$post_price_plan_id = get_post_meta($post->ID, 'post_price_plan_id', true);

			$post_address = get_post_meta($post->ID, 'post_address', true);

			$post_video = get_post_meta($post->ID, 'post_video', true);

			$featuredIMG = get_post_meta($post->ID, 'featured_img', true);

			$itemCondition = get_post_meta($post->ID, 'item-condition', true);

			$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);

			$classiera_post_type = get_post_meta($post->ID, 'classiera_post_type', true);
			$pay_per_post_product_id = get_post_meta($post->ID, 'pay_per_post_product_id', true);
			$days_to_expire = get_post_meta($post->ID, 'days_to_expire', true);

			$featured_post = "0";
			$post_price_plan_activation_date = get_post_meta($post->ID, 'post_price_plan_activation_date', true);
			$post_price_plan_expiration_date = get_post_meta($post->ID, 'post_price_plan_expiration_date', true);
			$todayDate = strtotime(date('d/m/Y H:i:s'));
			$expireDate = strtotime($post_price_plan_expiration_date);  
			if(!empty($post_price_plan_activation_date)) {
				if(($todayDate < $expireDate) or empty($post_price_plan_expiration_date)) {
					$featured_post = "1";
				}
			}
			if(empty($post_latitude)) {
				$post_latitude = 0;
			}			
			if(empty($post_longitude)) {
				$post_longitude = 0;
				$mapZoom = 2;
			} else {
				$mapZoom = 16;
			}	
			if ( has_post_thumbnail() ) {

				$post_thumbnail = get_the_post_thumbnail($current_post, 'thumbnail');		
			}

		}

	}
endwhile; endif;
wp_reset_query();global $current_post;
$postTitleError = '';
$post_priceError = '';
$catError = '';
$featPlanMesage = '';

if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {	
	
	if(trim($_POST['postTitle']) === '') {
		$postTitleError =  esc_html__( 'Please select a title.', 'classiera' );
		$hasError = true;
	} else {
		$postTitle = trim($_POST['postTitle']);
	}

	if(empty($_POST['cat'])){
		$catError =  esc_html__( 'Please select a category.', 'classiera' );
		$hasError = true;
	}

	if($hasError != true) {
		//$classieraPostType = $_POST['classiera_post_type'];
		if(is_super_admin() ){
			$postStatus = 'publish';
		}elseif(!is_super_admin()){		

			if($redux_demo['post-options-edit-on'] == 1){
				$postStatus = 'private';
			}else{
				$postStatus = $_POST['post_status'];
			}
			if($classieraPostType == 'payperpost'){
				$postStatus = 'pending';
			}
		}

		//Check Category//		
		if(trim($_POST['cat']) === '-1') {						
			$catError =  esc_html__( 'Please select a category.', 'classiera' );
			$hasError = true;
		} 		
		$mCatID = $_POST['cat'];
		$classieraGetCats = classiera_get_cats_on_edit($mCatID);				
		$categoriesID = get_ancestors($mCatID, 'category', 'taxonomy');
		if(!empty($categoriesID)){			
			$cats = "";
			foreach ($categoriesID as $id) {
				$cats .= $id.', ';
			}			
			$catsString = $cats.$mCatID;						
			$catsArray = explode(",", $catsString);
		}else{
			$catsArray = array($mCatID);
		}
		$post_main_cat = $classieraGetCats['post_main_cat'];
		$post_child_cat = $classieraGetCats['post_child_cat'];
		$post_inner_cat = $classieraGetCats['post_inner_cat'];		
		$post_date = $_POST['classiera_post_date'];		
		$post_information = array(
			'ID' => $current_post,
			'post_title' => esc_attr(strip_tags($_POST['postTitle'])),
			'post_content' => strip_tags($_POST['postContent'], '<h1><h2><h3><strong><b><ul><ol><li><i><a><blockquote><center><embed><iframe><pre><table><tbody><tr><td><video>'),
			'post-type' => 'post',
			'post_date' => $post_date,
			'post_category' => $catsArray,
	        'tags_input'    => explode(',', $_POST['post_tags']),
	        'tax_input' => array(
	        	'location' => $_POST['post_location'],
	        ),
	        'comment_status' => 'open',
	        'ping_status' => 'open',
	        'post_author' => $_POST['postAuthor'],
			'post_status' => $postStatus
		);

		$post_id = wp_insert_post($post_information);
		$googleLat = $_POST['latitude'];
		$googleLong = $_POST['longitude'];
				
		/*Check If Latitude is OFF */				
		if(empty($googleLat)){			
			$latitude = $classieraLatitude;
		}else{			
			$latitude = $googleLat;		
		}		
		/*Check If longitude is OFF */				
		if(empty($googleLong)){			
			$longitude = $classieraLongitude;		
		}else{			
			$longitude = $googleLong;		
		}
		
		$post_price_status = trim($_POST['post_price']);
		$old_price_status = trim($_POST['post_old_price']);

		$old_price_status = trim($_POST['item-condition']);	

						

		global $redux_demo; 
		$free_listing_tag = $redux_demo['free_price_text'];

		if(empty($post_price_status)) {
			$post_price_content = $free_listing_tag;
		} else {
			$post_price_content = $post_price_status;
		}

		if(empty($old_price_status)) {			
			$old_price_content = $free_listing_tag;		
		} else {			
			$old_price_content = $old_price_status;		
		}

		$catID = $mCatID.'custom_field';	
		$custom_fields = $_POST[$catID];			
		/*If We are using CSC Plugin*/		
		/*Get Country Name*/		
		if(isset($_POST['post_location'])){			
			$postLo = $_POST['post_location'];			
			$allCountry = get_posts( array( 'include' => $postLo, 'post_type' => 'countries', 'posts_per_page' => -1, 'suppress_filters' => 0, 'orderby'=>'post__in' ) );
			foreach( $allCountry as $country_post ){
				$postCounty = $country_post->post_title;
			}
		}
		if(isset($_POST['post_state'])){
			$poststate = $_POST['post_state'];
		}
		if(isset($_POST['post_state'])){
			$postCity = $_POST['post_city'];
		}		
		if(isset($_POST['classiera_CF_Front_end'])){			
			$classiera_CF_Front_end = $_POST['classiera_CF_Front_end'];		
		}
		if(isset($_POST['classiera_sub_fields'])){			
			$classiera_sub_fields = $_POST['classiera_sub_fields'];		
		}	
		if(isset($_POST['new_featured'])){			
			$new_featured = $_POST['new_featured'];		
		}
		if(isset($new_featured) && !empty($new_featured)){			
			update_post_meta($post_id, '_thumbnail_id', $new_featured);		
		}
		/*If We are using CSC Plugin*/		
		
		if(isset($_POST['post_category_type'])){			
			update_post_meta($post_id, 'post_category_type', esc_attr( $_POST['post_category_type'] ) );		
		}		
		$postMultiTag = $_POST['post_currency_tag'];
		
		update_post_meta($post_id, 'custom_field', $custom_fields);		
		update_post_meta($post_id, 'classiera_CF_Front_end', $classiera_CF_Front_end);		
		update_post_meta($post_id, 'classiera_sub_fields', $classiera_sub_fields);
		update_post_meta($post_id, 'classiera_ads_type', $_POST['classiera_ads_type'], $allowed);

		update_post_meta($post_id, 'post_perent_cat', $post_main_cat, $allowed);
		update_post_meta($post_id, 'post_child_cat', $post_child_cat, $allowed);				
		update_post_meta($post_id, 'post_inner_cat', $post_inner_cat, $allowed);

		update_post_meta($post_id, 'post_currency_tag', $postMultiTag, $allowed);

		update_post_meta($post_id, 'post_price', $post_price_content, $allowed);
		
		update_post_meta($post_id, 'post_old_price', $old_price_content, $allowed);
		if(isset($_POST['post_phone'])){
			update_post_meta($post_id, 'post_phone', $_POST['post_phone'], $allowed);
		}

		update_post_meta($post_id, 'post_location', wp_kses($postCounty, $allowed));

		update_post_meta($post_id, 'post_state', wp_kses($poststate, $allowed));	
		update_post_meta($post_id, 'post_city', wp_kses($postCity, $allowed));

		update_post_meta($post_id, 'post_latitude', wp_kses($latitude, $allowed));		
		update_post_meta($post_id, 'post_longitude', wp_kses($longitude, $allowed));

		update_post_meta($post_id, 'post_address', wp_kses($_POST['address'], $allowed));

		update_post_meta($post_id, 'post_video', $_POST['video'], $allowed);

		update_post_meta($post_id, 'featured_img', $_POST['featured-image'], $allowed);

		if(isset($_POST['item-condition'])){			
			update_post_meta($post_id, 'item-condition', $itemCondition, $allowed);		
		}

		//This was commented out
	// 	update_post_meta($post_id, 'classiera_post_type', $_POST['classiera_post_type'], $allowed);
	// 	update_post_meta($post_id, 'pay_per_post_product_id', $_POST['pay_per_post_product_id'], $allowed);
	// 	update_post_meta($post_id, 'days_to_expire', $_POST['days_to_expire'], $allowed);

	// 	$permalink = get_permalink( $post_id );
	// 	//Rest featured image from old images//
	// 	if(isset($_POST['classiera_featured_img'])){
	// 		$imageID = $_POST['classiera_featured_img'];
	// 		set_post_thumbnail( $post_id, $imageID );
	// 	}
	// 	//If Its posting featured image//
	// 	if(trim($_POST['classiera_post_type']) != 'classiera_regular'){
	// 		if($_POST['classiera_post_type'] == 'payperpost'){
	// 		//Do Nothing on Pay Per Post//
	// 		}elseif($_POST['classiera_post_type'] == 'classiera_regular_with_plan'){
	// 		//Regular Ads Posting with Plans//
	// 		$classieraPlanID = trim($_POST['regular_plan_id']);
	// 		global $wpdb;
	// 		$current_user = wp_get_current_user();
	// 		$userID = $current_user->ID;
	// 		$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE id = $classieraPlanID" );
	// 		if($result){
	// 			$tablename = $wpdb->prefix . 'classiera_plans';
	// 			$newRegularUsed = $info->regular_used +1;
	// 			$update_data = array('regular_used' => $newRegularUsed);
	// 			$where = array('id' => $classieraPlanID);
	// 			$update_format = array('%s');
	// 			$wpdb->update($tablename, $update_data, $where, $update_format);
	// 		}
	// 	}else{
	// 		//Featured Post with Plan Ads//
	// 		$featurePlanID = trim($_POST['classiera_post_type']);
	// 		global $wpdb;
	// 		$current_user = wp_get_current_user();
	// 		$userID = $current_user->ID;
	// 		$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE id = $featurePlanID" );
	// 		if ($result){
	// 			$featuredADS = 0;
	// 			$tablename = $wpdb->prefix . 'classiera_plans';
	// 			foreach ( $result as $info ){
	// 				$totalAds = $info->ads;
	// 				if (is_numeric($totalAds)){
	// 					$totalAds = $info->ads;
	// 					$usedAds = $info->used;
	// 					$infoDays = $info->days;
	// 				}
	// 				if($totalAds == 'unlimited'){
	// 					$availableADS = 'unlimited';
	// 				}else{
	// 					$availableADS = $totalAds-$usedAds;
	// 				if($usedAds < $totalAds && $availableADS != "0" || $totalAds == 'unlimited'){
	// 					global $wpdb;
	// 					$newUsed = $info->used +1;
	// 					$update_data = array('used' => $newUsed);
	// 					$where = array('id' => $featurePlanID);
	// 					$update_format = array('%s');
	// 					$wpdb->update($tablename, $update_data, $where, $update_format);
	// 					update_post_meta($post_id, 'post_price_plan_id', $featurePlanID );

	// 					$dateActivation = date('m/d/Y H:i:s');
	// 					update_post_meta($post_id, 'post_price_plan_activation_date', $dateActivation );

	// 					$daysToExpire = $infoDays;
	// 					$dateExpiration_Normal = date("m/d/Y H:i:s", strtotime("+ ".$daysToExpire." days"));
	// 					update_post_meta($post_id, 'post_price_plan_expiration_date_normal', $dateExpiration_Normal );



	// 					$dateExpiration = strtotime(date("m/d/Y H:i:s", strtotime("+ ".$daysToExpire." days")));
	// 					update_post_meta($post_id, 'post_price_plan_expiration_date', $dateExpiration );
	// 					update_post_meta($post_id, 'featured_post', "1" );
	// 				}
	// 			}
	// 		}
	// 	}
	// }
		//This Section was commented out
		if ( $_FILES ) {			$count = 0;
			$files = $_FILES['upload_attachment'];
			foreach ($files['name'] as $key => $value) {
				if ($files['name'][$key]) {
					$file = array(
						'name'     => $files['name'][$key],
						'type'     => $files['type'][$key],
						'tmp_name' => $files['tmp_name'][$key],
						'error'    => $files['error'][$key],
						'size'     => $files['size'][$key]
					);

					$_FILES = array("upload_attachment" => $file);

					foreach ($_FILES as $file => $array){
						$featuredimg = $_POST['classiera_featured_img'];
						if($count == $featuredimg){
							$attachment_id = classiera_insert_attachment($file,$post_id);
							set_post_thumbnail( $post_id, $attachment_id );
						}else{
							$attachment_id = classiera_insert_attachment($file,$post_id);
						}
						$count++;
					}
				}
			}
		}
		if (isset($_POST['att_remove'])) {
			foreach ($_POST['att_remove'] as $att_id){
				wp_delete_attachment($att_id);
			}
		}
		wp_redirect( $permalink ); exit;
	}
} 

get_header();  
?>
<?php 	
global $redux_demo;	$page = get_page($post->ID);	
$current_page_id = $page->ID;?>	
<?php while ( have_posts() ) : the_post(); ?>
	<section class="user-pages section-gray-bg">	
		<div class="container">		
			<div class="row">			
				<div class="col-lg-3 col-md-4">				
					<?php get_template_part( 'templates/profile/userabout' ); ?>			
				</div><!--col-lg-3 col-md-4-->			
				<div class="col-lg-9 col-md-8 user-content-height">				
					<div class="section-bg-white classiera_edit__post">					
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title text-uppercase"><?php esc_html_e('EDIT YOUR AD', 'classiera') ?></h3>
							</div>
						</div>
						<div class="submit-post">
							<form class="form-horizontal" action="" role="form" id="primaryPostForm" method="POST" data-toggle="validator" enctype="multipart/form-data">
								<input type="hidden" id="classiera_post_date" name="classiera_post_date" value="<?php echo esc_attr( $classieraPostDate ); ?>">
								<div class="form-main-section classiera-post-cat">
									<div class="classiera-post-main-cat">
										<h4 class="classiera-post-inner-heading">
										<?php esc_html_e('Select a Category', 'classiera') ?> :
									</h4>
									<select id="cat" class="postform" name="cat">
										<option value="All" disabled><?php esc_html_e('Select Category..', 'classiera') ?></option>
										<?php
										$currCatID = $category_id;
										$args = array( 'hierarchical' => '0', 'hide_empty' => '0');
										$categories = get_categories($args);
										foreach ($categories as $cat){
											if($cat->category_parent == 0){
												$catID = $cat->cat_ID;
										?>
										<option <?php if($currCatID == $catID){echo "selected";} ?> value="<?php echo esc_attr($cat->cat_ID); ?>"><?php echo esc_attr($cat->cat_name); ?></option>
										<?php
										$args2 = array( 'hide_empty' => '0', 'parent' => $catID );
										$categories = get_categories($args2);
										foreach($categories as $cat){
											$catSubID = $cat->cat_ID;
										?>
										<option <?php if($currCatID == $cat->cat_ID){echo "selected";} ?> value="<?php echo esc_attr($cat->cat_ID); ?>">--<?php echo esc_attr($cat->cat_name); ?></option>
										<?php
										$args3 = array( 'hide_empty' => '0', 'parent' => $catSubID );
										$categories = get_categories($args3);
										foreach($categories as $cat){
										?>
										<option <?php if($currCatID == $cat->cat_ID){echo "selected";} ?> value="<?php echo esc_attr($cat->cat_ID); ?>">---<?php echo esc_attr($cat->cat_name); ?></option>
										<?php
										}
										}
										}
										}
										?>
									</select>
								</div>
							</div><!--classiera-post-cat-->
							<!--AdsDetails-->
									<div class="form-main-section post-detail">
										<h4 class="text-uppercase border-bottom"><?php esc_html_e('Ad Details', 'classiera') ?> :</h4>
										<?php if($classiera_ads_typeOn == 1){ ?>							
											<?php 								
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
											<div class="form-group">                                
												<label class="col-sm-3 text-left flip"><?php esc_html_e('Type of Ad', 'classiera') ?> : <span>*</span></label>                                
												<div class="col-sm-9">                                    
													<div class="radio">										
														<?php if($classieraShowSell == 1){ ?>	                                        
															<input id="sell" type="radio" value="sell" name="classiera_ads_type" <?php if($classiera_ads_type == 'sell'){echo "checked";}?>>                                        <label for="sell"><?php esc_html_e('I want to sell', 'classiera') ?></label>									<?php } ?>									
															<?php if($classieraShowBuy == 1){ ?>                                        
																<input id="buy" type="radio" value="buy" name="classiera_ads_type" <?php if($classiera_ads_type == 'buy'){echo "checked";}?>>                                        
																<label for="buy"><?php esc_html_e('I want to buy', 'classiera') ?></label>									<?php } ?>										<?php if($classieraShowRent == 1){ ?>										
																	<input type="radio" name="classiera_ads_type" value="rent" id="rent" <?php if($classiera_ads_type == 'rent'){echo "checked";}?>>										
																	<label for="rent"><?php esc_html_e('I want to rent', 'classiera') ?></label>									
																	<?php } ?>									
																	<?php if($classieraShowHire == 1){ ?>										<input type="radio" name="classiera_ads_type" value="hire" id="hire" <?php if($classiera_ads_type == 'hire'){echo "checked";}?>>										
																	<label for="hire"><?php esc_html_e('I want to hire', 'classiera') ?></label>									<?php } ?>										<!--Lost and Found-->									
																	<?php if($classieraShowFound == 1){ ?>										
																		<input type="radio" name="classiera_ads_type" value="lostfound" id="lostfound" <?php if($classiera_ads_type == 'lostfound'){echo "checked";}?>>										
																		<label for="lostfound"><?php esc_html_e('Lost & Found', 'classiera') ?></label>									<?php } ?>									<!--Lost and Found-->									<!--Free-->									
																		<?php if($classieraShowFree == 1){ ?>										
																			<input type="radio" name="classiera_ads_type" value="free" id="typefree" <?php if($classiera_ads_type == 'free'){echo "checked";}?>>										
																			<label for="typefree"><?php esc_html_e('I give for free', 'classiera') ?></label>									
																			<?php } ?>									<!--Free-->									<!--Event-->									
																			<?php if($classieraShowEvent == 1){ ?>										
																				<input type="radio" name="classiera_ads_type" value="event" id="event" <?php if($classiera_ads_type == 'event'){echo "checked";}?>>										
																				<label for="event"><?php esc_html_e('I am an event', 'classiera') ?></label>									<?php } ?>									
																				<!--Event-->									<!--Professional service-->									
																				<?php if($classieraShowServices == 1){ ?>										
																					<input type="radio" name="classiera_ads_type" value="service" id="service" <?php if($classiera_ads_type == 'service'){echo "checked";}?>>										
																					<label for="service">											<?php esc_html_e('Professional service', 'classiera') ?>										
																				</label>									
																				<?php } ?>										
																				<input id="sold" type="radio" value="sold" name="classiera_ads_type" <?php if($classiera_ads_type == 'sold'){echo "checked";}?>>                                        
																				<label for="sold"><?php esc_html_e('Sold', 'classiera') ?></label>                                    </div>                                </div>                            
																			</div><!--Type of Ad-->							
																			<?php } ?>							
																			<div class="form-group">                                
																				<label class="col-sm-3 text-left flip" for="title"><?php esc_html_e('Ad title', 'classiera') ?> : <span>*</span></label>                                
																				<div class="col-sm-9">                                    
																					<input id="title" data-minlength="5" name="postTitle" type="text" class="form-control form-control-md" value="<?php echo esc_html($title); ?>" placeholder="<?php esc_html_e('Ad Title Goes here', 'classiera') ?>" required>                                   
																					<div class="help-block"><?php esc_html_e('type minimum 5 characters', 'classiera') ?></div>									
																					<?php 										
																					$post_id = $_GET['post'];										
																					$author = get_post_field ('post_author', $post_id);										
																					$postStatus = get_post_status($post_id);									?>									
																					<input type="hidden" id="postAuthor"  name="postAuthor" value="<?php echo esc_attr($author); ?>">									
																					<input type="hidden" id="postAuthor"  name="post_status" value="<?php echo esc_attr($postStatus); ?>">                                </div>                            
																				</div><!--Ad title-->							
																				<div class="form-group">                                
																					<label class="col-sm-3 text-left flip" for="description"><?php esc_html_e('Ad description', 'classiera') ?> : <span>*</span></label>                                
																					<div class="col-sm-9">                                    
																						<textarea name="postContent" id="description" class="form-control" data-error="<?php esc_html_e('Write description', 'classiera') ?>" required><?php echo esc_html($content);?></textarea>                                    
																						<div class="help-block with-errors"></div>                                </div>                            
																					</div><!--Ad description-->							
																					<div class="form-group">                                
																						<label class="col-sm-3 text-left flip"><?php esc_html_e('Ad Tags', 'classiera') ?> : </label>                               
																						 <div class="col-sm-9">                                    
																						 	<div class="form-inline row">                                        
																						 		<div class="col-sm-12">                                            
																						 			<div class="input-group">                                                
																						 				<div class="input-group-addon"><i class="fa fa-tags"></i></div>                                               
																						 				<?php	
																						 				echo "<input type='text' id='post_tags' placeholder='Tags' name='post_tags' value='";													
																						 				$posttags = get_the_tags($current_post);													
																						 				if ($posttags) {													  foreach($posttags as $tag) {														
																						 					$tags_list = $tag->name . ', '; 														
																						 					echo esc_html($tags_list);													  }													
																						 				}													
																						 				echo "' size='' maxlength='' class='form-control form-control-md'>"; 												 
																						 				?>                                            
																						 			</div>                                        
																						 		</div>                                    
																						 	</div>                                    
																						 	<div class="help-block">
																						 		<?php esc_html_e('Tags Example : ads, car, cat, business', 'classiera') ?></div>                                </div>                            
																						 	</div><!--Ad Tags-->							<?php 							

														$classieraPriceSecOFF = $redux_demo['classiera_sale_price_off'];							
														$classieraMultiCurrency = $redux_demo['classiera_multi_currency'];							
														$regularpriceon= $redux_demo['regularpriceon'];							
														$postCurrency = $redux_demo['classierapostcurrency'];							
														?>							
														<?php if($classieraPriceSecOFF == 1){?>							
															<div class="form-group classiera_hide_price">                                
																<label class="col-sm-3 text-left flip"><?php esc_html_e('Ad price', 'classiera') ?> : </label>                               
																 <div class="col-sm-9">                                    
																 	<div class="form-inline row">										
																 		<?php if($classieraMultiCurrency == 'multi'){?>							<div class="col-sm-12">                                            
																 			
																 			<div class="inner-addon right-addon input-group price__tag">                                                
																 				<div class="input-group-addon">                                                    
																 					<span class="currency__symbol">														
																 						<?php 
																 						echo classiera_Display_currency_sign($classieraTagDefault); ?>													</span>                                                
																 					</div>                                                
																 					<i class="form-icon right-form-icon fa fa-angle-down"></i>												
																 					<?php 
																 					echo classiera_Select_currency_dropdow($classieraTagDefault); ?>                                            
																 				</div>                                       
																 				 </div>										
																 				 <?php } ?>                                        
																 				 <div class="col-sm-6">                                            
																 				 	<div class="input-group">                                                
																 				 		<div class="input-group-addon">													
																 				 			<span class="currency__symbol">													
																 				 				<?php 													
																 				 				if (!empty($postCurrency) && $classieraMultiCurrency == 'single'){														
																 				 					echo esc_html($postCurrency);													}
																 				 					elseif($classieraMultiCurrency == 'multi'){														
																 				 						echo classiera_Display_currency_sign($classieraTagDefault);													}
																 				 						else{														
																 				 							echo "&dollar;";													}													
																 				 							?>														
																 				 						</span>												
																 				 					</div>                                                
										<input type="text" name="post_price" value="<?php echo esc_html($post_price); ?>" class="form-control form-control-md" placeholder="<?php esc_html_e('sale price', 'classiera') ?>">                                            
									</div>                                        
								</div>										
								<?php $regularpriceon= $redux_demo['regularpriceon']; ?>										
								<?php if($regularpriceon == 1){?>                                        
									<div class="col-sm-6">                                            
										<div class="input-group">                                                
											<div class="input-group-addon">													
												<span class="currency__symbol">													
													<?php 													
													if (!empty($postCurrency) && $classieraMultiCurrency == 'single'){														
														echo esc_html($postCurrency);													
													}
														elseif($classieraMultiCurrency == 'multi'){														
															echo classiera_Display_currency_sign($classieraTagDefault);													}else{														echo "&dollar;";													
														}													
														?>														
													</span>												
												</div>                                                
													
													<input type="text" name="post_old_price" value="<?php echo esc_attr($post_old_price); ?>" class="form-control form-control-md" placeholder="<?php esc_html_e('Regular price', 'classiera') ?>">                                            </div>                                        
												</div>										
												<?php } ?>                                    
											</div>									
												<?php $postCurrency = $redux_demo['classierapostcurrency'];?>									<?php if (!empty($postCurrency)){?>                                    
													<div class="help-block"><?php esc_html_e('Currency sign is already set as', 'classiera') ?>&nbsp;<?php echo esc_html($postCurrency); ?>&nbsp;<?php esc_html_e('Please do not use currency sign in price field. Only use numbers ex: 12345', 'classiera') ?></div>									
													<?php } ?>                                
												</div>                            
											</div><!--Ad Price-->							
											<?php } ?>							<!--ContactPhone-->							
											<?php $classieraAskingPhone = $redux_demo['phoneon'];?>							
											<?php if($classieraAskingPhone == 1){?>							
												<div class="form-group">                                
													<label class="col-sm-3 text-left flip"><?php esc_html_e('Your Phone/Mobile', 'classiera') ?> :</label>                                
													<div class="col-sm-9">                                    
														<div class="form-inline row">                                        
															<div class="col-sm-12">                                            
																<div class="input-group">                                                
																	<div class="input-group-addon">													<i class="fa fa-mobile-alt"></i>												</div>                                                
																	<input type="text" name="post_phone" value="<?php echo esc_html($post_phone); ?>" class="form-control form-control-md" placeholder="<?php esc_html_e('Enter your phone number or Mobile number', 'classiera') ?>">                                            </div>                                        </div>                                    </div>                                    
																	<div class="help-block"><?php esc_html_e('Its Not required, but if you will put phone here then it will show publicly', 'classiera') ?></div>                                
																</div>                            
															</div>							
															<?php } ?>							
															<!--ContactPhone-->								
																					
							</div>						<!--AdsDetails-->						
							<!--CustomDetails-->						
							<div class="classieraExtraFields">						
								<?php 						
								$user_id = $category_id;
								//print_r($customCate);						
								$user_name = get_cat_name( $customCate );						
								$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
								// echo '<pre>';print_r($tag_extra_fields);echo '</pre>';
								$wpcrown_category_custom_field_option = $tag_extra_fields[$customCate]['category_custom_fields'];						
								$wpcrown_category_custom_field_type = $tag_extra_fields[$customCate]['category_custom_fields_type'];					
								if(empty($wpcrown_category_custom_field_option)) {															
									$catobject = get_category($customCate,false);							
									$parentcat = $catobject->category_parent;							
									if(!empty($parentcat) || $parentcat != 0){								
										$wpcrown_category_custom_field_option = $tag_extra_fields[$parentcat]['category_custom_fields'];								
									$wpcrown_category_custom_field_type = $tag_extra_fields[$parentcat]['category_custom_fields_type'];							
								}						
								}						
								?>						
								<div class="form-main-section extra-fields wrap-content" id="cat-<?php echo esc_attr($user_id); ?>" 
									<?php if($currCatID == $user_id) { ?>style="display: block;"<?php  } else { ?>style="display: none;"<?php } ?>>							
									<?php $wpcrown_custom_fields = get_post_meta($current_post, 'custom_field', true);?>							
									<h4 class="text-uppercase border-bottom"><?php esc_html_e('Extra Fields For', 'classiera') ?>&nbsp;<?php echo esc_attr($user_name);?> :</h4>							

																	
																
			</div>						
		</div>						
		<!--CustomDetails-->						
		<!-- add photos and media -->						
		<div class="form-main-section media-detail">							
			<?php							
			/*Image Count Check*/							
			global $redux_demo;							
			global $wpdb;							
			$paidIMG = $redux_demo['premium-ads-limit'];							
			$regularIMG = $redux_demo['regular-ads-limit'];															
			$current_user = wp_get_current_user();													
			$userID = $current_user->ID;							
			$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id = $author ORDER BY id DESC" );							
			$totalAds = 0;							
			$usedAds = 0;							
			$availableADS = '';							
			if(!empty($result)){								
				foreach ( $result as $info ) {									
					$availAds = $info->ads;									
					if(is_numeric($availAds)){										
						$totalAds += $info->ads;										
						$usedAds += $info->used;									
					}																	
				}							
			}							
					
					$availableADS = $totalAds-$usedAds;														
					if($availableADS == "0" || empty($result)){								
						$imageLimit = $regularIMG;							
					}else{								
						$imageLimit = $paidIMG;							}							
						?>							
						<h4 class="text-uppercase border-bottom"><?php esc_html_e('Image And Video', 'classiera') ?> :</h4>							<div class="form-group">								
							<label class="col-sm-3 text-left flip"><?php esc_html_e('Photos and Video for your ad', 'classiera') ?> :</label>								
							<div class="col-sm-9">									
								<div class="classiera-dropzone-heading">                                        
									<i class="classiera-dropzone-heading-text fa fa-cloud-upload-alt" aria-hidden="true"></i>                                       
									 <div class="classiera-dropzone-heading-text">                                            
									 	<p><?php esc_html_e('Select files to Upload / Drag and Drop Files', 'classiera') ?></p>                                            
									 	<p><?php esc_html_e('You can add multiple images. Ads With photo get 50% more Responses', 'classiera') ?></p>											
									 	<p class="limitIMG"><?php esc_html_e('You can upload', 'classiera') ?>&nbsp;<?php echo esc_attr($imageLimit); ?>&nbsp;<?php esc_html_e('Images maximum.', 'classiera') ?></p>                                        
									 </div>                                    
									</div><!--classiera-dropzone-heading-->									
									<div id="mydropzone" class="classiera-image-upload clearfix" data-maxfile="<?php echo esc_attr($imageLimit); ?>">										
										<!--PreviousImages-->										
										<?php										
										$imageCount = 0;										
										$imgargs = array(											'post_parent' => $current_post,											'post_status' => 'inherit',											'post_type'   => 'attachment', 											'post_mime_type'   => 'image', 											'order' => 'ASC',											'orderby' => 'menu_order ID',										);										$attachments = get_children($imgargs);										
										if($attachments){										
											foreach($attachments as $att_id => $attachment){												
												$attachment_ID = $attachment->ID;												
												$full_img_url = wp_get_attachment_url($attachment->ID);										?>											
												<div id="<?php echo esc_attr($attachment_ID); ?>" class="edit-post-image-block">												
													<img class="edit-post-image" src="<?php echo esc_url($full_img_url);?>" />												
													<div class="remove-edit-post-image">													
														<i class="fas fa-minus-square"></i>													
														<span class="remImage"><?php esc_html_e('Remove', 'classiera');?></span>													
														<input type="hidden" name="" value="<?php echo esc_attr($attachment_ID); ?>">												
													</div><!--remove-edit-post-image-->											
												</div>											
												<?php $imageCount++;?>										
												<?php }?>										
												<?php }?>										
												<!--PreviousImages-->										
												<?php 										
												$imageCounter = $imageLimit-$imageCount;										
												for ($i = 0; $i < $imageCounter; $i++){										?>                                        
													<div class="classiera-image-box">                                            
														<div class="classiera-upload-box">												
															<input name="image-count" type="hidden" value="<?php echo esc_attr($imageCount); ?>" />                                                
															<input class="classiera-input-file imgInp" id="imgInp<?php echo esc_attr($i); ?>" type="file" name="upload_attachment[]">												                                                
															<label class="img-label" for="imgInp<?php echo esc_attr($i); ?>"><i class="fas fa-plus-square"></i></label>                                                

															<div class="classiera-image-preview"> 
															<img class="my-image" src="">                                                    
															<span class="remove-img">
																<i class="fas fa-times-circle"></i></span>

														</div>                                            </div>                                        
													</div>										
													<?php } ?>																				
													<input type="hidden" name="classiera_featured_img" id="classiera_featured_img" value="">                                    
												</div>									<!--Video-->									
												<?php 									
												$classiera_video_postads = $redux_demo['classiera_video_postads'];									
												if($classiera_video_postads == 1){									?>                                    
													<div class="iframe">                                        
														<div class="iframe-heading">                                            
															<i class="fa fa-video-camera"></i>                                           
															 <span><?php esc_html_e('Put here iframe or video url.', 'classiera') ?></span>                                        </div>                                        
															 <textarea class="form-control" name="video" id="video-code" placeholder="<?php esc_html_e('Put here iframe or video url.', 'classiera') ?>">
															 	<?php echo esc_html($post_video); ?></textarea>                                        
															 	<div class="help-block">                                            
															 		<p><?php esc_html_e('Add iframe or video URL (iframe 710x400) (youtube, vimeo, etc)', 'classiera') ?></p>
															 	</div>                                   
															 	</div>									
															 	<?php } ?>									
															 	<!--Video-->								
															 </div><!--col-sm-9-->							
															</div>						
														</div>						<!-- add photos and media -->						
														<!-- post location -->						
														<?php 						
														$classiera_ad_location_remove = $redux_demo['classiera_ad_location_remove'];						
														if($classiera_ad_location_remove == 1){						
															?>						
															<div class="form-main-section post-location">							
																<?php 														
																$country_posts = get_posts( array( 'post_type' => 'countries', 'posts_per_page' => -1, 'suppress_filters' => 0 ) );							
																if(!empty($country_posts)){							?>							
																	<h4 class="text-uppercase border-bottom"><?php esc_html_e('Ad Location', 'classiera') ?> :</h4>							
																	<?php }														if(!empty($country_posts)){								
																		?>							
																		<!--Select Country-->							
																		<div class="form-group">                                
																			<label class="col-sm-3 text-left flip">
																				<?php esc_html_e('Select Country', 'classiera') ?>: <span>*</span></label>                                
																				<div class="col-sm-6">                                    
																					<div class="inner-addon right-addon">                                        
																						<i class="form-icon right-form-icon fa fa-angle-down"></i>                                        
						<select name="post_location" id="post_location" class="form-control form-control-md">                                            
							<option <?php if(empty($post_location)){ echo "selected"; }?> disabled value=""><?php esc_html_e('Select Country', 'classiera'); ?></option>                                            
							<?php 											
							foreach( $country_posts as $country_post ){												
								if($post_location == $country_post->post_title){													
									$getStatesbyID = $country_post->ID;												
								}												
								?>												
								<option <?php if($post_location == $country_post->post_title){ echo "selected"; }?> value="<?php echo esc_attr($country_post->ID); ?>"><?php echo esc_html($country_post->post_title); ?></option>												

								<?php											}											?>                                        
						</select>                                    
					</div>                                
				</div>                            
			</div>							
			<?php } ?>							
			<!--Select Country-->								
			<!--Select States-->							
			<?php 							
			$locationsStateOn = $redux_demo['location_states_on'];							
			if($locationsStateOn == 1){							?>							
				<div class="form-group">                               
			 <label class="col-sm-3 text-left flip"><?php esc_html_e('Select State', 'classiera') ?>: <span>*</span></label>                                
			 <div class="col-sm-6">                                    
			 	<div class="inner-addon right-addon">                                        
			 		<i class="form-icon right-form-icon fa fa-angle-down"></i>										
			 		<select name="post_state" id="post_state" class="selectState form-control form-control-md" required>											
			 			<option value="" disabled>												
			 				<?php esc_html_e('Select State', 'classiera'); ?>											
			 		</option>											
			 		<?php 											
			 		if (function_exists('classiera_get_states_by_country_id')) {												
			 			echo classiera_get_states_by_country_id($getStatesbyID, $post_state);											
			 		}																						
			 		?>										
			 	</select>                                    
			 </div>                                
			</div>                            
		</div>							
		<?php } ?>							
		<!--Select States-->							
		<!--Select City-->							
		<?php 							
		$locationsCityOn= $redux_demo['location_city_on'];							
		if($locationsCityOn == 1){							?>							
			<div class="form-group">                                
				<label class="col-sm-3 text-left flip"><?php esc_html_e('Select City', 'classiera'); ?>: <span>*</span></label>                                
				<div class="col-sm-6">                                    
					<div class="inner-addon right-addon">                                        
						<i class="form-icon right-form-icon fa fa-angle-down"></i>										
						<select name="post_city" id="post_city" class="selectCity form-control form-control-md" required>											<option disabled>												
							<?php esc_html_e('Select City', 'classiera'); ?>											
						</option>											
						<?php 											
						if (function_exists('classiera_get_cities_by_state')) {												
							echo classiera_get_cities_by_state($post_state, $post_city);											
						}																						
						?>										
					</select>                                    
				</div>                                
			</div>                            
		</div>							
		<?php } ?>							
		<!--Select City-->
									
		<!--Address-->							
		<?php if($classieraAddress == 1){?>							
			<div class="form-group">                                
				<label class="col-sm-3 text-left flip"><?php esc_html_e('Address', 'classiera'); ?> : <span>*</span></label>                                
				<div class="col-sm-9">                                    
					<input id="address" type="text" name="address" value="<?php echo esc_html($post_address); ?>" class="form-control form-control-md" placeholder="<?php esc_html_e('Address or City', 'classiera') ?>" required>                                </div>                            
				</div>							
				<?php } ?>							
				<!--Address-->							
				<!--Google Value-->							
				<div class="form-group">								
					<?php 									
					$googleFieldsOn = $redux_demo['google-lat-long']; 									
					if($googleFieldsOn == 1){								
						?>                                
						<label class="col-sm-3 text-left flip"><?php esc_html_e('Set Latitude & Longitude', 'classiera') ?> : <span>*</span></label>								
					<?php } ?>                                
						<div class="col-sm-9">								
							<?php 									
							$googleFieldsOn = $redux_demo['google-lat-long']; 									
							if($googleFieldsOn == 1){								
								?>                                    
								<div class="form-inline row">                                        
									<div class="col-sm-6">                                            
										<div class="input-group">                                                
											<div class="input-group-addon"><i class="fas fa-map-marker-alt"></i></div>                                                
											<input type="text" name="latitude" id="latitude" value="<?php echo esc_attr($post_latitude); ?>" class="form-control form-control-md" placeholder="<?php esc_html_e('Latitude', 'classiera') ?>" required>                                            
										</div>                                        
									</div>                                        
									<div class="col-sm-6">                                            
										<div class="input-group">                                                
											<div class="input-group-addon"><i class="fas fa-map-marker-alt"></i></div>                                                
											<input type="text" name="longitude" value="<?php echo esc_attr($post_longitude); ?>" id="longitude" class="form-control form-control-md" placeholder="<?php esc_html_e('Longitude', 'classiera') ?>" required>                                            
										</div>                                        
									</div>                                    
								</div>									<?php }
								else{ ?>										
									<input type="hidden" id="latitude" name="latitude" value="<?php echo esc_attr($post_latitude); ?>">										
									<input type="hidden" id="longitude" name="longitude" value="<?php echo esc_attr($post_longitude); ?>">									<?php } ?>									
									<?php 									
									$googleMapadPost = $redux_demo['google-map-adpost'];									
									if($googleMapadPost == 1){									?>                                    
										<div id="post-map" class="submitMAp">                                        
											<div id="map-canvas"></div>										
											<script type="text/javascript">								
												jQuery(document).ready(function($) {									
													var geocoder;									
													var map;									
													var marker;									
													var geocoder = new google.maps.Geocoder();									
													function geocodePosition(pos) {											
														geocoder.geocode({											
															latLng: pos										
														}, function(responses) {										
															if (responses && responses.length > 0) {										  updateMarkerAddress(responses[0].formatted_address);										} else {										  updateMarkerAddress('Cannot determine address at this location.');										}									  
														});									
													}									
													function updateMarkerPosition(latLng) {									  
														jQuery('#latitude').val(latLng.lat());									  
														jQuery('#longitude').val(latLng.lng());									
													}									
													function updateMarkerAddress(str) {									  
														jQuery('#address').val(str);									
													}									
														function initialize() {									  
															var latlng = new google.maps.LatLng(<?php echo esc_attr($post_latitude); ?>, <?php echo esc_attr($post_longitude); ?>);									  
															var mapOptions = {										
																zoom: <?php echo esc_attr($mapZoom); ?>,										center: latlng									  
															}									  
															map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);									  
														geocoder = new google.maps.Geocoder();									 
														 marker = new google.maps.Marker({										
														 position: latlng,										
														map: map,										
													draggable: true									  
												});									  
											// Add dragging event listeners.									  google.maps.event.addListener(marker, 'dragstart', function() {										updateMarkerAddress('Dragging...');									  });									  									  google.maps.event.addListener(marker, 'drag', function() {										updateMarkerPosition(marker.getPosition());									  });									  									  google.maps.event.addListener(marker, 'dragend', function() {										geocodePosition(marker.getPosition());									  });									}									google.maps.event.addDomListener(window, 'load', initialize);									jQuery(document).ready(function() {							         									  initialize();									          									  jQuery(function(){										jQuery("#address").autocomplete({										  //This bit uses the geocoder to fetch address values										  source: function(request, response) {											geocoder.geocode( {'address': request.term }, function(results, status) {											  response(jQuery.map(results, function(item) {												return {												  label:  item.formatted_address,												  value: item.formatted_address,												  latitude: item.geometry.location.lat(),												  longitude: item.geometry.location.lng()												}											  }));											})										  },										  //This bit is executed upon selection of an address										  select: function(event, ui) {											jQuery("#latitude").val(ui.item.latitude);											jQuery("#longitude").val(ui.item.longitude);											var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);											marker.setPosition(location);											map.setZoom(16);											map.setCenter(location);										  }										});									  });									  									  //Add listener to marker for reverse geocoding									  google.maps.event.addListener(marker, 'drag', function() {										geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {										  if (status == google.maps.GeocoderStatus.OK) {											if (results[0]) {											  jQuery('#address').val(results[0].formatted_address);											  jQuery('#latitude').val(marker.getPosition().lat());											  jQuery('#longitude').val(marker.getPosition().lng());											}										  }										});									  });							  									});								});									
										</script>                                    
									</div>									
									<?php } ?>                                
								</div>                            
							</div>							
							<!--Google Value-->						
						</div>						
						<?php } ?>						
						<!-- post location -->						
						<!--Select Ads Type-->						
						<div class="form-main-section post-type">							
							<h4 class="text-uppercase border-bottom"><?php esc_html_e('Select Ad Post Type', 'classiera') ?> :</h4>							<p class="help-block"><?php esc_html_e('Select an Option to make your ad featured or regular', 'classiera') ?></p>							
							<div class="form-group">							
								<?php							/*Get Current Ad Type*/							
								$featured_post = "0";							
								$post_price_plan_activation_date = get_post_meta($current_post, 'post_price_plan_activation_date', true);							
								$post_price_plan_expiration_date = get_post_meta($current_post, 'post_price_plan_expiration_date', true);							
								$post_price_plan_expiration_date_noarmal = get_post_meta($current_post, 'post_price_plan_expiration_date_normal', true);							
								$todayDate = strtotime(date('m/d/Y h:i:s'));							
								$expireDate = $post_price_plan_expiration_date;							
								if(!empty($post_price_plan_activation_date)) {								
									if(($todayDate < $expireDate) or $post_price_plan_expiration_date == 0) {									$featured_post = "1";								
								}							
								}							/*Get Current Ad Type*/							
								?>							
								<?php if($featured_post == "1") { ?>							
									<div class="col-sm-4 col-md-3 col-lg-3 active-post-type">								
										<h3 class="text-uppercase">									
											<?php esc_html_e('Featured:', 'classiera') ?>								
										</h3>								
										<div class="radio">									
											<input type="radio" id="feature-post" name="feature-post" value="featured" class="form-checkbox" checked><?php esc_html_e('Expiry:', 'classiera') ?> <?php 
											if($post_price_plan_expiration_date_noarmal == 0) 
												{ ?> <?php 
													esc_html_e( 'Never', 'classiera' ); ?> <?php } else { 
														echo esc_html($post_price_plan_expiration_date_noarmal); } ?>								
													</div>							
												</div>							
												<?php }else{ 
													?>							
													<?php 															
													$regular_ads = $redux_demo['regular-ads'];								
													$classieraRegularAdsDays = $redux_demo['ad_expiry'];								
													$current_user = wp_get_current_user();								
													$userID = $current_user->ID;								
													$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id = $userID ORDER BY id DESC" );								
													$totalAds = '';								
													$usedAds = '';								
													$availableADS = '';								
													$planCount = 0;									
													if(!empty($result)){										
														foreach ( $result as $info ) {																						
															$totalAds = $info->ads;											
															$usedAds = $info->used;																						
															$name = $info->plan_name;											
															if($totalAds == 'unlimited'){												
																$name = esc_html__( 'Unlimited for Admin Only', 'classiera' );												$availableADS = 'unlimited';											}else{												$availableADS = $totalAds-$usedAds;											}											
																if($availableADS != 0 || $totalAds == 'unlimited'){											?>												
																	<div class="col-sm-4 col-md-3 col-lg-3">													
																		<div class="post-type-box">														
																			<h3 class="text-uppercase">															
																				<?php echo esc_html($name); ?>														
																			</h3>														
																			<p><?php esc_html_e('Total Ads Available', 'classiera') ?> : <?php echo esc_attr($availableADS); ?></p>														
																			<p><?php esc_html_e('Used Ads with this Plan', 'classiera') ?> : <?php echo esc_attr($usedAds); ?></p>														
																			<div class="radio">															
																				<input id="featured<?php echo esc_attr($planCount); ?>" type="radio" name="classiera_post_type" value="<?php echo esc_attr($info->id); ?>">															<label for="featured<?php echo esc_attr($planCount); ?>"><?php esc_html_e('Select', 'classiera') ?></label>														
																			</div>													
																		</div>												
																	</div>											
																	<?php											
																}											
																$planCount++;										
															}									
														}							
														?>								
														<?php if($regular_ads == 1 ){?>									
															<div class="col-sm-4 col-md-3 col-lg-3 active-post-type">										<div class="post-type-box">											
																<h3 class="text-uppercase"><?php esc_html_e('Regular', 'classiera') ?></h3>											
																<p><?php esc_html_e('For', 'classiera') ?>&nbsp;<?php echo esc_attr($classieraRegularAdsDays); ?>&nbsp;<?php esc_html_e('days', 'classiera') ?></p>											
																<div class="radio">												
																	<input id="regular" type="radio" name="classiera_post_type" value="classiera_regular" checked>												<label for="regular"><?php esc_html_e('Select', 'classiera') ?></label>											
																</div>											
																<input type="hidden" name="regular-ads-enable" value=""  >										
															</div>									
															</div>								
															<?php } ?>									<!--Pay Per Post Per Category Base-->								
															<div class="col-sm-4 col-md-3 col-lg-3 classieraPayPerPost">									
																<div class="post-type-box">										
																	<h3 class="text-uppercase">											
																		<?php esc_html_e('Featured Ad', 'classiera') ?>											<p class="classieraPPP"></p>											
																		<input id="payperpost" type="radio" name="classiera_post_type" value="payperpost">											
																		<label for="payperpost">											<?php esc_html_e('select', 'classiera') ?>											
																	</label>										
																	</h3>									
																</div>								
															</div>								
															<!--Pay Per Post Per Category Base-->							
															<?php } ?>							
														</div>						
													</div>						
													<!--Select Ads Type-->						
													<?php 						
													$featured_plans = $redux_demo['featured_plans'];						
													if(!empty($featured_plans)){							
														if($featuredADS == "0" || empty($result)){						?>						<div class="row">                            
															<div class="col-sm-9">                                
																<div class="help-block terms-use">                                    
																	<?php esc_html_e('Currently you have no active plan for featured ads. You must purchase a', 'classiera') ?> <strong><a href="<?php echo esc_url($featured_plans); ?>" target="_blank"><?php esc_html_e('Featured Pricing Plan', 'classiera') ?></a></strong> <?php esc_html_e('to be able to publish a Featured Ad.', 'classiera') ?>                                
																</div>                            
																</div>                        
															</div>						
															<?php }} ?>						
															<div class="row">                            
																<div class="col-sm-9">                                
																	<div class="help-block terms-use">                                    
																		<?php esc_html_e('By clicking "Update Ad", you agree to our', 'classiera') ?> <a href="<?php echo esc_url($termsandcondition); ?>"><?php esc_html_e('Terms of Use', 'classiera') ?></a> <?php esc_html_e('and acknowledge that you are the rightful owner of this item', 'classiera') ?>                                
																	</div>                            
																</div>                        
															</div>						
															<div class="form-main-section">                            
																<div class="col-sm-4">								
																	<input type="hidden" class="regular_plan_id" name="regular_plan_id" value="">								<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>								
																	<input type="hidden" name="submitted" id="submitted" value="true">                                
																	<button class="post-submit btn btn-primary sharp btn-md btn-style-one btn-block" type="submit" name="op" value="<?php esc_html_e('Update Ad', 'classiera') ?>"><?php esc_html_e('Update Ad', 'classiera') ?></button>                            
																</div>                        
															</div>					
														</form>
						</div>
												</div><!--submit-post-->			
											</div><!--col-lg-9-->		
										</div><!--row-->	
									</div><!--container-->
								</section><!--user-pages-->
<?php endwhile; ?>
<?php get_footer(); ?>
<?php
/**
 * Template name: Submit Ad
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */

if ( !is_user_logged_in() ) {
	global $redux_demo; 
	$login = $redux_demo['login'];
	wp_redirect( $login ); exit;
}
$postTitleError = '';
$post_priceError = '';
$catError = '';
$featPlanMesage = '';
$postContent = '';
$hasError ='';
$allowed ='';
$caticoncolor="";
$classieraCatIconCode ="";
$category_icon="";
$category_icon_color="";
global $redux_demo;
$featuredADS = 0;
$primaryColor = $redux_demo['color-primary'];
$googleFieldsOn = $redux_demo['google-lat-long'];
$classieraLatitude = $redux_demo['contact-latitude'];
$classieraLongitude = $redux_demo['contact-longitude'];
$classieraAddress = $redux_demo['classiera_address_field_on'];
$postCurrency = $redux_demo['classierapostcurrency'];
$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
$termsandcondition = $redux_demo['termsandcondition'];
$classieraProfileURL = $redux_demo['profile'];
$classiera_ads_typeOn = $redux_demo['classiera_ads_type'];
$ads_length = $redux_demo['ads-length'];
	
$templateGetCredits = 'template-get-credits.php';
$classieraGetCredits = getTplPageURL($templateGetCredits);

global $current_user;
wp_get_current_user();
$userID = $current_user->ID;
$query = new WP_Query(array('post_type' => 'post', 'posts_per_page' =>'-1', 'p' => $_GET['post']) );

if( isset($_GET['post'])){
	$cur_post_id = $_GET['post'];
	$author = get_post_field( 'post_author', $cur_post_id );
	if(current_user_can('administrator') ){
		
	}else{
		if($author != $userID) {
			wp_redirect( home_url() ); exit;
		}
	}
} else{
	wp_redirect( home_url() ); exit;
}

if(isset($_POST['postTitle'])){

	if(trim($_POST['postTitle']) != '' && $_POST['classiera-main-cat-field'] != ''){		
		if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
			
			if(empty($_POST['postTitle'])){
				$postTitleError =  esc_html__( 'Please enter a title.', 'classiera' );
				$hasError = true;
			}else{
				$postTitle = trim($_POST['postTitle']);
			}
			if(empty($_POST['classiera-main-cat-field'])){
				$catError = esc_html__( 'Please select a category', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['postContent'])){
				$catError = esc_html__( 'Please enter description', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['post_tags'])){
				$catError = esc_html__( 'Please enter tag', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['post_phone'])){
				$catError = esc_html__( 'Please enter phone', 'classiera' );
				$hasError = true;
			}

			if(empty($_POST['second_phone'])){
				$catError = esc_html__( 'Please enter phone', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['nationality'])){
				$catError = esc_html__( 'Select Your Nationality', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['user_age'])){
				$catError = esc_html__( 'Select Your Age', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['hair_color'])){
				$catError = esc_html__( 'Select Your Hair Color', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['eyes_color'])){
				$catError = esc_html__( 'Select Your Eyes Color', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['ethnicity'])){
				$catError = esc_html__( 'Select Your Ethnicity', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['height_feet'])){
				$catError = esc_html__( 'Select Your Height in Feet', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['height_inches'])){
				$catError = esc_html__( 'Select Your Height in Inches', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['weight'])){
				$catError = esc_html__( 'Select Your Weight', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['breast_type'])){
				$catError = esc_html__( 'Select Your Breast Type', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['breast_size_cup'])){
				$catError = esc_html__( 'Select Your Breast Size Cup', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['breast_size'])){
				$catError = esc_html__( 'Select Your Breast Size', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['waist_size'])){
				$catError = esc_html__( 'Select Your Waist Size', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['hips_size'])){
				$catError = esc_html__( 'Select Your Hips Size', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['dress_size'])){
				$catError = esc_html__( 'Select Your Dress Size', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['shoe_size'])){
				$catError = esc_html__( 'Select Your Shoe Size', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['pubic_area'])){
				$catError = esc_html__( 'Select Pubic Area', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['smoker'])){
				$catError = esc_html__( 'Are You a Smoker', 'classiera' );
				$hasError = true;
			}
			//Step 3
			if(empty($_POST['native_language'])){
				$catError = esc_html__( 'Select Native Language', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['private_numbers'])){
				$catError = esc_html__( 'Select Option for Private Numbers', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['sms_messages'])){
				$catError = esc_html__( 'Select Option for SMS Messages', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['private_messages'])){
				$catError = esc_html__( 'Select Option for Private Messages', 'classiera' );
				$hasError = true;
			}
			//Step 4
			if(empty($_POST['disabled_friendly'])){
				$catError = esc_html__( 'Select Option for Disabled Friendly', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['drinks_supplied'])){
				$catError = esc_html__( 'Select Option for Drinks Supplied', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['showers_available'])){
				$catError = esc_html__( 'Select Option for Showers Available', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['can_travel'])){
				$catError = esc_html__( 'Select Option for Available to Travel', 'classiera' );
				$hasError = true;
			}
			
			if(empty($_FILES['upload_attachment']))
			{
				$catError = esc_html__( 'Please Select Image', 'classiera' );
				$hasError = true;
			}
			//Image Count check//
			$userIMGCount = $_POST['image-count'];
			$files = $_FILES['upload_attachment'];
			$count = $files['name'];
			$filenumber = count($count);			
			if($filenumber > $userIMGCount){
				$imageError = esc_html__( 'You selected Images Count is exceeded', 'classiera' );
				$hasError = true;
			}
			//Image Count check//

			if($hasError != true && !empty($_POST['classiera_post_type']) || isset($_POST['regular-ads-enable'])) {
				$classieraPostType = $_POST['classiera_post_type'];
				//Set Post Status//
				if(is_super_admin() ){
					$postStatus = 'publish';
				}elseif(!is_super_admin()){
					if($redux_demo['post-options-on'] == 1){
						$postStatus = 'private';
					}else{
						$postStatus = 'publish';
					}
					if($classieraPostType == 'payperpost'){
						$postStatus = 'pending';
					}
				}
				//Set Post Status//
				//Check Category//
				$classieraMainCat = $_POST['classiera-main-cat-field'];
				if(empty($classieraCategory)){
					$classieraCategory = $classieraMainCat;
				}
				//print_r($classieraCategory);die;
				//Check Category//
				//Setup Post Data//
				$post_information = array(
					'post_title' => esc_attr(strip_tags($_POST['postTitle'])),			
					'post_content' => strip_tags($_POST['postContent'], '<h1><h2><h3><strong><b><ul><ol><li><i><a><blockquote><center><embed><iframe><pre><table><tbody><tr><td><video><br>'),
					'post-type' => 'post',
					'post_category' => array($classieraMainCat/*, $classieraChildCat, $classieraThirdCat*/),
					'tags_input'	=> explode(',', $_POST['post_tags']),
					'tax_input' => array(
						// 'location' => $_POST['post_location']
					),
					'comment_status' => 'open',
					'ping_status' => 'open',
					'post_status' => $postStatus
				);
				//print_r($post_information);die;
				// $post_id = wp_insert_post($post_information);
				$post_id = $cur_post_id;

				$featuredIMG = $_POST['classiera_featured_img'];
				
				/*Get Country Name*/
				if(isset($_POST['post_location'])){
					$postLo = $_POST['post_location'];
					$allCountry = get_posts( array( 'include' => $postLo, 'post_type' => 'countries', 'posts_per_page' => -1, 'suppress_filters' => 0, 'orderby'=>'post__in' ) );
					foreach( $allCountry as $country_post ){
						$postCounty = $country_post->post_title;
					}
				}				
				$poststate = $_POST['post_state'];
				$postCity = $_POST['post_city'];
				
				/*If We are using CSC Plugin*/
				if(isset($_POST['post_category_type'])){
					update_post_meta($post_id, 'post_category_type', esc_attr( $_POST['post_category_type'] ) );
				}	
				if(isset($_POST['classiera_sub_fields'])){
					$classiera_sub_fields = $_POST['classiera_sub_fields'];
					update_post_meta($post_id, 'classiera_sub_fields', $classiera_sub_fields);
				}
				if(isset($_POST['classiera_CF_Front_end'])){
					$classiera_CF_Front_end = $_POST['classiera_CF_Front_end'];
					update_post_meta($post_id, 'classiera_CF_Front_end', $classiera_CF_Front_end);
				}
				
				/*  update AdsType */
				update_post_meta($post_id,'ads_type_selected',$_POST['ads_type_selected']);
				/* update AdsType */

				update_post_meta($post_id, 'post_perent_cat', $classieraMainCat, $allowed);
				// update_post_meta($post_id, 'post_child_cat', $classieraChildCat, $allowed);				
				// update_post_meta($post_id, 'post_inner_cat', $classieraThirdCat, $allowed);
				
				if(isset($_POST['post_phone'])){
					update_post_meta($post_id, 'post_phone', $_POST['post_phone'], $allowed);
				}
				// Second Phone Number
				if(isset($_POST['second_phone'])){
					update_post_meta($post_id, 'second_phone', $_POST['second_phone'], $allowed);
				}
				// Nationality
				if(isset($_POST['nationality'])){
					update_post_meta($post_id, 'nationality', $_POST['nationality'], $allowed);
				}
				//User Age
				if(isset($_POST['user_age'])){
					update_post_meta($post_id, 'user_age', $_POST['user_age'], $allowed);
				}
				//Hair Color
				if(isset($_POST['hair_color'])){
					update_post_meta($post_id, 'hair_color', $_POST['hair_color'], $allowed);
				}
				//Eyes Color
				if(isset($_POST['eyes_color'])){
					update_post_meta($post_id, 'eyes_color', $_POST['eyes_color'], $allowed);
				}
				//Ethnicity
				if(isset($_POST['ethnicity'])){
					update_post_meta($post_id, 'ethnicity', $_POST['ethnicity'], $allowed);
				}
				//Height Feet
				if(isset($_POST['height_feet'])){
					update_post_meta($post_id, 'height_feet', $_POST['height_feet'], $allowed);
				}
				//Height Inches
				if(isset($_POST['height_inches'])){
					update_post_meta($post_id, 'height_inches', $_POST['height_inches'], $allowed);
				}
				//Weight
				if(isset($_POST['weight'])){
					update_post_meta($post_id, 'weight', $_POST['weight'], $allowed);
				}
				//Breast Size
				if(isset($_POST['breast_type'])){
					update_post_meta($post_id, 'breast_type', $_POST['breast_type'], $allowed);
				}
				//Breast Size Cup
				if(isset($_POST['breast_size_cup'])){
					update_post_meta($post_id, 'breast_size_cup', $_POST['breast_size_cup'], $allowed);
				}
				//Breast Size Letters
				if(isset($_POST['breast_size'])){
					update_post_meta($post_id, 'breast_size', $_POST['breast_size'], $allowed);
				}
				//Waist Size
				if(isset($_POST['waist_size'])){
					update_post_meta($post_id, 'waist_size', $_POST['waist_size'], $allowed);
				}
				//Hips Size
				if(isset($_POST['hips_size'])){
					update_post_meta($post_id, 'hips_size', $_POST['hips_size'], $allowed);
				}
				//Dress Size
				if(isset($_POST['dress_size'])){
					update_post_meta($post_id, 'dress_size', $_POST['dress_size'], $allowed);
				}
				//Shoe Size
				if(isset($_POST['shoe_size'])){
					update_post_meta($post_id, 'shoe_size', $_POST['shoe_size'], $allowed);
				}
				//Pubic Area
				if(isset($_POST['pubic_area'])){
					update_post_meta($post_id, 'pubic_area', $_POST['pubic_area'], $allowed);
				}
				//Smoker
				if(isset($_POST['smoker'])){
					update_post_meta($post_id, 'smoker', $_POST['smoker'], $allowed);
				}
				//Native Language
				if(isset($_POST['native_language'])){
					update_post_meta($post_id, 'native_language', $_POST['native_language'], $allowed);
				}
				//Language 1
				if(isset($_POST['language_1'])){
					update_post_meta($post_id, 'language_1', $_POST['language_1'], $allowed);
				}
				//Language 2
				if(isset($_POST['language_2'])){
					update_post_meta($post_id, 'language_2', $_POST['language_2'], $allowed);
				}
				//Language 1 Level
				if(isset($_POST['language_1_level'])){
					update_post_meta($post_id, 'language_1_level', $_POST['language_1_level'], $allowed);
				}
				//Language 2 Level
				if(isset($_POST['language_2_level'])){
					update_post_meta($post_id, 'language_2_level', $_POST['language_2_level'], $allowed);
				}
				//Private Numbers
				if(isset($_POST['private_numbers'])){
					update_post_meta($post_id, 'private_numbers', $_POST['private_numbers'], $allowed);
				}
				//SMS Messages
				if(isset($_POST['sms_messages'])){
					update_post_meta($post_id, 'sms_messages', $_POST['sms_messages'], $allowed);
				}
				//Private Messages
				if(isset($_POST['private_messages'])){
					update_post_meta($post_id, 'private_messages', $_POST['private_messages'], $allowed);
				}
				//Disabled Friendly
				if(isset($_POST['disabled_friendly'])){
					update_post_meta($post_id, 'disabled_friendly', $_POST['disabled_friendly'], $allowed);
				}
				//Drinks Supplied
				if(isset($_POST['drinks_supplied'])){
					update_post_meta($post_id, 'drinks_supplied', $_POST['drinks_supplied'], $allowed);
				}
				//Showers Available
				if(isset($_POST['showers_available'])){
					update_post_meta($post_id, 'showers_available', $_POST['showers_available'], $allowed);
				}
				//Available to Travel
				if(isset($_POST['can_travel'])){
					update_post_meta($post_id, 'can_travel', $_POST['can_travel'], $allowed);
				}

				//Prices
				if(isset($_POST['fifteen_min_euro'])){
					update_post_meta($post_id, 'fifteen_min_euro', $_POST['fifteen_min_euro'], $allowed);
				}
				if(isset($_POST['fifteen_min_pound'])){
					update_post_meta($post_id, 'fifteen_min_pound', $_POST['fifteen_min_pound'], $allowed);
				}
				if(isset($_POST['thirty_min_euro'])){
					update_post_meta($post_id, 'thirty_min_euro', $_POST['thirty_min_euro'], $allowed);
				}
				if(isset($_POST['thirty_min_pound'])){
					update_post_meta($post_id, 'thirty_min_pound', $_POST['thirty_min_pound'], $allowed);
				}
				if(isset($_POST['fourty_five_min_euro'])){
					update_post_meta($post_id, 'fourty_five_min_euro', $_POST['fourty_five_min_euro'], $allowed);
				}
				if(isset($_POST['fourty_five_min_pound'])){
					update_post_meta($post_id, 'fourty_five_min_pound', $_POST['fourty_five_min_pound'], $allowed);
				}
				if(isset($_POST['one_hour_euro'])){
					update_post_meta($post_id, 'one_hour_euro', $_POST['one_hour_euro'], $allowed);
				}
				if(isset($_POST['one_hour_pound'])){
					update_post_meta($post_id, 'one_hour_pound', $_POST['one_hour_pound'], $allowed);
				}
				if(isset($_POST['full_day_euro'])){
					update_post_meta($post_id, 'full_day_euro', $_POST['full_day_euro'], $allowed);
				}
				if(isset($_POST['full_day_pound'])){
					update_post_meta($post_id, 'full_day_pound', $_POST['full_day_pound'], $allowed);
				}
				if(isset($_POST['business_date_euro'])){
					update_post_meta($post_id, 'business_date_euro', $_POST['business_date_euro'], $allowed);
				}
				if(isset($_POST['business_date_pound'])){
					update_post_meta($post_id, 'business_date_pound', $_POST['business_date_pound'], $allowed);
				}
				//Images Verified
				update_post_meta($post_id, 'images_verified', $_POST['images_verified'], $allowed);
				//Age Verified
				update_post_meta($post_id, 'age_verified', $_POST['age_verified'], $allowed);

				// update_post_meta($post_id, 'classiera_ads_type', $_POST['classiera_ads_type'], $allowed);
				update_post_meta($post_id, 'classiera_ads_status', $_POST['classiera_ads_status'], $allowed);
				update_post_meta($post_id, 'classiera_ads_statustime', $_POST['classiera_ads_statustime'], $allowed);
				if(isset($_POST['seller'])){
					update_post_meta($post_id, 'seller', $_POST['seller'], $allowed);
				} 

				update_post_meta($post_id, 'post_location', wp_kses($postCounty, $allowed));
				
				update_post_meta($post_id, 'post_state', wp_kses($poststate, $allowed));
				update_post_meta($post_id, 'post_city', wp_kses($postCity, $allowed));

				// update_post_meta($post_id, 'post_latitude', wp_kses($latitude, $allowed));

				// update_post_meta($post_id, 'post_longitude', wp_kses($longitude, $allowed));

				// update_post_meta($post_id, 'post_address', wp_kses($_POST['address'], $allowed));
				if(isset($_POST['video'])){
					update_post_meta($post_id, 'post_video', $_POST['video'], $allowed);
				}
				update_post_meta($post_id, 'featured_img', $featuredIMG, $allowed);
				
				// if(isset($_POST['item-condition'])){
				// 	update_post_meta($post_id, 'item-condition', $itemCondition, $allowed);
				// }
				update_post_meta($post_id, 'classiera_post_type', $_POST['classiera_post_type'], $allowed);
				
				if(isset($_POST['pay_per_post_product_id'])){
					update_post_meta($post_id, 'pay_per_post_product_id', $_POST['pay_per_post_product_id'], $allowed);
				}
				if(isset($_POST['days_to_expire'])){
					$date=$_POST['days_to_expire'];
					$expired_date=date('Y-m-d H:i:s', strtotime('+'.$date.' day'));
					update_post_meta($post_id, 'days_to_expire', $expired_date, $allowed);
				}
				if($classieraPostType == 'payperpost'){
					$permalink = $classieraProfileURL;
				}else{
					$permalink = get_permalink( $post_id );
				}
				
				$current_user = wp_get_current_user();
				$userID = $current_user->ID;
				$ads_cost=$_POST['ads_cost'];
				$uw_balance=$_POST['uw_balance'];
				$balance=$uw_balance-$ads_cost;
				update_user_meta($userID,'_uw_balance',$balance);
				//If Its posting featured image//
				if(trim($_POST['classiera_post_type']) != 'classiera_regular'){
					if($_POST['classiera_post_type'] == 'payperpost'){
						//Do Nothing on Pay Per Post//
					}elseif($_POST['classiera_post_type'] == 'classiera_regular_with_plan'){
						//Regular Ads Posting with Plans//
						$classieraPlanID = trim($_POST['regular_plan_id']);
						global $wpdb;
						$current_user = wp_get_current_user();
						$userID = $current_user->ID;
						$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE id = $classieraPlanID" );
						if($result){
							$tablename = $wpdb->prefix . 'classiera_plans';
							foreach ( $result as $info ){
								$newRegularUsed = $info->regular_used +1;
								$update_data = array('regular_used' => $newRegularUsed);
								$where = array('id' => $classieraPlanID);
								$update_format = array('%s');
								$wpdb->update($tablename, $update_data, $where, $update_format);
							}
						}
					}else{
						//Featured Post with Plan Ads//
						$featurePlanID = trim($_POST['classiera_post_type']);
						global $wpdb;
						$current_user = wp_get_current_user();
						$userID = $current_user->ID;
						$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE id = $featurePlanID" );
						if ($result){
							$featuredADS = 0;
							$tablename = $wpdb->prefix . 'classiera_plans';
							foreach ( $result as $info ){
								$totalAds = $info->ads;
								if (is_numeric($totalAds)){
									$totalAds = $info->ads;
									$usedAds = $info->used;
									$infoDays = $info->days;
								}								
								if($totalAds == 'unlimited'){
									$availableADS = 'unlimited';
								}else{
									$availableADS = $totalAds-$usedAds;
								}								
								if($usedAds < $totalAds && $availableADS != "0" || $totalAds == 'unlimited'){
									global $wpdb;
									$newUsed = $info->used +1;
									$update_data = array('used' => $newUsed);
									$where = array('id' => $featurePlanID);
									$update_format = array('%s');
									$wpdb->update($tablename, $update_data, $where, $update_format);
									update_post_meta($post_id, 'post_price_plan_id', $featurePlanID );

									$dateActivation = date('m/d/Y H:i:s');
									update_post_meta($post_id, 'post_price_plan_activation_date', $dateActivation );		
									
									$daysToExpire = $infoDays;
									$dateExpiration_Normal = date("m/d/Y H:i:s", strtotime("+ ".$daysToExpire." days"));
									update_post_meta($post_id, 'post_price_plan_expiration_date_normal', $dateExpiration_Normal );



									$dateExpiration = strtotime(date("m/d/Y H:i:s", strtotime("+ ".$daysToExpire." days")));
									update_post_meta($post_id, 'post_price_plan_expiration_date', $dateExpiration );
									update_post_meta($post_id, 'featured_post', "1" );
								}
							}
						}
					}
				}
				//If Its posting featured image//
				if( isset($_POST['croppedImgUrlDouble'])){
					$croppedImg = $_POST['croppedImgUrlDouble'];
					if( $croppedImg != ""){
						$file_name = basename($croppedImg);
						$fileFullPath = __DIR__ . "/temp/" . $file_name;
						$arrPath = explode("/", $fileFullPath);
						$path = "";
						for( $i = 0; $i < count($arrPath) - 4; $i++){
							$path .= $arrPath[$i] . "/";
						}
						$path .= "uploads";
						if( !file_exists($path)){
							mkdir($path, 0744);
						}
						$path .= "/" . date("Y");
						if( !file_exists($path)){
							mkdir($path, 0744);
						}
						$month = date("m");
						if( $month < 10){
							$month = "0" . $month;
						}
						$path .= "/" . $month;
						if( !file_exists($path)){
							mkdir($path, 0744);
						}

						$path_parts = pathinfo($fileFullPath);
						$type = $path_parts['extension'];
						$ret = rename($fileFullPath, $path . "/" . $post_id . "_cropped_double." . $type);
						
						$imgPath = date("Y") . "/" . date("m") . "/" . $post_id . "_cropped_double." . $type;
						$arrUrlPath = explode("/", $_SERVER['REQUEST_URI']);
						$urlPath = "";
						for( $i = 0; $i < count($arrUrlPath) - 2; $i++){
							$urlPath .= $arrUrlPath[$i] . "/";
						}
						$urlPath .= "wp-content/uploads/" . date("Y") . "/" . $month . "/" . $post_id . "_cropped_double." . $type;
						update_post_meta($post_id, 'croppedImg_Path_double', $urlPath);
					}
				}
				if( isset($_POST['croppedImgUrl'])){
					$croppedImg = $_POST['croppedImgUrl'];
					$file_name = basename($croppedImg);
					$fileFullPath = __DIR__ . "/temp/" . $file_name;
					$arrPath = explode("/", $fileFullPath);
					$path = "";
					for( $i = 0; $i < count($arrPath) - 4; $i++){
						$path .= $arrPath[$i] . "/";
					}
					$path .= "uploads";
					if( !file_exists($path)){
						mkdir($path, 0744);
					}
					$path .= "/" . date("Y");
					if( !file_exists($path)){
						mkdir($path, 0744);
					}
					$month = date("m");
					if( $month < 10){
						$month = "0" . $month;
					}
					$path .= "/" . $month;
					if( !file_exists($path)){
						mkdir($path, 0744);
					}

					$path_parts = pathinfo($fileFullPath);
					$type = $path_parts['extension'];
					$ret = rename($fileFullPath, $path . "/" . $post_id . "_cropped." . $type);
					
					$imgPath = date("Y") . "/" . date("m") . "/" . $post_id . "_cropped." . $type;
					$arrUrlPath = explode("/", $_SERVER['REQUEST_URI']);
					$urlPath = "";
					for( $i = 0; $i < count($arrUrlPath) - 2; $i++){
						$urlPath .= $arrUrlPath[$i] . "/";
					}
					$urlPath .= "wp-content/uploads/" . date("Y") . "/" . $month . "/" . $post_id . "_cropped." . $type;
					update_post_meta($post_id, 'croppedImg_Path', $urlPath);
				}
				if ( isset($_FILES['upload_attachment']) ) {
					$count = 0;
					$files = $_FILES['upload_attachment'];
					foreach ($files['name'] as $key => $value) {				
						if ($files['name'][$key]) {
							$file = array(
								'name'	 => $files['name'][$key],
								'type'	 => $files['type'][$key],
								'tmp_name' => $files['tmp_name'][$key],
								'error'	=> $files['error'][$key],
								'size'	 => $files['size'][$key]
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
					}/*Foreach*/
				}					
				wp_redirect($permalink); exit();
			}
		}
	}else{
		if(trim($_POST['postTitle']) === '') {
			$postTitleError = esc_html__( 'Please enter a title.', 'classiera' );	
			$hasError = true;
		}
		if($_POST['classiera-main-cat-field'] === '-1') {
			$catError = esc_html__( 'Please select a category.', 'classiera' );
			$hasError = true;
		} 
	}

} 
get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$featuredUsed = null;
	$featuredAds = null;
	$regularUsed = null;
	$regularAds = null;
	$curPost = get_post($cur_post_id);
?>
<style type="text/css">
	.emptyRequire{
		border: 1px solid red !important;
	}
	hr{
		margin-top: 0px;
		border-top: 1px solid #888;
	}
</style>
<div class="closeBump"></div>
<section class="user-pages">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-4">
				<?php get_template_part( 'templates/profile/userabout' ); ?>
			</div><!--col-lg-3 col-md-4-->
			<div class="col-lg-9 col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title text-uppercase"><?php esc_html_e('Edit your AD', 'classiera') ?><!-- <span class="pull-right custom-selected-cat"></span> --></h3>
					</div>
					<div class="panel-body">
						<?php 
						global $redux_demo;
						global $wpdb;
						$current_user = wp_get_current_user();
						$userID = $current_user->ID;			
						$featured_plans = $redux_demo['featured_plans'];
						$classieraRegularAdsOn = $redux_demo['regular-ads'];
						$postLimitOn = $redux_demo['regular-ads-posting-limit'];
						$regularCount = $redux_demo['regular-ads-user-limit'];
						$cUserCheck = current_user_can( 'administrator' );
						$role = $current_user->roles;
						$currentRole = $role[0];
						$classieraAllowPosts = false;
						$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id = $userID ORDER BY id DESC" );
						foreach ($result as $info){											
							$featuredAdscheck = $info->ads;											
							if (is_numeric($featuredAdscheck)){
								$featuredAds += $info->ads;
								$featuredUsed += $info->used;
							}
							$regularAdscheck = $info->regular_ads;
							if (is_numeric($regularAdscheck)){
								$regularAds += $info->regular_ads;
								$regularUsed += $info->regular_used;
							}
						}
						if (is_numeric($featuredAds) && is_numeric($featuredUsed)){
							$featuredAvailable = $featuredAds-$featuredUsed;
						}
						if (is_numeric($regularAds) && is_numeric($regularUsed)){
							$regularAvailable = $regularAds-$regularUsed;
						}
						
						$curUserargs = array(					
							'author' => $user_ID,
							'post_status' => array('publish', 'pending', 'draft', 'private', 'trash')	
						);
						$countPosts = count(get_posts($curUserargs));
						if($currentRole == "administrator"){
							$classieraAllowPosts = true;
						}else{
							if($postLimitOn == true){
								if($regularAvailable == 0 && $featuredAvailable == 0 && $countPosts >= $regularCount){
									$classieraAllowPosts = false;
								}else{
									$classieraAllowPosts = true;
								}
							}else{
								$classieraAllowPosts = true;
							}
						}				
						if($classieraAllowPosts == false){
							?>
							<div class="alert alert-warning" role="alert">
							  <strong><?php esc_html_e('Hello.', 'classiera') ?></strong><?php esc_html_e('You Ads Posts limit are exceeded, Please Purchase a Plan for posting More Ads.', 'classiera') ?>&nbsp;&nbsp;<a class="btn btn-primary btn-sm" href="<?php echo esc_url( $featured_plans ); ?>"><?php esc_html_e('Purchase Plan', 'classiera') ?></a>
							</div>
							<?php
						}elseif($classieraAllowPosts == true){
						?>
						
						<div class="submit-post clearfix">
							<form class="form-horizontal" id="primaryPostForm" method="POST" data-toggle="validator" enctype="multipart/form-data">

								<div id="smartwizard" style="display: block;" class="container-fluid">
								 
									<div class="step-container clearfix">
										<!-- Begin Step-1 -->
										<div id="step-1">
											<div class="row">
												<div class="col-sm-12 col-lg-6">
													<div class="form-group">
														<!--Category-->
														<select id="categorySelect" name="categorySelect" required>
															<!-- <option value="" selected disabled><?php esc_html_e('Choose Your Category', 'classiera'); ?></option> -->
															<?php 
																$categories = get_terms('category', array(
																'hide_empty' => 0,
																'parent' => 0,
																'order'=> 'ASC'
																) 
															);
															$curCategory = get_post_meta($cur_post_id, 'categorySelect', true);
															// echo "<option>" . $curCategory . "</option>";
															// echo($curCategory);
															foreach ($categories as $category){
																//print_r($category);
																$tag = $category->term_id;
																$classieraCatFields = get_option(MY_CATEGORY_FIELDS);
															if (isset($classieraCatFields[$tag])){
																$classieraCatIconCode = $classieraCatFields[$tag]['category_icon_code'];
																$classieraCatIcoIMG = $classieraCatFields[$tag]['your_image_url'];
																$classieraCatIconClr = $classieraCatFields[$tag]['category_icon_color'];
															}
															if (empty($classieraCatIconClr)){
																$iconColor = $primaryColor;
															} else {
																$iconColor = $classieraCatIconClr;
															}
																$category_icon = stripslashes($classieraCatIconCode);
															?>
															<option value="<?php echo esc_attr( $tag ); ?>" <?php if($curCategory == esc_attr($tag)) echo "selected";?>><?php echo esc_html(get_cat_name( $tag )); ?></option>
															<?php } ?>
														</select><!--list-unstyled-->														
														<input type="hidden" name="adstype_price" value="2" id="adstype_price">
														<input class="classiera-main-cat-field" name="classiera-main-cat-field" type="hidden" value="">
														<!--Category-->
														<!-- Nickname -->
														<?php
														$postTitle = get_the_title($cur_post_id);// get_post_meta( $cur_post_id, 'postTitle', true);
														?>
														<div class="form-group has-error has-danger">
															<input id="title" data-minlength="1" name="postTitle" type="text" class="form-control form-control-md" placeholder="<?php esc_html_e('Your Nickname', 'classiera') ?>" required value="<?= $postTitle?>">
														</div>
														<input  value="1" type="hidden" name="classiera_ads_status">
														<input  value="1" type="hidden" name="classiera_ads_statustime">
														<!-- / Nickname -->
														<!-- Age -->
														<input id="age" name="user_age" type="text" class="form-control form-control-md" placeholder="<?php esc_html_e('Enter Your Age', 'classiera') ?>" required value="<?= get_post_meta($cur_post_id, 'user_age', true);?>">
														<input type="hidden" name="age_verified" id="age_verified" value="0">
														<!-- / Age -->
													</div><!-- / Form group -->
												</div><!-- / col-sm-12 col-lg-6 -->
												

												<div class="col-sm-12 col-lg-6">
													<!--ContactPhone 1-->
													<div class="form-group">
														<input type="number" name="post_phone" class="form-control form-control-md" placeholder="<?php esc_html_e('Enter your Mobile Number', 'classiera') ?>" required value="<?= get_post_meta($cur_post_id, 'post_phone', true);?>">
														<input type="number" name="second_phone" class="form-control form-control-md" placeholder="<?php esc_html_e('Enter your Second Mobile Number', 'classiera') ?>" value="<?= get_post_meta($cur_post_id, 'second_phone', true);?>">
														<?php
														$nationality = get_post_meta($cur_post_id, 'nationality', true);
														?>
														<select name="nationality" required>
															<option value="Romanian" <?php if($nationality == 'Romanian') echo"selected";?>><?php esc_html_e('Romanian', 'classiera'); ?></option>
															<option value="Russian" <?php if($nationality == 'Russian') echo"selected";?>><?php esc_html_e('Russian', 'classiera'); ?></option>
															<option value="British" <?php if($nationality == 'British') echo"selected";?>><?php esc_html_e('British', 'classiera'); ?></option>
															<option value="Brazilian" <?php if($nationality == 'Brazilian') echo"selected";?>><?php esc_html_e('Brazilian', 'classiera'); ?></option>
														</select> 
													</div>
													<!-- / ContactPhone 1-->													
													<!-- <div class="classieraExtraFields" style="display:none;"></div> -->
												</div>


												<div class="col-sm-12">
													<div class="form-group">
														<?php
														$postContent = $curPost->post_content;
														$tags_input = implode(",", $curPost->tags_input);
														print_r($tags_input);
														?>
														<textarea name="postContent" id="description" class="form-control" data-error="<?php esc_html_e('Write description', 'classiera') ?>" required ><?= $postContent?></textarea>
														<!-- Keywords Field -->
														<input id="fav-tags" type="text" name="post_tags" class="form-control form-control-md" placeholder="<?php esc_html_e('enter keywords for better search..!', 'classiera') ?>" value="<?=$tags_input?>">
														<!-- / Keywords Field -->
													</div><!--Ad description-->
												</div>
											</div>
										</div>
										<!-- End Step-1 -->
										<!-- Begin Step-2 -->
										<div id="step-2">
											<div class="row">
												<hr>
												<div class="col-sm-12 col-lg-6">
													<div class="form-group">
														<select name="hair_color" required>
															<?php
															$colors = ["Blonde", "Black", "Brown", "Red", "Other"];
															$hair_color = get_post_meta($cur_post_id, 'hair_color', true);
															foreach ($colors as $value) {
															?>
															<option value="<?=$value?>" <?php if($value == $hair_color) echo "selected";?>><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

														<select name="eyes_color" required>
															<?php
															$colors = ["Blue", "Black", "Brown", "Green", "Gray", "Amber"];
															$eyes_color = get_post_meta($cur_post_id, 'eyes_color', true);
															foreach ($colors as $value) {
															?>
															<option value="<?=$value?>" <?php if($eyes_color == $value) echo "selected";?>><?php esc_html_e( $value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

														<select name="ethnicity" required>
															<?php
															$colors = ["White", "Black", "Asian", "Latino", "Mixed"];
															$ethnicity = get_post_meta($cur_post_id, 'ethnicity', true);
															foreach ($colors as $value) {
															?>
															<option value="<?=$value?>" <?php if($ethnicity == $value) echo "selected"; ?>><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

														<span class="pre-heading"><?php esc_html_e('Height', 'classiera'); ?>:</span>
														<select name="height_inches" class="third-size pull-right" required>
															<!-- <option value="" disabled selected><?php esc_html_e('Inches', 'classiera'); ?></option> -->
															<?php
															$height_inches = get_post_meta($cur_post_id, 'height_inches', true);
															for( $_size = 1; $_size < 12; $_size++){
															?>
															<option value="<?=$_size?>" <?php if($height_inches == $_size) echo "selected"; ?>><?php esc_html_e($_size, 'classiera'); ?>"</option>
															<?php
															}
															?>
														</select>
														<select name="height_feet" class="third-size pull-right add-margin" required>
															<?php
															$height_feet = get_post_meta($cur_post_id, 'height_feet', true);
															for(  $_size = 4; $_size <=6; $_size++){
															?>
															<option value="<?=$_size?>" <?php if($height_feet == $_size) echo "selected"; ?>><?php esc_html_e($_size . ' Feet', 'classiera'); ?></option>
															<?php
															}
															?>
														</select>
														

														<select name="weight" required>
															<option value="" selected disabled><?php esc_html_e('Weight in Kilograms', 'classiera'); ?></option>
															<?php
															$weight = get_post_meta($cur_post_id, 'weight', true);
															for( $_size = 51; $_size <= 80; $_size++){
															?>
															<option value="<?=$_size?>" <?php if($weight == $_size) echo "selected";?>><?php esc_html_e($_size, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

														<span class="pre-heading"><?php esc_html_e('Breast Type', 'classiera'); ?>:</span>
														<select name="breast_type" class="fifth-size pull-right" required>
															<?php
															$breast_type = get_post_meta($cur_post_id, 'breast_type', true);
															?>
															<option value="" disabled selected><?php esc_html_e('Type', 'classiera'); ?></option>
															<option value="Natural" <?php if( $breast_type == "Natural") echo "selected";?>><?php esc_html_e('Natural', 'classiera'); ?></option>
															<option value="Enchanced" <?php if( $breast_type == "Enchanced") echo "selected";?>><?php esc_html_e('Enchanced', 'classiera'); ?></option>
														</select>
														<select name="breast_size_cup" class="fifth-size pull-right add-margin" required>
															<option value="" disabled selected><?php esc_html_e('Cup', 'classiera'); ?></option>
															<?php
															$breast_size_cup = get_post_meta($cur_post_id, 'breast_size_cup', true);
															?>
															<option value="AA" <?php if($breast_size_cup == 'AA') echo "selected";?>><?php esc_html_e('AA', 'classiera'); ?></option>
															<option value="A" <?php if($breast_size_cup == 'A') echo "selected";?>><?php esc_html_e('A', 'classiera'); ?></option>
															<option value="B" <?php if($breast_size_cup == 'B') echo "selected";?>><?php esc_html_e('B', 'classiera'); ?></option>
															<option value="C" <?php if($breast_size_cup == 'C') echo "selected";?>><?php esc_html_e('C', 'classiera'); ?></option>
															<option value="D" <?php if($breast_size_cup == 'D') echo "selected";?>><?php esc_html_e('D', 'classiera'); ?></option>
															<option value="E" <?php if($breast_size_cup == 'E') echo "selected";?>><?php esc_html_e('E', 'classiera'); ?></option>
															<option value="F" <?php if($breast_size_cup == 'F') echo "selected";?>><?php esc_html_e('F', 'classiera'); ?></option>
															<option value="G" <?php if($breast_size_cup == 'G') echo "selected";?>><?php esc_html_e('G', 'classiera'); ?></option>
															<option value="H" <?php if($breast_size_cup == 'H') echo "selected";?>><?php esc_html_e('H', 'classiera'); ?></option>
														</select>
														<select name="breast_size" class="fifth-size pull-right add-margin" required>
															<?php
															$breast_size = get_post_meta($cur_post_id, 'breast_size', true);
															?>
															<option value="" disabled selected><?php esc_html_e('Size', 'classiera'); ?></option>
															<?php
															for( $_size = 30; $_size < 50; $_size += 2){
															?>
															<option value="<?=$_size?>" <?php if($breast_size==$_size) echo "selected";?>><?php esc_html_e($_size, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>
													</div>
												</div>
												<div class="col-sm-12 col-lg-6">
													<div class="form-group">
														<select name="waist_size" required>
															<option selected disabled><?php esc_html_e('Waist Size in Inches', 'classiera'); ?></option>
															<?php
															$waist_size = get_post_meta($cur_post_id, 'waist_size', true);
															for( $_size = 28; $_size <= 46; $_size += 2){
															?>
															<option value="<?=$_size?>" <?php if($waist_size == $_size) echo "selected";?>><?php esc_html_e($_size, 'classiera'); ?>"</option>
															<?php
															}
															?>
														</select>

														<select name="hips_size" required>
															<option value="" selected disabled><?php esc_html_e('Hips Size in Inches', 'classiera'); ?></option>
															<?php
															$hips_size = get_post_meta($cur_post_id, 'hips_size', true);
															for( $_size = 30; $_size < 45; $_size++){
															?>
															<option value="<?=$_size?>" <?php if($hips_size == $_size) echo "selected";?>><?php esc_html_e($_size, 'classiera'); ?>"</option>
															<?php
															}
															?>
														</select>

														<select name="dress_size" required>
															<?php
															$dress_size = get_post_meta($cur_post_id, 'dress_size', true);
															?>
															<option value="" disabled><?php esc_html_e('Dress Size', 'classiera'); ?></option>
															<option value="32 (XXS)" <?php if($dress_size == "32 (XXS)") echo "selected";?>><?php esc_html_e('32 (XXS)', 'classiera'); ?></option>
															<option value="34 (XS)" <?php if($dress_size == "34 (XS)") echo "selected";?>><?php esc_html_e('34 (XS)', 'classiera'); ?></option>
															<option value="36 (S)" <?php if($dress_size == "36 (S)") echo "selected";?>><?php esc_html_e('36 (S)', 'classiera'); ?></option>
															<option value="38 (M)" <?php if($dress_size == "38 (M)") echo "selected";?>><?php esc_html_e('38 (M)', 'classiera'); ?></option>
															<option value="40 (L)" <?php if($dress_size == "40 (L)") echo "selected";?>><?php esc_html_e('40 (L)', 'classiera'); ?></option>
															<option value="42 (XL)" <?php if($dress_size == "42 (XL)") echo "selected";?>><?php esc_html_e('42 (XL)', 'classiera'); ?></option>
															<option value="44 (XXL)" <?php if($dress_size == "44 (XXL)") echo "selected";?>><?php esc_html_e('44 (XXL)', 'classiera'); ?></option>
															<option value="46 (XXXL)" <?php if($dress_size == "46 (XXXL)") echo "selected";?>><?php esc_html_e('46 (XXXL)', 'classiera'); ?></option>
														</select>

														<select name="shoe_size" required>
															<option value="" disabled><?php esc_html_e('Shoe Size (UK Size)', 'classiera'); ?></option>
															<?php
															$shoe_size = get_post_meta($cur_post_id, 'shoe_size', true);
															for( $_size = 2; $_size < 10; $_size++){
															?>
															<option value="<?=$_size?>" <?php if($shoe_size == $_size) echo "selected";?>><?php esc_html_e($_size, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

														<select name="pubic_area" required>
															<?php
															$pubic_area = get_post_meta($cur_post_id, 'pubic_area', true);
															?>
															<option disabled><?php esc_html_e('Pubic Area', 'classiera'); ?></option>
															<option value="Natural" <?php if($pubic_area == "Natural") echo "selected";?>><?php esc_html_e('Natural', 'classiera'); ?></option>
															<option value="Bikini Line Touch Up" <?php if($pubic_area == "Bikini Line Touch Up") echo "selected";?>><?php esc_html_e('Bikini Line Touch Up', 'classiera'); ?></option>
															<option value="Full Bikini Line" <?php if($pubic_area == "Full Bikini Line") echo "selected";?>><?php esc_html_e('Full Bikini Line', 'classiera'); ?></option>
															<option value="French" <?php if($pubic_area == "French") echo "selected";?>><?php esc_html_e('French', 'classiera'); ?></option>
															<option value="Brazilian" <?php if($pubic_area == "Brazilian") echo "selected";?>><?php esc_html_e('Brazilian', 'classiera'); ?></option>
															<option value="Shaved" <?php if($pubic_area == "Shaved") echo "selected";?>><?php esc_html_e('Shaved', 'classiera'); ?></option>
														</select>

														<select name="smoker" required>
															<?php
															$smoker = get_post_meta($cur_post_id, 'smoker', true);
															?>
															<option value="" disabled><?php esc_html_e('Are You a Smoker?', 'classiera'); ?></option>
															<option value="Yes" <?php if($smoker == "Yes") echo "selected";?>><?php esc_html_e('Yes', 'classiera'); ?></option>
															<option value="No" <?php if($smoker == "No") echo "selected";?>><?php esc_html_e('No', 'classiera'); ?></option>
														</select>

													</div>
												</div>
											</div>
										</div>
										<!-- End Step-2 -->
										<!-- Begin Step-3 -->
										<div id="step-3">
											<div class="row">
												<hr>
												<div class="col-sm-12 col-lg-6">
													<div class="form-group">
														<select name="native_language" rqeuired>
															<?php
															$native_language = get_post_meta($cur_post_id, 'native_language', true);

															?>
															<option value="" disabled><?php esc_html_e('Native Language', 'classiera'); ?></option>
															<option value="Irish" <?php if($native_language == "Irish") echo "selected";?>><?php esc_html_e('Irish', 'classiera'); ?></option>
															<option value="British" <?php if($native_language == "British") echo "selected";?>><?php esc_html_e('British', 'classiera'); ?></option>
															<option value="Romanian" <?php if($native_language == "Romanian") echo "selected";?>><?php esc_html_e('Romanian', 'classiera'); ?></option>
															<option value="Brazilian" <?php if($native_language == "Brazilian") echo "selected";?>><?php esc_html_e('Brazilian', 'classiera'); ?></option>
														</select>

														<select name="language_1_level" class="fit-two-fields pull-right">
															<?php
															$language_1_level = get_post_meta($cur_post_id, 'language_1_level', true);
															if( !isset($language_1_level))$language_1_level = '';
															?>
															<option value="" disabled selected><?php esc_html_e('Select Level', 'classiera'); ?></option>
															<option value="Fluent" <?php if($language_1_level == "Fluent") echo "selected";?>><?php esc_html_e('Fluent', 'classiera'); ?></option>
															<option value="Intermediate" <?php if($language_1_level == "Intermediate") echo "selected";?>><?php esc_html_e('Intermediate', 'classiera'); ?></option>
															<option value="Beginer" <?php if($language_1_level == "Beginer") echo "selected";?>><?php esc_html_e('Beginer', 'classiera'); ?></option>
														</select>

														<select name="language_1" class="fit-two-fields pull-right add-margin">
															<?php
															$language_1 = get_post_meta($cur_post_id, 'language_1', true);
															if( !isset($language_1)) $language_1 == "";
															?>
															<option value="" selected disabled><?php esc_html_e('Additional Language', 'classiera'); ?></option>
															<option value="Spanish" <?php if($language_1 == "Spanish") echo "selected";?>><?php esc_html_e('Spanish', 'classiera'); ?></option>
															<option value="Russian" <?php if($language_1 == "Russian") echo "selected";?>><?php esc_html_e('Russian', 'classiera'); ?></option>
															<option value="Portugeese" <?php if($language_1 == "Portugeese") echo "selected";?>><?php esc_html_e('Portugeese', 'classiera'); ?></option>
															<option value="French" <?php if($language_1 == "French") echo "selected";?>><?php esc_html_e('French', 'classiera'); ?></option>
															<option value="Itallian" <?php if($language_1 == "Itallian") echo "selected";?>><?php esc_html_e('Itallian', 'classiera'); ?></option>
														</select>

														<select name="language_2_level" class="fit-two-fields pull-right">
															<?php
															$language_2_level = get_post_meta($cur_post_id, 'language_2_level', true);
															?>
															<option value="" disabled selected><?php esc_html_e('Select Level', 'classiera'); ?></option>
															<option value="Fluent" <?php if($language_2_level == "Fluent") echo "selected";?>><?php esc_html_e('Fluent', 'classiera'); ?></option>
															<option value="Intermediate" <?php if($language_2_level == "Intermediate") echo "selected";?>><?php esc_html_e('Intermediate', 'classiera'); ?></option>
															<option value="Beginer" <?php if($language_2_level == "Beginer") echo "selected";?>><?php esc_html_e('Beginer', 'classiera'); ?></option>
														</select>

														<select name="language_2" class="fit-two-fields pull-right add-margin">
															<?php
															$language_2 = get_post_meta($cur_post_id, 'language_2', true);
															?>
															<option selected disabled><?php esc_html_e('Additional Language', 'classiera'); ?></option>
															<option value="Spanish" <?php if($language_2 == "Spanish") echo "selected";?>><?php esc_html_e('Spanish', 'classiera'); ?></option>
															<option value="Russian" <?php if($language_2 == "Russian") echo "selected";?>><?php esc_html_e('Russian', 'classiera'); ?></option>
															<option value="Portugeese" <?php if($language_2 == "Portugeese") echo "selected";?>><?php esc_html_e('Portugeese', 'classiera'); ?></option>
															<option value="French" <?php if($language_2 == "French") echo "selected";?>><?php esc_html_e('French', 'classiera'); ?></option>
															<option value="Itallian" <?php if($language_2 == "Itallian") echo "selected";?>><?php esc_html_e('Itallian', 'classiera'); ?></option>
														</select>
													</div>
												</div>
												<div class="col-sm-12 col-lg-6">
													<div class="form-group"><!-- Form Group Container -->
														<select name="private_numbers" required>
															<?php
															$private_numbers = get_post_meta($cur_post_id, 'private_numbers', true);
															?>
															<option value="" selected disabled><?php esc_html_e('Accept Private Numbers', 'classiera'); ?></option>
															<option value="Yes" <?php if( $private_numbers == "Yes") echo "selected";?>><?php esc_html_e('Yes', 'classiera'); ?></option>
															<option value="No" <?php if( $private_numbers == "No") echo "selected";?>><?php esc_html_e('No', 'classiera'); ?></option>
														</select>

														<select name="sms_messages" required>
															<?php
															$sms_messages = get_post_meta($cur_post_id, 'sms_messages', true);
															?>
															<option selected disabled><?php esc_html_e('Accept SMS Messages', 'classiera'); ?></option>
															<option value="Yes" <?php if( $sms_messages == "Yes") echo "selected";?>><?php esc_html_e('Yes', 'classiera'); ?></option>
															<option value="No" <?php if( $sms_messages == "No") echo "selected";?>><?php esc_html_e('No', 'classiera'); ?></option>
														</select>

														<select name="private_messages" required>
															<?php
															$private_messages = get_post_meta($cur_post_id, 'private_messages', true);
															?>
															<option selected disabled><?php esc_html_e('Respond to Private Messages', 'classiera'); ?></option>
															<option value="Yes" <?php if( $private_messages == "Yes") echo "selected";?>><?php esc_html_e('Yes', 'classiera'); ?></option>
															<option value="No" <?php if( $private_messages == "No") echo "selected";?>><?php esc_html_e('No', 'classiera'); ?></option>
														</select>
													</div><!-- / Form Group Container -->
												</div>
											</div>
										</div>
										<!-- End Step-3 -->
										<!-- Begin Step-4 -->
										<div id="step-4">
											<div class="row">
												<hr>
												<div class="col-sm-12 col-lg-6">
													<div class="form-group">
														<select name="disabled_friendly" required>
															<?php
															$disabled_friendly = get_post_meta($cur_post_id, 'disabled_friendly', true);
															?>
															<option value="" selected disabled><?php esc_html_e('Disabled Friendly', 'classiera'); ?></option>
															<option value="Yes" <?php if( $disabled_friendly == "Yes") echo "selected";?>><?php esc_html_e('Yes', 'classiera'); ?></option>
															<option value="No" <?php if( $disabled_friendly == "No") echo "selected";?>><?php esc_html_e('No', 'classiera'); ?></option>
														</select>

														<select name="drinks_supplied" required>
															<?php
															$drinks_supplied = get_post_meta($cur_post_id, 'drinks_supplied', true);
															?>
															<option value="" selected disabled><?php esc_html_e('Drinks Supplied', 'classiera'); ?></option>
															<option value="Yes" <?php if( $drinks_supplied == "Yes") echo "selected";?>><?php esc_html_e('Yes', 'classiera'); ?></option>
															<option value="No" <?php if( $drinks_supplied == "No") echo "selected";?>><?php esc_html_e('No', 'classiera'); ?></option>
														</select>
													</div>
												</div>

												<div class="col-sm-12 col-lg-6">
													<div class="form-group">
														<select name="showers_available" required>
															<?php
															$showers_available = get_post_meta($cur_post_id, 'showers_available', true);
															?>
															<option value="" selected disabled><?php esc_html_e('Showers Available', 'classiera'); ?></option>
															<option value="Yes" <?php if( $showers_available == "Yes") echo "selected";?>><?php esc_html_e('Yes', 'classiera'); ?></option>
															<option value="No" <?php if( $showers_available == "No") echo "selected";?>><?php esc_html_e('No', 'classiera'); ?></option>
														</select>

														<select name="can_travel" required>
															<?php
															$can_travel = get_post_meta($cur_post_id, 'can_travel', true);
															?>
															<option value="" selected disabled><?php esc_html_e('Available to Travel', 'classiera'); ?></option>
															<option value="Nationally" <?php if( $can_travel == "Nationally") echo "selected";?>><?php esc_html_e('Nationally', 'classiera'); ?></option>
															<option value="Internationally" <?php if( $can_travel == "Internationally") echo "selected";?>><?php esc_html_e('Internationally', 'classiera'); ?></option>
															<option value="Localy" <?php if( $can_travel == "Localy") echo "selected";?>><?php esc_html_e('Localy', 'classiera'); ?></option>
															<option value="No" <?php if( $can_travel == "No") echo "selected";?>><?php esc_html_e('No', 'classiera'); ?></option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<!-- End Step-4 -->
										<!-- Begin Step-5 -->
										<div id="step-5" style="display: block;">
											<div class="row">
												<hr>
												<div class="col-sm-12 col-lg-6">
													<!-- post location -->
													<?php
														$classiera_ad_location_remove = $redux_demo['classiera_ad_location_remove'];
														if($classiera_ad_location_remove == 1){ ?>
														<?php 
														$args = array(
															'post_type' => 'countries',
															'posts_per_page'   => -1,
															'orderby'		  => 'title',
															'order'			=> 'ASC',
															'post_status'	  => 'publish',
															'suppress_filters' => false 
														);
														$country_posts = get_posts($args);
														if(!empty($country_posts)){
														?>
															<!--Select Country-->
															<div class="form-group">
																<select name="post_location" id="post_location" required>
																	<?php
																	$post_location = get_post_meta($cur_post_id, "post_location", true);
																	?>
																	<option value="-1" selected disabled><?php esc_html_e('Select Country', 'classiera'); ?></option>
																	<?php foreach( $country_posts as $country_post ){ ?>
																		<?php
																		$post_location_ID = 0;
																		if( $country_post->post_title == $post_location) $post_location_ID = $country_post->ID;
																		?>
																		<option value="<?php echo esc_attr( $country_post->ID ); ?>" <?php if( $country_post->post_title == $post_location) echo "selected";?>><?php echo esc_html( $country_post->post_title ); ?></option>
																	<?php } ?>
																</select>
															<?php } ?>
															<!--Select Country--> 
															<!--Select States-->
															<?php 
															$locationsStateOn = $redux_demo['location_states_on'];
															if($locationsStateOn == 1){
															?>
																<?php
																$post_state = get_post_meta($cur_post_id, 'post_state', true);
																$state_posts = get_posts( array( 'post_type' => 'states', 'posts_per_page' => -1, 'suppress_filters' => 0, 'meta_query' => array(
																	array(
																		'key' => 'state_meta_box_country',
																		'value' => $post_location_ID,
																	)
																) ) );
																$statesList = "";
																if(!empty($state_posts)){		
																	foreach( $state_posts as $state_post ){
																		$state = $state_post->ID;					
																		$statesList .= get_post_meta($state, "classiera-all-states", true).",";				
																	}
																}
																$singleState = explode(",", $statesList);
																asort($singleState);
																?>
																<select name="post_state" id="post_state" class="selectState" required>
																	<option value=""><?php esc_html_e('Select State', 'classiera'); ?></option>
																	<?php
																	foreach ($singleState as $value) {
																		if( !empty($value)){
																	?>
																		<option value="<?=$value?>" <?php if( $post_state == $value) echo "selected";?>><?=$value?></option>
																	<?php
																		}
																	}
																	?>
																</select>
															<?php } ?>
															<!--Select States-->
															<!--Select City-->
															<?php 
															$locationsCityOn= $redux_demo['location_city_on'];
															if($locationsCityOn == 1){
															?>
																<?php
																$post_city = get_post_meta($cur_post_id, 'post_city', true);
																$city_posts = get_posts( array( 'post_type' => 'cities', 'posts_per_page' => -1, 'suppress_filters' => 0, 'meta_query' => array(
																	array(
																		'key' => 'city_meta_box_state',
																		'value' => $post_state,
																	)
																) ) );
																$cityList = "";
																if(!empty($city_posts)){		
																	foreach( $city_posts as $city_post ){
																		$state = $city_post->ID;					
																		$cityList .= get_post_meta($state, "classiera-all-city", true).",";				
																	}
																}
																$singlecity = explode(",", $cityList);
																asort($singlecity);
																?>
																<select name="post_city" id="post_city" class="selectCity" required>
																	<option value=""><?php esc_html_e('Select City', 'classiera'); ?></option>
																	<?php
																	foreach ($singlecity as $value) {
																		if(!empty($value)){
																		?>
																		<option value="<?=$value?>" <?php if($post_city==$value) echo "selected";?>><?=$value?></option>
																		<?php
																		}
																	}
																	?>
																</select>
															</div>
															<?php } ?>
															<!--Select City-->
															<!--Address-->
															<?php if($classieraAddress == 1){?>
															<div class="form-group">
															  <label class="col-sm-3 text-left flip"><?php esc_html_e('Address', 'classiera'); ?> : <span>*</span></label>
															  <div class="col-sm-9">
																  <input id="address" type="text" name="address" class="form-control form-control-md" placeholder="<?php esc_html_e('Address or City', 'classiera') ?>">
															  </div>
														  	</div>
															<?php } ?>
															<!--Address-->
												  	<?php } ?>
												</div>
											</div>
										</div>
										<!-- End Step-5 -->
										<!-- Begin Step-6 -->
										<div id="step-6">
											<div class="row">
												<hr>
												<div class="col-sm-12">
												<?php			   
												  /*Image Count Check*/
												  global $redux_demo;
												  global $wpdb;
												  $paidIMG = $redux_demo['premium-ads-limit'];
												  $regularIMG = $redux_demo['regular-ads-limit'];			   
												  $current_user = wp_get_current_user();
												  $userID = $current_user->ID;
												  $result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id = $userID ORDER BY id DESC" );
												  $totalAds = 0;
												  $usedAds = 0;
												  $availableADS = '';
												  if(!empty($result)){
													foreach ( $result as $info ){
													  $availAds = $info->ads;
													  if (is_numeric($availAds)) {
														$totalAds += $info->ads;
														$usedAds += $info->used;
													  }
													}
												  }
												  $availableADS = $totalAds-$usedAds;
												  if($availableADS == "0" || empty($result)){
													$imageLimit = $regularIMG;
												  }else{
													$imageLimit = $paidIMG;
												  }
												  if($currentRole == "administrator"){
													$imageLimit = $paidIMG;
												  }
												if($imageLimit != 0){ 
												?>
												<div class="form-main-section media-detail">
												  <div class="form-group">
														<div class="col-lg-12">
															<div class="row">
																<?php
																$croppedImgUrl = "";
																$croppedImgUrlDouble = "";
																$ads_type_selected = get_post_meta($cur_post_id, 'ads_type_selected', true);
																print_r($ads_type_selected);
																if( strpos($ads_type_selected, "standard") !== false){
																	$croppedImgUrl = get_post_meta($cur_post_id,'croppedImg_Path', true);
																?>
																<div class="col-sm-12 col-lg-12">
																	<input type="hidden" name="croppedImgUrl" id="croppedImgUrl" value="<?=$croppedImgUrl?>">
																	<div id="croppic" style="margin: 0 auto; display: none;"></div>
																	<div id="croppic_image" style="margin: 0 auto; width: 255px; background-position: center;">
																		<img src="<?=$croppedImgUrl?>">
																		<div onclick="xClicked('croppic')" style="position: relative; top: -343px; left: 235px; font-size: 20px; width: 20px; background-color: #8080806e; padding: 0px 5px; cursor: pointer; color: red;">&times;</div>
																	</div>
																</div>
																<?php
																} else{
																	$croppedImgUrl = get_post_meta($cur_post_id, 'croppedImg_Path', true);
																	$croppedImgUrlDouble = get_post_meta($cur_post_id, 'croppedImg_Path_double', true);
																?>
																<div class="col-sm-12 col-lg-4">
																	<input type="hidden" name="croppedImgUrl" id="croppedImgUrl" value="<?=$croppedImgUrl?>">
																	<div id="croppic" style="margin: 0 auto"></div>
																	<div id="croppic_image" style="margin: 0 auto; width: 255px; background-position: center;">
																		<img src="<?=$croppedImgUrl?>">
																		<div onclick="xClicked('croppic')" style="position: relative; top: -343px; left: 235px; font-size: 20px; width: 20px; background-color: #8080806e; padding: 0px 5px; cursor: pointer; color: red;">&times;</div>
																	</div>
																</div>
																<div class="col-sm-12 col-lg-8">
																	<input type="hidden" name="croppedImgUrlDouble" id="croppedImgUrlDouble" value="<?=$croppedImgUrlDouble?>">
																	<div id="croppic-double" style="margin: 0 auto"></div>
																	<div id="croppic-double_image" style="margin: 0 auto; width: 255px; background-position: center;">
																		<img src="<?=$croppedImgUrlDouble?>">
																		<div onclick="xClicked('croppic-double')" style="position: relative; top: -343px; left: 490px; font-size: 20px; width: 20px; background-color: #8080806e; padding: 0px 5px; cursor: pointer; color: red;">&times;</div>
																	</div>
																</div>
																<?php
																}
																?>
															</div>
														</div>
													  <div class="col-sm-12">
														  <div class="classiera-dropzone-heading">
															  <div class="classiera-dropzone-heading-text">
																  <p><?php esc_html_e('Select files to Upload', 'classiera') ?></p>
																  <p><?php esc_html_e('You can add multiple images. Ads With photo get 50% more Responses', 'classiera') ?></p>
																  <p class="limitIMG"><?php esc_html_e('You can upload', 'classiera') ?>&nbsp;<?php echo esc_attr( $imageLimit ); ?>&nbsp;<?php esc_html_e('Images maximum.', 'classiera') ?></p>
															  </div>
														  </div>
														  <!-- HTML heavily inspired by http://blueimp.github.io/jQuery-File-Upload/ -->
														  <div id="mydropzone" class="classiera-image-upload clearfix" data-maxfile="<?php echo esc_attr( $imageLimit ); ?>">
															<!--Imageloop-->
															<?php
															$upload_dir = wp_upload_dir();
															$attachments = get_children(array(
																'post_parent' => $cur_post_id,
																'post_status' => 'inherit',
																'post_type' => 'attachment',
																'post_mime_type' => 'image',
																'order' => 'ASC',
																'orderby' => 'menu_order ID'
																)
															);
															// print_r($attachments);
															$urls = [];
															foreach ($attachments as $attachment) {
																$curUrl = get_attached_file($attachment->ID);
																$arrUrls = explode("/", $curUrl);
																$realUrl = "";
																for( $i = count($arrUrls) - 3; $i < count($arrUrls); $i++){
																	$realUrl .= "/" . $arrUrls[$i];
																}
																$urls[] = $upload_dir['baseurl'] . $realUrl;
															}
															$_nCount = count($urls);
															for ($i = 0; $i < $imageLimit; $i++){
																$imgUrl = "";
																if( $i < $_nCount){
																	$imgUrl = $urls[$i];
																}
															?>
															  <div class="classiera-image-box">
																  <div class="classiera-upload-box">
																	  <input name="image-count" type="hidden" value="<?php echo esc_attr( $imageLimit ); ?>" />
																	  <input class="classiera-input-file imgInp" id="imgInp<?php echo esc_attr( $i ); ?>" type="file" name="upload_attachment[]">
																	  <label class="img-label" for="imgInp<?php echo esc_attr( $i ); ?>"><i class="fas fa-plus-square"></i></label>
																	  <div class="classiera-image-preview" <?php if($imgUrl) echo 'style="display: block;"';?>>
																		  <img class="my-image" src="<?=$imgUrl?>"/>
																		  <span class="remove-img"><i class="fas fa-times-circle"></i></span>
																	  </div>
																  </div>
															  </div>
															<?php } ?>
															 <input type="hidden" name="classiera_featured_img" id="classiera_featured_img" value="0">
															 <input type="hidden" name="images_verified" id="images_verified" value="0">
															<!--Imageloop-->
														  </div>
														  <?php 
														  $classiera_video_postads = $redux_demo['classiera_video_postads'];
														  if($classiera_video_postads == 1){
														  ?>
														  <div class="iframe">
															  <div class="iframe-heading">
																  <i class="fa fa-video-camera"></i>
																  <span><?php esc_html_e('Put here iframe or video url.', 'classiera') ?></span>
															  </div>
															  <?php
															  $post_video = get_post_meta($cur_post_id, 'post_video', true);
															  ?>
															  <textarea class="form-control" name="video" id="video-code" placeholder="<?php esc_html_e('Put here iframe or video url.', 'classiera') ?>"><?=$post_video?></textarea>
															  <div class="help-block">
																  <p><?php esc_html_e('Add iframe or video URL (iframe 710x400) (youtube, vimeo, etc)', 'classiera') ?></p>
															  </div>
														  </div>
														  <?php } ?>
													  </div>
												  </div>
												</div>
											  	<?php } ?>
											  	<!-- add photos and media -->
												</div>
											</div>
										</div>
										<!-- End Step-6 -->
										<!-- Begin Step-7 -->
										<div id="step-7">
											<div class="row">

												<div class="col-sm-12">
															<hr>
													<div class="form-group">
														<div class="row">
															<div id="toggle">
																<input type="checkbox" name="checkbox1" id="checkbox3" class="ios-toggle" checked/>
																<label for="checkbox3" class="checkbox-label" data-off="Prices Off" data-on="Prices On"></label>
															</div>
														</div><!-- / Row -->
														<p class="price-info" style="display: none;"><?php esc_html_e('I do not wish to disclose price information!', 'classiera'); ?></p>
													</div>
												</div>

												<div class="col-sm-12 col-lg-6"><!-- Form Container -->
													<div class="form-group price-fields"><!-- Form Group Container -->
														<div class="row">
															<span class="pre-heading"><?php esc_html_e('15 Minutes', 'classiera'); ?>:</span>
															<?php
															$fifteen_min_pound = get_post_meta($cur_post_id, 'fifteen_min_pound', true);
															$fifteen_min_euro = get_post_meta($cur_post_id, 'fifteen_min_euro', true);
															?>
															<input name="fifteen_min_pound" type="number" class="form-control quarter-size pull-right" placeholder="Price in &pound;" value="<?=$fifteen_min_pound?>">
															<input name="fifteen_min_euro" type="number" class="form-control quarter-size pull-right add-margin" placeholder="Price in &euro;" value="<?=$fifteen_min_euro?>">
														</div>
														<div class="row">
															<span class="pre-heading"><?php esc_html_e('30 Minutes', 'classiera'); ?>:</span>
															<?php
															$thirty_min_pound = get_post_meta($cur_post_id, 'thirty_min_pound', true);
															$thirty_min_euro = get_post_meta($cur_post_id, 'thirty_min_euro', true);
															?>
															<input name="thirty_min_pound" type="number" class="form-control quarter-size pull-right" placeholder="Price in &pound;" value="<?=$thirty_min_pound?>">
															<input name="thirty_min_euro" type="number" class="form-control quarter-size pull-right add-margin" placeholder="Price in &euro;" value="<?=$thirty_min_euro?>">
														</div>
														<div class="row">
															<span class="pre-heading"><?php esc_html_e('45 Minutes', 'classiera'); ?>:</span>
															<?php
															$fourty_five_min_pound = get_post_meta($cur_post_id, 'fourty_five_min_pound', true);
															$fourty_five_min_euro = get_post_meta($cur_post_id, 'fourty_five_min_euro', true);
															?>
															<input name="fourty_five_min_pound" type="number" class="form-control quarter-size pull-right" placeholder="Price in &pound;" value="<?=$fourty_five_min_pound?>">
															<input name="fourty_five_min_euro" type="number" class="form-control quarter-size pull-right add-margin" placeholder="Price in &euro;" value="<?=$fourty_five_min_euro?>">
														</div>
													</div><!-- / Form Group Container -->
												</div><!--  / Form Container -->

												<div class="col-sm-12 col-lg-6"><!-- Form Container -->
													<div class="form-group price-fields"><!-- Form Group Container -->
														<div class="row">
															<span class="pre-heading"><?php esc_html_e('', 'classiera'); ?><?php esc_html_e('1st Hour', 'classiera'); ?>:</span>
															<?php
															$one_hour_pound = get_post_meta($cur_post_id, 'one_hour_pound', true);
															$one_hour_euro = get_post_meta($cur_post_id, 'one_hour_euro', true);
															?>
															<input name="one_hour_pound" type="number" class="form-control quarter-size pull-right" placeholder="Price in &pound;" value="<?=$one_hour_pound?>">
															<input name="one_hour_euro" type="number" class="form-control quarter-size pull-right add-margin" placeholder="Price in &euro;" value="<?=$one_hour_euro?>">
														</div>
														<div class="row">
															<span class="pre-heading"><?php esc_html_e('', 'classiera'); ?><?php esc_html_e('Full Day', 'classiera'); ?>:</span>
															<?php
															$full_day_pound = get_post_meta($cur_post_id, 'full_day_pound', true);
															$full_day_euro = get_post_meta($cur_post_id, 'full_day_euro', true);
															?>
															<input name="full_day_pound" type="number" class="form-control quarter-size pull-right" placeholder="Price in &pound;" value="<?=$full_day_pound?>">
															<input name="full_day_euro" type="number" class="form-control quarter-size pull-right add-margin" placeholder="Price in &euro;" value="<?=$full_day_euro?>">
														</div>
														<div class="row">
															<span class="pre-heading"><?php esc_html_e('', 'classiera'); ?><?php esc_html_e('Business Date', 'classiera'); ?>:</span>
															<?php
															$business_date_pound = get_post_meta($cur_post_id, 'business_date_pound', true);
															$business_date_euro = get_post_meta($cur_post_id, 'business_date_euro', true);
															?>
															<input name="business_date_pound" type="number" class="form-control quarter-size pull-right" placeholder="Price in &pound;" value="<?=$business_date_pound?>">
															<input name="business_date_euro" type="number" class="form-control quarter-size pull-right add-margin" placeholder="Price in &euro;" value="<?=$business_date_euro?>">
														</div>
													</div><!-- / Form Group Container -->
												</div>

											</div>
										</div>
										<!-- End Step-7 -->
										<!-- Begin Step-8 -->
										<div id="step-8">
											<div class="row">
												<hr>

											   	<div class="col-sm-12 col-lg-6 tcs-container">
											   		<button type="button" class="btn btn-primary extra-padding post-advert-btn" id="beforeupdatecheck" data-toggle="modal" data-target="#myModal"><?php esc_html_e('Update Advert', 'classiera') ?></button>
											   	</div>

											   	<!-- Credits modal -->
											   	<div id="myModal" class="modal fade" role="dialog">
											   		<div class="modal-dialog">
											   			<div class="modal-content">
											   				<div class="modal-header">
											   					<button type="button" class="close" data-dismiss="modal">&times;</button>
											   					<h4 class="modal-title"></h4>
											   				</div>
											   				<div class="modal-body">
											   					<p class="modal-body-info"></p>
											   				</div>
											   				<div class="modal-footer">
											   				</div>
											   			</div>
											   		</div>
											   	</div>
											   	<!-- Credits Modal -->


										   	</div><!-- Row -->
										</div>
										<!-- End Step-8 -->
									</div>
								</div><!-- / Smart Wizard Content -->

								<div class="col-sm-12">
									<div class="progress" style="display: none;">
									  <div id="current-progress" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="0%">
										<span class="sr-only">0% Complete</span>
									  </div>
									</div>
								</div>
							</form>
						</div>
						<!-- / Smart Wizard Content -->

						<!--submit-post-->
						<?php } ?>
					</div>
				</div>
			</div><!--col-lg-9 col-md-8 user-content-heigh-->
		</div><!--row-->
	</div><!--container-->
</section><!--user-pages-->
<?php endwhile; ?>

<div class="loader_submit_form">
	<img src="<?php echo get_template_directory_uri().'/images/loader180.gif' ?>">
</div>
<script>
	jQuery(document).ready(function($) {
			$('#checkbox3').click(function() {
				if ($(this).is(':checked')) {
					$('.price-fields').show();
					$('.price-info').hide();
				} else {
					$('.price-fields').hide();
					$('.price-info').show();
				}
			});
		});
	function customValidate(_this){
		if( _this.is("select")){
			if( $(_this).find("option:selected").length == 0)
				return false;
			if( $(_this).find("option:selected").is("[disabled]"))
				return false;
		} else if( _this.is("input")){
			if( _this.is("[type=text]") || _this.is("[type=password]") || _this.is("[type=number]")){
				if( _this.val() == "")
					return false;
			}
		} else if( _this.is("textarea")){
			if( _this.val() == "")
				return false;
		}
		return true;
	}
	$("input[required]").change(function(){
		if( $(this).val() == ""){
			$(this).addClass("emptyRequire");
		} else{
			$(this).removeClass("emptyRequire");
		}
	});
	$("textarea[required]").change(function(){
		if( $(this).val() == ""){
			$(this).addClass("emptyRequire");
		} else{
			$(this).removeClass("emptyRequire");
		}
	});
	$("select[required]").change(function(){
		if( $(this).find("option:selected").is("[disabled]")){
			$(this).addClass("emptyRequire");
		} else{
			$(this).removeClass("emptyRequire");
		}
	});
	$("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
		var elmForm = $("#step-" + (stepNumber*1+1));
		// only on forward navigation, that makes easy navigation on backwards still do the validation when going next
		if( stepNumber == 5){ // step 6
			var arrCroppedImgs = elmForm.find("#croppic .croppedImg");
			if( arrCroppedImgs.length == 0){
				$("#croppic").addClass("emptyRequire");
				return false;
			}
			var imgCropped = arrCroppedImgs.eq(0);
			$("#croppedImgUrl").val(imgCropped.attr("src"));
			if( $('#ads_type_selected').val().indexOf("standard") == -1){
				var arrDoubleCroppedImgs = elmForm.find("#croppic-double .croppedImg");
				if( arrDoubleCroppedImgs.length == 0){
					$("#croppic-double").addClass("emptyRequire");
					return false;
				}
				$("#croppedImgUrlDouble").val(arrDoubleCroppedImgs.eq(0).attr("src"));
			}

			var arrThumbImgInputs = $("input.classiera-input-file.imgInp");
			var isUploaded = false;
			for( var i = 0; i < arrThumbImgInputs.length; i++){
				var curInput = arrThumbImgInputs.eq(i);
				if( curInput.val() != ""){
					isUploaded = true;
				}
			}
			return isUploaded;
		} else{
			if(stepDirection === 'forward' && elmForm){
				var arrReqElems = elmForm.find('input,textarea,select').filter('[required]');
				var result = true;
				for( var i = 0; i < arrReqElems.length; i++){
					var curReqElem = arrReqElems.eq(i);
					if( customValidate(curReqElem) == false){
						curReqElem.addClass("emptyRequire");
						result = false;
					}
				}
				return result;
			}
			return true;
		}
	});

	jQuery(document).ready(function(){
		  var cropperOptions = {
				uploadUrl:'/ahv/v1/wp-content/themes/classiera-child/img-process.php',
		  		cropUrl:'/ahv/v1/wp-content/themes/classiera-child/img-crop.php',
		  		outputUrlId: 'get_img_url',
		  		imgEyecandy:true,
				zoomFactor:10,
				doubleZoomControls:false,
				rotateFactor:10,
				rotateControls:false,
				processInline:false,
				// loadPicture: "<?=$croppedImgUrl?>"
			}
			var cropperHeader = new Croppic('croppic', cropperOptions);
			// cropperHeader.defaultImg = "<?=$croppedImgUrl?>";
			console.log(cropperHeader);
		if( $("#croppic-double")){
			var cropperOptionsDouble = {
				uploadUrl:'/ahv/v1/wp-content/themes/classiera-child/img-process.php',
		  		cropUrl:'/ahv/v1/wp-content/themes/classiera-child/img-crop-double.php',
		  		outputUrlId: 'get_img_url',
		  		imgEyecandy:true,
				zoomFactor:10,
				doubleZoomControls:false,
				rotateFactor:10,
				rotateControls:false,
				processInline:false,
				loadPicture: "<?=$croppedImgUrlDouble?>"
			}
			
			var cropperHeaderDouble = new Croppic('croppic-double', cropperOptionsDouble);
		}
	});
	function xClicked(_id){
		$("#" + _id + "_image").hide();
		$("#" + _id).show();
	}
</script>

<?php get_footer(); ?>
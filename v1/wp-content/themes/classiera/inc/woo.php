<?php
global $redux_demo;
function classiera_currency_sign(){
	global  $woocommerce;
	$currCode = "";
	if (function_exists("get_woocommerce_currency_symbol")){
		$currCode = get_woocommerce_currency_symbol();
	}else{
		$currCode = "$";
	}
	
	return $currCode;
}
function classiera_Plans_URL(){
	global $redux_demo;
	$login = $redux_demo['login'];
	$new_post = $redux_demo['new_post'];
	if(is_user_logged_in()){
		$redirect =	$new_post;
	}else{
		$redirect = $login;
	}
	return $redirect;
}
/*Pay Per categories posts*/
add_action('wp_ajax_classiera_pay_per_post_id', 'classiera_pay_per_post_id');
add_action('wp_ajax_nopriv_classiera_pay_per_post_id', 'classiera_pay_per_post_id');//for users that are not logged in.
function classiera_pay_per_post_id(){	
	if(isset($_POST['catID'])){		
		$cat_pay_per_post = '';
		$days_to_expire = '';
		$displayfeaturedtxt = esc_html__( 'Feature this ad only in ', 'classiera' );
		$categoryID = $_POST['catID'];			
		$categoryData = get_terms('category', array(
				'hide_empty' => 0,				
				'order'=> 'ASC',
				'include'=> $categoryID,
			)	
		);	
		//print_r($categoryData);		
		foreach($categoryData as $category){
			$tag = $category->term_id;
			$classieraCatFields = get_option(MY_CATEGORY_FIELDS);
			$cat_pay_per_post = $classieraCatFields[$tag]['cat_pay_per_post'];
			$days_to_expire = $classieraCatFields[$tag]['days_to_expire'];
		}	
		if(empty($cat_pay_per_post) || empty($days_to_expire)){
			die();
		}else{
			global $woocommerce;
			if(function_exists('wc_get_product')){
				$_product = wc_get_product($cat_pay_per_post);
				$price = $_product->get_price();
			}else{
				die();
			}
			$currency = classiera_currency_sign();		
			echo '<p>'.$displayfeaturedtxt.$currency.$price.'</p><input type="hidden" value="'.$cat_pay_per_post.'" name="pay_per_post_product_id"><input type="hidden" value="'.$days_to_expire.'" name="days_to_expire">';
		}
	}
	die();
}
/*Pay Per categories posts*/
/*Pay Per posts checkout*/
add_action('wp_ajax_classiera_payperpost', 'classiera_payperpost');
add_action('wp_ajax_nopriv_classiera_payperpost', 'classiera_payperpost');//for users that are not logged in.
function classiera_payperpost(){
	if(isset($_POST)){		
		$savevalue = array();
		$product_id = $_POST['product_id']; //This is product ID
		$savevalue['product_id'] = $_POST['product_id'];
		$savevalue['post_id'] = $_POST['post_id'];
		$savevalue['post_title'] = $_POST['post_title'];
		$savevalue['days_to_expire'] = $_POST['days_to_expire'];		
		$_SESSION['classiera_user_data'] = $savevalue;
		
		//Add data to woocommerce cart//
		$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
		$quantity = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );		
		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
		if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity) ) {
			do_action( 'woocommerce_ajax_added_to_cart', $product_id );
		}
		die();
	}
}
/*=====================================
	Classiera Bump Ads
======================================*/
add_action('wp_ajax_classiera_bump_ads', 'classiera_bump_ads');
add_action('wp_ajax_nopriv_classiera_bump_ads', 'classiera_bump_ads');
function classiera_bump_ads(){
	if(isset($_POST)){
		$savevalue = array();
		$product_id = $_POST['product_id']; //This is product ID
		$savevalue['product_id'] = $_POST['product_id'];
		$savevalue['post_id'] = $_POST['post_id'];
		$savevalue['post_title'] = $_POST['post_title'];
		$savevalue['bump_ads'] = 'bump_ads_type';
		$_SESSION['classiera_user_data'] = $savevalue;
		//Add data to woocommerce cart//
		$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
		$quantity = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );		
		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
		if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity) ) {
			do_action( 'woocommerce_ajax_added_to_cart', $product_id );
		}
		die();
	}
}

add_action('wp_ajax_classiera_implement_woo_ajax', 'classiera_implement_woo_ajax');
add_action('wp_ajax_nopriv_classiera_implement_woo_ajax', 'classiera_implement_woo_ajax');//for users that are not logged in.
function classiera_implement_woo_ajax(){	
	if(isset($_POST)){			
		$savevalue = array();
		$product_id = $_POST['wooID']; //This is product ID
		$savevalue['AMT'] = $_POST['AMT'];
		$savevalue['product_id'] = $_POST['wooID'];
		$savevalue['CURRENCYCODE'] = $_POST['CURRENCYCODE'];
		$savevalue['plan_name'] = $_POST['plan_name'];
		$savevalue['plan_ads'] = $_POST['featured_ads'];
		$savevalue['regular_ads'] = $_POST['regular_ads'];	
		$savevalue['plan_time'] = $_POST['plan_time'];
		$savevalue['plan_id'] = $_POST['plan_id'];
		$savevalue['user_ID'] = $_POST['user_ID'];		
		$_SESSION['classiera_user_data'] = $savevalue;	
		//Add data to woocommerce cart//
		$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['wooID'] ) );
		$quantity = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );		
		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
		if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity) ) {
			do_action( 'woocommerce_ajax_added_to_cart', $product_id );
		}	
		die();
	}
}
add_filter('woocommerce_add_cart_item_data','wdm_add_item_data',11,2); 
if(!function_exists('wdm_add_item_data')){
    function wdm_add_item_data($cart_item_data,$product_id){
        /*Here, We are adding item in WooCommerce session with, wdm_user_custom_data_value name*/		
        global $woocommerce;
		//session_start();    
        if (isset($_SESSION['classiera_user_data'])) {
            $option = $_SESSION['classiera_user_data'];       
            $new_value = array('wdm_user_custom_data_value' => $option);			
        }
		unset($_SESSION['classiera_user_data']);
        if(empty($option)){
            return $cart_item_data;
        }else{    
            if(empty($cart_item_data)){
                return $new_value;
            }else{
                return array_merge($cart_item_data,$new_value);
			}
        }       
		
    }
}
add_filter('woocommerce_get_cart_item_from_session', 'wdm_get_cart_items_from_session', 11, 3 );
if(!function_exists('wdm_get_cart_items_from_session')){
    function wdm_get_cart_items_from_session($item,$values,$key){
        if (array_key_exists( 'wdm_user_custom_data_value', $values ) ){
			$item['wdm_user_custom_data_value'] = $values['wdm_user_custom_data_value'];
        }       
        return $item;
    }
}
add_filter('woocommerce_checkout_cart_item_quantity','classiera_insert_data_into_cart',1,3);  
add_filter('woocommerce_cart_item_price','classiera_insert_data_into_cart',1,3);
if(!function_exists('classiera_insert_data_into_cart')){
 function classiera_insert_data_into_cart($product_name, $values, $cart_item_key ){		
        /*code to add custom data on Cart & checkout Page*/ 		
        if(count($values['wdm_user_custom_data_value']) > 0){			
			$newval = $values['wdm_user_custom_data_value'];
			//print_r($newval);
			if(isset($newval['days_to_expire'])){
				$days_to_expire = $newval['days_to_expire'];
			}else{
				$days_to_expire = NULL;
			}
			if(isset($newval['bump_ads'])){
				$classieraBumpAds = true;
			}else{
				$classieraBumpAds = false;
			}
            $return_string = $product_name . "</a><ul class='variation'>";
			$return_string .= "<div class='wdm_options_table' id='" . $newval['product_id'] . "'>";
			foreach( $newval as $key => $val ){					
				if(empty($days_to_expire)){
					if($classieraBumpAds == true){
						if($key == 'post_id'){
							$echokey = esc_html__( 'Your post ID', 'classiera' );
							$return_string .= '<li>'.$echokey.'&nbsp; : &nbsp; '.$val.'</li>';
						}
						if($key == 'post_title'){
							$echokey = esc_html__( 'Post Title', 'classiera' );
							$return_string .= '<li>'.$echokey.'&nbsp; : &nbsp; '.$val.'</li>';
						}
						if($key == 'bump_ads'){
							$echokey = esc_html__( 'You are going to Bump this Ad.', 'classiera' );
							$days = esc_html__( 'Days', 'classiera' );
							$return_string .= '<li>'.$echokey.'</li>';
						}
					}else{
						if($key == 'plan_name'){
							$echokey = esc_html__( 'Plan Name', 'classiera' );
							$return_string .= '<li>'.$echokey.'&nbsp; : &nbsp; '.$val.'</li>';
						}
						if($key == 'plan_ads'){
							$echokey = esc_html__( 'Featured Ads', 'classiera' );
							$return_string .= '<li>'.$echokey.'&nbsp; : &nbsp; '.$val.'</li>';
						}
						if($key == 'regular_ads'){
							$echokey = esc_html__( 'Regular Ads', 'classiera' );
							$return_string .= '<li>'.$echokey.'&nbsp; : &nbsp; '.$val.'</li>';
						}
						if($key == 'plan_time'){
							$echokey = esc_html__( 'Ads will be live for', 'classiera' );
							$spanVal = esc_html__( 'Only In', 'classiera' );
							$return_string .= '<li>'.$echokey.'&nbsp; : &nbsp; '.$val.'</li>';
							$update = esc_html__( 'Please dont update Quantity from here.', 'classiera' );
							$return_string .= '<li class="alert-danger">'.$update.'</li>';
						}
					}
					
				}else{
					if($key == 'post_id'){
						$echokey = esc_html__( 'Your post ID', 'classiera' );
						$return_string .= '<li>'.$echokey.'&nbsp; : &nbsp; '.$val.'</li>';
					}
					if($key == 'post_title'){
						$echokey = esc_html__( 'Post Title', 'classiera' );
						$return_string .= '<li>'.$echokey.'&nbsp; : &nbsp; '.$val.'</li>';
					}
					if($key == 'days_to_expire'){
						$echokey = esc_html__( 'Your Post will be featured', 'classiera' );
						$days = esc_html__( 'Days', 'classiera' );
						$return_string .= '<li>'.$echokey.'&nbsp; : &nbsp; '.$val.'&nbsp; '.$days.'</li>';
					}
				}
			}
            $return_string .= "</div></ul>";
            return $return_string;
        }else{
            return $product_name;
        }
    }
}
add_action('woocommerce_add_order_item_meta','wdm_add_values_to_order_item_meta',1,2);
if(!function_exists('wdm_add_values_to_order_item_meta')){
	function wdm_add_values_to_order_item_meta($item_id, $values){
		global $woocommerce,$wpdb;
		$user_custom_values = $values['wdm_user_custom_data_value'];
		if(!empty($user_custom_values)){
			foreach($user_custom_values AS $key => $val){
				wc_add_order_item_meta($item_id, $key, $val); 
			}            
		}
	}
}
add_action('woocommerce_before_cart_item_quantity_zero','wdm_remove_user_custom_data_options_from_cart',1,1);
if(!function_exists('wdm_remove_user_custom_data_options_from_cart')){
    function wdm_remove_user_custom_data_options_from_cart($cart_item_key){
        global $woocommerce;
        // Get cart
        $cart = $woocommerce->cart->get_cart();
        // For each item in cart, if item is upsell of deleted product, delete it
        foreach( $cart as $key => $values){
			if($values['wdm_user_custom_data_value'] == $cart_item_key ){
				unset( $woocommerce->cart->cart_contents[ $key ] );
			}
        }
    }
}
//Do a task on order status complete//
add_action( 'woocommerce_order_status_completed', 'classiera_complete_payment_order', 10);
function classiera_complete_payment_order($order_id){	
	global $wpdb;
	$order = wc_get_order( $order_id );
	$items = $order->get_items();
	foreach( $items as $item_id => $item_data ){
		$plan_time = wc_get_order_item_meta($item_id, 'plan_time', true);
		$plan_ads = wc_get_order_item_meta($item_id, 'plan_ads', true);
		$regular_ads = wc_get_order_item_meta($item_id, 'regular_ads', true);
		$user_ID = wc_get_order_item_meta($item_id, 'user_ID', true);
		$plan_name = wc_get_order_item_meta($item_id, 'plan_name', true);		
		$plan_price = wc_get_order_item_meta($item_id, 'AMT', true);
		$product_id = wc_get_order_item_meta($item_id, 'product_id', true);
		$quantity = wc_get_order_item_meta($item_id, '_qty', true);		
		$plan_id = wc_get_order_item_meta($item_id, 'plan_id', true);		
		$featured_post_id = wc_get_order_item_meta($item_id, 'post_id', true);
		$post_title = wc_get_order_item_meta($item_id, 'post_title', true);
		$days_to_expire = wc_get_order_item_meta($item_id, 'days_to_expire', true);	
		$bump_ads = wc_get_order_item_meta($item_id, 'bump_ads', true);	
		
		//Assign Plans
		if(empty($days_to_expire)){
			if(empty($bump_ads)){
				for($i=0; $i < $quantity ; $i++){ 
					$price_plan_information = array(
						'id' =>'', 
						'product_id' => $product_id, 
						'user_id' => $user_ID, 
						'plan_id' => $plan_id, 
						'regular_ads' => $regular_ads, 
						'plan_name' => $plan_name, 
						'price' => $plan_price, 
						'ads' => $plan_ads, 
						'days' => $plan_time, 
						'status' => "complete", 
						'used' => "0", 
						'regular_used' => "0", 
						'created' => time() 
					); 
					$insert_format = array('%d', '%d', '%d', '%d', '%d', '%s', '%s','%d', '%s', '%s', '%s', '%s', '%s'); 
					$insert_format = array('%d', '%d', '%d', '%d', '%d', '%s', '%s','%d', '%s', '%s', '%s', '%s', '%s');
					$tablename = $wpdb->prefix . 'classiera_plans'; 
					$wpdb->insert($tablename, $price_plan_information, $insert_format); 
				}
			}else{
				global $post;
				$time = current_time('mysql');
				$args = array(
					'ID' => $featured_post_id,
					'post_date' => $time,
					'post_date_gmt' => get_gmt_from_date( $time ),
				);
				wp_update_post($args);
			}
		}else{
			global $post;
			$post_information = array(
				'ID' => $featured_post_id,
				'post_status' => 'publish',
			);
			wp_update_post( $post_information );
			
			$dateActivation = date('m/d/Y H:i:s');
			update_post_meta($featured_post_id, 'post_price_plan_activation_date', $dateActivation );
			
			$daysToExpire = $days_to_expire;
			$dateExpiration_Normal = date("m/d/Y H:i:s", strtotime("+ ".$daysToExpire." days"));
			update_post_meta($featured_post_id, 'post_price_plan_expiration_date_normal', $dateExpiration_Normal );
			
			$dateExpiration = strtotime(date("m/d/Y H:i:s", strtotime("+ ".$daysToExpire." days")));
			update_post_meta($featured_post_id, 'post_price_plan_expiration_date', $dateExpiration );
			update_post_meta($featured_post_id, 'featured_post', "1" );
		}
	}		
}
?>
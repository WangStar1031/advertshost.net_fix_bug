<?php 

/*==========================

 Classiera 3.0.5: Hide Price section

 For specific categories.

 ===========================*/

add_action( 'wp_ajax_classiera_hide_submitad_section', 'classiera_hide_submitad_section' );

add_action( 'wp_ajax_nopriv_classiera_hide_submitad_section', 'classiera_hide_submitad_section' );

function classiera_hide_submitad_section(){		

	if(isset($_POST['checkcatid'])){

		global $redux_demo;

		$classierahidePriceCats = $redux_demo['classiera_categories_noprice'];

		$checkcatid = $_POST['checkcatid'];	

		if( in_array($checkcatid ,$classierahidePriceCats )){

			$returnid = $checkcatid;

		}else{

			$returnid = 'naho';

		}

		echo esc_attr($returnid);

		die();

	}

	die();

}

/*==========================

 Classiera : Search AJAX Function

 @since classiera 1.0

 ===========================*/

add_action( 'wp_ajax_get_search_classiera', 'get_search_classiera' );

add_action( 'wp_ajax_nopriv_get_search_classiera', 'get_search_classiera' );

function get_search_classiera(){		

	$args = array( 

		'post_type' => 'post',

		'post_status' => 'publish',

		'order' => 'DESC',

		'orderby' => 'date',

		's' => $_POST['CID'],

		'posts_per_page' => -1,	 

	);

	$startWord = $_POST['CID'];

	$query = new WP_Query( $args );

	if($query->have_posts()){

		$allCat = esc_html__( ' in All Categories', 'classiera' );

		$displayCatTrns = esc_html__( 'in', 'classiera' );

		$allCatDisplay = $startWord.$allCat;

		while ($query->have_posts()){

			$query->the_post();

			$postCatgory = get_the_category( $post->ID );				

			$categoryName = $postCatgory[0]->name;

			$category = get_the_category();

			$catID = $category[0]->cat_ID;

			$catSlug = $category[0]->slug;

			if ($category[0]->category_parent == 0) {

				$tag = $category[0]->cat_ID;

				$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);

				if (isset($tag_extra_fields[$tag])) {

					$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];

					$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];

				}

			}else{

				$tag = $category[0]->category_parent;

				$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);

				if (isset($tag_extra_fields[$tag])) {

					$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];

					$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];

				}

			}

			if(!empty($category_icon_code)) {

				$category_icon = stripslashes($category_icon_code);

			}

			$theTitle = get_the_title();

			//$posttags = get_the_tags();

			$tagsArga = array( 

				'name__like' => $startWord,				

				'order' => 'ASC',	 

			);

			$displaytag = '';

			$tagstring = '';

			$posttags = get_tags($tagsArga);			

			if($posttags){

			  foreach($posttags as $tag) {

				$tagstring .= $tag->name.',';				

			  }

			}

			$str1 = rtrim($tagstring,',');

			$str = implode(',' ,array_unique(explode(',', $str1)));

			$srt2 = explode(',', $str);

			foreach($srt2 as $val){

				$displaytag .= '<li><a class="SearchLink" href="#" name="'.$val.'">'.$val.'</a></li>';

			}

			$title .= '<li><a class="SearchLink" href="#" name="'.$theTitle.'">'.$theTitle.'</a></li>';

			$categorydisplay .= '<li><a class="SearchCat" href="#" name="'.$categoryName.'" id="'.$catSlug.'">'.$startWord.'<span>'.$displayCatTrns.'<i class="'.$category_icon.'"></i>'.$categoryName.'</span></a></li>';

		}

		echo"<ul>";

		echo '<li><a class="SearchCat" id="-1" href="#" name="all">'.esc_html($allCatDisplay).'</a></li>';

		echo wp_kses_post($categorydisplay);

		echo wp_kses_post($displaytag);

		echo"</ul>";

	}else{

		?>

		<ul><li><a href="#">.<?php esc_html_e( 'No Result found related your search', 'classiera' );?></a></li></ul>

		<?php 

	}exit();

}

/*==========================

 Select Sub categories AJAX Function

 ===========================*/

add_action('wp_ajax_classiera_implement_ajax', 'classiera_implement_ajax');

add_action('wp_ajax_nopriv_classiera_implement_ajax', 'classiera_implement_ajax');//for users that are not logged in.

function classiera_implement_ajax(){		

	if(isset($_POST['mainCat'])){

		$mainCatSlug = $_POST['mainCat'];

		$mainCatIDSearch = get_category_by_slug($mainCatSlug);

		$mainCatID = $mainCatIDSearch->term_id;

		$cat_child = get_term_children($mainCatID, 'category' );

		if (!empty($cat_child)) {	

			$categories=  get_categories('child_of='.$mainCatID.'&hide_empty=0');

			  foreach ($categories as $cat) {				

				$option .= '<option value="'.$cat->slug.'">';

				$option .= $cat->cat_name;				

				$option .= '</option>';

			  }

			  echo '<option value="-1" selected="selected" disabled="disabled">'.esc_html__( "Select Sub Category..", "classiera" ).'</option>'.$option;

			die();

		}else{			

			die();

		}

	} // end if

}

/*==========================

 Categories Third Level Categories

 ===========================*/

add_action('wp_ajax_classieraGetSubCatOnClick', 'classieraGetSubCatOnClick');

add_action('wp_ajax_nopriv_classieraGetSubCatOnClick', 'classieraGetSubCatOnClick');

function classieraGetSubCatOnClick(){

	if(isset($_POST['mainCat'])){

		$cat_child = get_term_children( $_POST['mainCat'], 'category' );		

		$classierMainCatID = $_POST['mainCat'];

		if (!empty($cat_child)){

			$args = array(

				'show_count' => 0,

				'orderby' => 'name',

				'suppress_filters' => false,

				'depth' => 1,

				'hierarchical' => 1,						  

				'hide_if_empty' => false,

				'hide_empty' => 0, 

				'parent' => $classierMainCatID,

				'child_of' => $classierMainCatID,

			);

			$categories=  get_categories($args);

			foreach ($categories as $cat){				

				$lireturn .= '<li><a href="#" id="'.$cat->term_id.'">'.$cat->cat_name.'</a></li>';

			}

			echo wp_kses_post($lireturn);

			die();

		}else{

			die();

		}

	}elseif(isset($_POST['subCat'])){

		$classierSubCatID = $_POST['subCat'];

		$cat_child = get_term_children( $classierSubCatID, 'category' );

		if (!empty($cat_child)){

			$args = array(

				'show_count' => 0,

				'orderby' => 'name',

				'suppress_filters' => false,

				'depth' => 1,

				'hierarchical' => 1,						  

				'hide_if_empty' => false,

				'hide_empty' => 0, 

				'parent' => $classierSubCatID,

				'child_of' => $classierSubCatID,

			);

			$categories=  get_categories($args);

			foreach ($categories as $cat){				

				$lireturn .= '<li><a href="#" id="'.$cat->term_id.'">'.$cat->cat_name.'</a></li>';

			}

			echo wp_kses_post($lireturn);

			die();

		}else{

			die();

		}

	}

}

/*==========================

 Classiera : Categories Custom Fields Ajax Function

 @since classiera 1.0

 ===========================*/

add_action( 'wp_ajax_classiera_Get_Custom_Fields', 'classiera_Get_Custom_Fields' );

add_action( 'wp_ajax_nopriv_classiera_Get_Custom_Fields', 'classiera_Get_Custom_Fields' );

function classiera_Get_Custom_Fields(){	

	$categoryID = $_POST['Classiera_Cat_ID'];

	$categoryName = get_cat_name( $categoryID );

	$cat_data = get_option(MY_CATEGORY_FIELDS);

	$thisCategoryOptions = $cat_data[$categoryID];

	if(isset($thisCategoryOptions)){

		$optionData = array();

		$selectFeature = esc_html__( 'Select Feature', 'classiera' );

		$thisCategoryFields = $thisCategoryOptions['category_custom_fields'];		

		$thisCategoryType = $thisCategoryOptions['category_custom_fields_type'];

		echo '<div class="form-main-section extra-fields wrap-content cat-'.$categoryID.'">';

		$counter = "";

		for($counter = 0; $counter < (count($thisCategoryFields)); $counter++){			

		}

		if($counter > 0){

			echo '<h4 class="text-uppercase border-bottom">'.esc_html__('Extra Fields For', 'classiera').'&nbsp;'.$categoryName.':</h4>';

		}

		for($i = 0; $i < (count($thisCategoryFields)); $i++){ 

			if($thisCategoryType[$i][1] == 'text'){

				echo '<div class="form-group cat-'.$categoryID.'"><label class="col-sm-3 text-left flip">'.$thisCategoryFields[$i][0].': </label><div class="col-sm-6"><input type="hidden" class="custom_field" id="custom_field['.$i.'][0]" name="'.$categoryID.'custom_field['.$i.'][0]" value="'.$thisCategoryFields[$i][0].'" size="12"><input type="text" class="form-control form-control-md" id="custom_field['.$i.'][1]" name="'.$categoryID.'custom_field['.$i.'][1]" placeholder="'.$thisCategoryFields[$i][0].'" size="12"></div></div>';

			}

		}

		for($i = 0; $i < (count($thisCategoryFields)); $i++){			

			if($thisCategoryType[$i][1] == 'dropdown'){

				$options = $thisCategoryType[$i][2];

				$optionsarray = explode(',',$options);

				foreach($optionsarray as $option){

					$optionData[$i] .= '<option value="'.$option.'">'.$option.'</option>';

				}

				echo '<div class="form-group cat-'.$categoryID.'"><label class="col-sm-3 text-left flip">'.$thisCategoryFields[$i][0].': </label><div class="col-sm-6"><div class="inner-addon right-addon"><i class="form-icon right-form-icon fa fa-angle-down"></i><input type="hidden" class="custom_field" id="custom_field['.$i.'][0]" name="'.$categoryID.'custom_field['.$i.'][0]" value="'.$thisCategoryFields[$i][0].'" size="12"><input type="hidden" class="custom_field" id="custom_field['.$i.'][2]" name="'.$categoryID.'custom_field['.$i.'][2]" value="'.$thisCategoryType[$i][1].'" size="12"><select class="form-control form-control-md" id="custom_field['.$i.'][1]" name="'.$categoryID.'custom_field['.$i.'][1]"><option>'.$thisCategoryFields[$i][0].'</option>'.$optionData[$i].'</select></div></div></div>';

			}			

		}

		for($i = 0; $i < (count($thisCategoryFields)); $i++){

			if($thisCategoryType[$i][1] == 'checkbox'){

				echo '<div class="form-group form__check cat-'.$categoryID.'"><p class="featurehide featurehide'.$i.'">'.$selectFeature.'</p><div class="col-sm-6"><div class="inner-addon right-addon"><i class="form-icon right-form-icon fa fa-angle-down"></i><input type="hidden" class="custom_field" id="custom_field['.$i.'][0]" name="'.$categoryID.'custom_field['.$i.'][0]" value="'.$thisCategoryFields[$i][0].'" size="12"><input type="hidden" class="custom_field" id="custom_field['.$i.'][2]" name="'.$categoryID.'custom_field['.$i.'][2]" value="'.$thisCategoryType[$i][1].'" size="12"><div class="checkbox"><input type="checkbox" class="custom_field custom_field_visible input-textarea newcehckbox" id="'.$categoryID.'custom_field['.$i.'][1]" name="'.$categoryID.'custom_field['.$i.'][1]"><label for="'.$categoryID.'custom_field['.$i.'][1]" class="newcehcklabel">'.$thisCategoryFields[$i][0].'</label></div></div></div></div>';

			}

		}

		echo '</div>';

	}

	die();

	

}

/*==========================

 Get Verification Code for user Profile

 ===========================*/

add_action( 'wp_ajax_classiera_send_verify_code', 'classiera_send_verify_code' );

add_action( 'wp_ajax_nopriv_classiera_send_verify_code', 'classiera_send_verify_code' );

function classiera_send_verify_code(){

	$verify_code = $_POST['verify_code'];

	$verify_user_ID = $_POST['verify_user_ID'];

	$verify_user_email = $_POST['verify_user_email'];

	$verification_code = $_POST['verification_code'];

	if($verify_code){

		update_user_meta( $verify_user_ID, 'author_vcode', $verify_code );

		$to = $verify_user_email;

		$subject = esc_html__('Author Verification', 'classiera');

		$body = esc_html__('Please Copy your Verification Code : ', 'classiera'). $_POST['verify_code'];

		$headers = array('Content-Type: text/html; charset=UTF-8');

		if ( function_exists('classiera_send_mail_with_headers')) {

			classiera_send_mail_with_headers($to, $subject, $body, $headers);

		}

	}

	if(isset($verification_code)){

		$dbcode = get_the_author_meta('author_vcode', $verify_user_ID);

		$confirm_code = $verification_code;

		if($confirm_code == $dbcode){

			update_user_meta( $verify_user_ID, 'author_verified', 'verified');

			update_user_meta( $verify_user_ID, 'author_verified_email', $verify_user_email);

			$message = '<p class="text-center"><i class="fa fa-check-square"></i></p><h4 class="text-center text-uppercase">'.esc_html__('Congratulations', 'classiera').'<span>!</span></h4><p class="text-center">'.esc_html__('Your Account Verified Now', 'classiera').'</p>';

			echo wp_kses_post($message);

		}else{

			update_user_meta( $verify_user_ID, 'author_verified', 'unverified');

			$message = '<p class="text-center"><i class="fa fa-user-times text-danger"></i></p><h4 class="text-center text-uppercase">'.esc_html__('Warning', 'classiera').'<span>!</span></h4><p class="text-center">'.esc_html__('Author Verification failed', 'classiera').'</p>';			

			echo wp_kses_post($message);

		}

	}

	die();

	

}

/*==========================

 Make Offer AJAX Function

 ===========================*/

add_action( 'wp_ajax_make_offer_classiera', 'make_offer_classiera' );

add_action( 'wp_ajax_nopriv_make_offer_classiera', 'make_offer_classiera' );

function make_offer_classiera(){	

	$message = "";

	$offer_price = $_POST['offer_price'];

	$offer_comment = $_POST['offer_comment'];

	$offer_post_id = $_POST['offer_post_id'];

	$post_author_id = $_POST['post_author_id'];

	$offer_author_id = $_POST['offer_author_id'];

	$offer_post_price = $_POST['offer_post_price'];

	if(empty($offer_author_id)){

		$message = esc_html__( 'You must need to login', 'classiera' );

	}elseif($post_author_id == $offer_author_id){

		$message = esc_html__( 'Sorry you are author of this ad & ad author cant post bid.', 'classiera' );

	}elseif(!empty($offer_price) && !empty($offer_comment)){

		global $wpdb;

		$offerMessage = array(

			'id' =>'', 

			'offer_price' => $offer_price, 

			'offer_comment' => $offer_comment, 

			'offer_post_id' => $offer_post_id, 

			'post_author_id' => $post_author_id, 

			'offer_author_id' => $offer_author_id, 

			'offer_post_price' => $offer_post_price,

			'date' => time() 

		); 

		$insert_format = array('%d', '%d', '%s', '%d', '%d', '%d', '%d', '%s');

		$tablename = $wpdb->prefix . 'classiera_inbox'; 

		$wpdb->insert($tablename, $offerMessage, $insert_format);

		$lastInsertId = $wpdb->insert_id; 

		//Insert data into readUnRead table//

		$readMessage = array(

			'id' =>'', 

			'message_id' => $lastInsertId, 

			'recipient_id' => $post_author_id,

			'message_status' => 'unread',

		);

		$statusformat = array('%d', '%d', '%s', '%s');

		$statusTable = $wpdb->prefix . 'classiera_inbox_read'; 

		$wpdb->insert($statusTable, $readMessage, $statusformat);

		//Insert data into readUnRead table//

		$message = '<i class="fa fa-check-circle"></i>'.esc_html__( 'Your offer have sent successfully, Check your inbox for more details.', 'classiera' );

		classiera_send_offer_to_author($offer_price, $offer_comment, $offer_post_id, $post_author_id, $offer_author_id, $offer_post_price);

	}		

	echo wp_kses_post($message);

	die();

	

}

/*==========================

 Get BID Comment AJAX Function

 ===========================*/

add_action( 'wp_ajax_classiera_get_comment_ajax', 'classiera_get_comment_ajax' );

add_action( 'wp_ajax_nopriv_classiera_get_comment_ajax', 'classiera_get_comment_ajax' );

function classiera_get_comment_ajax(){

	global $wpdb;

	global $post;

	$currentUserID = get_current_user_id();

	$dateFormat = get_option( 'date_format' );

	if(isset($_POST['commentID'])){		

		$commentID = $_POST['commentID'];

		$getfirstComment = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_inbox WHERE id = $commentID ORDER BY id DESC" );

		if($getfirstComment){

			$html = '';

			$userHTML = '';

			$mainHTML = '';

			$authorHTML = '';

			$innerComment = '';

			foreach ( $getfirstComment as $offerinfo ) :

				$offer_post_id = $offerinfo->offer_post_id;

				$offer_post_price = $offerinfo->offer_post_price;

				$post_author_id = $offerinfo->post_author_id;

				$offer_author_id = $offerinfo->offer_author_id;

				$offer_price = $offerinfo->offer_price;

				$offer_comment = $offerinfo->offer_comment;

				$thiscommentID = $offerinfo->id;

				$date = $offerinfo->date;				

				//$OfferDate = date($dateFormat, $date);

				$OfferDate = date_i18n($dateFormat,  strtotime($date));

				$postTitle = get_the_title($offer_post_id);

				$offerAuthor = get_the_author_meta('display_name', $offer_author_id );

				if(empty($offerAuthor)){

					$offerAuthor = get_the_author_meta('user_nicename', $offer_author_id );

				}

				if(empty($offerAuthor)){

					$offerAuthor = get_the_author_meta('user_login', $offer_author_id );

				}

				$offerAuthorIMG = get_user_meta($offer_author_id, "classify_author_avatar_url", true);

				$offerAuthorIMG = classiera_get_profile_img($offerAuthorIMG);

				if(empty($offerAuthorIMG)){										

					$offerAuthorIMG = classiera_get_avatar_url ($offer_author_id, $size = '150' );

				}

				$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);

				$offer_price =  classiera_post_price_display($post_currency_tag, $offer_price);

				//Main Comment//

				$mainHTML = '<div class="classiera_user_message"><a href="#"><img class="img-circle classiera_user_message_img" src="'.$offerAuthorIMG.'" alt="'.$offerAuthor.'"></a><div class="classiera_user_message__box"><span>'.esc_html__( "BID PRICE", "classiera" ).'&nbsp;:&nbsp;'.$offer_price.'</span><p>'.$offer_comment.'</p><p class="classiera_user_message__time">'.$OfferDate.'</p></div></div>';

				//Main Comment//

				//Get Sub Comments//

				$subComments = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_inbox_meta WHERE main_comment_id = $thiscommentID ORDER BY id ASC" );

				if($subComments){

					foreach($subComments as $info){

						$reply_check = $info->reply_check;

						$post_author_id = $info->post_author_id;

						$offer_author_id = $info->offer_author_id;

						$comment_reply = $info->comment_reply;

						$innerDate = $info->date;

						//$innerDate = date($dateFormat, $innerDate);

						$innerDate = date_i18n($dateFormat,  strtotime($innerDate));

						if($reply_check == 'user'){

							$user = get_the_author_meta('display_name', $offer_author_id );

							if(empty($user)){

								$user = get_the_author_meta('user_nicename', $offer_author_id );

							}

							if(empty($user)){

								$user = get_the_author_meta('user_login', $offer_author_id );

							}

							$userIMG = get_user_meta($offer_author_id, "classify_author_avatar_url", true);

							$userIMG = classiera_get_profile_img($userIMG);

							if(empty($userIMG)){										

								$userIMG = classiera_get_avatar_url ($offer_author_id, $size = '150' );

							}

							$userHTML = '<div class="classiera_user_message"><a href="#"><img class="img-circle classiera_user_message_img" src="'.$userIMG.'" alt="'.$user.'"></a><div class="classiera_user_message__box"><p>'.$comment_reply.'</p><p class="classiera_user_message__time">'.$innerDate.'</p></div></div>';

						}elseif($reply_check == 'author'){

							$author = get_the_author_meta('display_name', $post_author_id );

							if(empty($author)){

								$author = get_the_author_meta('user_nicename', $post_author_id );

							}

							if(empty($author)){

								$author = get_the_author_meta('user_login', $post_author_id );

							}

							$userIMG = get_user_meta($post_author_id, "classify_author_avatar_url", true);

							$userIMG = classiera_get_profile_img($userIMG);

							if(empty($userIMG)){										

								$userIMG = classiera_get_avatar_url ($post_author_id, $size = '150' );

							}							

							$userHTML = '<div class="classiera_user_message classiera_user_message__reply"><a href="#"><img class="img-circle classiera_user_message_img" src="'.$userIMG.'" alt="'.$author.'"><p>'.$author.'</p></a><div class="classiera_user_message__box"><p>'.$comment_reply.'</p><p class="classiera_user_message__time">'.$innerDate.'</p></div></div>';

						}

						//$innerComment .= $userHTML.$authorHTML;

						$innerComment .= $userHTML;

					}

				}

				//Get Sub Comments//

				echo '<div class="modal-header" id="'.$commentID.'"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title text-uppercase" id="myModalLabel">'.esc_html__( "Ad Title", "classiera" ).' : <span>'.$postTitle.'</span></h4></div><div class="modal-body classiera_show_reply">'.$mainHTML.$innerComment.'</div><form method="post" class="classiera_user_message__form" id="resetReply"><textarea class="form-control classiera_comment_reply" placeholder="'.esc_html__( "Type your message..", "classiera" ).'" required></textarea><input type="hidden" value="'.$thiscommentID.'" class="main_comment_ID"><input type="hidden" value="'.$currentUserID.'" class="current_user_id"><button type="submit" class="classiera_user_message__form_btn">'.esc_html__( "SEND", "classiera" ).'</button></form>';

			endforeach;			

			$deleteRead = ("DELETE from {$wpdb->prefix}classiera_inbox_read WHERE message_id = $commentID");

			$wpdb->query($deleteRead);

			//echo wp_kses_post($html);

		}

	}

	if(isset($_POST['main_comment_ID'])){

		$main_comment_ID = $_POST['main_comment_ID'];

		$commentData = $_POST['commentData'];

		if(empty($commentData) || $commentData == ''){

			$html = '<p class="alert alert-warning">'.esc_html__( "You must need to type some comment..!", "classiera" ).'</p>';

		}else{

			$post_author_id = '';

			$offer_author_id = '';

			$currentUserID = get_current_user_id();

			$getMainComment = $wpdb->get_results( "SELECT id, post_author_id, offer_author_id FROM {$wpdb->prefix}classiera_inbox WHERE id = $main_comment_ID" );

			if($getMainComment){

				foreach ( $getMainComment as $offerinfo ) :

					$thiscommentID = $offerinfo->id;

					$post_author_id = $offerinfo->post_author_id;

					$offer_author_id = $offerinfo->offer_author_id;

				endforeach;

			}

			if($currentUserID == $post_author_id){

				$reply_check = 'author';

				//Insert data for user to read message//

				/*$readMessage = array(

					'id' =>'', 

					'message_id' => $main_comment_ID, 

					'recipient_id' => $offer_author_id,

					'message_status' => 'unread',

				);

				$statusformat = array('%d', '%d', '%s', '%s');

				$statusTable = $wpdb->prefix . 'classiera_inbox_read'; 

				$wpdb->insert($statusTable, $readMessage, $statusformat);*/

				//Insert data for user to read message//

			}elseif($currentUserID == $offer_author_id){

				$reply_check = 'user';

				//Insert data into readUnRead table//

				$readMessage = array(

					'id' =>'', 

					'message_id' => $main_comment_ID, 

					'recipient_id' => $post_author_id,

					'message_status' => 'unread',

				);

				$statusformat = array('%d', '%d', '%s', '%s');

				$statusTable = $wpdb->prefix . 'classiera_inbox_read'; 

				$wpdb->insert($statusTable, $readMessage, $statusformat);

				//Insert data into readUnRead table//

			}

			$replyMessage = array(

				'id' =>'', 

				'main_comment_id' => $main_comment_ID, 

				'post_author_id' => $post_author_id,

				'offer_author_id' => $offer_author_id,

				'comment_reply' => $commentData,

				'reply_check' => $reply_check,

				'date' => time() 

			);

			$insert_format = array('%d', '%s', '%s', '%s', '%s', '%s', '%s');

			$tablename = $wpdb->prefix . 'classiera_inbox_meta'; 

			$wpdb->insert($tablename, $replyMessage, $insert_format);			

			//Comment reply data//

			$author = get_the_author_meta('display_name', $currentUserID );

			if(empty($author)){

				$author = get_the_author_meta('user_nicename', $currentUserID );

			}

			if(empty($author)){

				$author = get_the_author_meta('user_login', $currentUserID );

			}

			$offerAuthorIMG = get_user_meta($currentUserID, "classify_author_avatar_url", true);

			$offerAuthorIMG = classiera_get_profile_img($offerAuthorIMG);

			if(empty($offerAuthorIMG)){										

				$offerAuthorIMG = classiera_get_avatar_url ($currentUserID, $size = '150' );

			}

			$date = time();

			//$replydate = date($dateFormat, $date);

			$replydate = date_i18n($dateFormat,  strtotime($date));

			if($currentUserID == $offer_author_id){

				$html = '<div class="classiera_user_message"><a href="#"><img class="img-circle classiera_user_message_img" src="'.$offerAuthorIMG.'" alt="'.$author.'"></a><div class="classiera_user_message__box"><p>'.$commentData.'</p><p class="classiera_user_message__time">'.$replydate.'</p></div></div>';

			}elseif($currentUserID == $post_author_id){

				$html = '<div class="classiera_user_message classiera_user_message__reply"><a href="#"><img class="img-circle classiera_user_message_img" src="'.$offerAuthorIMG.'" alt="'.$author.'"><p>'.$author.'</p></a><div class="classiera_user_message__box"><p>'.$commentData.'</p><p class="classiera_user_message__time">'.$replydate.'</p></div></div>';

			}			

			

		}

		echo wp_kses_post($html);

	}

	die();

}

/*==========================

 Get BID Comment List AJAX Function

 ===========================*/

add_action( 'wp_ajax_classiera_get_comment_list', 'classiera_get_comment_list' );

add_action( 'wp_ajax_nopriv_classiera_get_comment_list', 'classiera_get_comment_list' );

function classiera_get_comment_list(){

	global $wpdb;

	$dateFormat = get_option( 'date_format' );

	if(isset($_POST['offer_post_id'])){

		$offer_post_id = $_POST['offer_post_id'];		

		$commentsData = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_inbox WHERE offer_post_id = $offer_post_id" );

		if($commentsData){

			$count = 1;

			$commentClass = 'readed';

			echo '<div role="tabpanel" class="tab-pane active">';

			foreach($commentsData as $info){

				$offer_post_id = $info->offer_post_id;

				$offer_post_price = $info->offer_post_price;

				$post_author_id = $info->post_author_id;

				$offer_author_id = $info->offer_author_id;

				$offer_price = $info->offer_price;

				$offer_comment = $info->offer_comment;

				$thiscommentID = $info->id;

				$date = $info->date;				

				//$OfferDate = date($dateFormat, $date);

				$OfferDate = date_i18n($dateFormat,  strtotime($date));

				$postTitle = get_the_title($offer_post_id);

				$offerAuthor = get_the_author_meta('display_name', $offer_author_id );

				if(empty($offerAuthor)){

					$offerAuthor = get_the_author_meta('user_nicename', $offer_author_id );

				}

				if(empty($offerAuthor)){

					$offerAuthor = get_the_author_meta('user_login', $offer_author_id );

				}

				$offerAuthorIMG = get_user_meta($offer_author_id, "classify_author_avatar_url", true);

				$offerAuthorIMG = classiera_get_profile_img($offerAuthorIMG);

				if(empty($offerAuthorIMG)){										

					$offerAuthorIMG = classiera_get_avatar_url ($offer_author_id, $size = '150' );

				}

				$readUnRead = classiera_unread_message_comment($thiscommentID);

				if($readUnRead > 0){

					$commentClass = 'unread';

				}

				if($count == 1){

					echo '<h5 class="text-uppercase user_comment_inner_head">'.esc_html__( 'Ad Title', 'classiera' ).' : <span>'.$postTitle.'</span></h5>';

				}

				echo '<div class="user_comment_box '.$commentClass.'"><a href="#" id="'.$thiscommentID.'" class="user_comment user_comment_inner" data-toggle="modal" data-target="#classieraChatModal"><div class="user_comment_img_box"><img class="user_comment_img img-circle" src="'.$offerAuthorIMG.'" alt="'.$offerAuthor.'"><span class="text-uppercase user_comment_author">'.$offerAuthor.'</span></div><div class="user_comment_body"><p class="text-capitalize short__comment">'.$offer_comment.'</p></div><div class="user_comment_date"><span>'.$OfferDate.'</span></div></a><form method="post"><input type="hidden" name="del_comment_id" value="'.$thiscommentID.'"><button type="submit" class="classiera_del_comment" name="del_comment" id="'.$thiscommentID.'"><i class="fa fa-trash-alt"></i></button></form></div>';

				$count++;

			}

			echo '</div>';

		}

	}

	if(isset($_POST['commentID'])){

		$commentID = $_POST['commentID'];

		$commentsData = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_inbox WHERE id = $commentID" );

		if($commentsData){

			foreach($commentsData as $info){

				$offer_post_id = $info->offer_post_id;

				$offer_post_price = $info->offer_post_price;

				$post_author_id = $info->post_author_id;

				$offer_author_id = $info->offer_author_id;

				$offer_price = $info->offer_price;

				$offer_comment = $info->offer_comment;

				$thiscommentID = $info->id;

				$date = $info->date;				

				//$OfferDate = date($dateFormat, $date);

				$OfferDate = date_i18n($dateFormat,  strtotime($date));

				$postTitle = get_the_title($offer_post_id);

				$offerAuthor = get_the_author_meta('display_name', $offer_author_id );

				if(empty($offerAuthor)){

					$offerAuthor = get_the_author_meta('user_nicename', $offer_author_id );

				}

				if(empty($offerAuthor)){

					$offerAuthor = get_the_author_meta('user_login', $offer_author_id );

				}

				$offerAuthorIMG = get_user_meta($offer_author_id, "classify_author_avatar_url", true);

				$offerAuthorIMG = classiera_get_profile_img($offerAuthorIMG);

				if(empty($offerAuthorIMG)){										

					$offerAuthorIMG = classiera_get_avatar_url ($offer_author_id, $size = '150' );

				}

				echo '<h5 class="text-uppercase user_comment_inner_head">'.esc_html__( 'Ad Title', 'classiera' ).' : <span>'.$postTitle.'</span></h5>';

				echo '<div class="modal-dialog" role="document">';

				echo '<div class="modal-content classiera_comment_ajax">';

				echo '<div class="modal-body classiera_show_reply" id="'.$thiscommentID.'">';

					//First Message Box//

					echo '<div class="classiera_user_message">';

						echo '<a href="#"><img class="img-circle classiera_user_message_img" src="'.$offerAuthorIMG.'" alt="'.$offerAuthor.'"></a>';

						echo '<div class="classiera_user_message__box">';

							echo '<span>'.esc_html__( 'BID PRICE', 'classiera' ).' : '.$offer_price.'</span>';

							echo '<p>'.$offer_comment.'</p>';

							echo '<p class="classiera_user_message__time">'.$OfferDate.'</p>';

						echo '</div>';

					echo '</div>';

					//First Message Box//

					$subComments = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_inbox_meta WHERE main_comment_id = $thiscommentID ORDER BY id ASC" );

					if($subComments){

						foreach($subComments as $info){

							$reply_check = $info->reply_check;

							$post_author_id = $info->post_author_id;

							$offer_author_id = $info->offer_author_id;

							$comment_reply = $info->comment_reply;

							$innerDate = $info->date;

							//$innerDate = date($dateFormat, $innerDate);

							$innerDate = date_i18n($dateFormat,  strtotime($innerDate));

							if($reply_check == 'user'){

								$user = get_the_author_meta('display_name', $offer_author_id );

								if(empty($user)){

									$user = get_the_author_meta('user_nicename', $offer_author_id );

								}

								if(empty($user)){

									$user = get_the_author_meta('user_login', $offer_author_id );

								}

								$userIMG = get_user_meta($offer_author_id, "classify_author_avatar_url", true);

								$userIMG = classiera_get_profile_img($userIMG);

								if(empty($userIMG)){

									$userIMG = classiera_get_avatar_url ($offer_author_id, $size = '150' );

								}

								echo '<div class="classiera_user_message"><a href="#"><img class="img-circle classiera_user_message_img" src="'.$userIMG.'" alt="'.$user.'"></a><div class="classiera_user_message__box"><p>'.$comment_reply.'</p><p class="classiera_user_message__time">'.$innerDate.'</p></div></div>';

								

							}elseif($reply_check == 'author'){

								$author = get_the_author_meta('display_name', $post_author_id );

								if(empty($author)){

									$author = get_the_author_meta('user_nicename', $post_author_id );

								}

								if(empty($author)){

									$author = get_the_author_meta('user_login', $post_author_id );

								}

								$userIMG = get_user_meta($post_author_id, "classify_author_avatar_url", true);

								$userIMG = classiera_get_profile_img($userIMG);

								if(empty($userIMG)){

									$userIMG = classiera_get_avatar_url ($post_author_id, $size = '150' );

								}

								echo '<div class="classiera_user_message classiera_user_message__reply"><a href="#"><img class="img-circle classiera_user_message_img" src="'.$userIMG.'" alt="'.$author.'"><p>'.$author.'</p></a><div class="classiera_user_message__box"><p>'.$comment_reply.'</p><p class="classiera_user_message__time">'.$innerDate.'</p></div></div>';

							}

						}

					}

				echo '</div>';

					echo '<form method="post" id="resetReply" class="classiera_user_message__form"><textarea class="form-control classiera_comment_reply" placeholder="'.esc_html__( "Type your message..", "classiera" ).'" required></textarea><input type="hidden" value="'.$thiscommentID.'" class="main_comment_ID"><button type="submit" class="classiera_user_message__form_btn">'.esc_html__( "SEND", "classiera" ).'</button></form>';

				echo '</div>';

				echo '</div>';

				

			}

		}

	}

	die();

}

add_action( 'wp_ajax_classiera_get_user_message_status', 'classiera_get_user_message_status' );

add_action( 'wp_ajax_nopriv_classiera_get_user_message_status', 'classiera_get_user_message_status' );

function classiera_get_user_message_status(){

	if(isset($_POST['recipient_id']) && $_POST['recipient_id'] != ''){

		$recipient_id = $_POST['recipient_id'];

		global $redux_demo;

		$classieraInbox = $redux_demo['classiera_inbox_page_url'];

		global $wpdb;

		$countunRead = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}classiera_inbox_read WHERE recipient_id = $recipient_id" );

		if($countunRead > 0 && $countunRead != 0){

			echo '<a href="'.$classieraInbox.'" class="bid_notification"><span class="bid_notification__icon"><i class="fa fa-bell"></i></span><span class="bid_notification__count">'.$countunRead.'</span></a>';

		}else{

			die();

		}

		die();

	}

	die();

}

?>
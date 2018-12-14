<?php
function theme_enqueue_styles() {
	
	if(is_rtl()){
		wp_enqueue_style( 'child-rtl', get_stylesheet_directory_uri() . '/rtl.css' );
	}
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
	wp_enqueue_script('classiera-child', get_stylesheet_directory_uri() . '/classiera-child.js', 'jquery', '', true);
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function experied_ads_checksum()
{
    global $wpdb;
    $posts=$wpdb->prefix.'posts';
    $postmeta=$wpdb->prefix.'postmeta';
    $sql="SELECT a.ID,DATEDIFF(NOW(),b.`meta_value`) as diffTime from `".$posts."` as a join `".$postmeta."` as b on( meta_key='days_to_expire' AND a.ID=b.`post_id`) WHERE post_type = 'post' AND post_status = 'publish'";
    $queryRes=$wpdb->get_results($sql);
   // print_r($queryRes);die;
    if($queryRes){
	    foreach ($queryRes as $key ) {
	    if($key->diffTime >= 0)
	        {
	            $sql2="UPDATE $posts
	             SET post_status = 'draft'
	             WHERE (ID = '".$key->ID."')"; 
	             $wpdb->query($sql2);
	        }
	    }
	}
}
add_action('wp_head','experied_ads_checksum');

add_filter('add_to_cart_redirect', 'cw_redirect_add_to_cart');
function cw_redirect_add_to_cart() {
    global $woocommerce;
    $cw_redirect_url_checkout = $woocommerce->cart->get_checkout_url();
    return $cw_redirect_url_checkout;
}

if( function_exists( 'add_image_size' ) ) {

    add_image_size( 'medium', 300, 200, false );
    add_image_size( 'large', 1024, 1024, false );
}



remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
add_action( 'woocommerce_proceed_to_checkout', 'custom_widget_shopping_cart_proceed_to_checkout', 20 );
// Custom Checkout button
function custom_widget_shopping_cart_proceed_to_checkout() {
    // $original_link = wc_get_checkout_url();
    // $custom_link = esc_url( $classieraGetCredits ); // HERE replacing checkout link
    echo '<a href="javascript:void(0)" class="checkout-button button alt wc-forward">' . esc_html__( 'Checkout', 'woocommerce' ) . '</a>';
}

add_action( 'wp_ajax_add_to_cart_ajax','add_to_cart_ajax' );
add_action( 'wp_ajax_nopriv_add_to_cart_ajax','add_to_cart_ajax' );
function add_to_cart_ajax(){

    if(!isset($_POST['checkout_active'])){
    global $woocommerce;

    $woocommerce->cart->maybe_set_cart_cookies(true);
    $woocommerce->cart->add_to_cart( $_POST['productid'] );
    $woocommerce->cart->get_cart_contents_count();
    echo do_shortcode('[woocommerce_cart]').'<script>jQuery("a.checkout-button").click( function(event) {
        event.preventDefault();
        var ajaxurl = "'.admin_url('admin-ajax.php').'";
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                "action":"add_to_cart_ajax",
                "checkout_active":"1",
            },
            success: function (responce) {
                jQuery(".gc_woocommercr_checkout").html(responce);
                jQuery(".gc_woocommercr_cart").hide();
                jQuery(".getCreditRow").hide();

            },
            error: function (errorThrown) {

            }
        });   
    });</script>';
    }
    else
    {
        echo do_shortcode('[woocommerce_checkout]');
    }
    exit(0);
    //wp_die();
}

add_action( 'wp_ajax_re_activate_ads','re_activate_ads' );
add_action( 'wp_ajax_nopriv_re_activate_ads','re_activate_ads' );
function re_activate_ads()
{
    $post_id=$_POST['post_id'];
    update_post_meta($post_id, 'classiera_ads_status','1');
}

function count_user_posts_child($user_id)
{
    global $wpdb;
    $table=$wpdb->prefix.'posts';
    $sql="SELECT COUNT(ID) count FROM $table WHERE `post_author` = $user_id AND `post_status`='publish' AND `post_type`='post'";
    $getfirstsent = $wpdb->get_results($sql);
    //print_r($getfirstsent);
    return $getfirstsent[0]->count;
}

function count_user_message($user_id)
{
    global $wpdb;
    $table=$wpdb->prefix.'classiera_inbox_read';
    $sql="SELECT COUNT(ID) count FROM $table WHERE `recipient_id` = $user_id ";
    $getfirstsent = $wpdb->get_results($sql);
    if($getfirstsent){
    return $getfirstsent[0]->count;
    }
    else
    {
        return 0;
    }
}
/*  Custom Redirect To thankyou page after payment woocommerce */
add_action( 'woocommerce_thankyou', 'ads_redirect_page');
 
function ads_redirect_page( $order_id ){
    $order = new WC_Order( $order_id );
    $templateProfile = 'template-profile.php';
    $classieraProfile = classiera_get_template_url($templateProfile);
    $url = $classieraProfile;
 
    if ( $order->status != 'failed' ) {
        wp_redirect($url);
        exit;
    }
}
add_action( 'woocommerce_order_status_completed', 'mysite_completed');
function mysite_completed($order_id) {
    $order = new WC_Order( $order_id );
    $order_total = $order->get_total();
    $user_id=get_current_user_id();
    $uw_balance=get_user_meta($user_id,'_uw_balance',true);
    $totalBal=$uw_balance+$order_total;
    update_user_meta($user_id,'_uw_balance',$totalBal);
}
if (!function_exists('child_classiera_unread_message_by_user')) {
    function child_classiera_unread_message_by_user($userID){
        global $wpdb;
        $readMessageQuery = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}classiera_inbox_read WHERE recipient_id = $userID" );
        return $readMessageQuery;
    }
}
if (!function_exists('child_classiera_unread_message_comment')) {
    function child_classiera_unread_message_comment($commentID){
        global $wpdb;
        $readMessageQuery = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}classiera_inbox_read WHERE message_id = $commentID" );
        return $readMessageQuery;
    }
}

/*==========================
 Count Total BID on a Post Function
 ===========================*/
if (!function_exists('child_classiera_bid_count')) {
    function child_classiera_bid_count($postID){
        global $post, $wpdb;        
        $countBids = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}ads_inbox WHERE post_id = $postID" );
        return $countBids; 
    }
}
/*==========================
 Delete BID Comment Function
 ===========================*/
if (!function_exists('child_classiera_delete_comment')) {
    function child_classiera_delete_comment($commentID){
        global $wpdb;       
        $runquery = ("DELETE FROM {$wpdb->prefix}ads_inbox WHERE id = $commentID");       
        $wpdb->query($runquery);
    }
}


/*==========================

 Get BID Comment AJAX Function

 ===========================*/

add_action( 'wp_ajax_child_classiera_get_comment_ajax', 'child_classiera_get_comment_ajax' );

add_action( 'wp_ajax_nopriv_child_classiera_get_comment_ajax', 'child_classiera_get_comment_ajax' );

function child_classiera_get_comment_ajax(){

    global $wpdb;

    global $post;

    $currentUserID = get_current_user_id();

    $dateFormat = get_option( 'date_format' );
    //print_r($_POST);

    if(isset($_POST['commentID'])){     

        $commentID = $_POST['commentID'];
        $getfirstComment = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ads_inbox WHERE id = $commentID ORDER BY id DESC" );

        if($getfirstComment){

            $html = '';

            $userHTML = '';

            $mainHTML = '';

            $authorHTML = '';

            $innerComment = '';

            foreach ( $getfirstComment as $offerinfo ) :

                $offer_post_id = $offerinfo->post_id;

                $post_author_id = $offerinfo->author_id;

                $offer_author_id = $offerinfo->enquery_author_id;

                // $offer_price = $offerinfo->offer_price;

                $offer_comment = $offerinfo->message;

                $thiscommentID = $offerinfo->id;

               // $date = $offerinfo->date;               

                //$OfferDate = date($dateFormat, $date);

                // $OfferDate = date_i18n($dateFormat,  strtotime($date));

                $postTitle = get_the_title($offer_post_id);

                $offerAuthor = $offerinfo->name;
                $offerAuthorIMG='';

                if(empty($offerAuthorIMG)){                                     

                    $offerAuthorIMG = classiera_get_avatar_url ($post_author_id, $size = '150' );

                }

                //Main Comment//

                $mainHTML = '<div class="classiera_user_message"><a href="#"><img class="img-circle classiera_user_message_img" src="'.$offerAuthorIMG.'" alt="'.$offerAuthor.'"></a><div class="classiera_user_message__box"><p>'.$offer_comment.'</p></div></div>';

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

            $getMainComment = $wpdb->get_results( "SELECT id, author_id, post_id,enquery_author_id FROM {$wpdb->prefix}ads_inbox WHERE id = $main_comment_ID" );

            if($getMainComment){

                foreach ( $getMainComment as $offerinfo ) :

                    $thiscommentID = $offerinfo->id;

                    $post_author_id = $offerinfo->author_id;

                    $offer_author_id = $offerinfo->enquery_author_id;

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

                'offer_author_id' => $offer_author_id ,

                'comment_reply' => $commentData,

                'reply_check' => $reply_check,

                'date' => time() 

            );

            $insert_format = array('%d', '%s', '%s', '%s', '%s', '%s', '%s');

            $tablename = $wpdb->prefix . 'classiera_inbox_meta'; 
            if($post_author_id!=0):
                $wpdb->insert($tablename, $replyMessage, $insert_format);
            endif;        

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
add_role( 'buyer', 'Buyer', array( 'read' => true, 'edit_posts' => true ) );
add_role( 'seller', 'Seller', array( 'read' => true, 'edit_posts' => true ) );

function getTplPageURL($TEMPLATE_NAME){ 
    $pages = query_posts(array( 'post_type' =>'page', 'meta_key' =>'_wp_page_template', 'meta_value'=> $TEMPLATE_NAME )); 
    $url = null; 
    if(isset($pages[0])) { 
        $url = get_page_link($pages[0]->ID); 
    } 
    return $url; 
}
add_image_size( 'advert_double', 400, 300, true );

add_action('wp_ajax_nopriv_bump_ads_post', 'bump_ads_post');
add_action('wp_ajax_bump_ads_post', 'bump_ads_post');
function bump_ads_post()
{
    global $wpdb;
    $post_id=$_POST['post_id'];
    $post = get_post( $post_id );
    $author_id=$post->post_author;
    $adsPostType=$_POST['adsPostType'];
    $posts=get_posts();
   // print_r($posts);
    foreach ($posts as $key ) {
         $adsBump=get_post_meta($key->ID,'bump_ads',true);
         $arr[]=$adsBump;
    }
    $max=max($arr);
    $uw_balance=get_user_meta($author_id,'_uw_balance', true);
    // if(! get_post_meta( $post_id, 'bump_ads', true )):
        if($adsPostType=='standard_top' || $adsPostType=='double_top')
        {
            $updated_bal=$uw_balance-10;
            update_user_meta($author_id,'_uw_balance',$updated_bal);
        }else
        {
            $updated_bal=$uw_balance-5;
            update_user_meta($author_id,'_uw_balance',$updated_bal);
        }
        update_post_meta($post_id,'bump_ads',$max+1);
    // endif;
    exit(0);
}
add_action('wp_ajax_nopriv_discount_ads_post', 'discount_ads_post');
add_action('wp_ajax_discount_ads_post', 'discount_ads_post');
function discount_ads_post()
{
    global $wpdb;
    $post_id=$_POST['post_id'];

    $discount_code=$_POST['discount_code'];
    update_post_meta($post_id,'discount_percentage',$discount_code);
    exit(0);
}

function submit_ads_scripts() {

    global $template;
    $template_array = explode('/',$template);

    if ( end($template_array) == 'template-submit-ads.php' ) {
        wp_enqueue_script('smart-wizard-js', get_stylesheet_directory_uri() . '/js/smartWizard.js', 'jQuery', '', true );
        wp_enqueue_script('selectize-js', get_stylesheet_directory_uri() . '/js/selectize.js', 'jQuery', '2.0', true );
        wp_enqueue_script('validator-js', get_stylesheet_directory_uri() . '/js/validator.min.js', 'jQuery', '2.0', true );
        wp_enqueue_style('selectize-css', get_stylesheet_directory_uri() . '/css/selectize.css' );
        wp_enqueue_style('croppic-css', get_stylesheet_directory_uri() . '/css/croppic.css' );
        wp_enqueue_script('croppic-js', get_stylesheet_directory_uri() . '/js/croppic.js', array( 'jquery' ), '', true );
    }
}
add_action( 'wp_enqueue_scripts', 'submit_ads_scripts' );

function edit_profile_scripts() {

    global $template;
    $template_array = explode('/',$template);

    if ( end($template_array) == 'template-edit-profile.php' ) {
        wp_enqueue_script('smart-wizard-js', get_stylesheet_directory_uri() . '/js/smartWizard.js', 'jQuery', '', true );
    }
}
add_action( 'wp_enqueue_scripts', 'edit_profile_scripts' );

function lightGallery_script() {

    if (is_single() ) {
        wp_enqueue_style('light-gallery-css', get_stylesheet_directory_uri() . '/css/lightgallery.css' );
        wp_enqueue_script('light-gallery-js', get_stylesheet_directory_uri() . '/js/lightgallery-all.min.js', 'jQuery', '20170816', true );
    }
}
add_action( 'wp_enqueue_scripts', 'lightGallery_script' );
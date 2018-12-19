<?php
/**
 * The Template for displaying all single posts.
 * 
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */
get_header(); ?>
  
  <?php while ( have_posts() ) : the_post(); ?>


<?php 

global $redux_demo; 
global $allowed_html; 
global $current_user; wp_get_current_user(); $user_ID == $current_user->ID;
$profileLink = get_the_author_meta( 'user_url', $user_ID );
$contact_email = get_the_author_meta('user_email');
$classieraContactEmailError = $redux_demo['contact-email-error'];
$classieraContactNameError = $redux_demo['contact-name-error'];
$classieraConMsgError = $redux_demo['contact-message-error'];
$classieraContactThankyou = $redux_demo['contact-thankyou-message'];
$classieraRelatedCount = $redux_demo['classiera_related_ads_count'];
$classieraSearchStyle = $redux_demo['classiera_search_style'];
$classieraSingleAdStyle = $redux_demo['classiera_single_ad_style'];
$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
$classieraComments = $redux_demo['classiera_sing_post_comments'];
$googleMapadPost = $redux_demo['google-map-adpost'];
$classieraToAuthor = $redux_demo['author-msg-box-off'];
$classieraReportAd = $redux_demo['classiera_report_ad'];
$locShownBy = $redux_demo['location-shown-by'];
$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
$classieraAuthorInfo = $redux_demo['classiera_author_contact_info'];
$classieraPriceSection = $redux_demo['classiera_sale_price_off'];
$classiera_bid_system = $redux_demo['classiera_bid_system'];
$category_icon_code = "";
$category_icon_color = "";
$your_image_url = "";

global $errorMessage;
global $emailError;
global $commentError;
global $subjectError;
global $humanTestError;
global $hasError;

//If the form is submitted
if(isset($_POST['submit'])) {
  if($_POST['submit'] == 'send_message'){
    //echo "send_message";

    //Check to make sure that the name field is not empty
    // if(trim($_POST['contactName']) === '') {
    //  $errorMessage = $classieraContactNameError;
    //  $hasError = true;
    // } elseif(trim($_POST['contactName']) === 'Name*') {
    //  $errorMessage = $classieraContactNameError;
    //  $hasError = true;
    // }  else {
    //  $name = trim($_POST['contactName']);
    // }

    //Check to make sure that the subject field is not empty
    if(trim($_POST['subject']) === '') {
      $errorMessage = $classiera_contact_subject_error;
      $hasError = true;
    } elseif(trim($_POST['subject']) === 'Subject*') {
      $errorMessage = $classiera_contact_subject_error;
      $hasError = true;
    } else {
      $subject = trim($_POST['subject']);
    }
    
    //Check to make sure sure that a valid email address is submitted
    // if(trim($_POST['email']) === ''){
    //  $errorMessage = $classieraContactEmailError;
    //  $hasError = true;   
    // }else{
    //  $email = trim($_POST['email']);
    // }
      
    //Check to make sure comments were entered  
    if(trim($_POST['comments']) === '') {
      $errorMessage = $classieraConMsgError;
      $hasError = true;
    } else {
      if(function_exists('stripslashes')) {
        $comments = stripslashes(trim($_POST['comments']));
      } else {
        $comments = trim($_POST['comments']);
      }
    }

    //Check to make sure that the human test field is not empty
    $classieraCheckAnswer = $_POST['humanAnswer'];
    if(trim($_POST['humanTest']) != $classieraCheckAnswer) {
      $errorMessage = esc_html__('Not Human', 'classiera');     
      $hasError = true;
    }
    $classieraPostTitle = $_POST['classiera_post_title']; 
    $classieraPostURL = $_POST['classiera_post_url'];
    
    //If there is no error, send the email    
    if(!isset($hasError)) {

      $emailTo = $contact_email;
      $subject = $subject;  
      $body = "Name: $name \n\nEmail: $email \n\nMessage: $comments";
      $headers = 'From <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
      
      //wp_mail($emailTo, $subject, $body, $headers);
      contactToAuthor($emailTo, $subject, $name, $email, $comments, $headers, $classieraPostTitle, $classieraPostURL);
      $emailSent = true;      

    }
  }
  // if($_POST['submit'] == 'report_to_admin'){    
  //   $displayMessage = '';
  //   $report_ad = $_POST['report_ad_val'];
  //   if($report_ad == "illegal") {
  //     $message = esc_html__('This is illegal/fraudulent Ads, please take action.', 'classiera');
  //   }
  //   if($report_ad == "spam") {
  //     $message = esc_html__('This Ad is SPAM, please take action', 'classiera');      
  //   }
  //   if($report_ad == "duplicate") {
  //     $message = esc_html__('This ad is a duplicate, please take action', 'classiera');     
  //   }
  //   if($report_ad == "wrong_category") {
  //     $message = esc_html__('This ad is in the wrong category, please take action', 'classiera');     
  //   }
  //   if($report_ad == "post_rules") {
  //     $message = esc_html__('The ad goes against posting rules, please take action', 'classiera');      
  //   }
  //   if($report_ad == "post_other") {
  //     $message = $_POST['other_report'];        
  //   }   
  //   $classieraPostTitle = $_POST['classiera_post_title']; 
  //   $classieraPostURL = $_POST['classiera_post_url'];
  //   //print_r($message); exit();
  //   classiera_reportAdtoAdmin($message, $classieraPostTitle, $classieraPostURL);
  //   if(!empty($message)){
  //     $displayMessage = esc_html__('Thanks for report, Our Team will take action ASAP.', 'classiera');
  //   }
  // }
  
}
if(isset($_POST['favorite'])){
  $author_id = $_POST['author_id'];
  $post_id = $_POST['post_id'];
  echo classiera_favorite_insert($author_id, $post_id);
}
if(isset($_POST['follower'])){  
  $author_id = $_POST['author_id'];
  $follower_id = $_POST['follower_id'];
  echo classiera_authors_insert($author_id, $follower_id);
}
if(isset($_POST['unfollow'])){
  $author_id = $_POST['author_id'];
  $follower_id = $_POST['follower_id'];
  echo classiera_authors_unfollow($author_id, $follower_id);
}

  //Search Styles//
  if($classieraSearchStyle == 1){
    get_template_part( 'templates/searchbar/searchstyle1' );
  }elseif($classieraSearchStyle == 2){
    get_template_part( 'templates/searchbar/searchstyle2' );
  }elseif($classieraSearchStyle == 3){
    get_template_part( 'templates/searchbar/searchstyle3' );
  }elseif($classieraSearchStyle == 4){
    get_template_part( 'templates/searchbar/searchstyle4' );
  }elseif($classieraSearchStyle == 5){
    get_template_part( 'templates/searchbar/searchstyle5' );
  }elseif($classieraSearchStyle == 6){
    get_template_part( 'templates/searchbar/searchstyle6' );
  }elseif($classieraSearchStyle == 7){
    get_template_part( 'templates/searchbar/searchstyle7' );
  }

global $redux_demo;
$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
global $post;
$postID = '';
$current_user = wp_get_current_user();
$edit_post_page_id = $redux_demo['edit_post'];
if(function_exists('icl_object_id')){
  $templateEditAd = 'template-edit-post.php';   
  $edit_post_page_id = classiera_get_template_url($templateEditAd);
}
$postID = $post->ID;
global $wp_rewrite;
if ($wp_rewrite->permalink_structure == ''){
  $edit_post = $edit_post_page_id."&post=".$postID;
}else{
  $edit_post = $edit_post_page_id."?post=".$postID;
}
/*PostMultiCurrencycheck*/
$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
if(!empty($post_currency_tag)){
  $classieraCurrencyTag = classiera_Display_currency_sign($post_currency_tag);
}else{
  global $redux_demo;
  $classieraCurrencyTag = $redux_demo['classierapostcurrency'];
}
/*PostMultiCurrencycheck*/

$post_price = get_post_meta($post->ID, 'post_price', true); 
$post_old_price = get_post_meta($post->ID, 'post_old_price', true);
$postVideo = get_post_meta($post->ID, 'post_video', true);
$dateFormat = get_option( 'date_format' );
$postDate = get_the_date($dateFormat, $post->ID);
$itemCondition = get_post_meta($post->ID, 'item-condition', true); 
$post_location = get_post_meta($post->ID, 'post_location', true);
$post_state = get_post_meta($post->ID, 'post_state', true);
$post_city = get_post_meta($post->ID, 'post_city', true);
$post_phone = get_post_meta($post->ID, 'post_phone', true);
$post_latitude = get_post_meta($post->ID, 'post_latitude', true);
$post_longitude = get_post_meta($post->ID, 'post_longitude', true);
$post_address = get_post_meta($post->ID, 'post_address', true);
$classieraCustomFields = get_post_meta($post->ID, 'custom_field', true);

// My Additions
$second_phone = get_post_meta($post->ID, 'second_phone', true);
$nationality = get_post_meta($post->ID, 'nationality', true);
$user_age = get_post_meta($post->ID, 'user_age', true);
$hair_color = get_post_meta($post->ID, 'hair_color', true);
$eyes_color = get_post_meta($post->ID, 'eyes_color', true);
$ethnicity = get_post_meta($post->ID, 'ethnicity', true);
$height_feet = get_post_meta($post->ID, 'height_feet', true);
$height_inches = get_post_meta($post->ID, 'height_inches', true);
$weight = get_post_meta($post->ID, 'weight', true);
$breast_type = get_post_meta($post->ID, 'breast_type', true);
$breast_size = get_post_meta($post->ID, 'breast_size', true);
$breast_size_cup = get_post_meta($post->ID, 'breast_size_cup', true);
$breast_size_cup = get_post_meta($post->ID, 'breast_size_cup', true);
$waist_size = get_post_meta($post->ID, 'waist_size', true);
$hips_size = get_post_meta($post->ID, 'hips_size', true);
$dress_size = get_post_meta($post->ID, 'dress_size', true);
$shoe_size = get_post_meta($post->ID, 'shoe_size', true);
$pubic_area = get_post_meta($post->ID, 'pubic_area', true);
$smoker = get_post_meta($post->ID, 'smoker', true);
$native_language = get_post_meta($post->ID, 'native_language', true);
$language_1 = get_post_meta($post->ID, 'language_1', true);
$language_1_level = get_post_meta($post->ID, 'language_1_level', true);
$language_2 = get_post_meta($post->ID, 'language_2', true);
$language_2_level = get_post_meta($post->ID, 'language_2_level', true);
$private_numbers = get_post_meta($post->ID, 'private_numbers', true);
$sms_messages = get_post_meta($post->ID, 'sms_messages', true);
$private_messages = get_post_meta($post->ID, 'private_messages', true);
$disabled_friendly = get_post_meta($post->ID, 'disabled_friendly', true);
$drinks_supplied = get_post_meta($post->ID, 'drinks_supplied', true);
$showers_available = get_post_meta($post->ID, 'showers_available', true);
$can_travel = get_post_meta($post->ID, 'can_travel', true);
//Prices
$fifteen_min_euro = get_post_meta($post->ID, 'fifteen_min_euro', true);
$fifteen_min_pound = get_post_meta($post->ID, 'fifteen_min_pound', true);
$thirty_min_euro = get_post_meta($post->ID, 'thirty_min_euro', true);
$thirty_min_pound = get_post_meta($post->ID, 'thirty_min_pound', true);
$fourty_five_min_euro = get_post_meta($post->ID, 'fourty_five_min_euro', true);
$fourty_five_min_pound = get_post_meta($post->ID, 'fourty_five_min_pound', true);
$one_hour_euro = get_post_meta($post->ID, 'one_hour_euro', true);
$one_hour_pound = get_post_meta($post->ID, 'one_hour_pound', true);
$full_day_euro = get_post_meta($post->ID, 'full_day_euro', true);
$full_day_pound = get_post_meta($post->ID, 'full_day_pound', true);
$business_date_euro = get_post_meta($post->ID, 'business_date_euro', true);
$business_date_pound = get_post_meta($post->ID, 'business_date_pound', true);
$images_verified = get_post_meta($post->ID, 'images_verified', true);
$age_verified = get_post_meta($post->ID, 'age_verified', true);


$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
//$user_age = get_post_meta($post->ID, 'post_age', true);

$croppedImg_Path = get_post_meta($post->ID, 'croppedImg_Path', true);
// $attachmentFiles = get_attached_file($post->ID);
// print_r($attachmentFiles);
?>

  <!-- Add your site or application content here -->
  <div class="container main-wrapper"><!-- Main Wrapper -->

    <div class="row"><!-- breadcrumbs row -->
      <div class="col-lg-12">
        <?php classiera_breadcrumbs();?>
      </div>
    </div><!-- / Breadcrumbs row -->

    <div class="row"><!-- Author and images row -->
      <div class="col-xs-12 col-sm-12 col-lg-3 author-container"><!-- Author Conatiner -->
        <div class="thumbnail">
          <img src="<?=$croppedImg_Path?>" alt="Author Portrait">
          <!-- <img src="https://via.placeholder.com/255x343" alt="Author Portrait"> -->
          <!-- https://via.placeholder.com/255x343 -->
          <div class="caption clearfix">

            <!-- Name -->
            <h3><?php the_title(); ?></h3>
            <!--  / Name -->

            <!-- Age -->
            <?php if(!empty($user_age)) {?>
	            <p><?php esc_html_e( 'Age ', 'classiera' ); ?>:

	            	<?php $meta = get_post_meta( get_the_ID(), 'age_verified', true );
	            		//print_r($meta);
	            	    if ($meta == '1') { ?>
	            	        <span class="glyphicon glyphicon-ok pull-right verified age-icon" data-toggle="tooltip" data-placement="top" title="Age Verified" style="margin-left: 5px"></span>
	            	    <?php } else { ?>
	            	        <span class="glyphicon glyphicon-remove pull-right not-verified age-icon" data-toggle="tooltip" data-placement="top" title="Age Verified" style="margin-left: 5px"></span>
	            	    <?php }
	            	 ?>
	              <span class="pull-right"><?php echo esc_html($user_age); ?></span>
	            </p>
            <?php }?>
            <!-- / Age -->

            <p>Type: <span class="pull-right"><?php classiera_Display_cat_level($post->ID); ?></span></p>

            <!-- Phone -->
            <?php if(!empty($post_phone)){?>
              <p><?php esc_html_e( 'Phone Number', 'classiera' ); ?>: 
                <a class="pull-right" href="tel:<?php echo esc_html($post_phone); ?>">
                  <?php echo esc_html($post_phone); ?>
                </a>
              </p>
            <?php } ?>
            <!-- / Phone -->

            <!-- Phone 2 -->
            <?php if(!empty($second_phone)){?>
              <p><?php esc_html_e( 'Alternative Number', 'classiera' ); ?>: 
                <a class="pull-right" href="tel:<?php echo esc_html($second_phone); ?>">
                  <?php echo esc_html($second_phone); ?>
                </a>
              </p>
            <?php } ?>
            <!-- / Phone 2 -->
            
            <!-- City --> 
            <?php if(!empty($post_city)){?>
            <p><?php esc_html_e( 'Location ', 'classiera' ); ?>:
              <span class="pull-right"><?php echo esc_attr($post_city); ?></span>
            </p>
            <?php } ?>
            <!-- / City -->
            <p><?php esc_html_e( 'Images Verified', 'classiera' ); ?>:
	            <?php $meta = get_post_meta( get_the_ID(), 'images_verified', true );
	            	//print_r($meta);
	                if ($meta == '1') { ?>
	                    <span class="pull-right image-verification verified" data-toggle="tooltip" data-placement="top" title="Images Verified"><span class="glyphicon glyphicon-ok"></span></span>
	                <?php } else { ?>
	                    <span class="pull-right not-verified" data-toggle="tooltip" data-placement="top" title="Images Not Verified"><span class="glyphicon glyphicon-remove"></span>
	                <?php }
	             ?>
            </p>
            <!-- Check If user looged in and Display PM Button according to User Role -->
            <?php 
                global $user_login, $current_user;
                wp_get_current_user();
                $user_info = get_userdata($current_user->ID);
                $roles = array (
                    'administrator',
                    'buyer'
                );
            ?>
            <?php if (is_user_logged_in() && array_intersect( $roles, $user_info->roles)) { ?>
              <button class="btn btn-primary btn-block" data-toggle="modal" data-target=".bs-example-modal-sm"><?php esc_html_e( 'Send PM', 'classiera' ); ?></button>
            <?php } elseif (in_array( 'seller', (array) $current_user->roles )) { ?>
              <!-- <button class="btn btn-primary btn-block disabled" type="submit"><?php esc_html_e( 'You can not send PM', 'classiera' ); ?></button> -->
              <p><?php esc_html_e( 'Views', 'classiera' ); ?>: <span class="pull-right"><?php echo classiera_get_post_views(get_the_ID()); ?></span></p>
            <?php } else { ?>
              <button class="btn btn-primary btn-block disabled" type="submit"><?php esc_html_e( 'Login to Send PM', 'classiera' ); ?></button>
            <?php } ?>
            <!-- / Check If user looged in and Display Form -->
            
            <!-- Modal Window -->
            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog">
              <?php 
              $classieraWidgetClass = "widget-content-post";
              $classieraMakeOffer = "user-make-offer-message widget-content-post-area";
              if($classieraSingleAdStyle == 1){
              $classieraWidgetClass = "widget-content-post";
              $classieraMakeOffer = "user-make-offer-message widget-content-post-area";
              }
              ?>

              <form data-toggle="validator" id="classiera_offer_form" method="post"><!-- Begin Form -->
              <span class="classiera--loader"><img src="<?php echo get_template_directory_uri().'/images/loader.gif' ?>" alt="classiera loader"></span><!-- Loader Container -->
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><?php esc_html_e( 'Private Message to', 'classiera' ); ?> <?php the_title(); ?></h4>
                    </div>
                    <div id="pm-modal" class="modal-body">
                      <div class="form-group input-group-lg">
                        <input type="text" class="form-control offer_price" name="offer_price" placeholder="<?php esc_html_e( 'Subject', 'classiera' ); ?>">
                        <div class="help-block with-errors"></div>
                      </div>
                      <div class="form-group input-group-lg">
                        <textarea class="offer_comment" data-error="<?php esc_html_e( 'You need to enter some information', 'classiera' ); ?>" name="offer_comment" placeholder="<?php esc_html_e( 'Message', 'classiera' ); ?>" required></textarea>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <?php 
                    $postAuthorID = $post->post_author;
                    $currentLoggedAuthor = wp_get_current_user();
                    $offerAuthorID = $currentLoggedAuthor->ID;
                    ?>
                    <input type="hidden" class="offer_post_id" name="offer_post_id" value="<?php echo esc_attr($post->ID);?>">
                    <input type="hidden" class="post_author_id" name="post_author_id" value="<?php echo esc_attr($postAuthorID); ?>">
                    <input type="hidden" class="offer_author_id" name="offer_author_id" value="<?php echo esc_attr($offerAuthorID); ?>">
                    <input type="hidden" class="offer_post_price" name="offer_post_price" value="<?php if(is_numeric($post_price)){ echo classiera_post_price_display($post_currency_tag, $post_price); }else{ echo esc_attr($post_price); }?>">
                    <?php 
                      $classieraFirstNumber = rand(1,9);
                      $classieraLastNumber = rand(1,9);
                      $classieraNumberAnswer = $classieraFirstNumber + $classieraLastNumber;
                    ?>

                    <div class="form-group clearfix">
                      <div class="col-sm-6">
                        <span class="control-label"><?php esc_html_e("Please input the result of ", "classiera"); ?>
                        <?php echo esc_attr($classieraFirstNumber); ?> + <?php echo esc_attr($classieraLastNumber);?>
                        </span>
                      </div>
                      
                      <div class="col-sm-6 pull-right">
                        <input id="humanTest" type="text" class="form-control form-control-xs" name="humanTest" placeholder="<?php esc_html_e('Your answer', 'classiera') ?>" required>
                        <input type="hidden" name="humanAnswer" id="humanAnswer" value="<?php echo esc_attr($classieraNumberAnswer); ?>" />
                        <input type="hidden" name="classiera_post_title" id="classiera_post_title" value="<?php the_title(); ?>" />
                        <input type="hidden" name="classiera_post_url" id="classiera_post_url" value="<?php the_permalink(); ?>"  />
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="submit" name="submit_bid" class="btn btn-primary submit_bid">
                        <?php esc_html_e( 'Send', 'classiera' ); ?>
                      </button>
                      <!-- <button type="button" class="btn btn-primary">Send</button> -->
                      <button type="button" class="btn btn-primary margin-top" data-dismiss="modal"><?php echo esc_html_e('Close', 'classiera') ?></button>

                      <div class="form-group">
                        <div class="classieraOfferResult bg-success text-center" style="margin-top: 20px;"></div>
                      </div>
                    </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </form><!--  End Form -->

            </div><!-- /.modal -->
            <!-- / Modal Window -->
          </div><!-- / Caption -->
        </div><!-- / Thumbnail -->
      </div><!-- / Author container -->  

      <?php 
          $attachments = get_children(array('post_parent' => $post->ID,
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => 'ASC',
            'orderby' => 'menu_order ID'
            )
          );
      ?>
      <?php if ( has_post_thumbnail() || !empty($attachments)){?>
        <div id="lightgallery" class="col-xs-12 col-sm-12 col-lg-9 gallery-wrapper">
        
        <?php 
        if(empty($attachments)){
          if ( has_post_thumbnail()){
            //$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
          }
        }else{
          //$count = 1;
          foreach($attachments as $att_id => $attachment){
            // $full_img_url = wp_get_attachment_url($attachment->ID);
            // $image_large = wp_get_attachment_image_url($attachment->ID, 'large');
            // $image_thumb = wp_get_attachment_image_url ( $attachment->ID, 'thumbnail' );
            $image_buff = get_attached_file($attachment->ID);
            $arrUrls = explode("/", $image_buff);
            $realUrl = "";
            for($i = 4; $i < count($arrUrls); $i ++){
              $realUrl .= "/" . $arrUrls[$i];
            }
            ?>
          <div class="col-xs-6 col-sm-6 col-lg-3"><!-- Single Image Wrapper -->
            <div class="thumbnail gallery-image" data-src="<?php echo esc_url($realUrl); ?>">
              <img class="img-responsive" src="<?php echo esc_url($realUrl); ?>" alt="<?php the_title(); ?>">
            </div>
          </div>
          <?php
          //$count++;
          }
        }
        ?>  
        
      </div><!--  / Gallery Wrapper -->
      <?php } ?>

    </div><!--  / Author Images Row -->

    <div class="row"><!-- Main Info Container -->

      <div class="col-lg-12">
        <div class="panel panel-default">
          <!-- Default panel contents -->
          <!-- <div class="panel-heading">Panel heading</div> -->
          <h3 class="panel-heading text-center"><?php esc_html_e( 'About Me', 'classiera' ); ?>
              <span class="glyphicon glyphicon-fire" style="position: absolute; left: 25px; top: 12px; color: red;"></span>
              <span class="glyphicon glyphicon-fire" style="position: absolute; left: 50px; top: 12px; color: red;"></span>
              <span class="glyphicon glyphicon-fire" style="position: absolute; left: 75px; top: 12px; color: red;"></span>
              <span class="glyphicon glyphicon-fire" style="position: absolute; left: 100px; top: 12px; color: #858585"></span>
              <span class="glyphicon glyphicon-fire" style="position: absolute; left: 125px; top: 12px; color: #858585"></span>
          </h3>
            <div class="panel-body">
              <p class="text-justify"><?php echo the_content(); ?><!-- No P End Tag Here, error in template file. Template tag outputs only closing </p> tag -->
              <div class="tags">
                <span>
                  <i class="fa fa-tags"></i>
                  <?php esc_html_e( 'Tags', 'classiera' ); ?> :
                </span>
                  <?php the_tags('','',''); ?>
              </div>
            </div>
          </div><!-- /Panel -->
      </div>

      <div class="col-lg-4">
        <div class="panel panel-default">
          <h3 class="panel-heading text-center"><?php esc_html_e('Prices', 'classiera') ?></h3>
          <ul class="list-group">

            <!-- 15 Minutes Price -->
            <?php if(!empty($fifteen_min_euro)) { ?>
              <li class="list-group-item"><?php esc_html_e('15 Minutes', 'classiera') ?>:
                <span class="pull-right">&euro; <?php echo $fifteen_min_euro; ?>
                  <?php
                    if(!empty($fifteen_min_pound)) { ?>
                      <span class="pull-right" style="margin-left: 20px;"> &pound; <?php echo $fifteen_min_pound; ?></span>
                    <?php }
                  ?>
                </span>
              </li>
            <?php } ?>
            <!-- / 15 Minutes Price -->

            <!-- 30 Minutes Price -->
            <?php if(!empty($thirty_min_euro)) { ?>
              <li class="list-group-item"><?php esc_html_e('30 Minutes', 'classiera') ?>:
                <span class="pull-right">&euro; <?php echo $thirty_min_euro; ?>
                  <?php
                    if(!empty($thirty_min_pound)) { ?>
                      <span class="pull-right" style="margin-left: 20px;"> &pound; <?php echo $thirty_min_pound; ?></span>
                    <?php }
                  ?>
                </span>
              </li>
            <?php } ?>
            <!-- / 30 Minutes Price -->

            <!-- 45 Minutes Price -->
            <?php if(!empty($fourty_five_min_euro)) { ?>
              <li class="list-group-item"><?php esc_html_e('45 Minutes', 'classiera') ?>:
                <span class="pull-right">&euro; <?php echo $fourty_five_min_euro; ?>
                  <?php
                    if(!empty($fourty_five_min_pound)) { ?>
                      <span class="pull-right" style="margin-left: 20px;"> &pound; <?php echo $fourty_five_min_pound; ?></span>
                    <?php }
                  ?>
                </span>
              </li>
            <?php } ?>
            <!-- / 45 Minutes Price -->

            <!-- 1 Hour Price -->
            <?php if(!empty($one_hour_euro)) { ?>
              <li class="list-group-item"><?php esc_html_e('1 Hour', 'classiera') ?>:
                <span class="pull-right">&euro; <?php echo $one_hour_euro; ?>
                  <?php
                    if(!empty($one_hour_pound)) { ?>
                      <span class="pull-right" style="margin-left: 20px;"> &pound; <?php echo $one_hour_pound; ?></span>
                    <?php }
                  ?>
                </span>
              </li>
            <?php } ?>
            <!-- / 1 Hour Price -->

            <!-- Business Date Price -->
            <?php if(!empty($business_date_euro)) { ?>
              <li class="list-group-item"><?php esc_html_e('Business Date', 'classiera') ?>:
                <span class="pull-right">&euro; <?php echo $business_date_euro; ?>
                  <?php
                    if(!empty($business_date_pound)) { ?>
                      <span class="pull-right" style="margin-left: 20px;"> &pound; <?php echo $business_date_pound; ?></span>
                    <?php }
                  ?>
                </span>
              </li>
            <?php } ?>
            <!-- / Business Date Price -->

            <!-- Full Day Price -->
            <?php if(!empty($full_day_euro)) { ?>
              <li class="list-group-item"><?php esc_html_e('Full Day', 'classiera') ?>:
                <span class="pull-right">&euro; <?php echo $full_day_euro; ?>
                  <?php
                    if(!empty($full_day_pound)) { ?>
                      <span class="pull-right" style="margin-left: 20px;"> &pound; <?php echo $full_day_pound; ?></span>
                    <?php }
                  ?>
                </span>
              </li>
            <?php } ?>
            <!-- / Full Day Price -->

          </ul>
        </div><!-- /Panel -->

        <div class="panel panel-default">
          <h3 class="panel-heading text-center"><?php esc_html_e('Spoken Languages', 'classiera') ?></h3>
          <ul class="list-group">

            <!-- Nationality -->
            <?php if(!empty($nationality)) { ?>
              <li class="list-group-item"><?php esc_html_e('Nationality', 'classiera') ?>:
                <span class="pull-right"><?php echo $nationality; ?></span>
              </li>
            <?php } ?>
            <!-- / Nationality -->

            <!-- Native Language -->
            <?php if(!empty($native_language)) { ?>
              <li class="list-group-item"><?php esc_html_e('Languages', 'classiera') ?>:
                <span class="pull-right"><?php echo $native_language; ?> - <?php esc_html_e('Native', 'classiera') ?></span>
              </li>
            <?php } ?>
            <!-- / Native Language -->

            <!-- Extra Language 1 -->
            <?php if(!empty($language_1)) { ?>
              <li class="list-group-item">&nbsp;
                <span class="pull-right"><?php echo $language_1; ?> - <?php echo $language_1_level; ?></span>
              </li>
            <?php } ?>
            <!-- / Extra Language 1 -->

            <!-- Extra Language 2 -->
            <?php if(!empty($language_2)) { ?>
              <li class="list-group-item">&nbsp;
                <span class="pull-right"><?php echo $language_2; ?> - <?php echo $language_2_level; ?></span>
              </li>
            <?php } ?>
            <!-- / Extra Language 2 -->

            
          </ul>
        </div><!-- /Panel -->
      </div>

      <div class="col-lg-4">
        <div class="panel panel-default">
          <h3 class="panel-heading text-center"><?php esc_html_e( 'Physical Appearance', 'classiera' ); ?></h3>
          <ul class="list-group">
            
            <!-- Age -->
            <?php if(!empty($user_age)) {?>
              <li class="list-group-item"><?php esc_html_e( 'Age', 'classiera' ); ?>:
                <span class="pull-right"><?php echo esc_html($user_age); ?></span>
              </li> 
            <?php }?>
            <!-- / Age -->

            
            <!-- Hair Colour -->
            <?php if(!empty($hair_color)) { ?>
              <li class="list-group-item"><?php esc_html_e('Hair Colour', 'classiera') ?>:
                <span class="pull-right"><?php echo $hair_color; ?></span>
              </li>
            <?php } ?>
            <!-- / Hair Coulour -->

            <!-- Eyes Colour -->
            <?php if(!empty($eyes_color)) { ?>
              <li class="list-group-item"><?php esc_html_e('Eyes Colour', 'classiera') ?>:
                <span class="pull-right"><?php echo $eyes_color; ?></span>
              </li>
            <?php } ?>
            <!-- / Eyes Coulour -->

            <!-- Ethnicity -->
            <?php if(!empty($ethnicity)) { ?>
              <li class="list-group-item"><?php esc_html_e('Ethnicity', 'classiera'); ?>:
                <span class="pull-right"><?php echo $ethnicity; ?></span>
              </li>
            <?php } ?>
            <!-- / Ethnicity -->

            <!-- Height -->
            <?php if(!empty($height_feet)) { ?>
              <li class="list-group-item"><?php esc_html_e('Height', 'classiera') ?>:
                <span class="pull-right"><?php echo $height_feet; ?>" <?php echo $height_inches; ?>'</span>
              </li>
            <?php } ?>
            <!-- / Height -->

            <!-- Weight -->
            <?php if(!empty($weight)) { ?>
              <li class="list-group-item"><?php esc_html_e('Weight', 'classiera') ?>:
                <?php
                $convertedWeight = round($weight * 2.205);
                 ?>
                <span class="pull-right"><?php echo $convertedWeight; ?> lbs / <?php echo $weight;?> kg</span>
              </li>
            <?php } ?>
            <!-- / Weight -->

            <!-- Breast Size -->
            <?php if(!empty($breast_size)) { ?>
              <li class="list-group-item"><?php esc_html_e('Breast Size', 'classiera') ?>:
                <span class="pull-right"><?php echo $breast_size; ?> <?php echo $breast_size_cup; ?> <?php echo $breast_type; ?></span>
              </li>
            <?php } ?>
            <!-- / Breast Size -->

            <!-- Waist Size -->
            <?php if(!empty($waist_size)) { ?>
              <li class="list-group-item"><?php esc_html_e('Waist Size', 'classiera') ?>:
                <?php
                $convertedWaist = round($waist_size * 2.54);//Inches to cm conversion
                ?>
                <span class="pull-right"><?php echo $waist_size; ?> <?php esc_html_e('Inch', 'classiera')?> / <?php echo $convertedWaist; ?> <?php esc_html_e('cm', 'classiera')?></span>
              </li>
            <?php } ?>
            <!-- / Waist Size -->

            <!-- Hips Size -->
            <?php if(!empty($hips_size)) { ?>
              <li class="list-group-item"><?php esc_html_e('Hips Size', 'classiera') ?>:
                <?php
                $convertedHips = round($hips_size * 2.54);
                ?>
                <span class="pull-right"><?php echo $hips_size; ?> <?php esc_html_e('Inch', 'classiera')?> / <?php echo $convertedHips; ?> <?php esc_html_e('cm', 'classiera')?></span>
              </li>
            <?php } ?>
            <!-- / Hips Size -->

            <!-- Dress Size -->
            <?php if(!empty($dress_size)) { ?>
              <li class="list-group-item"><?php esc_html_e('Dress Size', 'classiera') ?>:
                <span class="pull-right"><?php echo $dress_size; ?></span>
              </li>
            <?php } ?>
            <!-- / Dress Size -->

            <!-- Shoe Size -->
            <?php if(!empty($shoe_size)) { ?>
              <li class="list-group-item"><?php esc_html_e('Shoe Size', 'classiera') ?>:
                <span class="pull-right"><?php echo $shoe_size; ?> <?php esc_html_e('UK Size', 'classiera') ?></span>
              </li>
            <?php } ?>
            <!-- / Shoe Size -->

            <!-- Pubic Area -->
            <?php if(!empty($pubic_area)) { ?>
              <li class="list-group-item"><?php esc_html_e('Pubic Area', 'classiera') ?>:
                <span class="pull-right"><?php echo $pubic_area; ?></span>
              </li>
            <?php } ?>
            <!-- / Pubic Area -->

            <!-- Are You a Smoker? -->
            <?php if(!empty($smoker)) { ?>
              <li class="list-group-item"><?php esc_html_e('Smoker', 'classiera') ?>:
                <span class="pull-right"><?php echo $smoker; ?></span>
              </li>
            <?php } ?>
            <!-- / Are You a Smoker? -->

          </ul>
        </div><!-- /Panel -->
      </div>

     <div class="col-lg-4">
        <div class="panel panel-default">
          <!-- Default panel contents -->
          <h3 class="panel-heading text-center"><?php esc_html_e('Communication', 'classiera') ?></h3>
          <!-- List group -->
          <ul class="list-group">

            <!-- Private Numbers -->
            <?php if(!empty($private_numbers)) { ?>
              <li class="list-group-item"><?php esc_html_e('Private Numbers', 'classiera') ?>:
                <span class="pull-right"><?php echo $private_numbers; ?></span>
              </li>
            <?php } ?>
            <!-- / Private Numbers -->

            <!-- SMS Messages -->
            <?php if(!empty($sms_messages)) { ?>
              <li class="list-group-item"><?php esc_html_e('SMS Messages', 'classiera') ?>:
                <span class="pull-right"><?php echo $sms_messages; ?></span>
              </li>
            <?php } ?>
            <!-- / SMS Messages -->

            <!-- Private Messages -->
            <?php if(!empty($private_messages)) { ?>
              <li class="list-group-item"><?php esc_html_e('Private Messages', 'classiera') ?>:
                <span class="pull-right"><?php echo $private_messages; ?></span>
              </li>
            <?php } ?>
            <!-- / Private Messages -->

            <!-- <li class="list-group-item">Private Numbers:<span class="pull-right">No</span></li>
            <li class="list-group-item">SMS Messages:<span class="pull-right">Yes</span></li>
            <li class="list-group-item">Private Messages: <span class="pull-right">Yes</span></li> -->
          </ul>
        </div><!-- /Panel -->

        <div class="panel panel-default">
          <!-- Default panel contents -->
          <h3 class="panel-heading text-center"><?php esc_html_e('Facilities', 'classiera') ?></h3>
          <!-- List group -->
          <ul class="list-group">

            <!-- Disabled Friendly -->
            <?php if(!empty($disabled_friendly)) { ?>
              <li class="list-group-item"><?php esc_html_e('Disabled Friendly', 'classiera') ?>:
                <span class="pull-right"><?php echo $disabled_friendly; ?></span>
              </li>
            <?php } ?>
            <!-- / Disabled Friendly -->

            <!-- Drinks Supplied -->
            <?php if(!empty($drinks_supplied)) { ?>
              <li class="list-group-item"><?php esc_html_e('Drinks Supplied', 'classiera') ?>:
                <span class="pull-right"><?php echo $drinks_supplied; ?></span>
              </li>
            <?php } ?>
            <!-- / Drinks Supplied -->

            <!-- Showers Available -->
            <?php if(!empty($showers_available)) { ?>
              <li class="list-group-item"><?php esc_html_e('Showers Available', 'classiera') ?>:
                <span class="pull-right"><?php echo $showers_available; ?></span>
              </li>
            <?php } ?>
            <!-- / Showers Available -->

            <!-- Available to Travel -->
            <?php if(!empty($can_travel)) { ?>
              <li class="list-group-item"><?php esc_html_e('Available to Travel', 'classiera') ?>:
                <span class="pull-right"><?php echo $can_travel; ?></span>
              </li>
            <?php } ?>
            <!-- / Available to Travel -->
          </ul>
        </div><!-- /Panel -->
     </div>
    </div><!-- / Main Info Container -->

  </div><!-- / Main Wrapper -->
  

<?php endwhile; ?>

<script type="text/javascript">
  
  jQuery(document).ready(function($){

    $('#lightgallery').lightGallery({
      selector: '.gallery-image',
      speed: 800,
      cssEasing : 'cubic-bezier(0.25, 0, 0.25, 1)',
      escKey : true,
      enableDrag: true,
      enableSwipe: true
    });
    
  });
  
</script>

<?php get_footer(); ?>

<?php
/**
 * Template name: Single User All Ads
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera
 */

if ( !is_user_logged_in() ) { 
	global $redux_demo; 
	$login = $redux_demo['login'];
	wp_redirect( $login ); exit;
}
global $redux_demo; 
$edit = $redux_demo['edit'];
$pagepermalink = get_permalink($post->ID);
if(isset($_GET['delete_id'])){
	$deleteUrl = $_GET['delete_id'];
	wp_delete_post($deleteUrl);
}
if(isset($_POST['unfavorite'])){
	$author_id = $_POST['author_id'];
	$post_id = $_POST['post_id'];
	echo classiera_authors_unfavorite($author_id, $post_id);	
}
if(isset($_GET['sold_id'])){
	$sold_post_id = $_GET['sold_id'];
	echo classiera_post_mark_as_sold($sold_post_id);
}if(isset($_GET['pause_id']))
{
	$pause_post_id = $_GET['pause_id'];	
	echo  classiera_post_mark_as_pause($pause_post_id);   
	echo classiera_post_mark_as_status($pause_post_id);
	$days_to_expire = get_post_meta($post->ID, 'days_to_expire', true); 
	$date = strtotime("+1 day", strtotime($days_to_expire));
	update_post_meta($pause_post_id, 'days_to_expire', date("Y-m-d H:i:s", $date));
	}
if(isset($_GET['un_sold_id'])){
	$un_sold_id = $_GET['un_sold_id'];
	echo classiera_post_mark_as_unsold($un_sold_id);
}
global $current_user, $user_id;
wp_get_current_user();
$user_info = get_userdata($user_ID);
$user_id = $current_user->ID;
get_header(); 
?>
<?php 
	global $redux_demo; 
	$profile = $redux_demo['profile']; //Output profile link
	$all_adds = $redux_demo['all-ads'];
	$allFavourite = $redux_demo['all-favourite'];
	$newPostAds = $redux_demo['new_post'];
	$bumpProductID = $redux_demo['classiera_bump_ad_woo_id'];
	$classiera_cart_url = $redux_demo['classiera_cart_url'];
	$caticoncolor="";
	$category_icon_code ="";
	$category_icon="";
	$category_icon_color=""; 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$iconClass = 'icon-left';
	if(is_rtl()){
		$iconClass = 'icon-right';
	}
?>
<!-- user pages -->
<section class="user-pages">
	<div class="container">
        <div class="row">
			<div class="col-lg-3 col-md-4">
				<?php get_template_part( 'templates/profile/userabout' );?>
			</div><!--col-lg-3-->
			<div class="col-lg-9 col-md-8 user-content-height">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title text-uppercase"><?php esc_html_e("User Adverts", 'classiera') ?></h3>
					</div>
					<div class="panel-body">
						<div class="user-detail-section">
							<!-- my ads -->
							<?php
							// echo '<pre>';
							// print_r($redux_demo);
							// echo '</pre>';
							?>
							<div class="user-ads user-my-ads">
								<!-- <h5 class="redux_heading">Get Credits</h5>
								<p class="redux_body"></p> -->
								<?php 
									//print_r($user_id);
									global $paged, $wp_query, $wp;
									$args = wp_parse_args($wp->matched_query);
									if ( !empty ( $args['paged'] ) && 0 == $paged ) {
										$wp_query->set('paged', $args['paged']);
										$paged = $args['paged'];
									}
									$wp_query = null;
									$kulPost = array(
										'post_type'  => 'post',
										'author' => $user_id,
										'posts_per_page' => 12,
										'paged' => $paged,
										'post_status' => array( 'publish', 'pending', 'future', 'draft', 'private' ),
									);
									$wp_query = new WP_Query($kulPost);
									while ($wp_query->have_posts()) : $wp_query->the_post();
									$title = get_the_title($post->ID); 
									$classieraPstatus = get_post_status( $post->ID );
									$dateFormat = get_option( 'date_format' );
									$postDate = get_the_date($dateFormat, $post->ID);
									$postStatus = get_post_status($post->ID);
									$productID = get_post_meta($post->ID, 'pay_per_post_product_id', true);
									$days_to_expire = get_post_meta($post->ID, 'days_to_expire', true);
									$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
								$classiera_ads_status = get_post_meta($post->ID, 'classiera_ads_status', true);
								$classiera_ads_statustime = get_post_meta($post->ID, 'classiera_ads_statustime', true);
								$current_time = date("Y-m-d H:i:s");
								if($current_time >= $classiera_ads_statustime)
								{
									update_post_meta($post->ID, 'classiera_ads_status','1');
									}
									?>
								<div class="media border-bottom">
									<div class="media-left">
										<?php 
										if ( has_post_thumbnail()){
										$imgURL = get_post_meta($post->ID, "croppedImg_Path");
										$imgCropped = $imgURL[0];
										$imgURL = get_the_post_thumbnail_url();
										?>
		                                <img style="height: auto;" class="media-object" src="<?php echo esc_url( $imgCropped ); ?>" alt="<?php echo esc_attr( $title ); ?>">
										<?php } ?>
		                            </div><!--media-left-->
									<div class="media-body">
										<h5 class="media-heading">
											<a href="<?php echo esc_url( get_permalink($post->ID) ); ?>">
												<?php echo esc_attr( $title ); ?>
											</a>
										</h5>
										
										<?php
										if($classiera_ads_status==0){ ?>
										<h5 class="media-heading tmerh">
										
											<script>

												initializeClock("timer<?= $post->ID?>","<?= $classiera_ads_statustime?> GMT+1");


												function initializeClock(cls,endtime){

												  var timeinterval = setInterval(function(){
													var t = getTimeRemaining(endtime);

												$('.'+cls).html( t.hours + ':' + t.minutes + ':' +t.seconds);


												   if(t.total<=0){
													  clearInterval(timeinterval);
													  var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
													  $.ajax({
													  	type: 'POST',
									                    url: ajaxurl,
									                    data: {
									                        'action' : 're_activate_ads',
									                        'post_id': "<?php echo $post->ID;?>",
									                    },
									                    success: function (responce) {
									                       location.reload();

									                    },
									                    error: function (errorThrown) {

									                    }

													  })
													}
												  },1000);
												}

												function getTimeRemaining(endtime){
												  var t = Date.parse(endtime) - Date.parse(new Date());
												  var seconds = Math.floor( (t/1000) % 60 );
												  var minutes = Math.floor( (t/1000/60) % 60 );
												  var hours = Math.floor( (t/(1000*60*60)) % 24 );
												  var days = Math.floor( t/(1000*60*60*24) );
												  var sec = ("0" + seconds).slice(-2);
												  var mintue = ("0" + minutes).slice(-2);
												  var hour = ("0" + hours).slice(-2);

												  return {
													'total': t,
													'days': days,
													'hours': hour,
													'minutes': mintue,
													'seconds': sec
												  };
												}


											</script>

										</h5>
										<?php 
										}
										// print_r($current_time);
										// print_r($days_to_expire);
										 if($classiera_ads_status==1 && $current_time <= $days_to_expire && $postStatus=='publish'):
										?>
										<div class="displayTimer">
											<?php
												//print_r($days_to_expire);
												?>
											<label>Display Time</label>
											<h5 class="media-heading tmerhm" id="tmerhm<?= $post->ID?>">
												
												<script>

												initializeClocks("tmerhm<?= $post->ID?>","<?= $days_to_expire?> GMT");


												function initializeClocks(cls,endtime){

												  var timeinterval = setInterval(function(){
													var t = getTimeRemainings(endtime);
													//console.log(endtime);
													//console.log(t);
													$('#'+cls).html(t.days+' Days '+ t.hours + ':' + t.minutes + ':' +t.seconds);


												   if(t.total<=0){
													  clearInterval(timeinterval);
													}
												  },1000);
												}

												function getTimeRemainings(endtime){
												  var t = Date.parse(endtime) - Date.parse(new Date());
												//  console.log(t);
												  var seconds = Math.floor( (t/1000) % 60 );
												  var minutes = Math.floor( (t/1000/60) % 60 );
												  var hours = Math.floor( (t/(1000*60*60)) % 24 );
												  var days = Math.floor( t/(1000*60*60*24) );
												  var sec = ("0" + seconds).slice(-2);
												  var mintue = ("0" + minutes).slice(-2);
												  var hour = ("0" + hours).slice(-2);
												  var d = ("0" + days).slice(-2);

												  return {
													'total': t,
													'days': d,
													'hours': hour,
													'minutes': mintue,
													'seconds': sec
												  };
												}


												</script>
											</h5>
										</div>
										<?php endif;?>
										<p>
		                                    <span class="published">
		                                        <i class="fa fa-check-circle"></i>
		                                        <?php classieraPStatusTrns($classieraPstatus); ?>
		                                    </span>
		                                    <span>
		                                        <i class="fa fa-eye"></i>
		                                        <?php echo classiera_get_post_views($post->ID); ?>
		                                    </span>
		                                    <span>
		                                        <i class="fa fa-clock"></i>                                      
												<?php echo esc_html( $postDate ); ?>
		                                    </span>
											<span>
												<i class="removeMargin fa fa-hashtag"></i>
												<?php esc_html_e( 'ID', 'classiera' ); ?> : 
												<?php echo esc_attr( $post->ID ); ?>
		                                    </span>
		                                </p>
										
										<!-- Print variable information -->
										<!-- <pre><?php //print_r ($$bumpProductID); ?></pre> -->
										
										
										<?php if($classiera_ads_status==0){ ?>
										<span><?php esc_html_e("Your advert has been paused and will re-activate after: ", 'classiera') ?></span>
										<span class="timer<?=$post->ID ?>"></span>
										<?php  } else{ ?>
										<!-- <p>Pausing the ad will stop it for 24 hours.</p> -->
										<?php } ?>
									</div><!--media-body-->
									<div class="classiera_posts_btns">
										<!--PayPerPostbtn-->
										<?php if(!empty($productID) && $postStatus == 'pending'){?>
										<div class="classiera_main_cart">
											<a href="#" class="btn btn-primary classiera_ppp_btn" data-quantity="1" data-product_id="<?php echo esc_attr( $productID ); ?>" data-product_sku="">
												<?php esc_html_e( 'Pay to Publish', 'classiera' ); ?>
											</a>
											<form method="post" class="classiera_ppp_ajax">				
												<input type="hidden" class="product_id" name="product_id" value="<?php echo esc_attr( $productID ); ?>">
												<input type="hidden" class="post_id" name="post_id" value="<?php echo esc_attr( $post->ID ); ?>">
												<input type="hidden" class="post_title" name="post_title" value="<?php echo esc_html( the_title());?>">
												<input type="hidden" class="days_to_expire" name="days_to_expire" value="<?php echo esc_attr( $days_to_expire ); ?>">
											</form>
											<a class="btn btn-primary classiera_ppp_cart" href="<?php echo esc_url( $classiera_cart_url );?>">
												<?php esc_html_e( 'View Cart', 'classiera' ); ?>
											</a>
										</div>
										<?php } ?>
										<!--PayPerPostbtn-->
										<!--BumpAds-->
										<?php if(!empty($bumpProductID) && $postStatus == 'publish'){?>
										<div class="classiera_bump_ad">
											
											<!-- <a href="javascript:void(0);" class="btn btn-primary classiera_bump_btns" onclick="bump_ads('<?php echo admin_url('admin-ajax.php');?>','<?php echo $post->ID; ?>')" data-quantity="1" data-product_id="<?php echo esc_attr( $post->ID ); ?>" data-product_sku="">
													<?php esc_html_e( 'Bump Ad', 'classiera' ); ?>
											</a> -->
											
											<a href="javascript:void(0);" class="btn btn-primary classiera_bump_btns" onclick="bump_ads('<?php echo admin_url('admin-ajax.php');?>','<?php echo $post->ID; ?>')" data-quantity="1" data-product_id="<?php echo esc_attr( $post->ID ); ?>">
												<?php esc_html_e( 'Bump Advert', 'classiera' ); ?>
											</a>
											<input type="hidden" name="adstype-<?php echo $post->ID; ?>" value="<?php echo get_post_meta($post->ID,'ads_type_selected', true)?>" class="bump_ads_type" id="bump_ads_type-<?php echo $post->ID; ?>">

											<!-- The Modal -->
											<input type="hidden" name="uw_balance" value="<?php echo get_user_meta($current_user->ID,'_uw_balance', true)?>" id="uw_balance">
											<!-- <div id="myModalBump" class="modal">
											  <div class="modal-content">
											    <div class="modal-header">
											      <span class="closeBump">&times;</span>
											      <h2>Bump Advert</h2>
											    </div>
											    <div class="modal-body">
											      <p id="textbump">Are you sure you wish to bump your advert? Bumping advery will cost you <span id="bumpCredit"></span> credits.</p>
											    </div>
											    <div class="modal-footer">
											      <button id="bumpOkBtn" class="post-submit btn btn-default" type="button" name="op">OK</button>
											      <button type="button" id="cancelBtn" class="btn btn-default" data-dismiss="modal">Cancel</button>
											    </div>
											  </div>
											</div> -->

											<div id="myModalBump" class="modal" tabindex="-1" role="dialog">
											  <div class="modal-dialog" role="document">
											    <div class="modal-content">
											      <div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											        <h4 class="modal-title"><?php esc_html_e('Bump Advert', ''); ?></h4>
											      </div>
											      <div class="modal-body">
											        <p id="textbump">Are you sure you wish to bump current advert? Bumping advert will cost you <span id="bumpCredit"></span> credits.</p>
											      </div>
											      <div class="modal-footer">
											        <button id="bumpOkBtn" class="post-submit btn btn-default" type="button" name="op">OK</button>
											      <button type="button" id="cancelBtn" class="btn btn-default" data-dismiss="modal">Cancel</button>
											      </div>
											    </div><!-- /.modal-content -->
											  </div><!-- /.modal-dialog -->
											</div><!-- /.modal -->

		 								</div>
										<?php } ?>
										<!--BumpAds-->
										<?php 
											global $redux_demo;
											$edit_post_page_id = $redux_demo['edit_post'];
											if(function_exists('icl_object_id')){
												$templateEditAd = 'template-edit-post.php';		
												$edit_post_page_id = classiera_get_template_url($templateEditAd);
											}
											$postID = $post->ID;
											global $wp_rewrite;
											if ($wp_rewrite->permalink_structure == ''){
												//we are using ?page_id
												$edit_post = $edit_post_page_id."&post=".$post->ID;
												$del_post = $pagepermalink."&delete_id=".$post->ID;
												$soldpost = $pagepermalink."&sold_id=".$post->ID;
												$unsold = $pagepermalink."&un_sold_id=".$post->ID;
												$pausepost=$pagepermalink."?pause_id=".$post->ID;										
											}else{
												//we are using permalinks
												$edit_post = $edit_post_page_id."?post=".$post->ID;
												$del_post = $pagepermalink."?delete_id=".$post->ID;
												$soldpost = $pagepermalink."?sold_id=".$post->ID;
												$unsold = $pagepermalink."?un_sold_id=".$post->ID;
												$pausepost=$pagepermalink."?pause_id=".$post->ID;										
											}
										//if(get_post_status( $post->ID ) !== 'private'){ 	
										?>
										<a href="<?php echo esc_url($edit_post); ?>" class="btn btn-primary"><i class="<?php echo esc_attr($iconClass); ?> far fa-edit"></i><?php esc_html_e("Edit", 'classiera') ?></a>
										<?php //} ?>

										<!-- Delete Modal -->
										<a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#deleteAdvert-<?php echo $post->ID;?>"><i class="<?php echo esc_attr($iconClass); ?> fa fa-trash-alt"></i><?php esc_html_e("Remove", 'classiera') ?></a>

										<div class="modal fade" id="deleteAdvert-<?php echo $post->ID;?>" tabindex="-1" role="dialog" aria-labelledby="deleteAvert">
										  <div class="modal-dialog" role="document">
										    <div class="modal-content">
										      <div class="modal-header">
										        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										        <h4 class="modal-title" id="deleteAvert-<?php echo $post->ID;?>"><?php esc_html_e("Remove Advert", 'classiera') ?></h4>
										      </div>
										      <div class="modal-body">
										        <p><?php esc_html_e("Are you sure you wish to remove this advert. This action can not be reverted?", 'classiera') ?></p>
										      </div>
										      <div class="modal-footer">
										      	<a href="<?php echo esc_url($del_post); ?>" type="button" class="btn btn-primary"><?php esc_html_e("Remove", 'classiera') ?></a>
										        <a href="javascript:void(0)" type="button" class="btn btn-primary" data-dismiss="modal"><?php esc_html_e("Cancel", 'classiera') ?></a>
										      </div>
										    </div>
										  </div>
										</div>
										<!-- Delete Modal -->

										<?php if($classiera_ads_status==1 && $postStatus=='publish') {?>
											<!-- set time pause-->
											<a href="javascript:void(0)" class=" btn btn-primary" data-toggle="modal" data-target="#myModal">
												<i class="<?php echo esc_attr($iconClass); ?> far fa-check-square"></i>
													<?php esc_html_e("Pause", 'classiera');?>
											</a>

											<!-- Modal -->
											<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
											  <div class="modal-dialog" role="document">
											    <div class="modal-content">
											      <div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											        <h4 class="modal-title" id="myModalLabel"><?php esc_html_e("Pause Advert", 'classiera') ?></h4>
											      </div>
											      <div class="modal-body">
											      	<p><?php esc_html_e("Are you sure you wish to pause your advert for 24 hours? Your advert will automatically activate itself after 24 hours and you will not loose your advert display time.", 'classiera') ?></p>
											      </div>
											      <div class="modal-footer">
											      	<a class="btn btn-primary" href="<?php echo esc_url($pausepost); ?>"><?php esc_html_e("OK", 'classiera') ?></a>
											      	<a class="btn btn-primary" data-dismiss="modal" href="javascript:void(0)"><?php esc_html_e("Cancel", 'classiera') ?></a>
											      	<!-- <button type="button" class="btn btn-primary">OK</button> -->
											        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> -->
											      </div>
											    </div>
											  </div>
											</div>
											<!-- / Modal -->
										<?php } ?>
												
										<?php if( $postStatus == 'publish'){?>
											<a href="javascript:void(0)" class=" btn btn-primary" data-toggle="modal" data-target="#discountModal-<?php echo $post->ID;?>">
												<i class="<?php echo esc_attr($iconClass); ?> far fa-check-square"></i>
														<?php esc_html_e("Discount", 'classiera');?>
											</a>
											<!-- Modal -->
											<div class="modal fade" id="discountModal-<?php echo $post->ID;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
											  <div class="modal-dialog" role="document">
											    <div class="modal-content">
											      <div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											        <h4 class="modal-title" id="myModalLabel"><?php esc_html_e("Choose Your Discount", 'classiera') ?></h4>
											      </div>
											      <div class="modal-body">
											      	<p>
													    <input id="radio-0-<?php echo $post->ID;?>" name="radiodiscount-<?php echo $post->ID;?>" type="radio" value="0">
													    <label  for="radio-0-<?php echo $post->ID;?>" class="radio-label"><?php esc_html_e("No Discount");?></label>
													</p>
													<p>
													    <input id="radio-1-<?php echo $post->ID;?>" name="radiodiscount-<?php echo $post->ID;?>" type="radio" value="10">
													    <label  for="radio-1-<?php echo $post->ID;?>" class="radio-label"><?php esc_html_e("10% Discount");?></label>
													</p>
													<p>
													    <input id="radio-2-<?php echo $post->ID;?>" name="radiodiscount-<?php echo $post->ID;?>" type="radio" value="20">
													    <label  for="radio-2-<?php echo $post->ID;?>" class="radio-label"><?php esc_html_e("20% Discount");?></label>
													</p>
													<p>
													    <input id="radio-3-<?php echo $post->ID;?>" name="radiodiscount-<?php echo $post->ID;?>" type="radio" value="30">
													    <label  for="radio-3-<?php echo $post->ID;?>" class="radio-label"><?php esc_html_e("30% Discount");?></label>
													</p>
											      </div>
											      <div class="modal-footer">
											      	<a class="btn btn-primary" href="javascript:void(0)" onclick="discount_ads('<?php echo admin_url('admin-ajax.php');?>','<?php echo $post->ID; ?>')"><?php esc_html_e("OK", 'classiera') ?></a>
											      	<a class="btn btn-primary" data-dismiss="modal" href="javascript:void(0)"><?php esc_html_e("Cancel", 'classiera') ?></a>
											      	<!-- <button type="button" class="btn btn-primary">OK</button> -->
											        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> -->
											      </div>
											    </div>
											  </div>
											</div>
											<!-- / Modal -->
										<?php } ?>		
									</div><!--classiera_posts_btns-->
								</div><!--media border-bottom-->
								<?php endwhile; ?>
								<?php									
								  if(function_exists('classiera_pagination')){
									classiera_pagination();
								  }
								?>
								<?php wp_reset_query(); ?>	
							</div><!--user-ads user-my-ads-->
							<!-- my ads -->

						</div><!--user-detail-section-->
					</div>
				</div>
			</div><!--col-lg-9-->
		</div><!--row-->
	</div><!-- container-->
</section>

<!-- user pages -->
<?php get_footer(); ?>	
<?php
/**
 * Template name: Inbox
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
if(isset($_POST['del_comment_id'])){
	$commentID = $_POST['del_comment_id'];
	classiera_delete_comment($commentID);	
}
global $redux_demo;
$pagepermalink = get_permalink($post->ID);
global $current_user, $user_id;
$current_user = wp_get_current_user();
$user_info = get_userdata($user_ID);
$user_id = $current_user->ID; // You can set $user_id to any users, but this gets the current users ID.
get_header(); 
$profile = $redux_demo['profile'];
$all_adds = $redux_demo['all-ads'];
$allFavourite = $redux_demo['all-favourite'];
$newPostAds = $redux_demo['new_post'];
$caticoncolor="";
$category_icon_code ="";
$category_icon="";
$commentClass = 'readed';
$category_icon_color="";
$page = get_page($post->ID);
$current_page_id = $page->ID;
$dateFormat = get_option( 'date_format' );
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
						<h3 class="panel-title text-uppercase"><?php esc_html_e( 'Messages', 'classiera' ); ?></h3>
						<div class="user_inbox_header">
	                        <!-- Nav tabs -->
	                        <ul class="nav nav-pills" role="tablist">
								<li class="active">
	                                <a href="#recieve" aria-controls="profile" role="tab" data-toggle="tab">
										<?php esc_html_e( 'Received', 'classiera' ); ?>
									</a>
	                            </li>
	                            <li>
	                                <a href="#sent" aria-controls="home" role="tab" data-toggle="tab">
										<?php esc_html_e( 'Sent', 'classiera' ); ?>
									</a>
	                            </li>                            
	                        </ul>
	                    </div><!--user_inbox_header-->
					</div>
					<div class="panel-body">
						<div class="user-detail-section">
							
							<!--user_inbox_content-->
							<div class="user_inbox_content">
								<div class="tab-content">
									<span class="classiera--loader"><img src="<?php echo get_template_directory_uri().'/images/loader180.gif' ?>" alt="classiera loader"></span>
									<?php 
									global $wpdb;
									global $post;
									global $firstPostId;							
									$currentSentOffers = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_inbox WHERE offer_author_id = $user_id GROUP BY offer_post_id" );							
									$currentRecOffers = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_inbox WHERE post_author_id = $user_id GROUP BY offer_post_id" );
									//print_r($currentSentOffers);
									?>
									<!--Sent Offers-->
									<div role="tabpanel" class="tab-pane" id="sent">
										<div class="row">
											<?php if($currentSentOffers){?>
											<div class="col-sm-4">
												<ul class="nav nav-tabs nav-stacked sent_comments">
												<?php 
													$count = 1;
													foreach ( $currentSentOffers as $offerinfo ) :
													$offer_post_id = $offerinfo->offer_post_id;
													//$offer_post_price = $offerinfo->offer_post_price;
													$post_author_id = $offerinfo->post_author_id;
													$offer_author_id = $offerinfo->offer_author_id;
													//$offer_price = $offerinfo->offer_price;
													$offer_comment = $offerinfo->offer_comment;
													$commentID = $offerinfo->id;
													$date = $offerinfo->date;
													$postTitle = get_the_title($offer_post_id);
													
													$postAuthor = get_the_author_meta('display_name', $post_author_id );
													if(empty($postAuthor)){
														$postAuthor = get_the_author_meta('user_nicename', $post_author_id );
													}
													if(empty($postAuthor)){
														$postAuthor = get_the_author_meta('user_login', $post_author_id );
													}
													$image = wp_get_attachment_image_src( get_post_thumbnail_id( $offer_post_id ), 'full' );
													if($count == 1){
														$firstPostId = $offer_post_id;
													}
												?>
													<!--start loop-->
													<li <?php if($count == 1){ ?> class="active" <?php }?>>
		                                                <a class="user_comment comment_sent" href="#" id="<?php echo esc_attr( $commentID ); ?>">
		                                                    <img class="user_comment_img thumbnail" src="<?php echo esc_url( $image[0] ); ?>" alt="author">
		                                                    <div class="user_comment_body">
		                                                        <p class="text-uppercase">
																	<?php echo esc_html( $postTitle ); ?>
																</p>
		                                                        <p><?php echo esc_attr( $postAuthor ); ?></p>
		                                                    </div><!--user_comment_body-->
		                                                </a>
		                                            </li>
													<!--End loop-->
													<?php $count++;?>
													<?php endforeach; ?>
												</ul>
											</div><!--col-sm-4-->
											<div class="col-sm-8">
												<div class="tab-content classiera_sent_comment">
													<div role="tabpanel" class="tab-pane active">
													<?php 
													$currentUserID = get_current_user_id();
													$getfirstsent = '';
													if($firstPostId){
														$getfirstsent = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_inbox WHERE offer_post_id = $firstPostId AND offer_author_id = $currentUserID ORDER BY id ASC" );
													}
													if($getfirstsent){
														foreach ($getfirstsent as $sentinfo):
															$offer_post_id = $sentinfo->offer_post_id;
															//$offer_post_price = $sentinfo->offer_post_price;
															$post_author_id = $sentinfo->post_author_id;
															$offer_author_id = $sentinfo->offer_author_id;
															//$offer_price = $sentinfo->offer_price;
															$offer_comment = $sentinfo->offer_comment;
															$date = $sentinfo->date;
															//$date = date($dateFormat, $date);
															$date = date_i18n($dateFormat,  strtotime($date));
															$postTitle = get_the_title($offer_post_id);
															$thiscommentID = $sentinfo->id;
															$offerAuthor = get_the_author_meta('display_name', $offer_author_id );
															if(empty($offerAuthor)){
																$offerAuthor = get_the_author_meta('user_nicename', $offer_author_id );
															}
															if(empty($offerAuthor)){
																$offerAuthor = get_the_author_meta('user_login', $offer_author_id );
															}
															$offerAuthorIMG = get_user_meta($currentUserID, "classify_author_avatar_url", true);
															$offerAuthorIMG = classiera_get_profile_img($offerAuthorIMG);
															if(empty($offerAuthorIMG)){										
																$offerAuthorIMG = classiera_get_avatar_url ($currentUserID, $size = '150' );
															}
															?>
															<h5 class="text-uppercase user_comment_inner_head"><?php esc_html_e( 'Ad Title', 'classiera' ); ?> :
																<span><?php echo esc_html( $postTitle ); ?></span>
															</h5>
															<div class="modal-dialog" role="document">
																<div class="modal-content classiera_comment_ajax">
																	<div class="modal-body classiera_show_reply" id="<?php echo esc_attr( $thiscommentID ); ?>">
																		<!--Offer Author box-->
																		<div class="classiera_user_message">
																			<a href="#"><img class="img-circle classiera_user_message_img" src="<?php echo esc_url( $offerAuthorIMG ); ?>" alt="author"></a>
																			<div class="classiera_user_message__box">
																				<p>
																					<?php echo esc_html( $offer_comment ); ?>
																				</p>
																				<p class="classiera_user_message__time">
																					<?php echo esc_html( $date ); ?>
																				</p>
																			</div>
																		</div>
																		<!--Offer Author box-->
																		<!--Get Sub Comments-->
																		<?php 
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
																					$userHTML = '<div class="classiera_user_message">
																									<a href="#"><img class="img-circle classiera_user_message_img" src="'.$userIMG.'" alt="'.$user.'"></a>
																									<div class="classiera_user_message__box">
																										<p>'.$comment_reply.'</p>
																										<p class="classiera_user_message__time">'.$innerDate.'</p>
																									</div>
																								</div>';
																					echo $userHTML;
																					//echo wp_kses($userHTML, $allowed_html);
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
																					$authorHTML =
																					'<div class="classiera_user_message classiera_user_message__reply">
																						<a href="#"><img class="img-circle classiera_user_message_img" src="'.$userIMG.'" alt="'.$author.'"><p>'.$author.'</p></a>
																						<div class="classiera_user_message__box">
																							<p>'.$comment_reply.'</p>
																							<p class="classiera_user_message__time">'.$innerDate.'</p>
																						</div>
																					</div>';							
																					//$authorHTML = '<div class="classiera_user_message classiera_user_message__reply"><a href="#"><img class="img-circle classiera_user_message_img" src="'.$userIMG.'" alt="'.$author.'"><p>'.$author.'</p></a><div class="classiera_user_message__box"><p>'.$comment_reply.'</p><p class="classiera_user_message__time">'.$innerDate.'</p></div></div>';
																					echo $authorHTML;
																					// echo wp_kses($authorHTML, $allowed_html);
																				}
																			}
																		}
																		?>
																		<!--Get Sub Comments-->
																	</div><!--modal-body-->
																	<form method="post" id="resetReply" class="classiera_user_message__form">
																		<textarea class="form-control classiera_comment_reply" placeholder="<?php esc_html_e( "Type your message..", "classiera" )?>" required></textarea>
																		<input type="hidden" value="<?php echo esc_attr( $thiscommentID ); ?>" class="main_comment_ID">
																		<button type="submit" class="classiera_user_message__form_btn"><?php esc_html_e( "SEND", "classiera" )?></button>
																	</form>
																</div><!--modal-content-->
															</div><!--modal-dialog-->
															<?php
														endforeach;
													}
													?>
													</div><!--tabpanel-->
												</div><!--tab-content-->
											</div><!--col-sm-8-->
											<?php }else{ ?>
											<div class="col-sm-12">
												<h4><?php esc_html_e( 'You have not sent any offer..!', 'classiera' ); ?></h4>
											</div>
											<?php } ?>
										</div><!--row-->
									</div>
									<!--Sent Offers-->
									<!--Received Offers-->
									<div role="tabpanel" class="tab-pane active" id="recieve">
										<div class="row">
											<?php if($currentRecOffers){ ?>
											<div class="col-sm-4">
												<ul class="nav nav-tabs nav-stacked received_comments">
												<?php 
													$count = 1;
													foreach ( $currentRecOffers as $offerinfo ) :
													$offer_post_id = $offerinfo->offer_post_id;
													//$offer_post_price = $offerinfo->offer_post_price;
													$post_author_id = $offerinfo->post_author_id;
													$offer_author_id = $offerinfo->offer_author_id;
													//$offer_price = $offerinfo->offer_price;
													$offer_comment = $offerinfo->offer_comment;
													$date = $offerinfo->date;
													$postTitle = get_the_title($offer_post_id);
													$postAuthor = get_the_author_meta('display_name', $post_author_id );
													if(empty($postAuthor)){
														$postAuthor = get_the_author_meta('user_nicename', $post_author_id );
													}
													if(empty($postAuthor)){
														$postAuthor = get_the_author_meta('user_login', $post_author_id );
													}
													$image = wp_get_attachment_image_src( get_post_thumbnail_id( $offer_post_id ), 'full' );
													if($count == 1){
														$firstrecPostId = $offer_post_id;
													}
												?>
													<!--start loop-->
													<li <?php if($count == 1){ ?> class="active" <?php }?>>
		                                                <a class="user_comment comment_rec" href="#" id="<?php echo esc_attr( $offer_post_id ); ?>">
		                                                    <img class="user_comment_img thumbnail" src="<?php echo esc_url( $image[0] ); ?>" alt="author">
		                                                    <div class="user_comment_body">
		                                                        <p class="text-uppercase"><?php echo esc_html( $postTitle); ?></p>
		                                                        <p><?php echo esc_html( $postAuthor); ?></p>
		                                                    </div><!--user_comment_body-->
		                                                    <div class="user_comment_number">
																<?php $totalBids = classiera_bid_count($offer_post_id);?>
																<span><?php echo esc_attr( $totalBids); ?></span>
		                                                    </div><!--user_comment_number-->
		                                                </a>
		                                            </li>
													<!--End loop-->
													<?php $count++;?>
													<?php endforeach;?>
												<?php //} ?>
												</ul>
											</div><!--col-sm-4-->
											<div class="col-sm-8">
												<div class="tab-content classiera_replace_comment">
													<div role="tabpanel" class="tab-pane active">
													<?php
													$getfirstComment = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_inbox WHERE offer_post_id = $firstrecPostId ORDER BY id DESC" );
													if($getfirstComment){
														$count = 1;
														foreach ( $getfirstComment as $offerinfo ) :
														$offer_post_id = $offerinfo->offer_post_id;
														//$offer_post_price = $offerinfo->offer_post_price;
														$post_author_id = $offerinfo->post_author_id;
														$offer_author_id = $offerinfo->offer_author_id;
														//$offer_price = $offerinfo->offer_price;
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
														$readUnRead = classiera_unread_message_comment($thiscommentID);
														if($readUnRead > 0){
															$commentClass = 'unread';
														}
													?>											
														<?php if($count == 1):?>
														<h5 class="text-uppercase user_comment_inner_head">
															<?php esc_html_e( 'Ad Title', 'classiera' ); ?> :
		                                                    <span><?php echo esc_html( $postTitle); ?></span>
		                                                </h5>
														<?php endif; ?>
														<div class="user_comment_box <?php echo esc_attr( $commentClass); ?>">
														<a href="#" id="<?php echo esc_attr( $thiscommentID); ?>" class="user_comment user_comment_inner" data-toggle="modal" data-target="#classieraChatModal">
															<div class="user_comment_img_box">
		                                                        <img class="user_comment_img img-circle" src="<?php echo esc_url( $offerAuthorIMG); ?>" alt="<?php echo esc_attr( $offerAuthor); ?>">
		                                                        <span class="text-uppercase user_comment_author">
																	<?php echo esc_attr( $offerAuthor); ?>
																</span>
		                                                    </div><!--user_comment_img_box-->
															<div class="user_comment_body">
		                                                        <p class="text-capitalize short__comment">
																<?php echo esc_html( $offer_comment); ?>
																</p>
		                                                    </div><!--user_comment_body-->
															<div class="user_comment_date">
		                                                        <span><?php echo esc_html( $OfferDate); ?></span>
		                                                    </div><!--user_comment_date-->
														</a>
														<form method="post">
															<input type="hidden" name="del_comment_id" value="<?php echo esc_attr( $thiscommentID); ?>">
															<button type="submit" class="classiera_del_comment" name="del_comment">
																<i class="fa fa-trash-alt"></i>
															</button>
														</form>
														</div>
														<?php $count++;?>
														<?php endforeach;?>
													<?php } ?>
													</div>
												</div>
											</div>
											<?php }else{ ?>
												<div class="col-sm-12">
												<h4><?php esc_html_e( 'You have not received any offer yet..!', 'classiera' ); ?></h4>
												</div>
											<?php } ?>
										</div><!--row-->
									</div>
									<!--Received Offers-->
								</div><!--tab-content-->
							</div><!--user_inbox_content-->
							<!--user_inbox_content-->
						</div><!--user-detail-section-->
					</div>
				</div>
				
			</div><!--col-lg-9-->
		</div><!--row-->
	</div><!-- container-->
</section>
<!-- user pages -->
<!--modal-->	
<div class="modal fade" id="classieraChatModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content classiera_comment_ajax_rec">
            
        </div>		
    </div>
</div>
<!--modal-->	
<?php get_footer(); ?>
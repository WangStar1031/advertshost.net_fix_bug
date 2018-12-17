<?php
/**
 * Template name: Pricing Plans
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */



$successMsg = '';

get_header(); ?>

<?php 
	global $redux_demo;
	$classieraSearchStyle = $redux_demo['classiera_search_style'];
	$classieraPremiumStyle = $redux_demo['classiera_premium_style'];
	$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
	$classiera_cat_style = $redux_demo['classiera_cat_style'];
	$classieraCartURL = $redux_demo['classiera_cart_url'];
	$classieraPremiumSlider = $redux_demo['featured-options-on'];
	$login = $redux_demo['login'];
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$page_slider = get_post_meta($current_page_id, 'page_slider', true);
	$page_custom_title = get_post_meta($current_page_id, 'page_custom_title', true);
	$plans_Title = $redux_demo['plans-title'];
	$plans_desc = $redux_demo['plans-desc'];
	$current_user = wp_get_current_user();
	$user_ID = $current_user->ID;
?>
<?php 
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
?>
<?php 
	//Premium Styles//
if($classieraPremiumSlider == 1){	
	if($classieraPremiumStyle == 1){
		get_template_part( 'templates/premium/premiumv1' );
	}elseif($classieraPremiumStyle == 2){
		get_template_part( 'templates/premium/premiumv2' );
	}elseif($classieraPremiumStyle == 3){
		get_template_part( 'templates/premium/premiumv3' );
	}elseif($classieraPremiumStyle == 4){
		get_template_part( 'templates/premium/premiumv4' );
	}elseif($classieraPremiumStyle == 5){
		get_template_part( 'templates/premium/premiumv5' );
	}elseif($classieraPremiumStyle == 6){
		get_template_part( 'templates/premium/premiumv6' );
	}
}	
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php $contentEmpty = get_the_content();?>
<?php if(!empty($contentEmpty)){?>
<section class="inner-page-content border-bottom pricingContent">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<article class="article-content pageContent">
					<?php the_content(); ?>
				</article>
			</div>
		</div>
	</div>
</section>
<?php } ?>
<?php endwhile; endif; ?>
<?php 
	if($classiera_cat_style == 1){
		get_template_part('templates/plans/plansv1');
	}elseif($classiera_cat_style == 2){
		get_template_part('templates/plans/plansv2');
	}elseif($classiera_cat_style == 3){ 
		get_template_part('templates/plans/plansv3');
	}elseif($classiera_cat_style == 4){
		get_template_part('templates/plans/plansv4');
	}elseif($classiera_cat_style == 5){ 
		get_template_part('templates/plans/plansv5');
	}elseif($classiera_cat_style == 6){ 
		get_template_part('templates/plans/plansv6');
	}elseif($classiera_cat_style == 7){ 
		get_template_part('templates/plans/plansv7');
	}

?>
<!-- Company Section Start-->
<?php 
	global $redux_demo; 
	$classieraCompany = $redux_demo['partners-on'];
	$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
	if($classieraCompany == 1){
		if($classieraPartnersStyle == 1){
			get_template_part('templates/members/memberv1');
		}elseif($classieraPartnersStyle == 2){
			get_template_part('templates/members/memberv2');
		}elseif($classieraPartnersStyle == 3){
			get_template_part('templates/members/memberv3');
		}elseif($classieraPartnersStyle == 4){
			get_template_part('templates/members/memberv4');
		}elseif($classieraPartnersStyle == 5){
			get_template_part('templates/members/memberv5');
		}elseif($classieraPartnersStyle == 6){
			get_template_part('templates/members/memberv6');
		}
	}
?>
<?php get_footer(); ?>
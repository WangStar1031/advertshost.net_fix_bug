<?php
/**
 * Template name: All Categories
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera
 */


get_header(); ?>

<?php 

	$page = get_page($post->ID);
	$current_page_id = $page->ID;

	$page_slider = get_post_meta($current_page_id, 'page_slider', true); 
	$page_custom_title = get_post_meta($current_page_id, 'page_custom_title', true);


	global $redux_demo, $maximRange; 
	$home_cat_desc = $redux_demo['cat-sec-desc'];
	$catSecTitle = $redux_demo['cat-sec-title'];	
	$category_icon_code = "";
	$category_icon_color = "";
	$your_image_url = "";
	$caticoncolor="";
	$category_icon="";
	$classieraSearchStyle = $redux_demo['classiera_search_style'];	
	$classieraPremiumStyle = $redux_demo['classiera_premium_style'];	
	$classieraCategoriesStyle = $redux_demo['classiera_cat_style'];	
	$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
	$classieraPremiumSlider = $redux_demo['featured-options-on'];
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
	//Categories Styles//
	if($classieraCategoriesStyle == 1){
		get_template_part( 'templates/categoriesstyle/catstyle1' );
	}elseif($classieraCategoriesStyle == 2){
		get_template_part( 'templates/categoriesstyle/catstyle2' );
	}elseif($classieraCategoriesStyle == 3){
		get_template_part( 'templates/categoriesstyle/catstyle3' );
	}elseif($classieraCategoriesStyle == 4){
		get_template_part( 'templates/categoriesstyle/catstyle4' );
	}elseif($classieraCategoriesStyle == 5){
		get_template_part( 'templates/categoriesstyle/catstyle5' );
	}elseif($classieraCategoriesStyle == 6){
		get_template_part( 'templates/categoriesstyle/catstyle6' );
	}elseif($classieraCategoriesStyle == 7){
		get_template_part( 'templates/categoriesstyle/catstyle7' );
	}
	//Patners Styles//
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
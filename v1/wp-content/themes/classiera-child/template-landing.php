<?php
/**
 * Template name: Landing Page
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
 * @since classiera 1.1
 */
get_header(); ?>

<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$page_slider = get_post_meta($current_page_id, 'page_slider', true); 
	global $redux_demo;
	$homeLayout = $redux_demo['opt-homepage-layout-landing']['enabled'];
?>
<?php 
if ($homeLayout):
	foreach ($homeLayout as $key=>$value) { 
			switch($key) {
		 
					case 'imgslider1': get_template_part( 'templates/slider/sliderv2' );
					break;
					case 'navcategories': get_template_part( 'templates/category/menu-bar-cats' );
					break;
					case 'imgslider2': get_template_part( 'templates/slider/sliderv3' );
					break;
					case 'imgslider3': get_template_part( 'templates/slider/sliderv4' );
					break;
					
					case 'googlemap': get_template_part( 'templates/slider/classiera-header-map' );
					break;
					
					case 'layerslider': get_template_part( 'templates/slider/sliderv1' );
					break;
					
					case 'searchv1': get_template_part( 'templates/searchbar/searchstyle1' );
					break;
					case 'searchv2': get_template_part( 'templates/searchbar/searchstyle2' );
					break;
					case 'searchv3': get_template_part( 'templates/searchbar/searchstyle3' );
					break;
					case 'searchv4': get_template_part( 'templates/searchbar/searchstyle4' );
					break;
					case 'searchv5': get_template_part( 'templates/searchbar/searchstyle5' );
					break;
					case 'searchv6': get_template_part( 'templates/searchbar/searchstyle6' );
					break;
					case 'searchv7': get_template_part( 'templates/searchbar/searchstyle7' );
					break;
					
					case 'premiumslider1': get_template_part( 'templates/premium/premiumv1' );
					break;
					case 'premiumslider2': get_template_part( 'templates/premium/premiumv2' );
					break;
					case 'premiumslider3': get_template_part( 'templates/premium/premiumv3' );
					break;
					case 'premiumslider4': get_template_part( 'templates/premium/premiumv4' );
					break;
					case 'premiumslider5': get_template_part( 'templates/premium/premiumv5' );
					break;
					case 'premiumslider6': get_template_part( 'templates/premium/premiumv6' );
					break;
					
					case 'categories1': get_template_part( 'templates/category/catstyle1' );
					break;
					case 'categories2': get_template_part( 'templates/category/catstyle2' );
					break;
					case 'categories3': get_template_part( 'templates/category/catstyle3' );
					break;
					case 'categories4': get_template_part( 'templates/category/catstyle4' );
					break;
					case 'categories5': get_template_part( 'templates/category/catstyle5' );
					break;
					case 'categories6': get_template_part( 'templates/category/catstyle6' );
					break;
					case 'categories7': get_template_part( 'templates/category/catstyle7' );
					break;
					
					case 'advertisement1': get_template_part( 'templates/adv/advstyle1' );
					break;
					case 'advertisement2': get_template_part( 'templates/adv/advstyle2' );
					break;
					case 'advertisement3': get_template_part( 'templates/adv/advstyle3' );
					break;
					case 'advertisement4': get_template_part( 'templates/adv/advstyle4' );
					break;
					case 'advertisement5': get_template_part( 'templates/adv/advstyle5' );
					break;
					case 'advertisement6': get_template_part( 'templates/adv/advstyle6' );
					break;
					case 'advertisement7': get_template_part( 'templates/adv/advstyle7' );
					break;
					
					case 'locationv1': get_template_part( 'templates/locations/locationsv1' );
					break;
					case 'locationv2': get_template_part( 'templates/locations/locationsv2' );
					break;
					case 'locationv3': get_template_part( 'templates/locations/locationsv3' );
					break;
					case 'locationv4': get_template_part( 'templates/locations/locationsv4' );
					break;
					case 'locationv5': get_template_part( 'templates/locations/locationsv5' );
					break;
					
					case 'plans1': get_template_part( 'templates/plans/plansv1' );
					break;
					case 'plans2': get_template_part( 'templates/plans/plansv2' );
					break;
					case 'plans3': get_template_part( 'templates/plans/plansv3' );
					break;
					case 'plans4': get_template_part( 'templates/plans/plansv4' );
					break;
					case 'plans5': get_template_part( 'templates/plans/plansv5' );
					break;
					case 'plans6': get_template_part( 'templates/plans/plansv6' );
					break;
					case 'plans7': get_template_part( 'templates/plans/plansv7' );
					break;
					
					case 'callout1': get_template_part( 'templates/callout/callout1' );
					break;
					case 'callout2': get_template_part( 'templates/callout/callout2' );
					break;
					case 'callout3': get_template_part( 'templates/callout/callout3' );
					break;
					case 'callout4': get_template_part( 'templates/callout/callout4' );
					break;
					case 'callout5': get_template_part( 'templates/callout/callout5' );
					break;
					case 'callout6': get_template_part( 'templates/callout/callout6' );
					break;
					case 'callout7': get_template_part( 'templates/callout/callout7' );
					break;
					
					case 'partners1': get_template_part( 'templates/members/memberv1' );
					break;
					case 'partners2': get_template_part( 'templates/members/memberv2' );
					break;
					case 'partners3': get_template_part( 'templates/members/memberv3' );
					break;
					case 'partners4': get_template_part( 'templates/members/memberv4' );
					break;
					case 'partners5': get_template_part( 'templates/members/memberv5' );
					break;
					case 'partners6': get_template_part( 'templates/members/memberv6' );
					break;
					
					case 'blogs1': get_template_part( 'templates/blogs/blogv1' );
					break;
					case 'blogs2': get_template_part( 'templates/blogs/blogv2' );
					break;
					case 'blogs3': get_template_part( 'templates/blogs/blogv3' );
					break;
					case 'blogs4': get_template_part( 'templates/blogs/blogv4' );
					break;
					
					case 'customads': get_template_part( 'templates/customads' );
					break;
					case 'customads2': get_template_part( 'templates/customads2' );
					break;
					case 'customads3': get_template_part( 'templates/customads3' );
					break;
					
					case 'contentsection': get_template_part( 'templates/contentsection' );
					break;
				}			 
			}		 
	endif;
?>
<?php get_footer(); ?>
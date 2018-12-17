<?php
/**
 * Template name: Homepage V7 - Allure
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
 * @since classiera 1.0
 */
get_header(); ?>

<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$page_slider = get_post_meta($current_page_id, 'page_slider', true); 
	global $redux_demo;
	$homeLayout = $redux_demo['opt-homepage-layout-v7']['enabled'];
?>
<?php 
if ($homeLayout):
	foreach ($homeLayout as $key=>$value) { 
			switch($key) {
		 
					case 'banner': get_template_part( 'templates/slider/sliderv4' );
					break;
					
					case 'premiumslider': get_template_part( 'templates/premium/premiumv6' );
					break;
					
					case 'categories': get_template_part( 'templates/category/catstyle7');
					break;	
			 
					case 'customads': get_template_part( 'templates/customads' );    
					break;
					case 'customads2': get_template_part( 'templates/customads2' );
					break;
					case 'customads3': get_template_part( 'templates/customads3' );
					break;
					
					case 'callout': get_template_part( 'templates/callout/callout7' );
					break;
					
					case 'location': get_template_part( 'templates/locations/locationsv5' );
					break;
					
					case 'advertisement': get_template_part( 'templates/adv/advstyle7' );    
					break; 
					
					case 'packages': get_template_part( 'templates/plans/plansv7' );    
					break;
					
					case 'blogs': get_template_part( 'templates/blogs/blogv4' );    
					break;
					
					case 'partners': get_template_part( 'templates/members/memberv6' );    
					break;
					
					case 'contentsection': get_template_part( 'templates/contentsection' );
					break;
				}			 
			}		 
	endif;
?>
<?php get_footer(); ?>
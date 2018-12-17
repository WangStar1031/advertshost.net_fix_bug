<?php
/**
 * Template name: Full Width
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

get_header();
 ?>

<?php 

	$page = get_page($post->ID);
	$current_page_id = $page->ID;

	$page_slider = get_post_meta($current_page_id, 'page_slider', true); 
	$page_custom_title = get_post_meta($current_page_id, 'page_custom_title', true);

	global $redux_demo;
	$classieraSearchStyle = $redux_demo['classiera_search_style'];
	$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
$caticoncolor="";
$category_icon_code ="";
$category_icon="";
$category_icon_color="";	

?>

<?php if($page_slider == "LayerSlider") : ?>
<?php get_template_part( 'templates/slider/sliderv1' ); ?>
<?php endif; ?>
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
<!--PageContent-->
<section class="inner-page-content border-bottom">
	<div class="container">
		<!-- breadcrumb -->
		<?php classiera_breadcrumbs();?>
		<!-- breadcrumb -->
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<article class="article-content">
					<h3><?php the_title(); ?></h3>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php the_content(); ?>
					<?php endwhile; endif; ?>
				</article>
				<!--comments-->
				<?php
					$defaults = array(
						'before'           => '<p>' . __( 'Pages:' , 'classiera'),
						'after'            => '</p>',
						'link_before'      => '',
						'link_after'       => '',
						'next_or_number'   => 'number',
						'separator'        => ' ',
						'nextpagelink'     => __( 'Next page', 'classiera'),
						'previouspagelink' => __( 'Previous page', 'classiera'),
						'pagelink'         => '%',
						'echo'             => 1
					);
					wp_link_pages( $defaults );
				?>
				<div class="hidden">
					<?php comment_form(); ?>
				</div>
				<!--comments-->
			</div><!--col-md-8 col-lg-9-->
		</div><!--row-->
	</div>
</section>
<!--PageContent-->
<!-- Company Section Start-->
<?php 
	global $redux_demo; 
	$classieraCompany = $redux_demo['partners-on'];
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
<!-- Company Section End-->	
<?php get_footer(); ?>
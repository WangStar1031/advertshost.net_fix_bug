<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera
 */

get_header(); ?>
<section class="inner-page-content border-bottom">
	<div class="container">
		<?php if ( have_posts() ) : ?>
		<?php if ( is_home() && ! is_front_page() ) : ?>
		<div class="row">
            <div class="col-lg-12">
                <?php //classiera_breadcrumbs();?>
            </div>
        </div><!-- /.breadcrumb -->	
		<?php endif; ?>
		<div class="row top-pad-50">
			<div class="col-md-8 col-lg-9">
				<?php
				// Start the loop.
				while ( have_posts() ) : the_post();						
					get_template_part( 'content', get_post_format() );
				// End the loop.
				endwhile;
				?>
				<?php //get_template_part('pagination'); ?>
			</div><!--col-md-8 col-lg-9-->
			<div class="col-md-4 col-lg-3">
				<aside class="sidebar">
					<div class="row">
						<?php get_sidebar('pages'); ?>
					</div>
				</aside>
			</div><!--col-md-4 col-lg-3-->
		</div><!--row top-pad-50-->
		<?php 
			else :
			echo "No Content";
			endif;
		?>
	</div><!--container-->
</section><!--inner-page-content border-bottom-->
<?php get_footer(); ?>
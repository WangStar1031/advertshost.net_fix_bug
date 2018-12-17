<?php
/**
 * The template for displaying archives of blog categories
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 2.0.6
 */
 ?>
<?php get_header();?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$wp_query->get_queried_object();
?>
<section class="inner-page-content border-bottom">
	<div class="container">
		<!-- breadcrumb -->
			<?php classiera_breadcrumbs();?>
		<!-- breadcrumb -->
		<div class="row top-pad-50">			
			<div class="col-md-8 col-lg-9">
			<?php if ( have_posts() ): ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'templates/blog-loop' ); ?>
				<?php endwhile; ?>
				<div class="classiera-pagination">
					<nav aria-label="Page navigation">
						<?php 
						//pagination
						$big = 999999999; // need an unlikely integer		
						echo paginate_links( array(
								'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format' => '?paged=%#%',
								'current' => max( 1, get_query_var('paged') ),
								'total' => $wp_query->max_num_pages
							) );                        
						?>
					</nav>
				</div><!--classiera-pagination-->
				<?php 
				else :
					echo esc_html__( 'Sorry Nothing Found', 'classiera' );
					
				endif;
				wp_reset_postdata(); 
				?>
			</div><!--col-md-8 col-lg-9-->
			<div class="col-md-4 col-lg-3">
				<aside class="sidebar">
					<div class="row">
						<?php dynamic_sidebar('blog'); ?>
					</div>
				</aside>
			</div>
		</div><!--row top-pad-50-->
	</div><!--container-->
</section>
<?php get_footer(); ?>
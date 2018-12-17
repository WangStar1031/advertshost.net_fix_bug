<?php
/**
 * Template Name: Blog Main Page
 *
 * The template for displaying the Main Blog Page.
 *
 * it will loop and display the blog posts
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
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<section class="inner-page-content border-bottom">
	<div class="container">
		<!-- breadcrumb -->
			<?php classiera_breadcrumbs();?>
		<!-- breadcrumb -->
		<div class="row top-pad-50">
			<div class="col-md-8 col-lg-9">
				<?php 
				$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
				$blog_args = array (					
						'post_type' => array('blog','blog_posts'),
						'posts_per_page' => 10,
						'paged' => $paged,
					);
				$blog_query = new WP_Query( $blog_args );
				if ( $blog_query->have_posts() ):
				while ( $blog_query->have_posts() ) : $blog_query->the_post();
					get_template_part( 'templates/blog-loop' );
				endwhile;			
				?>
				<div class="classiera-pagination">
					<nav aria-label="Page navigation">
						<?php 
						//pagination
						$big = 999999999; // need an unlikely integer		
						echo paginate_links( array(
								'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format' => '?paged=%#%',
								'type' => 'list',
								'current' => max( 1, get_query_var('paged') ),
								'total' => $blog_query->max_num_pages
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
<?php endwhile; endif; ?>
<?php get_footer(); ?>
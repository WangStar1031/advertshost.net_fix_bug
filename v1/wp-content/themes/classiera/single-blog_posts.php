<?php
/**
 * The template for displaying the single blog posts.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera 1.0
 */

get_header();

 ?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
?>
<section class="inner-page-content">
	<div class="container">
		<!-- breadcrumb -->
		<?php classiera_breadcrumbs();?>
		<!-- breadcrumb -->
		<div class="row top-pad-50">
			<div class="col-md-8 col-lg-9">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<article class="blog article-content blog-post">
					<div class="single-post border-bottom">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p>
                            <span><i class="fa fa-user"></i><?php the_author(); ?></span>
							<?php $dateFormat = get_option( 'date_format' );?>
                            <span><i class="fa fa-clock"></i><?php echo get_the_date($dateFormat, $post->ID); ?></span>
                            <span><i class="fas fa-comments"></i><?php echo comments_number(); ?></span>
                        </p>
						<?php if ( has_post_thumbnail() ){?>
						<div class="blog-img">
							<?php 
							$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
							?>
							<img class="thumbnail" src="<?php echo esc_url($imageurl[0]); ?>" alt="<?php the_title(); ?>">
						</div>
						<?php } ?>
						<?php $content = the_content(); ?>
						<div class="tags">
							<span><i class="fa fa-tags"></i><?php esc_html_e( 'Tags', 'classiera' ); ?> :</span>
							<?php the_tags('','',''); ?>
						</div>
					</div>
				</article>
				<?php endwhile; endif; ?>
				<section class="border-section border comments">
					<?php 
					$file ='';
					$separate_comments ='';
					comments_template( $file, $separate_comments ); 
					?>
				</section>
			</div><!--col-md-8-->
			<div class="col-md-4 col-lg-3">
				<aside class="sidebar">
					<div class="row">
						<?php dynamic_sidebar('blog'); ?>
					</div>
				</aside>
			</div>
		</div><!--row-->
	</div><!--container-->
</section><!--inner-page-content-->
<?php get_footer(); ?>
<?php 
/* 
 * used to display blog posts items in archives and listings 
 *
 * need to be called within the loop
 */
 ?>	
<article <?php post_class( 'blog article-content' ); ?> id="post-<?php the_ID(); ?>">
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<p>
		<span><i class="fa fa-user"></i><a href="#"><?php the_author(); ?></a></span>
		<?php $dateFormat = get_option( 'date_format' );?>
		<span><i class="fa fa-clock"></i><?php echo get_the_date($dateFormat, $post->ID); ?></span>
		<span><i class="fas fa-comments"></i><?php echo comments_number(); ?></span>
	</p>
	<?php if ( has_post_thumbnail()){?>
	<div class="blog-img">
		<img class="thumbnail" src="<?php echo the_post_thumbnail_url( 'full' ); ?>" alt="<?php the_title(); ?>">
	</div><!--blog-img-->
	<?php } ?>
	<!--BodyContent-->
	<?php the_excerpt(); ?>
	<!--BodyContent-->
	<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-md sharp btn-style-one">
		<i class="icon-left fa fa-arrow-circle-right"></i>
		<?php esc_html_e( 'Read More', 'classiera' ); ?>
	</a>
</article>
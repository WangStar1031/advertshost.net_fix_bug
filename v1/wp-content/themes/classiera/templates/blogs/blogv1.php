<?php 
	global $redux_demo;
	$classieraBlogSecTitle = $redux_demo['classiera_blog_section_title'];
	$classieraBlogSecDesc = $redux_demo['classiera_blog_section_desc'];
	$classieraBlogSecCount = $redux_demo['classiera_blog_section_count'];
	$classieraBlogSecPOrder = $redux_demo['classiera_blog_section_post_order'];
	$classieraBlogPOrder = $redux_demo['classiera_blog_post_order'];
?>
<section class="blog-post-section section-pad">
    <!-- section heading with icon -->
    <div class="section-heading-v1 section-heading-with-icon">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-9 center-block">
                    <h3 class="text-capitalize">
						<?php echo esc_html($classieraBlogSecTitle); ?><i class="fab fa-leanpub"></i>
					</h3>
                    <p><?php echo esc_html($classieraBlogSecDesc); ?></p>
                </div>
            </div>
        </div>
    </div><!-- section heading with icon -->

    <div class="container">
        <div class="row">
		<?php 
			$args = array (
				'post_type' => array('blog','blog_posts'),
				'post_status' => 'publish',
				'posts_per_page' => $classieraBlogSecCount,
				'order' => $classieraBlogPOrder,
				'orderby' => $classieraBlogSecPOrder,
			);
			$blogSecQuery = new WP_Query($args);
		?>
		<?php if ( $blogSecQuery->have_posts() ): ?>
			<?php while ( $blogSecQuery->have_posts() ) : $blogSecQuery->the_post(); ?>
			<?php 
				$user_ID = $post->post_author;
				$classieradateFormat = get_option( 'date_format' );
			?>
            <div class="col-lg-4 col-sm-6 col-md-4">
                <div class="blog-post match-height">
                    <div class="blog-post-img-sec">
                        <div class="blog-img">
                            <?php 
							if( has_post_thumbnail()){
								echo get_the_post_thumbnail();
							}	
							?>	
                            <span class="hover-posts">
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary radius btn-md active">
                                    <?php esc_html_e( 'View Post', 'classiera' ); ?>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="blog-post-content">
                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <p>
                            <span>
								<i class="fa fa-user"></i>
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author_meta('display_name', $user_ID ); ?></a>
							</span>
                            <span><i class="far fa-clock"></i><?php echo get_the_date($classieradateFormat, $post->ID); ?></span>
                            <span><i class="fas fa-comments"></i>
								<?php printf( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'classiera' ), number_format_i18n( get_comments_number() ) );?>
							</span>
                        </p>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
        </div>
    </div>
	<?php 
	$blogPermalink = "";
	$blogTempName = 'template-blog.php';
	$blogPermalink = classiera_get_template_url($blogTempName);
	?>
    <div class="view-all text-center">
        <a href="<?php echo esc_url($blogPermalink); ?>" class="btn btn-primary btn-style-four"><?php esc_html_e( 'View All', 'classiera' ); ?></a>
    </div>
</section><!-- /.blog post -->
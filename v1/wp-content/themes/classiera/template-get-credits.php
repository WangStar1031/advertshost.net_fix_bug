<?php
/**
 * Template name: Get Credits
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

<section class="user-pages section-gray-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-4">
			<?php get_template_part( 'templates/profile/userabout' );?>
			</div><!--col-lg-3-->
			<div class="col-lg-9 col-md-8 user-content-height">
				<div class="user-detail-section section-bg-white">
					<!-- favorite ads -->
					<div class="user-ads favorite-ads">
						<h4 class="user-detail-section-heading text-uppercase">
						<?php esc_html_e("Get Credits", 'classiera') ?>
						</h4>
					</div><!--user-ads-->
					<!-- favorite ads -->
				</div><!--user-detail-->
			</div><!--col-lg-9-->
		</div><!--row-->
	</div><!--container-->
</section><!--user-pages-->

 <?php get_footer(); ?>
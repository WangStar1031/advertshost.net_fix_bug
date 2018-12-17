<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */
?> 
<?php get_header(); ?>
<section class="page-content-404">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="background-wrap">
                    <div class="x1">
                        <div class="cloud-inner"></div>
                        <div class="cloud"></div>
                    </div>

                    <div class="x2">
                        <div class="cloud-inner"></div>
                        <div class="cloud"></div>
                    </div>

                    <div class="x3">
                        <div class="cloud-inner"></div>
                        <div class="cloud"></div>
                    </div>

                    <div class="x4">
                        <div class="cloud-inner"></div>
                        <div class="cloud"></div>
                    </div>

                    <div class="x5">
                        <div class="cloud-inner"></div>
                        <div class="cloud"></div>
                    </div>
                </div>
                <div class="img-404 text-center">
                    <img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/404.png" alt="404">
                </div>
                <div class="text-404 text-center">
                    <h1 class="text-uppercase"><?php esc_html_e('Oops, ', 'classiera' ); ?></h1>
                    <h2 class="text-uppercase"><?php esc_html_e('Sorry We Cant Find That Page!', 'classiera' ); ?></h2>
                    <p><?php esc_html_e('Either something went wrong or the page doesnt exist anymore.', 'classiera' ); ?></p>
                    <a href="<?php echo home_url(); ?>" class="btn btn-primary btn-sm sharp btn-style-one"><?php esc_html_e('Go back HomePage', 'classiera' ); ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="grass-404"></section>
<?php get_footer(); ?>
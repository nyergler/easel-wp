<?php
/**
 * The template for displaying a Work Medium archive.
 *
 * @package Easel
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

            <header class="page-header">
                <h1 class="page-title">
                    <a href="<?php echo get_post_type_archive_link( 'print' ); ?>">Prints</a> &raquo;
                    <?php single_term_title(); ?>
                </h1>
            </header>

            <div class="portfolio-entry-content">
				<?php echo term_description(); ?>
            </div>

			<?php /* Start the Loop */ ?>

			<div class="portfolio-projects">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php include(plugin_dir_path(__FILE__) . '/content-print.php'); ?>

				<?php endwhile; ?>

				<!-- <?php sketch_paging_nav(); ?> -->

			</div><!-- .projects -->

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
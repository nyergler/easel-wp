<?php
/**
 * The Template for displaying a single Work
 *
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
        <?php
        if ( has_post_thumbnail() ) {
            the_post_thumbnail();
        }
        ?>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<ul>
				<?php
				$easel_work_year = get_post_meta(get_the_ID(), 'easel_work-year', true);
				$easel_work_dimensions = get_post_meta(get_the_ID(), 'easel_work-dimensions', true);
				?>
				<li><?php the_author() ?></li>
				<li><?php echo $easel_work_year ?></li>
				<li><?php echo $easel_work_dimensions ?></li>
				<li><?php the_terms( get_the_ID(), 'easel_medium' ) ?></li>
			</ul>
			<?php edit_post_link( __( 'Edit', 'easel' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'easel' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'easel' ) );
			if ( $categories_list ) :
		?>
		<span class="cat-links">
			<?php printf( __( 'Posted in %1$s', 'easel' ), $categories_list ); ?>
		</span>
		<?php endif; // End if categories ?>
		<?php
			$tags_list = get_the_tag_list( '', '' );
			if ( $tags_list && ! is_wp_error( $tags_list ) ) :
		?>
		<span class="tags-links">
			<?php echo $tags_list; ?>
		</span>
		<?php endif; // End if $tags_list ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

<?php the_post_navigation(); ?>

<?php
    // If comments are open or we have at least one comment, load up the comment template
    if ( comments_open() || '0' != get_comments_number() ) :
        comments_template();
    endif;
?>

<?php endwhile; // end of the loop. ?>

</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

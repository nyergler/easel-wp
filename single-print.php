<?php
/**
 * The Template for displaying a single Print
 *
 * @package Sketch
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
				function term_name($t)
				{
					return $t->$name;
				}

				?>
				<li><?php echo join(', ', get_field('artist')); ?></li>
				<li><?php echo get_field('year'); ?></li>
				<li><?php echo get_field('dimensions'); ?></li>
				<li><?php echo join(', ', array_map(term_name, get_field('medium'))); ?></li>
			</ul>
			<?php edit_post_link( __( 'Edit', 'sketch' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'sketch' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'sketch' ) );
			if ( $categories_list && sketch_categorized_blog() ) :
		?>
		<span class="cat-links">
			<?php printf( __( 'Posted in %1$s', 'sketch' ), $categories_list ); ?>
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

<?php sketch_post_nav(); ?>

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

<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Sketch
 */
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer" role="contentinfo">
            <?php if ( has_nav_menu ( 'social' ) ) : ?>
                    <?php wp_nav_menu( array( 'theme_location' => 'social', 'depth' => 1, 'link_before' => '<span class="screen-reader-text">', 'link_after' => '</span>', 'container_class' => 'social-links', ) ); ?>
            <?php endif; ?>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
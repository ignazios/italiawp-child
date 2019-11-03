<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package pasw2017
 */
 
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'Prose' ); ?>>
<?php 
        if ( has_post_thumbnail() ) {
        echo '<img src="'.get_the_post_thumbnail_url( null, 'large' ).'" style="max-width:100%;" >';
    }
    ?>
<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pasw2017' ),
				'after'  => '</div>',
			) );
		?>
</article>

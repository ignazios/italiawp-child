<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package italiawp-child
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'Prose' ); ?> >

<?php
	the_content();

	wp_link_pages( array(
		'before' => '<div class="page-links"> Pagine',
		'after'  => '</div>',
	) );
?>
</article>
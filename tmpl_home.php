<?php
/**
* Template Name: Home page
*
* This is the template that displays the home page.
* Please note that this is the WordPress construct of pages
* and that other 'pages' on your WordPress site may use a
* different template.
*
* @link https://codex.wordpress.org/Template_Hierarchy
*
* @package italiawp-child
*/

get_header(); 
if ( has_post_thumbnail() ) {
	$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
?>	<div class="map-full-content">
		<img src="<?php echo $large_image_url[0];?>" style="width: 100%;"/>
	</div><?php
}
	if(get_theme_mod('active_slide_inevidenza') or get_theme_mod('active_blocco_scuola')){
	?>
		<div id="Scuola" class="u-padding-r-top">
	<?php
		if(get_theme_mod('active_slide_inevidenza')){
			get_template_part( 'template-parts/section', 'slider' );
		}
		if(get_theme_mod('active_blocco_scuola')){
		    get_template_part( 'template-parts/section', 'scuola' );
		}
	?>
		</div>
	<?php	
	}
//    get_template_part( 'template-parts/cards', 'home' );
//    get_template_part( 'template-parts/section', 'last-news' );
    for ( $i = 1; $i < 4; $i++ ) {
        if ( is_active_sidebar('home-'.$i ) ) {
//            echo '<div class="Grid-cell u-md-size12of12 u-lg-size12of12">';
            dynamic_sidebar('home-'.$i);
//            echo '</div>';
        }
	}
get_footer();
<?php
/**
* Template Name: Pagina piena
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
get_header();?>
  <section class="content-page">
      <div class="u-layout-wide u-layoutCenter u-layout-withGutter u-padding-r-top u-padding-bottom-xxl">
        <?php the_title( '<h2 class="u-text-h2">', '</h2>' ); ?>

          <div class="Grid Grid--withGutter">

            <?php
    $args = array(
        'post_type'      => 'page',
        'posts_per_page' => -1,
        'post_parent'    => $post->ID,
        'order'          => 'ASC',
        'orderby'        => 'menu_order'
    );

    $parent = new WP_Query( $args );

	$Are_Child=FALSE;
    if ( $parent->have_posts() ):
    	$Are_Child=TRUE;    
    endif; wp_reset_query();

    if ( $post->post_parent ) {
        $args = array(
            'post_type'      => 'page',
            'posts_per_page' => -1,
            'post_parent'    => $post->post_parent,
            'order'          => 'ASC',
            'orderby'        => 'menu_order'
        );

        $parent = new WP_Query( $args );

        if ( $parent->have_posts() ) :
    		$Are_Child=TRUE;    
        endif; 
	}    
	wp_reset_query();
    
    while ( have_posts() ) : the_post();

if ( trim(str_replace('&nbsp;','',strip_tags(get_the_content()))) != '' ) {
	
	
	if($Are_Child){
		echo '<div class="Grid-cell u-md-size10of12 u-lg-size10of12">';	
	}else{
		echo '<div class="Grid-cell u-md-size12of12 u-lg-size12of12">';	
	}
    
    get_template_part( 'template-parts/content', 'page' );
    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
        comments_template();
    endif;

    echo '</div>';
    if($Are_Child){
    	get_sidebar( 'navigation2' );
	}
} else { get_template_part( 'template-parts/content', 'pageblank' ); }
endwhile; // End of the loop.
?>
          </div>
      </div>
  </section>

  <?php
get_footer();
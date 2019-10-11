<?php
/**
* The template for displaying all pages
*
* This is the template that displays all pages by default.
* Please note that this is the WordPress construct of pages
* and that other 'pages' on your WordPress site may use a
* different template.
*
* @link https://codex.wordpress.org/Template_Hierarchy
*
*/

get_header();?>
  <section>
    <p class="u-md-hidden u-lg-hidden u-padding-r-all u-text-m u-background-grey-20">
      <span class="Icon-list u-text-r-xl u-alignMiddle u-padding-r-right" aria-hidden="true"></span>
      <a href="#subnav" class="js-scrollTo u-text-r-s u-textClean u-color-grey-50 u-alignMiddle">Esplora contenuti correlati</a>
    </p>

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
    
    while ( have_posts() ) : the_post(); ?>	
    	<div class="Grid-cell u-md-size9of12 u-lg-size9of12 u-padding-r-all u-text-r-l">
<?php
		if ( trim(str_replace('&nbsp;','',strip_tags(get_the_content()))) != '' ) {
	    	get_template_part( 'template-parts/content', 'page' );
		    // If comments are open or we have at least one comment, load up the comment template.
		    if ( comments_open() || get_comments_number() ) :
		        comments_template();
		    endif;	
		} else { get_template_part( 'template-parts/content', 'pageblank' ); }	
	endwhile; // End of the loop.
?>    
    	</div>
    	<div class="Grid-cell u-sizeFull u-md-size3of12 u-lg-size3of12">
    		<div id="subnav" class="Grid-cell">
<?php
		    if($Are_Child)
		    	get_sidebar( 'navigation2' );  	
		    get_template_part('template-parts/sidebar-page');
            if (!get_theme_mod('active_allegati_contenuto'))
                get_template_part('template-parts/attachments'); ?>
          </div>
    	</div>
  </section>

<?php
get_sidebar();
get_footer();
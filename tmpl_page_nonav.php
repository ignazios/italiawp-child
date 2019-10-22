<?php
/**
* Template Name: Pagina senza colonna di navigazione
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

get_header(); ?>

  <section class="content-page">
    <p class="u-md-hidden u-lg-hidden u-padding-r-all u-text-m u-background-grey-20">
      <span class="Icon-list u-text-r-xl u-alignMiddle u-padding-r-right" aria-hidden="true"></span>
      <a href="#subnav" class="js-scrollTo u-text-r-s u-textClean u-color-grey-50 u-alignMiddle">Esplora contenuti correlati</a>
    </p>

    <?php get_template_part( 'template-parts/breadcrumbs' ); ?>
      <div class="u-layout-wide u-layoutCenter u-layout-withGutter u-padding-r-top u-padding-bottom-xxl">
        <?php the_title( '<h2 class="u-text-h2">', '</h2>' ); ?>

          <div class="Grid Grid--withGutter">

            <?php
while ( have_posts() ) : the_post();

if ( trim(str_replace('&nbsp;','',strip_tags(get_the_content()))) != '' ) {
    echo '<div class="Grid-cell u-md-size12of12 u-lg-size12of12">';
    
    get_template_part( 'template-parts/content', 'page_no_nav' );
    
    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
        comments_template();
    endif;

    echo '</div>';
} else { get_template_part( 'template-parts/content', 'pageblank' ); }
endwhile; // End of the loop.
?>
          </div>
      </div>
  </section>

  <?php
get_footer();
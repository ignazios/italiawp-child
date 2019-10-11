<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
                <div class="Grid-cell u-md-size9of12 u-lg-size9of12">

				<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', get_post_format() );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
                </div>
                 <div class="Grid-cell u-md-size3of12 u-lg-size3of12" id="subnav">
				 <div class="u-nbfc u-background-50 u-color-white u-borderShadow-m u-xs-borderShadow-none u-borderRadius-m u-text-r-xxs u-padding-r-all" id="BloccoMetaArticolo">
                	<p class="u-textWeight-400 u-text-r-xxs u-margin-r-bottom">
                		<i class="fas fa-user-edit u-padding-r-right"></i> <?php the_author_posts_link() ?>
                	</p>
               		<p class="u-textWeight-400 u-text-r-xxs u-margin-r-bottom">
                		<i class="far fa-calendar-alt u-padding-r-right"></i> <?php the_time( get_option( 'date_format' ) ); ?>
                	</p>
               		<?php if(get_the_category_list()) :?>
              		<p class="u-textWeight-400 u-text-r-xxs u-margin-r-bottom">
                		<i class="fa fa-folder-open u-padding-r-right"></i> <?php the_category(', '); ?>
                	</p>
 					<?php endif;
 						  if(get_the_tag_list()) :?>
              		<p class="u-textWeight-400 u-text-r-xxs u-margin-r-bottom">
                		<i class="fas fa-hashtag u-padding-r-right"></i> <?php the_tags( '', ', '); ?>
                	</p>  					
					<?php endif;?>
 				</div>
 					 <?php if (is_active_sidebar('sidebar-articoli')) { ?>
					<div class="italiawp-sidebar">
					    <?php dynamic_sidebar('sidebar-articoli'); ?>
					</div>
					<?php } ?>           
				 </div>
        </div>
    </section>

<?php
get_footer();
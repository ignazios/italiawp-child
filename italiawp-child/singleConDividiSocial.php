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

        <?php get_template_part( 'template-parts/breadcrumbs' ); ?>
        <div class="u-layout-wide u-layoutCenter u-layout-withGutter u-padding-r-top u-padding-bottom-xxl">
            <?php the_title( '<h2 class="u-text-h2">', '</h2>' ); ?>
            <div class="Grid Grid--withGutter">
                <div class="Grid-cell u-md-size8of12 u-lg-size8of12">

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
                 <div class="Grid-cell u-size6of12 u-md-size3of12 u-lg-size3of12">
					<div class="Share">
				  		<div class="Share-reveal js-Share">
						    <a href="#share-options" class="Share-revealText" data-menu-trigger="share-options" data-menu-inline="" aria-controls="share-options" aria-haspopup="true" role="button">
						      <span class="Share-revealIcon Icon Icon-share"></span>
						      Condividi
						    </a>
				  		</div>
				  		<ul id="share-options" class="Dropdown-menu" data-menu="" role="menu" aria-hidden="true">
						    <li role="menuitem">
						    	<a href="#" title=""><span class="Icon Icon-facebook"></span><span class="u-hiddenVisually">Facebook</span>
						    	</a>
						    </li>
						    <li role="menuitem">
						    	<a href="#"><span class="Icon Icon-twitter"></span><span class="u-hiddenVisually">Twitter</span>
						    	</a>
						    </li>
						    <li role="menuitem">
						    	<a href="#"><span class="Icon Icon-googleplus"></span><span class="u-hiddenVisually">Google Plus</span>
						    	</a>
						    </li>
						    <li role="menuitem">
						    	<a href="#"><span class="Icon Icon-youtube"></span><span class="u-hiddenVisually">Youtube</span>
						    	</a>
						    </li>
						    <li role="menuitem">
						    	<a href="#"><span class="Icon Icon-flickr"></span><span class="u-hiddenVisually">Flickr</span>
						    	</a>
						    </li>
						    <li role="menuitem">
						    	<a href="#"><span class="Icon Icon-slideshare"></span><span class="u-hiddenVisually">Slideshare</span>
						    	</a>
						    </li>
						    <li role="menuitem">
						    	<a href="#"><span class="Icon Icon-whatsapp"></span><span class="u-hiddenVisually">Whatsapp</span>
						    	</a>
						    </li>
						</ul>
				</div>   
				<div class="u-nbfc u-background-grey-30 u-sizeFull u-borderShadow-m u-xs-borderShadow-none u-borderRadius-m u-text-r-xxs u-padding-r-all">
                	<p class="u-textWeight-400 u-text-r-xxs u-color-grey-80 u-margin-r-bottom">
                		<span class="dashicons dashicons-admin-users" style="font-size:2em;padding-right:1.4em;"></span><?php the_author_posts_link() ?>
                	</p>
               		<p class="u-textWeight-400 u-text-r-xxs u-color-grey-80 u-margin-r-bottom IcoCalendar24">
                		<?php the_time( get_option( 'date_format' ) ); ?>
                	</p>
              		<p class="u-textWeight-400 u-text-r-xxs u-color-grey-80 u-margin-r-bottom IcoCategory24">
                		<?php the_category(', '); ?>
                	</p>
              		<p class="u-textWeight-400 u-text-r-xxs u-color-grey-80 u-margin-r-bottom IcoTag24">
                		<?php the_tags( '', ', '); ?>
                	</p>  					
 				</div>
                <?php get_sidebar(); ?>
            </div>
        </div>
    </section>

<?php
get_footer();
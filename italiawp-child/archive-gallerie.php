<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */
 
get_header(); 

?>
    <section>
        <div class="u-layout-wide u-layoutCenter u-layout-withGutter u-padding-r-top u-padding-bottom-xxl">
		<?php
		the_archive_title( '<h2 class="u-text-r-l u-padding-r-bottom">', '</h2>' );
		the_archive_description( '<div class="u-padding-r-left u-padding-r-bottom">', '</div>' );
?>      	<div class="Grid Grid--withGutter">
				<div class="Grid-cell u-md-size9of12 u-lg-size9of12">
<?php
		while ( have_posts() ) : the_post();
			$img_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'news-image');
	        if ($img_url != "") {
	            $img_url = $img_url[0];
	        } else {
	            $img_url = esc_url(get_theme_mod('immagine_evidenza_default'));
	            if($img_url=="") {
	                $img_url = get_bloginfo('template_url') . "/images/400x220.png";
	            }
	        }
			$categories = get_the_terms( get_the_ID(), 'phototype' );
			$separator = '&nbsp;&nbsp;&nbsp;';
			$categorylist = '';
			foreach( $categories as $category ) {
				$categorylist .= '<a class="u-textClean u-textWeight-700 u-text-r-xs u-color-50" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'pasw2017' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
			}
?>					<div class="Grid-cell">
                		<div class="u-border-top-xxs u-padding-right-xxl u-padding-r-all">
                    		<p class="u-padding-r-bottom ">
 		<?php  if($categorylist!=""){?>
                       <i class="fa fa-folder-open u-padding-r-right "></i> <?php echo $categorylist;?>
							<br />
 <?php				}?>
                        <i class="far fa-calendar-alt u-padding-r-right "></i> <?php the_time( get_option( 'date_format' ) ); ?>
                    </p>
                    <div class="Grid Grid--withGutter u-padding-all-l">
                    	<div class="Grid-cell u-size6of12 u-lg-size1of4">
                    		<img src="<?php print $img_url; ?>" class="u-sizeFull" />
                    	</div>
                    	<div class="Grid-cell u-size6of12 u-lg-size3of4">
                    		<h3 class="u-padding-r-top u-padding-r-bottom"><a class="u-text-h4 u-textClean u-color-black" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    	</div>
                    </div>
                    <p class="u-lineHeight-l u-text-r-xs u-textSecondary u-padding-r-right"><?php echo wp_trim_words( $post->post_content, 30, '...' ); ?></p>
                </div>
			</div>
 		<?php
			endwhile;?>
		       </div>
<?php 
	if(!have_posts()) { ?>
				<div class="Prose Alert Alert--info Alert--withIcon u-layout-prose u-padding-r-bottom u-padding-r-right u-margin-r-bottom" role="alert">
				    <h2 class="u-text-h3">
				        Attenzione
				    </h2>
				    <p class="u-text-p">non risultano gallerie codificate</p>
				</div>		
<?php }?>
				</div>
        </div>
    </section>

<?php
get_footer();

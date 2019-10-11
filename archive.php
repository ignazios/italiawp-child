<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */
add_filter( 'posts_groupby', 'my_posts_groupby' );
function my_posts_groupby($groupby) {
    global $wpdb;
    $groupby = "YEAR($wpdb->posts.post_date), MONTH(($wpdb->posts.post_date)) ";
    return $groupby;
}

add_filter( 'posts_fields', 'my_posts_fields' );
function my_posts_fields( $sql ) {
	global $wpdb;
	return " YEAR(post_date) AS 'Anno', MONTH(post_date) AS 'Mese', count(DISTINCT ID) as 'NumArt' ";
}
get_header(); 

?>
    <section>
        <p class="u-md-hidden u-lg-hidden u-padding-r-all u-text-m u-background-grey-20">
            <span class="Icon-list u-text-r-xl u-alignMiddle u-padding-r-right" aria-hidden="true"></span>
            <a href="#subnav" class="js-scrollTo u-text-r-s u-textClean u-color-grey-50 u-alignMiddle">Vai all'archivio temporale</a>
        </p>

        <div class="u-layout-wide u-layoutCenter u-layout-withGutter u-padding-r-top u-padding-bottom-xxl">
		<?php
		the_archive_title( '<h2 class="u-text-r-l u-padding-r-bottom">', '</h2>' );
		the_archive_description( '<div class="u-padding-r-left u-padding-r-bottom">', '</div>' );
?>            <div class="Grid Grid--withGutter">
<div class="Grid-cell u-md-size9of12 u-lg-size9of12">
<?php
		while ( have_posts() ) : the_post();		
			$categories = get_the_category();
			$separator = '&nbsp;&nbsp;&nbsp;';
			$categorylist = '';
			if ( ! empty( $categories ) ) {
				foreach( $categories as $category ) {
					$categorylist .= '<a class="u-textClean u-textWeight-700 u-text-r-xs u-color-50" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'pasw2017' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
			    }
			}
			$tags = get_the_tags();
			$taglist = '';
			if ( ! empty( $tags ) ) {
				foreach( $tags as $tag ) {
					$taglist .= '<a class="u-textClean u-textWeight-700 u-text-r-xs u-color-50" href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'pasw2017' ), $tag->name ) ) . '">' . esc_html( $tag->name ) . '</a>' . $separator;
			    }
			}
?>				<div class="Grid-cell">
                <div class="u-border-top-xxs u-padding-right-xxl u-padding-r-all">
                    <p class="u-padding-r-bottom ">
 		<?php  if($categorylist!=""){?>
                       <i class="fa fa-folder-open u-padding-r-right "></i> <?php echo $categorylist;?>
							<br />
 <?php				}
				if($taglist!=""){?>
						<i class="fas fa-hashtag u-padding-r-right "></i> <?php echo $taglist; ?>
							<br />
 <?php				
				}?>
                        <i class="far fa-calendar-alt u-padding-r-right "></i> <?php the_time( get_option( 'date_format' ) ); ?>
                    </p>
                    <h3 class="u-padding-r-top u-padding-r-bottom"><a class="u-text-h4 u-textClean u-color-black" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <p class="u-lineHeight-l u-text-r-xs u-textSecondary u-padding-r-right"><?php echo wp_trim_words( $post->post_content, 30, '...' ); ?></p>
                </div>
			</div>
 		<?php
			endwhile;?>
		       </div>
<?php 
if(have_posts()){
		get_template_part( 'template-parts/archive', 'nav' );
		}else{
?>
		<div class="Prose Alert Alert--info Alert--withIcon u-layout-prose u-padding-r-bottom u-padding-r-right u-margin-r-bottom" role="alert">
    <h2 class="u-text-h3">
        Attenzione
    </h2>
    <p class="u-text-p">non risultano articoli per questa categoria</p>
</div>		
<?php }?>
        </div>
    </section>

<?php
get_template_part( 'template-parts/archive', 'pagination' );
//get_sidebar();
get_footer();

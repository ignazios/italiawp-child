<?php 
$categorie = 4;//get_theme_mod( 'pasw2017_news_cat' );
$nrnews = 4;//intval(get_theme_mod( 'pasw2017_nr_news' ));

?>

<div class=" u-background-compl-10 u-layout-centerContent u-padding-r-top">

    <section class="u-padding-r-all">
	   <div class="u-layout-medium u-layoutCenter">
	        <div class="Grid">
	            <h2 id="carousel-heading" class="Grid-cell u-text-h2 u-color-black u-layout-centerLeft">In Evidenza</h2>
	            <!-- <next / prev buttons> -->
	            <div class="Grid-cell u-layout-centerRight">
	                <button class="owl-prev u-padding-bottom-xl u-padding-right-xxl u-text-r-xl u-color-teal-50" aria-controls="carousel-InEvidenza">
	            <span class="u-hiddenVisually">Vai alla notizia precedente</span>
	            <span class="u-alignMiddle Icon Icon-arrow-left" role="presentation"></span>
	        </button>
	                <button class="owl-next u-padding-bottom-xl u-padding-left u-text-r-xl u-color-teal-50" aria-controls="carousel-InEvidenza">
	          <span class="u-hiddenVisually">Vai alla notizia successiva</span>
	          <span class="u-alignMiddle Icon Icon-arrow-right" role="presentation"></span>
	        </button>
	                <p class="u-hiddenVisually">È possibile navigare le notizie utilizzando i tasti freccia</p>
	            </div>
	            <!-- </next / prev buttons> -->
	        </div>
        <div class="owl-carousel owl-theme" role="region" id="carousel-InEvidenza">
 
<?php

$args = array(
	'posts_per_page'   => $nrnews,
	'offset'           => 0,
	'category'    =>   $categorie,
	'orderby'          => 'date',
	'order'            => 'DESC',
	'post_status'      => 'publish',
	'suppress_filters' => true 
);
	$myposts = get_posts( $args ); 
//	var_dump($args);
    $counter = 1;
	foreach($myposts as $post) {
    setup_postdata($post);

	$categories = get_the_category();
    $separator = '&nbsp; &#8226; &nbsp;';
    $output = '<p class="u-text-h6 u-margin-bottom-l">';
	if ( ! empty( $categories ) ) {
		foreach( $categories as $category ) {
			$output .= '<a class="u-color-50 u-textClean" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'pasw2017' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
		}
		$output .= '</p>';
	}
	$TutteLeNotizie=get_category_link($categorie[0]);
?>
          <div class="Carousel-item">
				<div class="Grid-cell">
					<div class="u-nbfc u-borderShadow-xxs u-borderRadius-m u-color-grey-30 u-background-white">
					<?php if (!empty(get_the_post_thumbnail_url())){ ?>
						<img class="InEvidenza" src="<?php echo get_the_post_thumbnail_url( null, 'medium' ); ?>" alt="no images" />
					<?php } ?>	
						<div class="u-text-r-l u-padding-r-all u-layout-prose">
							<?php echo trim( $output, $separator ); ?>
							<h3 class="u-text-h4 u-margin-r-bottom"><a class="u-text-r-m u-color-black u-textWeight-400 u-textClean" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p class="u-text-p u-textSecondary">
								<?php echo wp_trim_words( $post->post_content, 20, '...' ); ?>
							</p>
						</div>
					</div>
				</div>
            </div>
<?php }	?>
        </div>
        <p class="u-padding-r-top u-text-r-xl">
            <a href="<?php echo $TutteLeNotizie;?>" class="u-layout-centerLeft u-padding-r-top u-text-h4 u-textWeight-700 u-color-teal-50">Vedi tutte le notizie</a>
        </p>
    </div>
	</section>
</div>

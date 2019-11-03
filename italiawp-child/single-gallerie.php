<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

get_header();

?>

<div class="u-layout-centerContent u-background-white u-color-black u-text-xxl section u-padding-r-top section">

    <section class="u-padding-r-bottom">
        <div class="u-layout-medium u-layoutCenter">

            <div class="Grid">
                <h2 id="carousel-heading" class="Grid-cell u-text-h2 u-layout-centerLeft">Galleria: <?php the_title(); ?></h2>
                <div class="owl-nav Grid-cell u-layout-centerRight u-color-50"></div>
            </div>

            <div class="owl-carousel owl-theme u-text-r-xxs u-padding-r-all u-background-95" role="region" id="carousel-1">
                
<?php
if ( get_post_type()=="gallerie" && get_post_status() == 'publish' ) {
	$medias = get_attached_media('image', get_the_ID()); // Get image attachment(s) to the current Post
	$i=1;
	foreach($medias as $media){
        $img_url = wp_get_attachment_image_src($media->ID, 'news-image');
        if ($img_url != "") {
            $img_url = $img_url[0];
        } else {
            $img_url = esc_url(get_theme_mod('immagine_evidenza_default'));
            if($img_url=="") {
                $img_url = get_bloginfo('template_url') . "/images/400x220.png";
            }
        }
        $datapost = get_the_date('j F Y', '', ''); ?>

                <div class="Carousel-item">
                    <div class="u-color-grey-30">
                        <figure>
                            <a href="<?php print $img_url; ?>" aria-labelledby="desc-<?php echo $i; ?>" class="u-block u-padding-all-xxs">
                                <img src="<?php print $img_url; ?>" class="u-sizeFull" alt="<?php print $media->post_excerpt ; ?>" />
                            </a>
                            <figcaption class="u-padding-r-top">
                                <p class="u-color-white u-text-r-xxs u-margin-bottom-s"><?php echo $datapost; ?></p>
                                <div class="Grid">
                                    <span class="Grid-cell u-sizeFit Icon-camera u-color-white u-floatLeft u-text-r-l" aria-hidden="true"></span>
                                    <h3 id="desc-<?php echo $i; ?>" class="Grid-cell u-sizeFill u-padding-left-s u-lineHeight-l u-color-white u-text-r-xs u-textWeight-700">
                                        <?php echo $media->post_title; ?>
                                    </h3>
                                </div>
								<div class="Grid">
                                    <p class="Grid-cell u-sizeFill u-padding-left-s u-lineHeight-l u-color-white u-text-r-xs u-textWeight-700">
                                        <?php echo $media->post_content; ?>
                                    </p>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                
<?php
    	$i++;
	}
}
    wp_reset_postdata();    
    ?>
           </div>
        </div>
    </section>   
</div>
<?php
get_footer();
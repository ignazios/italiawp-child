<?php

/* Mia Galleria */

if (!get_theme_mod('disactive_stili_immagini_agid')) {
    add_filter('the_content', 'italiawp_child_custom_images', 90);
    function italiawp_child_custom_images($content) {
    	remove_filter('the_content', 'italiawp_custom_images');
        if (!preg_match_all('/<img [^>]+>/', $content, $matches)) {
            return $content;
        }
        foreach ($matches[0] as $image) {
            $doc = new DOMDocument();
            $doc->loadHTML($image);
            $xpath = new DOMXPath($doc);
            $class = $xpath->evaluate("string(//img/@class)");
            
            if ( strpos($class, 'in-gallery') == false ) {
                $src = $xpath->evaluate("string(//img/@src)");
                $attachment_id = get_attachment_id($src);
                $content = str_replace($image, italiawp_child_custom_image_tag($src, $attachment_id,$class), $content);
            }
        }

        return $content;
    }

    function italiawp_child_custom_image_tag($src, $attachment_id,$class) {
        $attachment_meta = wp_get_attachment($attachment_id);

        $imgCaption = $attachment_meta['caption'];
        $imgSrc = $src;
        $imgTitle = $attachment_meta['title'];
        $imgDate = $attachment_meta['date'];
        $imgAlt = $attachment_meta['alt'];

        $fullImage = wp_get_attachment_image_src($attachment_id, 'full');
        $fullImage = $fullImage[0];
        $class_aligh="";
		if(strpos($class, 'alignleft')== true){
			$class_aligh=' alignleft';
		}
		if(strpos($class, 'alignright')== true){
			$class_aligh=' alignright';
		}
		if(strpos($class, 'aligncenter')== true){
			$class_aligh=' aligncenter';
		}
        $custom_image = '
        <section class="u-nbfc u-borderShadow-xxs u-borderRadius-m image-content u-color-grey-30 u-background-white'.$class_aligh.'">
            <figure class="u-background-grey-60 u-padding-all-s">
                <img src="' . $imgSrc . '" class="u-sizeFull" alt="' . $imgAlt . '">
                <figcaption class="u-padding-r-top">
                    <span class="Icon Icon-camera u-color-white u-floatRight u-text-r-l" aria-hidden="true"></span>
                    <p class="u-color-teal-50 u-text-r-xxs u-textWeight-700 u-padding-bottom-xs">' . $imgTitle . '</p>
                    <p class="u-color-white u-text-r-xxs">' . date('j F Y',strtotime($imgDate)) . '</p>
                </figcaption>
            </figure>';

        if ($imgCaption !== "") {
            $custom_image .= '
            <div class="u-text-r-l u-padding-r-all u-layout-prose">
                <h3 class="u-text-h4 u-margin-r-bottom">
                    <span class="u-color-black u-textWeight-400 u-text-r-m">' . $imgCaption . '</span>
                </h3>
            </div>';
        }

        $custom_image .= '</section>';
        return $custom_image;
    }
}

<?php

    global $wp_query;

    // Stop execution if there's only 1 page
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max = intval( $wp_query->max_num_pages );
    
    // Add current page to the array
    if ( $paged >= 1 )
        $links[] = $paged;

    // Add the pages around the current page to the array
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }


    echo '<nav role="navigation" aria-label="Navigazione paginata" class="u-layout-prose u-text-r-xxs u-padding-r-bottom">
    <ul class="Grid Grid--fit Grid--alignMiddle u-text-r-xxs">';

    // Previous Post Link
    if ( get_previous_posts_link() )
        printf( '<li class="Grid-cell u-textCenter">
            <a href="%s" class="u-color-50 u-textClean u-block" title="Pagina precedente">
                <span class="Icon-chevron-left u-text-r-s" role="presentation"></span>
                <span class="u-hiddenVisually">Pagina precedente</span>
            </a>
        </li>', get_previous_posts_page_link() );

    // Link to first page, plus ellipses if necessary
    if ( ! in_array( 1, $links ) ) {
        if ( $class = 1 == $paged ) {
            printf( '<li class="Grid-cell u-textCenter">
            <span class="u-padding-r-all u-block u-background-50 u-color-white">
        <span class="u-text-r-s"><span class="u-md-hidden u-lg-hidden">Pagina</span> %s</span>
            </span>
        </li>', $link);
        } else {
            printf( '<li class="Grid-cell u-textCenter u-hidden u-md-inlineBlock u-lg-inlineBlock">
            <a href="%s" aria-label="Pagina 13" class="u-padding-r-all u-color-50 u-textClean u-block">
                <span class="u-text-r-s">%s</span>
            </a>
        </li>', esc_url( get_pagenum_link( 1 ) ), '1' );
        }
        if ( ! in_array( 2, $links ) )
            echo '<li class="Grid-cell u-textCenter u-hidden u-md-inlineBlock u-lg-inlineBlock" aria-hidden="true">
            <span class="u-padding-r-all u-block u-color-50">
        <span class="u-text-r-m">...</span>
            </span>
        </li>';
    }

    // Link to current page, plus 2 pages in either direction if necessary
    sort( $links );
    foreach ( (array) $links as $link ) {
        if ( $class = $paged == $link ) {
            printf( '<li class="Grid-cell u-textCenter">
            <span class="u-padding-r-all u-block u-background-50 u-color-white">
        <span class="u-text-r-s"><span class="u-md-hidden u-lg-hidden">Pagina</span> %s</span>
            </span>
        </li>', $link);
        } else {
            printf( '<li class="Grid-cell u-textCenter u-hidden u-md-inlineBlock u-lg-inlineBlock">
            <a href="%s" aria-label="Pagina 13" class="u-padding-r-all u-color-50 u-textClean u-block">
                <span class="u-text-r-s">%s</span>
            </a>
        </li>', esc_url( get_pagenum_link( $link ) ), $link );
        }
    }

    // Link to last page, plus ellipses if necessary
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) ) {
            echo '<li class="Grid-cell u-textCenter u-hidden u-md-inlineBlock u-lg-inlineBlock" aria-hidden="true">
            <span class="u-padding-r-all u-block u-color-50">
        <span class="u-text-r-m">...</span>
            </span>
        </li>';
        }

        if ( $class = $paged == $max ) {
            printf( '<li class="Grid-cell u-textCenter">
            <span class="u-padding-r-all u-block u-background-50 u-color-white">
        <span class="u-text-r-s"><span class="u-md-hidden u-lg-hidden">Pagina</span> %s</span>
            </span>
        </li>', $max);
        } else {
            printf( '<li class="Grid-cell u-textCenter u-hidden u-md-inlineBlock u-lg-inlineBlock">
            <a href="%s" aria-label="Pagina 13" class="u-padding-r-all u-color-50 u-textClean u-block">
                <span class="u-text-r-s">%s</span>
            </a>
        </li>', esc_url( get_pagenum_link( $max ) ), $max );
        }
    }

    // Next Post Link
    if ( get_next_posts_link() )
        printf( '<li class="Grid-cell u-textCenter">
            <a href="%s" class="u-padding-r-all u-color-50 u-textClean u-block" title="Pagina successiva">
                <span class="Icon-chevron-right u-text-r-s" role="presentation"></span>
                <span class="u-hiddenVisually">Pagina successiva</span>
            </a>
        </li>', get_next_posts_page_link() );

    echo '</ul></nav>';
?>
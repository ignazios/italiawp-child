	 	<div class="u-nbfc u-color-grey-30 u-xs-padding-all-none u-borderShadow-m u-xs-borderShadow-none u-borderRadius-m u-background-white BloccoSubNavPage">
	    	<div class="u-padding-r-all">
	        	<div  style="min-height: 100px;">
	            	<h3 class="u-textWeight-400 u-text-r-xs u-color-grey-80 u-margin-r-bottom"><span class="far fa-newspaper"></span> Navigazione pagine</h3>
	 				<div class="Accordion Accordion--default fr-accordion js-fr-accordion" id="accordion-page">
<?php
	$CurIDPage=$post->ID;
	$ParentIDPage=wp_get_post_parent_id( $CurIDPage );
    
    $args = array(
        'post_type'      => 'page',
        'posts_per_page' => -1,
        'post_parent'    => $post->ID,
        'order'          => 'ASC',
        'orderby'        => 'title'
    );
    $parent = new WP_Query( $args );
    if ( $parent->have_posts() ) :
		$slug=get_post_field( 'post_name', get_post($post->ID) );?>
						<h4 class="MenuHeader Accordion-header js-fr-accordion__header fr-accordion__header" id="accordion-header-<?php echo $slug;?>">
							<span class="Accordion-link"><span class="fas fa-ellipsis-v"></span> <?php echo get_the_title();?></span>
						</h4>
				<div id="accordion-panel-<?php echo $slug; ?>" style="height: auto;" class="Accordion-panel fr-accordion__panel js-fr-accordion__panel">
							<ul class="Linklist u-text-r-xxs">
<?php      	while ( $parent->have_posts() ) : $parent->the_post();
            	echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
        	endwhile;?>
        					</ul>
        				</div>	
<?php    endif; wp_reset_query();

    if ( $post->post_parent ) {
        $args = array(
            'post_type'      => 'page',
            'posts_per_page' => -1,
            'post_parent'    => $post->post_parent,
            'order'          => 'ASC',
            'orderby'        => 'title'
        );

        $parent = new WP_Query( $args );

        if ( $parent->have_posts() ) :
        	$PaginaPadre=get_post_field( 'post_name', get_post($ParentIDPage) );?>
        				<h4 class="MenuHeader Accordion-header js-fr-accordion__header fr-accordion__header" aria-expanded="true"id="accordion-header-<?php echo $PaginaPadre;?>">
							<span class="Accordion-link"><span class="fas fa-ellipsis-h"></span> <?php echo get_the_title($ParentIDPage);?></span>
						</h4>
						<div id="accordion-panel-<?php echo $PaginaPadre;?>" class="Accordion-panel fr-accordion__panel js-fr-accordion__panel">
							<ul class="Linklist u-text-r-xxs">						
<?php           while ( $parent->have_posts() ) : $parent->the_post();
	            	if($parent->post->ID!=$CurIDPage)
	                	echo ' <li><a class="Linklist-link" href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
	            endwhile;	?>						
            				</ul>
            			</div>
<?php   endif; ?>
				</div>
<?php    wp_reset_query();
    }
?>
					</div>
				</div>
			</div>
		</div>

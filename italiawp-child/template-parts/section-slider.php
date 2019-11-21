<?php
/*
 * ### SEZIONE Slider ###
 * Mostra gli ultimi N articoli caricati in uno slider.
 * Il numero è preso dall'optione "Home_blocco_InEvidenza_numart" editabile dalla pagina "Dettagli" del backend
 *
 */
	$Articoli=get_posts(array(
		'category' 		 => get_theme_mod('Home_blocco_InEvidenza_categoria'),
		'posts_per_page' => get_theme_mod('Home_blocco_InEvidenza_numart')));
	$NumArt=count($Articoli);
?>
<section class="inEvidenza">
    	<div id="main_area">
	        <!-- Slider -->
	        <div class="row">
	            <div class="col-xs-12" id="slider">
<!-- Top part of the slider -->
	                <div class="row">
	                    <div class="col-md-6" id="carousel-bounding-box">
	                        <div class="carousel slide" id="myCarousel">
	                        <div class="carousel-inner">
<!-- Carousel items -->
<?php
	$i=0;
	$Classe="item active";
	foreach($Articoli as $Articolo){
		if ( has_post_thumbnail($Articolo->ID) ) {
			$attr = array(
				'alt' => "Immagine articolo:".trim(strip_tags( $Articolo->post_title )),
				'title' => trim(strip_tags( $Articolo->post_title )),
				);
			$Immagine=get_the_post_thumbnail( $Articolo->ID, array(770,300),$attr );
		}else {
			$Immagine='<img src="'.get_bloginfo( 'stylesheet_directory' ) . '/img/thumbnail-default.jpg"  alt="Immagine segnaposto" title="">';
		}
		if($i!=0){
			$Classe="item";
		}
?>
		<div class="<?php echo $Classe;?>" data-slide-number="<?php echo $i; ?>">
        <?php echo $Immagine; ?></div>
<?php 
		$i++;		
		
	} ?>		                            
	                            </div>
<!-- Fine Carousel items -->
	                            </div>
	                    </div>
<!-- Carousel Dati Articoli -->
<?php
	$i=0;
	foreach($Articoli as $Articolo){
		if($i==0){ ?>
	                    <div class="col-md-6" id="carousel-text">
	                    	<h2><?php echo $Articolo->post_title;?></h2>
	                            <p><?php echo $Articolo->post_excerpt;?></p>
	                            <p class="sub-text"><?php echo IWP_FormatDataItaliano($Articolo->post_modified);?> - <a href="<?php echo $Articolo->guid;?>">Leggi l'articolo</a></p>
	                    </div>			
	                    <div id="slide-content" style="display: none;">
<?php	}?>
	                    	<div id="slide-content-<?php echo $i; ?>">
		                    	<h2><?php echo $Articolo->post_title;?></h2>
		                            <p><?php echo $Articolo->post_excerpt;?></p>
		                            <p class="sub-text"><?php echo IWP_FormatDataItaliano($Articolo->post_modified);?> - <a href="<?php echo $Articolo->guid;?>">Leggi l'articolo</a></p>
		                    </div>			
<?php
		$i++;		
	} ?>		 

	                        </div>
<!-- Carousel nav -->
				   <nav id="navslider">
						<ul class="control-box pager" >
							<li >
								<a data-slide="prev" href="#myCarousel" class="arrowStil" title="Carousel vai alla slide precedente"><span class="glyphicon glyphicon-chevron-left"></span></a>
							</li>
							<li >
								<a data-slide="next" href="#myCarousel" class="arrowStil" title="Carousel vai alla slide successiv"><span class="glyphicon glyphicon-chevron-right"></span></a>
							</li>
						</ul>
					</nav>   
<!-- Fine Carousel nav -->	                        
<!-- Fine Carousel Dati Articoli -->
	                    </div>
	                </div>
	            </div>
	        </div>
<!-- Fine Slider-->

<!--Miniature-->
                <div class="row hidden-xs" id="slider-thumbs">
<!-- Bottom switcher of slider -->
                        <ul class="hide-bullets">
 <?php
	$i=0;
	foreach($Articoli as $Articolo){
		if ( has_post_thumbnail($Articolo->ID) ) {
			$attr = array(
				'alt' => "Immagine articolo:".trim(strip_tags( $Articolo->post_title )),
				'title' => trim(strip_tags( $Articolo->post_title )),
			);
			$Immagine=get_the_post_thumbnail( $Articolo->ID, array(770,300),$attr );
		}else {
			$Immagine='<img src="'.get_bloginfo( 'stylesheet_directory' ) . '/img/thumbnail-default.jpg" alt="Immagine segnaposto" title="">';
		}
?>
							<li class="col-sm-2">
                                <a class="thumbnail" id="carousel-selector-<?php echo $i; ?>" data-slide-to="<?php echo $i; ?>"><?php echo $Immagine; ?></a>
                            </li>
<?php 
		$i++;		
		
	} ?>		           
                        </ul>                 
<!-- Fine Bottom switcher of slider -->
                </div>
<!-- Fine Miniature-->
	</section>
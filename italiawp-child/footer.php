<?php
/*
 * Utilizzare i Widget per le 4 colonne e la pagina "Dettagli" del backend per i recapiti e url mappa
 *
 */
?>

<?php if(is_front_page()): 
	if (get_theme_mod('active_section_map') And get_theme_mod('Scuola_Mappa')): ?>

	<section id="mappa" class="u-layout-centerContent u-padding-r-top section  u-padding-bottom-l">
	        <h2 class="u-text-r-l u-padding-r-all u-text-h3">Mappa Interattiva</h2>
	       	<div class="map-full-content ">
	    		<div class="map-wrap" style="height: 500px;"></div>
					<?php echo get_theme_mod('Scuola_Mappa');
					if(get_theme_mod('Scuola_Mappa_Link')):?>
	    			<p class="u-textCenter u-text-md-right u-text-lg-right u-margin-r u-text-r-xl u-padding-right-m">
	    				<a href="<?php echo get_theme_mod('Scuola_Mappa_Link');?>" class="u-color-50 u-textClean u-text-h4 external-link" target="_blank">Visualizza mappa ingrandita</a>
	    			</p>
	    			<?php endif;?>
			</div>
	</section>
</section>
<?php endif; 
endif;?>
        
<div class="u-background-95 u-hiddenPrint">
    <div class="u-layout-wide u-layoutCenter u-layout-r-withGutter">
        <footer class="Footer u-background-95">
            <div class="u-cf">              
            <?php
                $custom_logo_id = get_theme_mod('custom_logo');
                $custom_logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                if (has_custom_logo()) {
                    $custom_logo = esc_url($custom_logo[0]);
                } else {
                    $custom_logo = get_stylesheet_directory_uri() . '/images/stemma-default.png';
                } ?>
                
                <img height="80" width="auto" class="Footer-logo" src="<?php echo $custom_logo; ?>" alt="<?php echo bloginfo('name'); ?>">

                <p class="Footer-siteName">
                    <?php bloginfo( 'name' ); ?>
                </p>
            </div>
            <div class="Grid Grid--withGutter">

                <div class="Footer-block Grid-cell u-sm-size1of2 u-md-size1of4 u-lg-size1of4">
                    <h2 class="Footer-blockTitle">Informazioni</h2>
                    <div class="Footer-subBlock">
                         <address>
                            <?php echo get_theme_mod('dettagli-contatti-indirizzo'); ?><br>
                            <?php echo get_theme_mod('dettagli-contatti-cap'); ?>, <?php echo get_theme_mod('dettagli-contatti-citta'); ?><br><br>
                            C.F.<br><?php echo get_theme_mod('dettagli-contatti-cfpa'); ?>
                            <?php echo (get_theme_mod('dettagli-contatti-pipa')!=""?"<br><br>P.Iva<br>".get_theme_mod('dettagli-contatti-pipa'):""); ?>
                        </address>
                    </div>
                </div>

                <div class="Footer-block Grid-cell u-sm-size1of2 u-md-size1of4 u-lg-size1of4">
                    <h2 class="Footer-blockTitle">Recapiti</h2>
                    <div class="Footer-subBlock">
                         <address>
                            Telefono<br><a href="tel:+39<?php echo get_theme_mod('dettagli-contatti-telefono'); ?>" > <?php echo get_theme_mod('dettagli-contatti-telefono'); ?></a><br><br>
                            Fax<br><a href="tel:+39<?php echo get_theme_mod('dettagli-contatti-fax'); ?>" > <?php echo get_theme_mod('dettagli-contatti-fax'); ?></a><br><br>
                        </address>
                    </div>
                </div>

                <div class="Footer-block Grid-cell u-sm-size1of2 u-md-size1of4 u-lg-size1of4">
                    <h2 class="Footer-blockTitle">Indirizzi Email</h2>
                    <div class="Footer-subBlock" style="padding-bottom: 0!important;">
                        <address>
                            PEC<br><a href="mailto:<?php echo get_theme_mod('dettagli-contatti-pec'); ?>" ><?php echo get_theme_mod('dettagli-contatti-pec'); ?></a><br><br>
                            Email<br><a href="mailto:<?php echo get_theme_mod('dettagli-contatti-email'); ?>" ><?php echo get_theme_mod('dettagli-contatti-email'); ?></a><br><br>
                        <?php if(get_theme_mod('dettagli-contatti-mail2')!=""): ?>
                            Email<br><a href="mailto:<?php echo get_theme_mod('dettagli-contatti-email2'); ?>" ><?php echo get_theme_mod('dettagli-contatti-email2'); ?></a>
                        <?php endif; ?>
                        </address>
                    </div>

                </div>
 
<?php      if(has_nav_menu('menu-footer-istituto')) {?>

                <div class="Footer-block Grid-cell u-sm-size1of2 u-md-size1of4 u-lg-size1of4">
                	<h2 class="Footer-blockTitle">Sedi</h2>
					<div class="Footer-subBlock">
						<nav id="footer-navigation" >
			            <?php       $menu = array(
			                        'theme_location' => 'menu-footer-istituto',
			                        'menu_id' => 'utilita-menu',
			                        'menu_class' => 'u-text-r-xs'
			                    );
			                    echo strip_tags(wp_nav_menu($menu));?>
			            </nav>                 
 
					</div>
	            </div>
<?php       } ?>
            </div>
            <div class="Grid Grid--withGutter">
	            <div class="Grid-cell u-size1of2">   
	               <?php   if(has_nav_menu('menu-footer-legale')) {
	                    $menu = array(
	                        'theme_location' => 'menu-footer-legale',
	                        'menu_id' => 'footer-menu',
	                        'menu_class' => 'Footer-links Footer-links-mt u-cf'
	                    );
	                    echo strip_tags(wp_nav_menu($menu));
	                } ?>            
	            </div>	
            	<div class="Footer-block Footer-block-Social Footer-links-mt Grid-cell u-size1of2">
            <?php 	
        $Facebook=get_theme_mod('dettagli-social-facebook');
		$Twitter=get_theme_mod('dettagli-social-twitter');
		$YouTube=get_theme_mod('dettagli-social-youtube');
		$Instagram=get_theme_mod('dettagli-social-instagram');
		if($Facebook!="" or $Twitter!="" or $YouTube!="" or $Instagram=""){?>                     
					<h2 class="Footer-blockTitle">Seguici su: 
                     	<ul class="Footer-socialIcons" style="display:inline;">
                        <?php if($Facebook!=""): ?>
                            <li><a target="_blank" href="<?php echo $Facebook; ?>"><span class="Icon Icon-facebook"></span><span class="u-hiddenVisually">Facebook</span></a></li>
                        <?php endif; ?>
                        <?php if($Twitter!=""): ?>
                            <li><a target="_blank" href="<?php echo $Twitter; ?>"><span class="Icon Icon-twitter"></span><span class="u-hiddenVisually">Twitter</span></a></li>
                        <?php endif; ?>
                        <?php if($YouTube!=""): ?>
                            <li><a target="_blank" href="<?php echo $YouTube; ?>"><span class="Icon Icon-youtube"></span><span class="u-hiddenVisually">Youtube</span></a></li>
                        <?php endif; ?>
                        <?php if($Instagram!=""): ?>
                            <li><a target="_blank" href="<?php echo $Instagram; ?>"><span class="Icon Icon-instagram"></span><span class="u-hiddenVisually">Instagram</span></a></li>
                        <?php endif; ?>
                        </ul>
                    </h2>
       <?php } ?> 
       				</div>
       			</div>
         </footer>
     </div>
	<div class="Grid Grid--withGutter">
		<div class="Grid-cell">
	       <ul class="Footer-links u-cf" id="Footer-links">
	             <li>Realizzato con <a target="_blank" href="https://it.wordpress.org">WordPress</a></li>           
	            <!-- Per favore, non rimuoverlo! -->
	            <?php 
	            $main_theme = wp_get_theme(get_template());
	            $main_theme_author = $main_theme->get('Author');
	            $main_theme_author_uri = $main_theme->get('AuthorURI');
	            $main_theme_name = $main_theme->get('Name');
	            $main_theme_uri = $main_theme->get('ThemeURI');
	             ?>
	            <li>Tema <a target="_blank" href="<?php echo $main_theme_uri; ?>"><?php echo $main_theme_name; ?></a> di <a target="_blank" href="<?php echo $main_theme_author_uri; ?>"><?php echo $main_theme_author; ?></a>&nbsp;&nbsp;personalizzato da: <a target="_blank" href="http://www.eduva.org">Scimone Ignazio</a></li>
	            <li>Basato sul <a target="_blank" href="https://italia.github.io/design-web-toolkit/">Web Toolkit AGID</a></li>
	            <!-- Grazie :) -->
	        </ul>
	    </div>
    </div>
</div>

<a href="#" title="torna all'inizio del contenuto" class="ScrollTop js-scrollTop js-scrollTo">
    <span class="ScrollTop-icon Icon-collapse" aria-hidden="true"></span>
    <span class="u-hiddenVisually">torna all'inizio del contenuto</span>
</a>
</div>

<?php wp_footer(); ?>

<!--[if IE 8]>
<script src="<?php bloginfo('template_url'); ?>/webtoolkit/respond.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/webtoolkit/rem.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/webtoolkit/selectivizr.js"></script>
<script src="<?php bloginfo('template_url'); ?>/webtoolkit/slice.js"></script>
<![endif]-->

<!--[if lte IE 9]>
<script src="<?php bloginfo('template_url'); ?>/webtoolkit/polyfill.min.js"></script>
<![endif]-->
<script>
	window.onscroll = function() {myFunction()};

	var header = document.getElementById("Contenuto");
	var sticky = 0;

	function myFunction() {
	  if (window.pageYOffset > sticky) {
	    header.classList.add("sticky");
	  } else {
	    header.classList.remove("sticky");
	  }
	}
</script>
<script>__PUBLIC_PATH__ = '<?php bloginfo('template_url'); ?>/webtoolkit/'</script>
<script src="<?php bloginfo('template_url'); ?>/webtoolkit/IWT.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/inc/scripts.js"></script>

</body>
</html>

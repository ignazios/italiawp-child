<?php
/*
 * ### SEZIONE Scuola ###
 * Mostra una sezione divisa in due parti uguali, il blocco di sinistra con i soggetti ed il blocco di destra con la presentazioen della scuola.

 *
 */
	 $Testo_SinUp=get_theme_mod('Scuola_Testo_SinUp');
	 if(!$Testo_SinUp)
	 	$Testo_SinUp="Docenti";
	 $Logo_SinUp=get_theme_mod('Scuola_Logo_SinUp');
	 $Link_SinUp=get_theme_mod('Scuola_categoria_SinUp');
	 if(!$Link_SinUp)
	 	$Link_SinUp="#";
	 else
	 	$Link_SinUp=get_category_link($Link_SinUp);
	 $Testo_DesUp=get_theme_mod('Scuola_Testo_DesUp');
	 if(!$Testo_DesUp)
	 	$Testo_DesUp="Personale ATA";
	 $Logo_DesUp=get_theme_mod('Scuola_Logo_DesUp');
	 $Link_DesUp=get_theme_mod('Scuola_categoria_DesUp');
	 if(!$Link_DesUp)
	 	$Link_DesUp="#"; 	
	 else
	 	$Link_DesUp=get_category_link($Link_DesUp);
	 $Testo_SinDw=get_theme_mod('Scuola_Testo_SinDw');
	 if(!$Testo_SinDw)
	 	$Testo_SinDw="Studenti";
	 $Logo_SinDw=get_theme_mod('Scuola_Logo_SinDw');
	 $Link_SinDw=get_theme_mod('Scuola_categoria_SinDw');
	 if(!$Link_SinDw)
	 	$Link_SinDw="#"; 	
	 else
	 	$Link_SinDw=get_category_link($Link_SinDw);
	 $Testo_DesDw=get_theme_mod('Scuola_Testo_DesDw');
	 if(!$Testo_DesDw)
	 	$Testo_DesDw="Studenti";
	 $Logo_DesDw=get_theme_mod('Scuola_Logo_DesDw');
	 $Link_DesDw=get_theme_mod('Scuola_categoria_DesDw');
	 if(!$Link_DesDw)
	 	$Link_DesDw="#"; 
	 else
	 	$Link_DesDw=get_category_link($Link_DesDw);
	 $Eti_Prima=get_theme_mod('Scuola_primaTabs_testo');
	 $Pag_Prima=get_theme_mod('Scuola_primaTabs_pagina');
	 $TestoLink_Prima=get_theme_mod('Scuola_primaTabs_testo_leggitutto');
	 if(!$Pag_Prima){
	 	$Link_Prima="#"; 
	 	$Testo_Prima="";	
	 }else{
	 	$Link_Prima=get_page_link($Pag_Prima);
	 	$Post=get_post( $Pag_Prima); 
	 	$Testo_Prima=apply_filters( 'the_content', $Post->post_content);
	 }
	 $Eti_Seconda=get_theme_mod('Scuola_secondaTabs_testo');
	 $Pag_Seconda=get_theme_mod('Scuola_secondaTabs_pagina');
	 $TestoLink_Seconda=get_theme_mod('Scuola_secondaTabs_testo_leggitutto');
	 if(!$Pag_Seconda){
	 	$Link_Seconda="#"; 
	 	$Testo_Seconda="";	 	
	 }else{
	 	$Link_Seconda=get_page_link($Pag_Seconda);
	 	$Post=get_post( $Pag_Seconda); 
	 	$Testo_Seconda=apply_filters( 'the_content', $Post->post_content);
	 }
	 $Eti_Terza=get_theme_mod('Scuola_terzaTabs_testo');
	 $Pag_Terza=get_theme_mod('Scuola_terzaTabs_pagina');
	 $TestoLink_Terza=get_theme_mod('Scuola_terzaTabs_testo_leggitutto');
	 if(!$Pag_Terza){
	 	$Link_Terza="#"; 
	 	$Testo_Terza="";	 	
	 }else{
	 	$Link_Terza=get_page_link($Pag_Terza);
	 	$Post=get_post( $Pag_Terza); 
	 	$Testo_Terza=apply_filters( 'the_content', $Post->post_content);
	 }
?>
<section class="scuola">
    	<div class="Grid Grid--withGutter u-layout-medium u-layoutCenter">
  			<div class="Grid-cell u-md-size1of1 u-lg-size1of2 ">
	  			<h2 class="u-text-h2 widget-title">Soggetti</h2>
				<div class="Grid">
					<div class="u-md-size1of2 u-lg-size1of2">
<?php if($Logo_SinUp) :?>
						<div class="u-md-size1of1 u-lg-size1of1 u-padding-all-s">
							<div class="u-nbfc u-borderShadow-xxs u-borderRadius-m u-background-50">
						<img src="<?php echo wp_get_attachment_url($Logo_SinUp);?>" alt="" class="soggetti">
								<div class="u-text-r-xxs u-padding-r-all u-layout-prose">
									<h3 class="u-text-h4 u-margin-r-bottom">
										<a class="u-text-r-m u-color-white u-textClean" href="<?php echo $Link_SinUp;?>" tabindex="-1" data-owl-temp-tabindex="0"><?php echo $Testo_SinUp;?></a>
									</h3>
								</div>
							</div>
						</div>						
<?php endif;
      if($Logo_SinDw) :?>
						<div class="u-md-size1of1 u-lg-size1of1 u-padding-all-s">
							<div class="u-nbfc u-borderShadow-xxs u-borderRadius-m u-background-50">
							<img src="<?php echo wp_get_attachment_url($Logo_SinDw);?>" alt="" class="soggetti">
								<div class="u-text-r-xxs u-padding-r-all u-layout-prose">
									<h3 class="u-text-h4 u-margin-r-bottom">
										<a class="u-text-r-m u-color-white u-textClean" href="<?php echo $Link_SinDw;?>" tabindex="-1" data-owl-temp-tabindex="0"><?php echo $Testo_SinDw;?></a>
									</h3>
								</div>
							</div>
						</div>	
<?php endif;?>
					</div>
					<div class="u-md-size1of2 u-lg-size1of2">
<?php if($Logo_DesUp) :?>
						<div class="u-md-size1of1 u-lg-size1of1 u-padding-all-s">
							<div class="u-nbfc u-borderShadow-xxs u-borderRadius-m u-background-50">
							<img src="<?php echo wp_get_attachment_url($Logo_DesUp);?>" alt="" class="soggetti">
								<div class="u-text-r-xxs u-padding-r-all u-layout-prose">
									<h3 class="u-text-h4 u-margin-r-bottom">
										<a class="u-text-r-m u-color-white u-textClean" href="<?php echo $Link_DesUp;?>" tabindex="-1" data-owl-temp-tabindex="0"><?php echo $Testo_DesUp;?></a>
									</h3>
								</div>
							</div>	
						</div>				
<?php endif;
      if($Logo_DesDw) :?>
						<div class="u-md-size1of1 u-lg-size1of1 u-padding-all-s">
							<div class="u-nbfc u-borderShadow-xxs u-borderRadius-m u-background-50">
							<img src="<?php echo wp_get_attachment_url($Logo_DesDw);?>" alt="" class="soggetti">
								<div class="u-text-r-xxs u-padding-r-all u-layout-prose">
									<h3 class="u-text-h4 u-margin-r-bottom">
										<a class="u-text-r-m u-color-white u-textClean" href="<?php echo $Link_DesDw;?>" tabindex="-1" data-owl-temp-tabindex="0"><?php echo $Testo_DesDw;?></a>
									</h3>
								</div>
							</div>		
						</div>						
<?php endif;?>
					</div>
  				</div>
  			</div>
 			<div class="Grid-cell u-md-size1of1 u-lg-size1of2 u-padding-r-left">
				<h2 class="u-text-h2 widget-title">La Scuola</h2>
				<div class="Grid">
					<div class="u-nbfc u-borderShadow-xs u-borderRadius-m">
						<div id="exTab1">	
							<ul  class="nav nav-tabs">
								<li class="active">
									<a  href="#1a" data-toggle="tab"><?php echo $Eti_Prima;?></a>
								</li>
								<li>
									<a href="#2a" data-toggle="tab"><?php echo $Eti_Seconda;?></a>
								</li>
								<li>
									<a href="#3a" data-toggle="tab"><?php echo $Eti_Terza;?></a>
								</li>
							</ul>

							<div class="tab-content clearfix">
							  	<div class="tab-pane active" id="1a">
							  		<div class="tab-pane-content">
					          			<?php echo $Testo_Prima;?>
			          				</div>
									<div class="tab-pane-readnext">
										<p class="u-textCenter u-text-md-right u-text-lg-right u-margin-r-top">
	            						<a href="<?php echo $Link_Prima;?>" class="u-color-50 u-textClean u-text-h4"><?php echo $TestoLink_Prima;?> <span class="Icon Icon-chevron-right"></span></a>
	        							</p>
									</div>			
								</div>
								<div class="tab-pane" id="2a">
									<div class="tab-pane-content">
					          			<?php echo $Testo_Seconda;?>
									</div>
									<div class="tab-pane-readnext">
										<p class="u-textCenter u-text-md-right u-text-lg-right u-margin-r-top">
	            						<a href="<?php echo $Link_Seconda;?>" class="u-color-50 u-textClean u-text-h4"><?php echo $TestoLink_Seconda;?> <span class="Icon Icon-chevron-right"></span></a>
	        							</p>
									</div>
								</div>										
				        		<div class="tab-pane" id="3a">
				        			<div class="tab-pane-content">
				          				<?php echo $Testo_Terza;?>
									</div>
									<div class="tab-pane-readnext">
										<p class="u-textCenter u-text-md-right u-text-lg-right u-margin-r-top">
	            						<a href="<?php echo $Link_Terza;?>" class="u-color-50 u-textClean u-text-h4"><?php echo $TestoLink_Terza;?> <span class="Icon Icon-chevron-right"></span></a>
	        							</p>
									</div>
								</div>
							</div>
				  		</div>
					</div>				
				</div>
  			</div>
	</div>
</section>
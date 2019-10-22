<?php
/**
* Template Name: Pagina mappa del sito
*
* This is the template that displays the home page.
* Please note that this is the WordPress construct of pages
* and that other 'pages' on your WordPress site may use a
* different template.
*
* @link https://codex.wordpress.org/Template_Hierarchy
*
* @package italiawp-child
*/
get_header();?>
  <section class="content-page">
       <div class="u-layout-medium u-layoutCenter u-layout-withGutter u-padding-r-top u-padding-bottom-xxl">
        <?php the_title( '<h2 class="u-text-h2">', '</h2>' ); ?>
        <div class="Grid Grid--withGutter u-padding-all-xs">
 			<div class="Grid-cell u-sizeFull u-md-size1of3 u-lg-size1of3">
       			<div class="u-borderShadow-m u-borderRadius-l u-background-white">
					<div class="u-background-60">
						<h2 class="u-color-white u-padding-r-all">Pagine</h2>	    	 		
					</div>
					<ul id="MappaPagine" class="Linklist Linklist--padded u-text-r-xs">
	               		<?php wp_list_pages ("sort_column=menu_order&title_li="); ?>
	                </ul>
	            </div>
	        </div>
			<div class="Grid-cell u-sizeFull u-md-size1of3 u-lg-size1of3">
       			<div class="u-borderShadow-m u-borderRadius-l u-background-white">
					<div class="u-background-60">
						<h2 class="u-color-white u-padding-r-all">Categorie</h2>	    	 		
					</div>
					<ul id="MappaPagine" class="Linklist Linklist--padded u-text-r-xs">
	               		<?php wp_list_categories ("hide_empty=0&sort_column=menu_order&title_li="); ?>
	                </ul>
	          	</div>
	          </div>
 			<div class="Grid-cell u-sizeFull u-md-size1of3 u-lg-size1of3">
       			<div class="u-borderShadow-m u-borderRadius-l u-background-white">
					<div class="u-background-60">
						<h2 class="u-color-white u-padding-r-all">Tag</h2>	    	 		
					</div>
					<ul id="MappaPagine" class="Linklist Linklist--padded u-text-r-xs">
	               		<?php wp_tag_cloud("show_count=1&smallest=10&largest=18"); ?>
	                </ul>
	          	</div>
	          </div>
         </div>
     	 </div>
  </section>
<?php
get_footer();
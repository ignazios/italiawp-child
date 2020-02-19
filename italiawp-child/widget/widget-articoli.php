<?php
/****************************************************************************
Widget Articoli
Titolo:	($title) Testo che viene visualizzato in Testa all'elenco degli articoli estratti
*/

class Articoli extends WP_Widget
{

	function __construct()
	{
		parent::__construct( false, 'ItaliaWP Articoli',
		array('classname' => 'Articoli',
		'description' => 'Blocco Articoli su due colonne con due categoria') );
	}

	function widget( $args, $instance )
	{
		//       	var_dump($instance);
		extract($args);
		$title = apply_filters('widget_title', $instance['titolo']);
		$bgkcolor=isset($instance['bgkcolor'])?$instance['bgkcolor']:"";
		$bgkcolorblocchi=isset($instance['bgkcolorblocchi'])?$instance['bgkcolorblocchi']:"";
		$colortit=isset($instance['colortit'])?$instance['colortit']:"";
		$colortitblocchi=isset($instance['colortitblocchi'])?$instance['colortitblocchi']:"";
		$bgkcolortitblocchi=isset($instance['bgkcolortitblocchi'])?$instance['bgkcolortitblocchi']:"";
		$catprimoblocco=isset($instance['catprimoblocco'])?$instance['catprimoblocco']:"";
		$catsecondoblocco=isset($instance['catsecondoblocco'])?$instance['catsecondoblocco']:"";
		$numelementi=isset($instance['numelementi'])?$instance['numelementi']:"";
		$linkLT=isset($instance['leggitutto'])?$instance['leggitutto']:"";
?>
<div class="u-layoutCenter u-layout-withGutter u-padding-r-top <?php echo $instance['bgkcolor']; ?>">
	<?php
	echo $before_widget;
	$TitoloPB=get_cat_name( $catprimoblocco );
	$args = array( 'cat' => $catprimoblocco,
	'posts_per_page'  => $numelementi,
	'post_status' => (is_user_logged_in()? array('publish','private'):'publish'));
	$ArticoliPB = get_posts( $args );
	$TitoloSB=get_cat_name( $catsecondoblocco );
	$args = array( 'cat' => $catsecondoblocco,
	'posts_per_page'  => $numelementi,
	'post_status' => (is_user_logged_in()? array('publish','private'):'publish'));
	$ArticoliSB = get_posts( $args );
	?>
	<div class="u-layout-medium u-layoutCenter">
		<?php
		if ( $title ) {
			$before_title=str_replace("<h2 class=\"","<h2 class=\"u-text-h2 ".$colortit." ",$before_title);
			echo $before_title . $title . $after_title;
		}
		?>
		<div class="u-layout-wide u-layoutCenter u-layout-withGutter u-padding-r-top <?php echo $bgkcolor; ?>">
			<div class="Grid Grid--withGutter u-padding-all-xs">
				<div class="Grid-cell u-sizeFull u-md-size1of2 u-lg-size1of2">
					<div class="u-borderShadow-m u-borderRadius-l <?php echo $bgkcolorblocchi; ?>">
						<h3 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi; ?> u-padding-r-all"><?php echo $TitoloPB; ?></h3>
						<ul id="ListaArticoliSx" class="Linklist Linklist--padded u-text-r-xs">
							<?php
							foreach ($ArticoliPB as $Articolo) {
								//var_dump($Articolo);
								echo "<li><a href=\"".get_permalink($Articolo->ID)."\">".$Articolo->post_title."</a>
			<p class=\"u-textWeight-600;\">
			Del ".IWP_FormatDataItaliano($Articolo->post_date)."<br />
		<span class=\"fas fa-user-edit\"></span> ".get_the_author_meta('display_name', $Articolo->post_author)."</p>
		</li>";
							}
							if ($linkLT) {
							?>
							<li>
								<div class="tab-pane-readnext">
									<p class="u-textCenter u-text-md-right u-text-lg-right u-margin-r-top">
										<a href="<?php echo get_category_link($catprimoblocco); ?>" class="u-color-white u-textClean u-text-h4"> Leggi tutto
											<span class="Icon Icon-chevron-right"></span></a>
									</p>
								</div>
							</li>
							<?php	} ?>
						</ul>
					</div>
				</div>
				<div class="Grid-cell u-sizeFull u-md-size1of2 u-lg-size1of2">
					<div class="u-borderShadow-m u-borderRadius-l <?php echo $bgkcolorblocchi; ?>">
						<h3 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi; ?> u-padding-r-all"><?php echo $TitoloSB; ?></h3>
						<ul id="ListaArticoliDx" class="Linklist Linklist--padded u-text-r-xs">
							<?php
							foreach ($ArticoliSB as $Articolo) {
								//var_dump($Articolo);
								echo "<li><a href=\"".get_permalink($Articolo->ID)."\">".$Articolo->post_title."</a>
			<p class=\"u-textWeight-600;\">
			Del ".IWP_FormatDataItaliano($Articolo->post_date)."<br />
		<span class=\"fas fa-user-edit\"></span> ".get_the_author_meta('display_name', $Articolo->post_author)."</p>
		</li>";
							}
							if ($linkLT) {
							?>
							<li>
								<div class="tab-pane-readnext">
									<p class="u-textCenter u-text-md-right u-text-lg-right u-margin-r-top">
										<a href="<?php echo get_category_link($catsecondoblocco); ?>" class="u-color-white u-textClean u-text-h4"> Leggi tutto
											<span class="Icon Icon-chevron-right"></span></a>
									</p>
								</div>
							</li>
							<?php	} ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
}

function update( $new_instance, $old_instance )
{
	//var_dump($new_instance);wp_die();
	$instance = $old_instance;
	$instance['titolo'] = strip_tags($new_instance['titolo']);
	$instance['blocchi'] = strip_tags(serialize($Blocchi));
	$instance['bgkcolor']=strip_tags($new_instance['bgkcolor']);
	$instance['bgkcolorblocchi']=strip_tags($new_instance['bgkcolorblocchi']);
	$instance['colortit']=strip_tags($new_instance['colortit']);
	$instance['colortitblocchi']=strip_tags($new_instance['colortitblocchi']);
	$instance['bgkcolortitblocchi']=strip_tags($new_instance['bgkcolortitblocchi']);

	$instance['catprimoblocco']=strip_tags($new_instance['catprimoblocco']);
	$instance['catsecondoblocco']=strip_tags($new_instance['catsecondoblocco']);
	$instance['numelementi']=strip_tags($new_instance['numelementi']);
	$instance['leggitutto']=strip_tags($new_instance['leggitutto']);
	return $instance;
}

function form( $instance )
{
	$instance = wp_parse_args( (array) $instance, array( ) );
	$titolo = ! empty( $instance['titolo'] ) ? $instance['titolo'] : esc_html__( 'Comunicazioni', 'text_domain' );
	$catprimoblocco=isset($instance['catprimoblocco'])?$instance['catprimoblocco']:0;
	$catsecondoblocco=isset($instance['catsecondoblocco'])?$instance['catsecondoblocco']:0;
	$bgkcolor=isset($instance['bgkcolor'])?$instance['bgkcolor']:"";
	$bgkcolorblocchi=isset($instance['bgkcolorblocchi'])?$instance['bgkcolorblocchi']:"";
	$colortit=isset($instance['colortit'])?$instance['colortit']:"";
	$colortitblocchi=isset($instance['colortitblocchi'])?$instance['colortitblocchi']:"";
	$bgkcolortitblocchi=isset($instance['bgkcolortitblocchi'])?$instance['bgkcolortitblocchi']:"";
	$numelementi=isset($instance['numelementi'])?$instance['numelementi']:5;
	$ColoriSfondo=array("u-background-black"=>"#000;",
	"u-background-white"=>"#fff;",
	"u-background-5"=>"#d9e6f2;",
	"u-background-10"=>"#adcceb;",
	"u-background-20"=>"#7db2e8;",
	"u-background-30"=>"#4799eb;",
	"u-background-40"=>"#127ae2;",
	"u-background-50"=>"#06c;",
	"u-background-60"=>"#0059b3;",
	"u-background-70"=>"#004c99;",
	"u-background-80"=>"#004080;",
	"u-background-90"=>"#036;",
	"u-background-95"=>"#00264d;",
	"u-background-teal-30"=>"#00c5ca;",
	"u-background-teal-50"=>"#65dcdf;",
	"u-background-teal-70"=>"#004a4d;",
	"u-background-grey-10"=>"#f5f5f0;",
	"u-background-grey-20"=>"#eee;",
	"u-background-grey-30"=>"#ddd;",
	"u-background-grey-40"=>"#a5abb0;",
	"u-background-grey-50"=>"#5a6772;",
	"u-background-grey-60"=>"#444e57;",
	"u-background-grey-80"=>"#30373d;",
	"u-background-grey-90"=>"#1c2024;");
	$ColoriTesto= array("u-color-black"=>"#000;",
	"u-color-white"=>"#fff;",
	"u-color-5"=>"#d9e6f2;",
	"u-color-10"=>"#adcceb;",
	"u-color-20"=>"#7db2e8;",
	"u-color-30"=>"#4799eb;",
	"u-color-40"=>"#127ae2;",
	"u-color-50"=>"#06c;",
	"u-color-60"=>"#0059b3;",
	"u-color-70"=>"#004c99;",
	"u-color-80"=>"#004080;",
	"u-color-90"=>"#036;",
	"u-color-95"=>"#00264d;",
	"u-color-teal-30"=>"#00c5ca;",
	"u-color-teal-50"=>"#65dcdf;",
	"u-color-teal-70"=>"#004a4d;",
	"u-color-grey-10"=>"#f5f5f0;",
	"u-color-grey-20"=>"#eee;",
	"u-color-grey-30"=>"#ddd;",
	"u-color-grey-40"=>"#a5abb0;",
	"u-color-grey-50"=>"#5a6772;",
	"u-color-grey-60"=>"#444e57;",
	"u-color-grey-80"=>"#30373d;",
	"u-color-grey-90"=>"#1c2024;"); //var_dump($instance);
?>

<p>
	<label for="<?php echo $this->get_field_id( 'titolo' ); ?>">Titolo Sezione:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'titolo' ); ?>" name="<?php echo $this->get_field_name( 'titolo' ); ?>" value="<?php echo esc_attr( $titolo ); ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'bgkcolor' ); ?>">Colore di sfondo della sezione:</label><br />
	<select id="<?php echo $this->get_field_id( 'bgkcolor' ); ?>" name="<?php echo $this->get_field_name( 'bgkcolor' ); ?>">
		<?php
		foreach ($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo) {
			echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.'"';
			if ($KColoreSfondo==$bgkcolor) {
				echo " selected ";
			}
			echo'> '.$KColoreSfondo.' </option>';
		}
		?> </select>
	<span style="background-color:<?php echo ($bgkcolor!=""?$ColoriSfondo[$bgkcolor]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'colortit' ); ?>">Colore del titolo della sezione:</label><br />
	<select id="<?php echo $this->get_field_id( 'colortit' ); ?>" name="<?php echo $this->get_field_name( 'colortit' ); ?>">
		<?php
		foreach ($ColoriTesto as $KColoreTesto=>$ColoreTesto) {
			echo '<option value="'.$KColoreTesto.'" style="color: '.$ColoreTesto.'"';
			if ($KColoreTesto==$colortit) {
				echo " selected ";
			}
			echo'> '.$KColoreTesto.' </option>';
		}
		?> </select>
	<span style="color:<?php echo ($colortit!=""?$ColoriTesto[$colortit]:"");?>;">&ensp;&ensp;Colore del testo</span>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'bgkcolorblocchi' ); ?>">Colore di sfondo dei blocchi:</label><br />
	<select id="<?php echo $this->get_field_id( 'bgkcolorblocchi' ); ?>" name="<?php echo $this->get_field_name( 'bgkcolorblocchi' ); ?>">
		<?php
		foreach ($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo) {
			echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.';"';
			if ($KColoreSfondo==$bgkcolorblocchi) {
				echo " selected ";
			}
			echo'> '.$KColoreSfondo.' </option>';
		}
		?> </select>
	<span style="background-color:<?php echo ($bgkcolorblocchi!=""?$ColoriSfondo[$bgkcolorblocchi]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'colortitblocchi' ); ?>">Colore del titolo dei blocchi:</label><br />
	<select id="<?php echo $this->get_field_id( 'colortitblocchi' ); ?>" name="<?php echo $this->get_field_name( 'colortitblocchi' ); ?>">
		<?php
		foreach ($ColoriTesto as $KColoreTesto=>$ColoreTesto) {
			echo '<option value="'.$KColoreTesto.'" style="color: '.$ColoreTesto.'"';
			if ($KColoreTesto==$colortitblocchi) {
				echo " selected ";
			}
			echo'> '.$KColoreTesto.' </option>';
		}
		?> </select>
	<span style="color:<?php echo ($colortitblocchi?$ColoriTesto[$colortitblocchi]:"");?>;">&ensp;&ensp;Colore del testo</span>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'bgkcolortitblocchi' ); ?>">Colore di sfondo del titolo dei blocchi:</label><br />
	<select id="<?php echo $this->get_field_id( 'bgkcolortitblocchi' ); ?>" name="<?php echo $this->get_field_name( 'bgkcolortitblocchi' ); ?>">
		<?php
		foreach ($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo) {
			echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.'"';
			if ($KColoreSfondo==$bgkcolortitblocchi) {
				echo " selected ";
			}
			echo'> '.$KColoreSfondo.' </option>';
		}
		?> </select>
	<span style="background-color:<?php echo ($bgkcolortitblocchi!=""?$ColoriSfondo[$bgkcolortitblocchi]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'numelementi' ); ?>">N° elementi da visualizzare:</label>
	<input type="number" min="1" max="10" id="<?php echo $this->get_field_id( 'numelementi' ); ?>" name="<?php echo $this->get_field_name( 'numelementi' ); ?>" value="<?php echo $numelementi; ?>" />
</p>
<div class="Servizi">
	<h3>Categoria Blocco Sx</h3>
	<input type="hidden" name="catprimoblocco" id="catprimoblocco" value="-1">
	<label for="<?php echo $this->get_field_id( 'catprimoblocco' ); ?>">Categoria:</label>
	<?php
	$args = array(
	'option_none_value'  => '-1',
	'orderby'            => 'name',
	'order'              => 'ASC',
	'show_count'         => 0,
	'hide_empty'         => FALSE,
	'child_of'           => 0,
	'echo'               => TRUE,
	'selected'           => $catprimoblocco,
	'name'               => $this->get_field_name('catprimoblocco'),
	'id'                 => $this->get_field_id('catprimoblocco'),
	'class'              => '',);
	wp_dropdown_categories( $args );
	?>
</div>
<div class="Servizi">
	<h3>Altre Comunicazioni</h3>
	<label for="<?php echo $this->get_field_id( 'catsecondoblocco' ); ?>">Categoria:</label>
	<?php
	$args = array(
	'option_none_value'  => '-1',
	'orderby'            => 'name',
	'order'              => 'ASC',
	'show_count'         => 0,
	'hide_empty'         => FALSE,
	'child_of'           => 0,
	'echo'               => TRUE,
	'selected'           => $catsecondoblocco,
	'name'               => $this->get_field_name('catsecondoblocco'),
	'id'                 => $this->get_field_id('catsecondoblocco'),
	'class'              => '',);
	wp_dropdown_categories( $args );
	?>
</div>
<div class="Servizi">
	<h3>Link Leggi Tutto</h3>
	<label for="<?php echo $this->get_field_id( 'leggitutto' ); ?>">Attiva:</label>
	<input type="checkbox" id="<?php echo $this->get_field_id('leggitutto'); ?>" name="<?php echo $this->get_field_name('leggitutto'); ?>" value="1" <?php echo ($instance['leggitutto'] == '1') ? 'checked="checked"':''; ?>/>
</div>
<?php
}
}
/****************************************************************************
Widget Feed RSS
Titolo:	($title) Testo che viene visualizzato in Testa all'elenco degli articoli estratti
Url:  ($url) Url del Feed RSS
Elem: ($numele) Numero di elementi da visualizzare
VisTitolo: ($vistit) Flag che indicase se visualizzare il Titolo della notizia
VisAutore: ($visaut) Flag che indicase se visualizzare l'Autore della notizia
VisData: ($visdata) Flag che indicase se visualizzare la data di pubblicazione della notizia
*/
class Feed_RSS extends WP_Widget
{

	function __construct()
	{
		parent::__construct( false, 'ItaliaWP Feed RSS',
		array('classname' => 'Feed_RSS',
		'description' => 'Visualizzatore Feed RSS') );
	}

	public function widget( $args, $instance )
	{
		extract($args);
		$titoloSx=isset($instance['itawprss-titleSx']) ? $instance['itawprss-titleSx'] : '';
		$titoloCx	=isset($instance['itawprss-titleCx']) ? $instance['itawprss-titleCx'] : '';
		$titoloDx	=isset($instance['itawprss-titleDx']) ? $instance['itawprss-titleDx'] : '';
		$numele	=isset($instance['itawprss-items']) ? (int)$instance['itawprss-items']:0;
		$viscont=isset($instance['itawprss-vis_contenuto']) ? (int) $instance['itawprss-vis_contenuto'] : 0;
		$visaut	=isset($instance['itawprss-vis_autore']) ? (int) $instance['itawprss-vis_autore'] : 0;
		$visdata	=isset($instance['itawprss-vis_data']) ? (int) $instance['itawprss-vis_data'] : 0;
		$bgkcolor=isset($instance['bgkcolor'])?$instance['bgkcolor']:"";
		$bgkcolorblocchi=isset($instance['bgkcolorblocchi'])?$instance['bgkcolorblocchi']:"";
		$colortit=isset($instance['colortit'])?$instance['colortit']:"";
		$colortitblocchi=isset($instance['colortitblocchi'])?$instance['colortitblocchi']:"";
		$bgkcolortitblocchi=isset($instance['bgkcolortitblocchi'])?$instance['bgkcolortitblocchi']:"";
		$urlSx = ! empty( $instance['itawprss-urlSx'] ) ? $instance['itawprss-urlSx'] : '';
		while ( stristr( $urlSx, 'http' ) != $urlSx ) {
			$urlSx = substr( $urlSx, 1 );
		}
		$urlCx = ! empty( $instance['itawprss-urlCx'] ) ? $instance['itawprss-urlCx'] : '';
		while ( stristr( $urlCx, 'http' ) != $urlCx ) {
			$urlCx = substr( $urlCx, 1 );
		}
		$urlDx = ! empty( $instance['itawprss-urlDx'] ) ? $instance['itawprss-urlDx'] : '';
		while ( stristr( $urlDx, 'http' ) != $urlDx ) {
			$urlDx = substr( $urlDx, 1 );
		}
		if ( empty( $urlSx ) And empty($urlCx) And empty($urlDx)) {
			return;
		}
		if (in_array(untrailingslashit($urlSx),array(site_url(),home_url()))
		And in_array(untrailingslashit($urlCx),array(site_url(),home_url())) 			And in_array(untrailingslashit($urlDx),array(site_url(),home_url()))) {
			return;
		}
		$NumFeed=0;
		if ( !empty( $urlSx )) {
			$rssSx   = fetch_feed( $urlSx );
			$NumFeed++;
		}
		if ( !empty( $urlCx )) {
			$rssSx   = fetch_feed( $urlCx );
			$NumFeed++;
		}
		if ( !empty( $urlDx )) {
			$rssSx   = fetch_feed( $urlDx );
			$NumFeed++;
		}
		$title = $instance['itawprss-title'];
		$desc  = '';
		$link  = '';
?>
<div class="u-layoutCenter u-layout-withGutter u-padding-r-top <?php echo $instance['bgkcolor']; ?>">
	<section id="<?php echo $args['widget_id']; ?>">
		<div class="u-layout-medium u-layoutCenter">
			<?php
			if ( $title ) {
				$before_title=str_replace("<h2 class=\"","<h2 class=\"u-text-h2 ".$colortit." ",$before_title);
				echo $before_title . $title . $after_title;
			}
			?>
			<div class="u-layout-wide u-layoutCenter u-layout-withGutter u-padding-r-top <?php echo $bgkcolor; ?>">
				<div class="Grid Grid--withGutter u-padding-all-xs">
					<?php
					if ( !empty( $urlSx )) {
					?>
					<div class="Grid-cell u-sizeFull u-md-size1of<?php echo $NumFeed; ?> u-lg-size1of<?php echo $NumFeed; ?>">
						<div class="u-borderShadow-m u-borderRadius-l <?php echo $bgkcolorblocchi; ?>">
							<h3 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi; ?> u-padding-r-all"><?php echo $titoloSx; ?></h3>
							<?php $this->crea_VociFeed($urlSx,$numele,$viscont,$visaut,$visdata); ?>
						</div>
					</div>
					<?php
				}
				if ( !empty( $urlCx )) {
					?>
					<div class="Grid-cell u-sizeFull u-md-size1of<?php echo $NumFeed; ?> u-lg-size1of<?php echo $NumFeed; ?>">
						<div class="u-borderShadow-m u-borderRadius-l <?php echo $bgkcolorblocchi; ?>">
							<h3 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi; ?> u-padding-r-all"><?php echo $titoloCx; ?></h3>
							<?php $this->crea_VociFeed($urlCx,$numele,$viscont,$visaut,$visdata); ?>
						</div>
					</div>
					<?php
				}
				if ( !empty( $urlDx )) {
					?>
					<div class="Grid-cell u-sizeFull u-md-size1of<?php echo $NumFeed; ?> u-lg-size1of<?php echo $NumFeed; ?>">
						<div class="u-borderShadow-m u-borderRadius-l <?php echo $bgkcolorblocchi; ?>">
							<h3 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi; ?> u-padding-r-all"><?php echo $titoloDx; ?></h3>
							<?php $this->crea_VociFeed($urlDx,$numele,$viscont,$visaut,$visdata); ?>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>
</div>
<?php
}
private function crea_VociFeed($rss, $numele, $viscont, $visaut, $visdata)
{
	if ( is_string( $rss ) ) {
		$rss = fetch_feed($rss);
	} elseif ( is_array($rss) && isset($rss['url']) ) {
		$args = $rss;
		$rss = fetch_feed($rss['url']);
	} elseif ( !is_object($rss) ) {
		return;
	}
	if ( is_wp_error($rss) ) {
		if ( is_admin() || current_user_can('manage_options') )
			echo '<p><strong>' . __( 'RSS Error:' ) . '</strong> ' . $rss->get_error_message() . '</p>';
		return;
	}
	if ( $numele < 1 || 20 < $numele )
		$numele = 10;

	if ( !$rss->get_item_quantity() ) {
		echo '<ul><li>' . __( 'An error has occurred, which probably means the feed is down. Try again later.' ) . '</li></ul>';
		$rss->__destruct();
		unset($rss);
		return;
	}
?>		<ul class="Linklist Linklist--padded u-text-r-xs">
<?php
foreach ( $rss->get_items( 0, $numele ) as $item ) {
	$link = $item->get_link();
	while ( stristr( $link, 'http' ) != $link ) {
		$link = substr( $link, 1 );
	}
	$link = esc_url( strip_tags( $link ) );

	$title = esc_html( trim( strip_tags( $item->get_title() ) ) );
	if ( empty( $title ) ) {
		$title = __( 'Untitled' );
	}
	$desc = @html_entity_decode( $item->get_description(), ENT_QUOTES, get_option( 'blog_charset' ) );
	$desc = esc_attr( wp_trim_words( $desc, 55, ' [&hellip;]' ) );
	$summary = '';
	if ( $viscont ) {
		$summary = $desc;
		// Change existing [...] to [&hellip;].
		if ( '[...]' == substr( $summary, -5 ) ) {
			$summary = substr( $summary, 0, -5 ) . '[&hellip;]';
		}
		$summary = '<div class="u-textItalic">' . esc_html( $summary ) . '</div>';
	}
	$date = '';
	if ( $visdata ) {
		$date = $item->get_date( 'U' );
		if ( $date ) {
			$date = ' <span class="rss-date">' . date_i18n( get_option( 'date_format' ), $date ) . '</span>';
		}
	}
	$author = '';
	if ( $visaut ) {
		$author = $item->get_author();
		if ( is_object($author) ) {
			$author = $author->get_name();
			$author = ' <cite>' . esc_html( strip_tags( $author ) ) . '</cite>';
		}
	}
	if ( $link == '' ) {
		echo "<li>$title{$date}{$summary}{$author}</li>";
	} elseif ( $viscont ) {
		echo "<li><a class='rsswidget' href='$link'>$title</a><span class=\"dettagliFeddRss\">{$date}{$summary}{$author}</li>";
	} else {
		echo "<li><a class='rsswidget' href='$link'>$title</a><span class=\"dettagliFeddRss\">{$date}{$author}</span></li>";
	}
}
echo '</ul>';
$rss->__destruct();
unset($rss);
}
public function update( $new_instance, $old_instance )
{
	$instance = $old_instance;

	$instance['itawprss-title']	=$new_instance['itawprss-title'];
	$instance['itawprss-titleSx']	=$new_instance['itawprss-titleSx'];
	$instance['itawprss-urlSx']		=$new_instance['itawprss-urlSx'];
	$instance['itawprss-titleCx']	=$new_instance['itawprss-titleCx'];
	$instance['itawprss-urlCx']		=$new_instance['itawprss-urlCx'];
	$instance['itawprss-titleDx']	=$new_instance['itawprss-titleDx'];
	$instance['itawprss-urlDx']		=$new_instance['itawprss-urlDx'];
	$instance['itawprss-items']		=$new_instance['itawprss-items'];
	$instance['itawprss-vis_contenuto']=$new_instance['itawprss-vis_contenuto'];
	$instance['itawprss-vis_autore']=$new_instance['itawprss-vis_autore'];
	$instance['itawprss-vis_data']	=$new_instance['itawprss-vis_data'];
	$instance['bgkcolor']=strip_tags($new_instance['bgkcolor']);
	$instance['bgkcolorblocchi']=strip_tags($new_instance['bgkcolorblocchi']);
	$instance['colortit']=strip_tags($new_instance['colortit']);
	$instance['colortitblocchi']=strip_tags($new_instance['colortitblocchi']);
	$instance['bgkcolortitblocchi']=strip_tags($new_instance['bgkcolortitblocchi']);

	return $instance;
}

/**
* Outputs the settings form for the RSS widget.
*
* @since 2.8.0
*
* @param array $instance Current settings.
*/
public function form( $instance )
{
	if ( empty( $instance ) ) {
		$instance = array(
		'title'				  => 'Notizie della Scuola',
		'itawprss-titleSx'        => '',
		'itawprss-urlSx'          => '',
		'itawprss-titleCx'        => '',
		'itawprss-urlCx'          => '',
		'itawprss-titleDx'        => '',
		'itawprss-urlDx'          => '',
		'itawprss-items'        => 10,
		'itawprss-vis_contenuto' => 0,
		'itawprss-vis_autore'  => 0,
		'itawprss-vis_data'    => 0,
		);
	}
	$titolo	=isset($instance['itawprss-title']) ? $instance['itawprss-title'] : 'Notizie della Scuola';
	$titoloSx	=isset($instance['itawprss-titleSx']) ? $instance['itawprss-titleSx'] : '';
	$urlSx	=isset($instance['itawprss-urlSx']) ? $instance['itawprss-urlSx'] : '';
	$titoloCx	=isset($instance['itawprss-titleCx']) ? $instance['itawprss-titleCx'] : '';
	$urlCx	=isset($instance['itawprss-urlCx']) ? $instance['itawprss-urlCx'] : '';
	$titoloDx	=isset($instance['itawprss-titleDx']) ? $instance['itawprss-titleDx'] : '';
	$urlDx	=isset($instance['itawprss-urlDx']) ? $instance['itawprss-urlDx'] : '';
	$numele	=isset($instance['itawprss-items']) ? (int)$instance['itawprss-items']:0;
	$viscont=isset($instance['itawprss-vis_contenuto']) ? (int) $instance['itawprss-vis_contenuto'] : 0;
	$visaut	=isset($instance['itawprss-vis_autore']) ? (int) $instance['itawprss-vis_autore'] : 0;
	$visdata	=isset($instance['itawprss-vis_data']) ? (int) $instance['itawprss-vis_data'] : 0;
	$bgkcolor=isset($instance['bgkcolor'])?$instance['bgkcolor']:"";
	$bgkcolorblocchi=isset($instance['bgkcolorblocchi'])?$instance['bgkcolorblocchi']:"";
	$colortit=isset($instance['colortit'])?$instance['colortit']:"";
	$colortitblocchi=isset($instance['colortitblocchi'])?$instance['colortitblocchi']:"";
	$bgkcolortitblocchi=isset($instance['bgkcolortitblocchi'])?$instance['bgkcolortitblocchi']:"";
	$ColoriSfondo=array("u-background-black"=>"#000;",
	"u-background-white"=>"#fff;",
	"u-background-5"=>"#d9e6f2;",
	"u-background-10"=>"#adcceb;",
	"u-background-20"=>"#7db2e8;",
	"u-background-30"=>"#4799eb;",
	"u-background-40"=>"#127ae2;",
	"u-background-50"=>"#06c;",
	"u-background-60"=>"#0059b3;",
	"u-background-70"=>"#004c99;",
	"u-background-80"=>"#004080;",
	"u-background-90"=>"#036;",
	"u-background-95"=>"#00264d;",
	"u-background-teal-30"=>"#00c5ca;",
	"u-background-teal-50"=>"#65dcdf;",
	"u-background-teal-70"=>"#004a4d;",
	"u-background-grey-10"=>"#f5f5f0;",
	"u-background-grey-20"=>"#eee;",
	"u-background-grey-30"=>"#ddd;",
	"u-background-grey-40"=>"#a5abb0;",
	"u-background-grey-50"=>"#5a6772;",
	"u-background-grey-60"=>"#444e57;",
	"u-background-grey-80"=>"#30373d;",
	"u-background-grey-90"=>"#1c2024;");
	$ColoriTesto= array("u-color-black"=>"#000;",
	"u-color-white"=>"#fff;",
	"u-color-5"=>"#d9e6f2;",
	"u-color-10"=>"#adcceb;",
	"u-color-20"=>"#7db2e8;",
	"u-color-30"=>"#4799eb;",
	"u-color-40"=>"#127ae2;",
	"u-color-50"=>"#06c;",
	"u-color-60"=>"#0059b3;",
	"u-color-70"=>"#004c99;",
	"u-color-80"=>"#004080;",
	"u-color-90"=>"#036;",
	"u-color-95"=>"#00264d;",
	"u-color-teal-30"=>"#00c5ca;",
	"u-color-teal-50"=>"#65dcdf;",
	"u-color-teal-70"=>"#004a4d;",
	"u-color-grey-10"=>"#f5f5f0;",
	"u-color-grey-20"=>"#eee;",
	"u-color-grey-30"=>"#ddd;",
	"u-color-grey-40"=>"#a5abb0;",
	"u-color-grey-50"=>"#5a6772;",
	"u-color-grey-60"=>"#444e57;",
	"u-color-grey-80"=>"#30373d;",
	"u-color-grey-90"=>"#1c2024;");
	if ( ! empty( $instance['error'] ) ) {
		echo '<p class="widget-error"><strong>' . __( 'RSS Error:' ) . '</strong> ' . $instance['error'] . '</p>';
	}
?>
<label for=<?php echo $this->get_field_id( "itawprss-title"); ?>>Titolo del Blocco</label>
<input class="widefat" id=<?php echo $this->get_field_id( "itawprss-title"); ?> name=<?php echo $this->get_field_name( 'itawprss-title' ); ?> type="text" value="<?php echo esc_attr( $titolo ); ?>" /></p>
<p>
	<label for=<?php echo $this->get_field_id( "itawprss-urlSx"); ?>>Url Feed RSS blocco di Sinistra</label>
	<input class="widefat" id=<?php echo $this->get_field_id( "itawprss-urlSx"); ?> name=<?php echo $this->get_field_name( 'itawprss-urlSx' ); ?> type="text" value="<?php echo esc_url( $urlSx ); ?>" /></p>
<p>
	<label for=<?php echo $this->get_field_id( "itawprss-titleSx"); ?>>Titolo del Feed Rss blocco di Sinistra</label>
	<input class="widefat" id=<?php echo $this->get_field_id( "itawprss-titleSx"); ?> name=<?php echo $this->get_field_name( 'itawprss-titleSx' ); ?> type="text" value="<?php echo esc_attr( $titoloSx ); ?>" /></p>
<p>
	<label for=<?php echo $this->get_field_id( "itawprss-urlCx"); ?>>Url Feed RSS blocco Centrale</label>
	<input class="widefat" id=<?php echo $this->get_field_id( "itawprss-urlCx"); ?> name=<?php echo $this->get_field_name( 'itawprss-urlCx' ); ?> type="text" value="<?php echo esc_url( $urlCx ); ?>" /></p>
<p>
	<label for=<?php echo $this->get_field_id( "itawprss-titleCx"); ?>>Titolo del Feed Rss blocco Centrale</label>
	<input class="widefat" id=<?php echo $this->get_field_id( "itawprss-titleCx"); ?> name=<?php echo $this->get_field_name( 'itawprss-titleCx' ); ?> type="text" value="<?php echo esc_attr( $titoloCx ); ?>" /></p>
<p>
	<label for=<?php echo $this->get_field_id( "itawprss-urlDx"); ?>>Url Feed RSS blocco di Destra</label>
	<input class="widefat" id=<?php echo $this->get_field_id( "itawprss-urlDx"); ?> name=<?php echo $this->get_field_name( 'itawprss-urlDx' ); ?> type="text" value="<?php echo esc_url( $urlDx ); ?>" /></p>
<p>
	<label for=<?php echo $this->get_field_id( "itawprss-titleDx"); ?>>Titolo del Feed Rss blocco di Destra</label>
	<input class="widefat" id=<?php echo $this->get_field_id( "itawprss-titleDx"); ?> name=<?php echo $this->get_field_name( 'itawprss-titleDx' ); ?> type="text" value="<?php echo esc_attr( $titoloDx ); ?>" /></p>
<p>
	<label for=<?php echo $this->get_field_id( "itawprss-items"); ?>>Numero elementi da Visualizzare</label>
	<input class="widefat" type="number" id=<?php echo $this->get_field_id( "itawprss-items"); ?> name=<?php echo $this->get_field_name( 'itawprss-items' ); ?> value="<?php echo esc_attr( $numele ); ?>" min="1" max="20" style="width:4em;">
</p>
<p><input id=<?php echo $this->get_field_id( "itawprss-vis_contenuto"); ?> name=<?php echo $this->get_field_name( 'itawprss-vis_contenuto' ); ?> type="checkbox" value="1" <?php checked( $viscont ); ?> />
	<label for=<?php echo $this->get_field_id( "itawprss-vis_contenuto"); ?>>Visualizza Contenuto Post</label></p>
<p><input id=<?php echo $this->get_field_id( "itawprss-vis_autore"); ?> name=<?php echo $this->get_field_name( 'itawprss-vis_autore' ); ?> type="checkbox" value="1" <?php checked( $visaut ); ?> />
	<label for=<?php echo $this->get_field_id( "itawprss-vis_autore"); ?>>Visualizza Autore Post</label></p>
<p><input id=<?php echo $this->get_field_id( "itawprss-vis_data"); ?> name=<?php echo $this->get_field_name( 'itawprss-vis_data' ); ?> type="checkbox" value="1" <?php checked( $visdata ); ?>/>
	<label for=<?php echo $this->get_field_id( "itawprss-vis_data"); ?>>Visualizza Data Post</label></p>
<p>
	<label for="<?php echo $this->get_field_id( 'bgkcolor' ); ?>">Colore di sfondo della sezione:</label><br />
	<select id="<?php echo $this->get_field_id( 'bgkcolor' ); ?>" name="<?php echo $this->get_field_name( 'bgkcolor' ); ?>">
		<?php
		foreach ($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo) {
			echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.'"';
			if ($KColoreSfondo==$bgkcolor) {
				echo " selected ";
			}
			echo'> '.$KColoreSfondo.' </option>';
		}
		?> </select>
	<span style="background-color:<?php echo ($bgkcolor!=""?$ColoriSfondo[$bgkcolor]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'colortit' ); ?>">Colore del titolo della sezione:</label><br />
	<select id="<?php echo $this->get_field_id( 'colortit' ); ?>" name="<?php echo $this->get_field_name( 'colortit' ); ?>">
		<?php
		foreach ($ColoriTesto as $KColoreTesto=>$ColoreTesto) {
			echo '<option value="'.$KColoreTesto.'" style="color: '.$ColoreTesto.'"';
			if ($KColoreTesto==$colortit) {
				echo " selected ";
			}
			echo'> '.$KColoreTesto.' </option>';
		}
		?> </select>
	<span style="color:<?php echo ($colortit!=""?$ColoriTesto[$colortit]:"");?>;">&ensp;&ensp;Colore del testo</span>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'bgkcolorblocchi' ); ?>">Colore di sfondo dei blocchi:</label><br />
	<select id="<?php echo $this->get_field_id( 'bgkcolorblocchi' ); ?>" name="<?php echo $this->get_field_name( 'bgkcolorblocchi' ); ?>">
		<?php
		foreach ($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo) {
			echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.';"';
			if ($KColoreSfondo==$bgkcolorblocchi) {
				echo " selected ";
			}
			echo'> '.$KColoreSfondo.' </option>';
		}
		?> </select>
	<span style="background-color:<?php echo ($bgkcolorblocchi!=""?$ColoriSfondo[$bgkcolorblocchi]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'colortitblocchi' ); ?>">Colore del titolo dei blocchi:</label><br />
	<select id="<?php echo $this->get_field_id( 'colortitblocchi' ); ?>" name="<?php echo $this->get_field_name( 'colortitblocchi' ); ?>">
		<?php
		foreach ($ColoriTesto as $KColoreTesto=>$ColoreTesto) {
			echo '<option value="'.$KColoreTesto.'" style="color: '.$ColoreTesto.'"';
			if ($KColoreTesto==$colortitblocchi) {
				echo " selected ";
			}
			echo'> '.$KColoreTesto.' </option>';
		}
		?> </select>
	<span style="color:<?php echo ($colortitblocchi?$ColoriTesto[$colortitblocchi]:"");?>;">&ensp;&ensp;Colore del testo</span>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'bgkcolortitblocchi' ); ?>">Colore di sfondo del titolo dei blocchi:</label><br />
	<select id="<?php echo $this->get_field_id( 'bgkcolortitblocchi' ); ?>" name="<?php echo $this->get_field_name( 'bgkcolortitblocchi' ); ?>">
		<?php
		foreach ($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo) {
			echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.'"';
			if ($KColoreSfondo==$bgkcolortitblocchi) {
				echo " selected ";
			}
			echo'> '.$KColoreSfondo.' </option>';
		} ?>
	</select>
	<span style="background-color:<?php echo ($bgkcolortitblocchi!=""?$ColoriSfondo[$bgkcolortitblocchi]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>
</p>
<?php
}
}
<?php
/****************************************************************************
Widget Comunicazioni
Titolo:	($title) Testo che viene visualizzato in Testa all'elenco degli articoli estratti
*/

class Comunicazioni extends WP_Widget
{

	function __construct()
	{
		parent::__construct( false, 'ItaliaWP Comunicazioni',
		array('classname' => 'Comunicazioni',
		'description' => 'Blocco Comunicazioni due blocchi uno per le circolari ed uno per una categoria') );
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
		$categoria=isset($instance['catsecondoblocco'])?$instance['catsecondoblocco']:"";
		$TitoloCategoria=get_cat_name( $categoria );
		$numelementi=isset($instance['numelementi'])?$instance['numelementi']:"";
		$linkLT=isset($instance['leggitutto'])?$instance['leggitutto']:"";
		$pagcircolari=isset($instance['pagcircolari'])?$instance['pagcircolari']:0;

?>
<div class="u-layoutCenter u-layout-withGutter u-padding-r-top <?php echo $instance['bgkcolor']; ?>">
	<?php
	echo $before_widget;
	$TipoCircolari="C";
	if ( post_type_exists( 'circolari' ) ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if (is_plugin_active("gestione-circolari-groups/GestioneCircolari.php")) {
			$TipoCircolari="G";
			$Circolari=get_ListaCircolariG(FALSE,$numelementi);
			$Gruppi=gcg_get_Circolari_Gruppi("ArrayN");
			$NumCircolari=0;
			if (is_user_logged_in())
				$NumCircolari=gcg_GetCircolariDaFirmare("N");
		} else {
			$Circolari=get_ListaCircolari(FALSE,$numelementi);
			if (is_user_logged_in())
				$NumCircolari=GetCircolariDaFirmare("N");
			//				var_dump($Circolari);wp_die();
		}
	}
	$args = array( 'cat' => $categoria,
	'posts_per_page'  => $numelementi,
	'post_status' => (is_user_logged_in()? array('publish','private'):'publish'));
	$Articoli = get_posts( $args );
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
						<h3 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi; ?> u-padding-r-all">Circolari
							<?php
							if ($NumCircolari>0)
								: ?>
							<a href="<?php echo get_site_url(); ?>/wp-admin/edit.php?post_type=circolari&page=Firma">
								<span class="fas fa-edit u-color-white u-text-r-xxl u-padding-r-left" style="font-size:1.5em!important"  title="Ci sono <?php echo $NumCircolari; ?> circolari da firmare"></span>
								<span class="u-text-r-s u-padding-left-xxs u-padding-right-xxs u-borderRadius-circle u-color-white" style="background-color: red;"><?php echo $NumCircolari; ?></span></a>
							<?php endif ?>
						</h3>
						<ul id="ListaCircolari" class="Linklist Linklist--padded u-text-r-xs">
							<?php
							if (isset($Circolari)) {
								foreach ($Circolari as $CircolareVis) {
									$Elenco="";
									$Tipo="";
									$Protetto="";
									$numero=get_post_meta($CircolareVis->ID, "_numero",TRUE);
									$anno=get_post_meta($CircolareVis->ID, "_anno",TRUE);
									if ($TipoCircolari=="C") {
										$fgs = wp_get_object_terms($CircolareVis->ID, 'gruppiutenti');
										if (!empty($fgs)) {
											foreach ($fgs as $fg) {
												$Elenco.=$fg->name." - ";
											}
											$Elenco=substr($Elenco,0,strlen($Elenco)-3);
										}
										if (!empty($CircolareVis->post_password))
											$Protetto= '<span class="fas fa-lock"></span> Contenuto Protetto';
										else
											$Protetto="";
										if (Is_Circolare_Da_Firmare($CircolareVis->ID))
											if (!Is_Circolare_Firmata($CircolareVis->ID)) {
											$ngiorni=Get_scadenzaCircolare($CircolareVis->ID,"",True);
											if (Is_Circolare_Scaduta($CircolareVis->ID)) {
												$Tipo='<span style="color:red;"><span class="fa fa-user-edit"></span> Scaduta e non Firmata</span>';
											} else {
												switch ($ngiorni) {
													case -1:
														$entro="";
														break;
													case 0:
														$entro="entro OGGI";
														break;
													case 1:
														$entro="entro DOMANI";
														break;
													default:
														$entro="entro $ngiorni giorni";
														break;
												}
												$sign=get_post_meta($CircolareVis->ID, "_firma",TRUE);
												if ($sign!="Si")
													$Tipo="<span style=\"color:red;\"><span class=\"fa fa-user-edit\"></span> Esprimere adesione ".$entro."</span>";
												else
													$Tipo="<span style=\"color:red;\"><span class=\"fa fa-user-edit\"></span> Firmare ".$entro."</span>";
											}
										} else {
											$Tipo="<span style=\"color:blue;\"><span class=\"fa fa-user-edit\"></span> Firmata</span>";
										}
										echo "<li><p><a href=\"".get_permalink($CircolareVis->ID)."\">".$CircolareVis->post_title."</a>
				<p class=\"u-textWeight-600;\">
				Del ".FormatDataItaliano($CircolareVis->post_date).($numero!=""?" Numero ".$numero."_".$anno:"")."<br />
			<span class=\"fa fa-folder-open\"></span> ".$CircolareVis->post_type." ";
										if ($CircolareVis->post_type!="post") {
											echo "<span class=\"fa fa-users\"></span> ".$Elenco." ";
										}
										if ($Protetto) {
											echo $Protetto;
										}
										if ($Tipo) {
											echo "<br />".$Tipo."</p>";
										}
										echo "</li>";
									} else {
										$Destinatari=get_post_meta($CircolareVis->ID, "_destinatari");
										$Elenco="";
										if ($CircolareVis->post_type=="circolari") {
											if (count($Destinatari)>0) {
												$Destinatari=unserialize($Destinatari[0]);
												$Nomi_Des='';
												//			var_dump($Destinatari);var_dump($Gruppi);die();
												foreach ($Destinatari as $Dest)
													$Nomi_Des.=$Gruppi[$Dest].", ";
												$Elenco=substr($Nomi_Des,0,-2);
											}
										}
										if (!empty($CircolareVis->post_password))
											$Protetto= '<span class="fas fa-lock"></span> Contenuto Protetto';
										else
											$Protetto="";
										if (($post->post_type=="circolari") && gcg_Is_Circolare_Da_Firmare($CircolareVis->ID)) {
											if (!gcg_Is_Circolare_Firmata($CircolareVis->ID)) {
												$ngiorni=gcg_GetscadenzaCircolare($CircolareVis->ID,"",True);
												if (gcg_Is_Circolare_Scaduta($CircolareVis->ID)) {
													$Tipo='<span style="color:red;"><span class="fa fa-user-edit"></span> Scaduta e non Firmata</span>';
												} else {
													switch ($ngiorni) {
														case -1:
															$entro="";
															break;
														case 0:
															$entro="entro OGGI";
															break;
														case 1:
															$entro="entro DOMANI";
															break;
														default:
															$entro="entro $ngiorni giorni";
															break;
													}
													$Tipo="";
													if (get_post_meta($CircolareVis->ID, "_sign",TRUE)=="Firma")
														$Tipo="Firmare $entro";
													else if (get_post_meta($CircolareVis->ID, "_sign",TRUE)!="NoFirma")
														$Tipo="Esprimere scelta $entro";
												}
											} else {
												$Tipo="<span style=\"color:blue;\"><span class=\"fa fa-user-edit\"></span> Firmata</span>";
											}
										}
										echo "<li><p><a href=\"".get_permalink($CircolareVis->ID)."\">".$CircolareVis->post_title."</a>
				<p class=\"u-textWeight-600;\">
				Del ".gcg_FormatDataItaliano($CircolareVis->post_date).($numero!=""?" Numero ".$numero."_".$anno:"")."<br />
			<span class=\"fa fa-folder-open\"></span> ".$CircolareVis->post_type." ";
										if ($CircolareVis->post_type!="post") {
											echo "<span class=\"fa fa-users\"></span> ".$Elenco." ";
										}
										if ($Tipo) {
											echo "<br />".$Tipo."</p>";
										}
										echo "</li>";
									}
								}
								if ($linkLT) {
							?>
							<li>
								<div class="tab-pane-readnext">
									<p class="u-textCenter u-text-md-right u-text-lg-right u-margin-r-top">
										<a href="<?php echo $pagcircolari; ?>" class="u-color-white u-textClean u-text-h4">Leggi tutto
											<span class="Icon Icon-chevron-right"></span></a>
									</p>
								</div>
							</li>
							<?php	} ?>
						</ul>
						<?php } ?>
					</div>
				</div>
				<div class="Grid-cell u-sizeFull u-md-size1of2 u-lg-size1of2">
					<div class="u-borderShadow-m u-borderRadius-l <?php echo $bgkcolorblocchi; ?>">
						<h2 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi; ?> u-padding-r-all"><?php echo $TitoloCategoria; ?></h2>
						<ul id="ListaArticoliComunicazioni" class="Linklist Linklist--padded u-text-r-xs">
							<?php
							foreach ($Articoli as $Articolo) {
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
										<a href="<?php echo get_category_link($categoria); ?>" class="u-color-white u-textClean u-text-h4">Leggi tutto
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
	$instance['pagcircolari']=strip_tags($new_instance['pagcircolari']);
	return $instance;
}

function make_List_Pages($Pages, $Id, $Name, $Default)
{
	$Pagine="<select id=\"".$Id."\" name=\"".$Name."\">
		<option value=\"\" >--------</option>";
	foreach ( $Pages as $Pagina ) {
		$Url=get_permalink($Pagina->ID);
		$Pagine.= "<option value=\"".$Url."\"";
		if ($Url==$Default) {
			$Pagine.= " selected ";
		}
		$Pagine.= " >".$Pagina->post_title."</option>";
	}
	$Pagine.="</select>";
	return $Pagine;
}

function form( $instance )
{
	$args = array(
	'post_status' => 'publish',
	'sort_order' => 'asc',
	'sort_column' => 'post_title'
	);
	$Pagine=get_pages( $args );
	$instance = wp_parse_args( (array) $instance, array( ) );
	$titolo = ! empty( $instance['titolo'] ) ? $instance['titolo'] : esc_html__( 'Comunicazioni', 'text_domain' );
	$catprimoblocco=isset($instance['catprimoblocco'])?$instance['catprimoblocco']:0;
	$pagcircolari=isset($instance['pagcircolari'])?$instance['pagcircolari']:0;
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
	<h3>Circolari</h3>
	<?php
	if ( post_type_exists( 'circolari' ) ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		echo "Gestite tramite il plugin ";
		if (function_exists("circolariG_Visualizza")) {
			echo "Gestione Circolari Groups";
		} else {
			echo "Gestione Circolari ";
		} ?>
	<input type="hidden" name="catprimoblocco" id="catprimoblocco" value="-1">
	<br />
	<label for="<?php echo $this->get_field_id( 'pagcircolari' ); ?>">Pagina Circolari:</label>
	<?php echo $this->make_List_Pages($Pagine,$this->get_field_id( 'pagcircolari' ),$this->get_field_name( 'pagcircolari' ),! empty( $instance['pagcircolari'] ) ? $instance['pagcircolari'] :"");
	} else {
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
	} ?>
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

<?php
/****************************************************************************
Widget Multi Menu Orizontale
Titolo:	($title) Testo che viene visualizzato in Testa all'elenco degli articoli estratti
Menu:($menu) Indice del menu
*/
class Multi_Menu extends WP_Widget
{

	function __construct()
	{
		parent::__construct( false, 'ItaliaWP Multi Menu',
		array('classname' => 'Multi_Menu',
		'description' => 'Blocco da usare in Home Page per visualizzare fino a 3 Menu in Verticale') );
	}
	public function widget( $args, $instance )
	{
		extract($args);
		$titolo	=isset($instance['itawpmenu-title']) ? $instance['itawpmenu-title'] : 'Menu Scuola';
		$titoloSx	=isset($instance['itawpmenu-titleSx']) ? $instance['itawpmenu-titleSx'] : '';
		$MenuSx	=isset($instance['itawpmenu-MenuSx']) ? $instance['itawpmenu-MenuSx'] : '';
		$titoloCx	=isset($instance['itawpmenu-titleCx']) ? $instance['itawpmenu-titleCx'] : '';
		$MenuCx	=isset($instance['itawpmenu-MenuCx']) ? $instance['itawpmenu-MenuCx'] : '';
		$titoloDx	=isset($instance['itawpmenu-titleDx']) ? $instance['itawpmenu-titleDx'] : '';
		$MenuDx	=isset($instance['itawpmenu-MenuDx']) ? $instance['itawpmenu-MenuDx'] : '';
		$bgkcolor=isset($instance['itawpmenu-bgkcolor'])?$instance['itawpmenu-bgkcolor']:"";
		$bgkcolorblocchi=isset($instance['itawpmenu-bgkcolorblocchi'])?$instance['itawpmenu-bgkcolorblocchi']:"";
		$colortit=isset($instance['itawpmenu-colortit'])?$instance['itawpmenu-colortit']:"";
		$colortitblocchi=isset($instance['itawpmenu-colortitblocchi'])?$instance['itawpmenu-colortitblocchi']:"";
		$bgkcolortitblocchi=isset($instance['itawpmenu-bgkcolortitblocchi'])?$instance['itawpmenu-bgkcolortitblocchi']:"";
		if ( empty( $MenuSx ) And empty($MenuCx) And empty($MenuDx)) {
			return;
		}
		$NumMenu=0;
		if ( !empty( $MenuSx )) {
			$NumMenu++;
		}
		if ( !empty( $MenuCx )) {
			$NumMenu++;
		}
		if ( !empty( $MenuDx )) {
			$NumMenu++;
		}
		$desc  = '';
		$link  = '';
		//		echo "<pre>";var_dump(wp_get_nav_menu_items( $MenuSx));echo "</pre>";
?>
<div class="u-layoutCenter u-layout-withGutter u-padding-r-top <?php echo $instance['bgkcolor']; ?>">
	<section id="<?php echo $args['widget_id']; ?>">
		<div class="u-layout-medium u-layoutCenter">
			<?php
			if ( $titolo ) {
				$before_title=str_replace("<h2 class=\"","<h2 class=\"u-text-h2 ".$colortit." ",$before_title);
				echo $before_title . $titolo . $after_title;
			}
			?>
			<div class="u-layout-wide u-layoutCenter u-layout-withGutter u-padding-r-top <?php echo $bgkcolor; ?>">
				<div class="Grid Grid--withGutter u-padding-all-xs">
					<?php
					if ( !empty( $MenuSx )) {
					?>
					<div class="Grid-cell u-sizeFull u-md-size1of<?php echo $NumMenu; ?> u-lg-size1of<?php echo $NumMenu; ?>">
						<div class="u-borderShadow-m u-borderRadius-l <?php echo $bgkcolorblocchi; ?>">
							<h3 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi; ?> u-padding-r-all"><?php echo $titoloSx; ?></h3>
							<ul class="Linklist Linklist Linklist--padded u-text-r-xs">
								<?php
								$Menus=wp_get_nav_menu_items( $MenuSx);
								$Livello=array(0);
								$IndexC=0;
								foreach ($Menus as $Menu) {
									//									echo "<pre>";var_dump($Livello);echo "</pre>";
									//									echo $IndexC." - ";
									if ($Livello[$IndexC]!=$Menu->menu_item_parent) {
										if (($IndexC>0 And $Livello[$IndexC-1]!=$Menu->menu_item_parent) OR $IndexC==0) {
											$IndexC++;
											$Livello[]=$Menu->menu_item_parent;
								?>
								<ul> <?php
							} else {
								unset($Livello[$IndexC]);
								$Livello=$this->compact_index($Livello);
								$IndexC--;
								?> </ul> <?php
							}
						}
						$Stili="";
						if (isset($Menu->classes)) {
							foreach ($Menu->classes as $Classe) {
								if ($Classe!="")
									$Stili.=$Classe.' ';
							}
							if ($Stili!="")
								$Stili='class="'.$Stili.'"';
						}
						$Target="";
						if ($Menu->target!="") {
							$Target='target="'.$Menu->target.'"';
						} ?>

								<li>
									<a href="<?php echo $Menu->url; ?>" <?php echo $Target; ?> <?php echo $Stili; ?>><?php echo$Menu->title; ?></a>
								</li>
								<?php
					}
					for ($i=$IndexC;$i>0;$i--) {
						echo "	</ul>";
					} ?>
							</ul>
						</div>
					</div>
					<?php
				}
				if ( !empty( $MenuCx )) {
					?>
					<div class="Grid-cell u-sizeFull u-md-size1of<?php echo $NumMenu; ?> u-lg-size1of<?php echo $NumMenu; ?>">
						<div class="u-borderShadow-m u-borderRadius-l <?php echo $bgkcolorblocchi; ?>">
							<h3 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi; ?> u-padding-r-all"><?php echo $titoloCx; ?></h3>
							<ul class="Linklist Linklist Linklist--padded u-text-r-xs">
								<?php
								$Menus=wp_get_nav_menu_items( $MenuCx);
								$Livello=array(0);
								$IndexC=0;
								foreach ($Menus as $Menu) {
									//									echo "<pre>";var_dump($Livello);echo "</pre>";
									//									echo $IndexC." - ";
									if ($Livello[$IndexC]!=$Menu->menu_item_parent) {
										if (($IndexC>0 And $Livello[$IndexC-1]!=$Menu->menu_item_parent) OR $IndexC==0) {
											$IndexC++;
											$Livello[]=$Menu->menu_item_parent;
								?>
								<ul> <?php
							} else {
								unset($Livello[$IndexC]);
								$Livello=$this->compact_index($Livello);
								$IndexC--;
								?> </ul> <?php
							}
						}
						$Stili="";
						if (isset($Menu->classes)) {
							foreach ($Menu->classes as $Classe) {
								if ($Classe!="")
									$Stili.=$Classe.' ';
							}
							if ($Stili!="")
								$Stili='class="'.$Stili.'"';
						}
						$Target="";
						if ($Menu->target!="") {
							$Target='target="'.$Menu->target.'"';
						} ?>

								<li>
									<a href="<?php echo $Menu->url; ?>" <?php echo $Target; ?> <?php echo $Stili; ?>><?php echo$Menu->title; ?></a>
								</li>
								<?php
					}
					for ($i=$IndexC;$i>0;$i--) {
						echo "	</ul>";
					} ?>
							</ul>
						</div>
					</div>
					<?php
				}
				if ( !empty( $MenuDx )) {
					?>
					<div class="Grid-cell u-sizeFull u-md-size1of<?php echo $NumMenu; ?> u-lg-size1of<?php echo $NumMenu; ?>">
						<div class="u-borderShadow-m u-borderRadius-l <?php echo $bgkcolorblocchi; ?>">
							<h3 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi; ?> u-padding-r-all"><?php echo $titoloDx; ?></h3>
							<ul class="Linklist Linklist Linklist--padded u-text-r-xs">
								<?php
								$Menus=wp_get_nav_menu_items( $MenuDx);
								$Livello=array(0);
								$IndexC=0;
								foreach ($Menus as $Menu) {
//									echo "<pre>";var_dump($Livello);echo "</pre>";
//									echo $IndexC." - ";
									if ($Livello[$IndexC]!=$Menu->menu_item_parent) {
										if (($IndexC>0 And $Livello[$IndexC-1]!=$Menu->menu_item_parent) OR $IndexC==0) {
											$IndexC++;
											$Livello[]=$Menu->menu_item_parent;
									?><ul> <?php
										} else {
											unset($Livello[$IndexC]);
											$Livello=$this->compact_index($Livello);
											$IndexC--;
									?> </ul> <?php
										}
									}
									$Stili="";
									if (isset($Menu->classes)) {
										foreach ($Menu->classes as $Classe) {
											if($Classe!="")
												$Stili.=$Classe.' ';
										}
										if($Stili!="")
											$Stili='class="'.$Stili.'"';
									}
									$Target="";
									if ($Menu->target!="") {
										$Target='target="'.$Menu->target.'"';
									}?>
									
										<li>
									<a href="<?php echo $Menu->url; ?>" <?php echo $Target;?> <?php echo $Stili;?>><?php echo$Menu->title; ?></a>
										</li>
										<?php
									}
									for ($i=$IndexC;$i>0;$i--) {
										echo "	</ul>";
									}?>
							</ul>
						</div>
					</div>
					<?php
				} ?>
				</div>
			</div>
		</div>
	</section>
</div>
<?php
}
private function compact_index($Array){
	$Appo=array();
	foreach ($Array as $Ele) {
		$Appo[]=$Ele;
	}
	return $Appo;
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
		'title'				  => 'Menu',
		'itawpmenu-titleSx'   => '',
		'itawpmenu-MenuSx'    => '',
		'itawpmenu-titleCx'   => '',
		'itawpmenu-MenuCx'    => '',
		'itawpmenu-titleDx'   => '',
		'itawpmenu-MenuDx'    => '',
		);
	}
	$titolo	=isset($instance['itawpmenu-title']) ? $instance['itawpmenu-title'] : 'Menu Scuola';
	$titoloSx	=isset($instance['itawpmenu-titleSx']) ? $instance['itawpmenu-titleSx'] : '';
	$MenuSx	=isset($instance['itawpmenu-MenuSx']) ? $instance['itawpmenu-MenuSx'] : '';
	$titoloCx	=isset($instance['itawpmenu-titleCx']) ? $instance['itawpmenu-titleCx'] : '';
	$MenuCx	=isset($instance['itawpmenu-MenuCx']) ? $instance['itawpmenu-MenuCx'] : '';
	$titoloDx	=isset($instance['itawpmenu-titleDx']) ? $instance['itawpmenu-titleDx'] : '';
	$MenuDx	=isset($instance['itawpmenu-MenuDx']) ? $instance['itawpmenu-MenuDx'] : '';
	$bgkcolor=isset($instance['itawpmenu-bgkcolor'])?$instance['itawpmenu-bgkcolor']:"";
	$bgkcolorblocchi=isset($instance['itawpmenu-bgkcolorblocchi'])?$instance['itawpmenu-bgkcolorblocchi']:"";
	$colortit=isset($instance['itawpmenu-colortit'])?$instance['itawpmenu-colortit']:"";
	$colortitblocchi=isset($instance['itawpmenu-colortitblocchi'])?$instance['itawpmenu-colortitblocchi']:"";
	$bgkcolortitblocchi=isset($instance['itawpmenu-bgkcolortitblocchi'])?$instance['itawpmenu-bgkcolortitblocchi']:"";
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
	// Get menus
	$menus = wp_get_nav_menus();
	if ( ! empty( $instance['error'] ) ) {
		echo '<p class="widget-error"><strong>' . __( 'Menu Error:' ) . '</strong> ' . $instance['error'] . '</p>';
	}
?>
<label for=<?php echo $this->get_field_id( "itawpmenu-title"); ?>>Titolo del Blocco</label>
<input class="widefat" id=<?php echo $this->get_field_id( "itawpmenu-title"); ?> name=<?php echo $this->get_field_name( 'itawpmenu-title' ); ?> type="text" value="<?php echo esc_attr( $titolo ); ?>" /></p>
<p style="text-align: center;font-weight: bold;">Blocco di Sinistra</p>
<p>
	<label for=<?php echo $this->get_field_id( "itawpmenu-titleSx"); ?>>Titolo</label>
	<input class="widefat" id=<?php echo $this->get_field_id( "itawpmenu-titleSx"); ?> name=<?php echo $this->get_field_name( 'itawpmenu-titleSx' ); ?> type="text" value="<?php echo esc_attr( $titoloSx ); ?>" /></p>
<p>
	<label for=<?php echo $this->get_field_id( "itawpmenu-MenuSx"); ?>>Menu</label>
	<select id="<?php echo $this->get_field_id( 'itawpmenu-MenuSx' ); ?>" name="<?php echo $this->get_field_name( 'itawpmenu-MenuSx' ); ?>">
		<option value="0"><?php _e( '&mdash; Select &mdash;' ); ?></option>
		<?php
		foreach ( $menus as $menu )
			: ?>
		<option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $MenuSx, $menu->term_id ); ?>>
			<?php echo esc_html( $menu->name ); ?>
		</option>
		<?php endforeach; ?>
	</select>
</p>
<p style="text-align: center;font-weight: bold;">Blocco Centrale</p>
<p>
	<label for=<?php echo $this->get_field_id( "itawpmenu-titleCx"); ?>>Titolo</label>
	<input class="widefat" id=<?php echo $this->get_field_id( "itawpmenu-titleCx"); ?> name=<?php echo $this->get_field_name( 'itawpmenu-titleCx' ); ?> type="text" value="<?php echo esc_attr( $titoloCx ); ?>" /></p>
<p>
	<label for=<?php echo $this->get_field_id( "itawpmenu-MenuCx"); ?>>Menu</label>
	<select id="<?php echo $this->get_field_id( 'itawpmenu-MenuCx' ); ?>" name="<?php echo $this->get_field_name( 'itawpmenu-MenuCx' ); ?>">
		<option value="0"><?php _e( '&mdash; Select &mdash;' ); ?></option>
		<?php
		foreach ( $menus as $menu )
			: ?>
		<option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $MenuCx, $menu->term_id ); ?>>
			<?php echo esc_html( $menu->name ); ?>
		</option>
		<?php endforeach; ?>
	</select>
</p>
<p style="text-align: center;font-weight: bold;">Blocco di Destra</p>
<p>
	<label for=<?php echo $this->get_field_id( "itawpmenu-titleDx"); ?>>Titolo</label>
	<input class="widefat" id=<?php echo $this->get_field_id( "itawpmenu-titleDx"); ?> name=<?php echo $this->get_field_name( 'itawpmenu-titleDx' ); ?> type="text" value="<?php echo esc_attr( $titoloDx ); ?>" /></p>
<p>
	<label for=<?php echo $this->get_field_id( "itawpmenu-MenuDx"); ?>>Menu</label>
	<select id="<?php echo $this->get_field_id( 'itawpmenu-MenuDx' ); ?>" name="<?php echo $this->get_field_name( 'itawpmenu-MenuDx' ); ?>">
		<option value="0"><?php _e( '&mdash; Select &mdash;' ); ?></option>
		<?php
		foreach ( $menus as $menu )
			: ?>
		<option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected($MenuDx, $menu->term_id ); ?>>
			<?php echo esc_html( $menu->name ); ?>
		</option>
		<?php endforeach; ?>
	</select>
</p>
<label for="<?php echo $this->get_field_id( 'itawpmenu-bgkcolor' ); ?>">Colore di sfondo della sezione:</label><br />
<select id="<?php echo $this->get_field_id( 'itawpmenu-bgkcolor' ); ?>" name="<?php echo $this->get_field_name( 'itawpmenu-bgkcolor' ); ?>">
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
	<label for="<?php echo $this->get_field_id( 'itawpmenu-colortit' ); ?>">Colore del titolo della sezione:</label><br />
	<select id="<?php echo $this->get_field_id( 'itawpmenu-colortit' ); ?>" name="<?php echo $this->get_field_name( 'itawpmenu-colortit' ); ?>">
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
	<label for="<?php echo $this->get_field_id( 'itawpmenu-bgkcolorblocchi' ); ?>">Colore di sfondo dei blocchi:</label><br />
	<select id="<?php echo $this->get_field_id( 'itawpmenu-bgkcolorblocchi' ); ?>" name="<?php echo $this->get_field_name( 'itawpmenu-bgkcolorblocchi' ); ?>">
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
	<label for="<?php echo $this->get_field_id( 'itawpmenu-colortitblocchi' ); ?>">Colore del titolo dei blocchi:</label><br />
	<select id="<?php echo $this->get_field_id( 'itawpmenu-colortitblocchi' ); ?>" name="<?php echo $this->get_field_name( 'itawpmenu-colortitblocchi' ); ?>">
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
	<label for="<?php echo $this->get_field_id( 'itawpmenu-bgkcolortitblocchi' ); ?>">Colore di sfondo del titolo dei blocchi:</label><br />
	<select id="<?php echo $this->get_field_id( 'itawpmenu-bgkcolortitblocchi' ); ?>" name="<?php echo $this->get_field_name( 'itawpmenu-bgkcolortitblocchi' ); ?>">
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
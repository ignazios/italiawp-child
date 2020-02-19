<?php
/****************************************************************************
Widget Galleria
Titolo:	($title) Testo che viene visualizzato in Testa all'elenco degli articoli estratti
Categoria:  ($categoria) Id della categoria dei link di cui creare la galleria
*/

class GalleriaLinks extends WP_Widget
{

	function __construct()
	{
		parent::__construct (false, 'ItaliaWP Galleria Link',
		array('classname' => 'GalleriaLinks',
		'description' => 'Blocco Galleria serve per creare una galleria di link con Immagine, descrizione e link'));
	}

	function widget( $args, $instance )
	{
		extract($args);
		//        	var_dump($args);
		$title = apply_filters('widget_title', $instance['titolo']);
		$idW=str_replace(" ","_",strtolower($instance['titolo']));
		$categoria=$instance['categoria'];
		$MD=new Mobile_Detect();
		if ($MD->isMobile()) {
			$NC=1;
		} else {
			$NC=4;
		}
?>
<div class="u-layout-wide u-layoutCenter u-layout-withGutter u-padding-r-top u-padding-bottom-xs" id="Link">
	<section id="Servizi">
	<h2 class="u-text-h2 widget-title"><?php echo $title; ?></h2>
	<div class="col-xs-12">
		<div class="carousel slide" id="<?php echo $idW; ?>">
			<div class="carousel-inner">
				<?php
				$Links=get_bookmarks("category=".$categoria);
				$Num=0;
				$Primo=" active";
				foreach ($Links as $Link) {
					if ($Num==0) {
				?>
				<div class="item<?php echo $Primo; ?>">
					<ul class="thumbnails">
						<?php				}
					$Primo="";
					$Num++;
					$D_SE=parse_url($Link->link_url);
					$D_Me=parse_url(get_home_url());
					if ((!isset($D_SE) or count($D_SE)>0) And 
						($D_SE["scheme"]==$D_Me["scheme"] and
					$D_SE["host"]==$D_Me["host"]) or
					empty($D_SE['host'])) {
						$StileNoExt='';
					} else {
						$StileNoExt='class="share-icon"';			}
						?>
						<li class="col-sm-25 u-borderShadow-xs u-border-all-xxs u-padding-all-m">
							<div class="casing">
								<div class="noBorder thumbnail" style="height:120px;">
									<a href="<?php echo $Link->link_url.'" '.$StileNoExt; ?> target="<?php echo $Link->link_target; ?>" alt="link a <?php echo $Link->link_name; ?>" title="Link a <?php echo $Link->link_name; ?>">
										<img src="<?php echo $Link->link_image; ?>" alt="Logo: <?php echo $Link->link_name; ?>" >
									</a>
								</div>
								<div class="caption" style="height:180px;">
									<h3>
										<a href="<?php echo $Link->link_url.'" '.$StileNoExt; ?> alt="Logo: <?php echo $Link->link_name; ?>" title="Logo: <?php echo $Link->link_name; ?>"><?php echo $Link->link_name; ?></a></h3>
									<p class="riassunto">
										<a href="<?php echo $Link->link_url.'" '.$StileNoExt; ?> target="<?php echo $Link->link_target; ?>" alt="link a <?php echo $Link->link_name; ?>" title="Link a <?php echo $Link->link_name; ?>"><?php echo $Link->link_description; ?></a></p>
								</div>
							</div>
						</li>
						<?php
						if ($Num==$NC) {
							$Num=0;
						?>
					</ul>
				</div>
				<?php
			}
		}
		if ($Num!=$NC) {
				?>
				</ul>
			</div>
			<?php	} ?>
		</div>
		<nav>
			<ul class="control-box pager">
				<li class="left">
					<a data-slide="prev" href="#<?php echo $idW; ?>" class="arrowStil" title="Galleria Link vai alla pagina precedente">
						<span class="glyphicon glyphicon-chevron-left"></span></a>
				</li>
				<li class="right">
					<a data-slide="next" href="#<?php echo $idW; ?>" class="arrowStil" title="Galleria Link vai alla pagina precedente">
						<span class="glyphicon glyphicon-chevron-right"></span></a>
				</li>
			</ul>
		</nav>
	</div><!-- /#mioCarosello -->
</div>
</section>
</div>
<div style="clear: both;"></div>
<?php
}

function update( $new_instance, $old_instance )
{

	$instance = $old_instance;
	$instance['titolo'] = strip_tags($new_instance['titolo']);
	$instance['categoria'] = strip_tags($new_instance['categoria']);
	return $instance;
}

function form( $instance )
{

	$instance = wp_parse_args( (array) $instance, array( ) );
	$titolo = ! empty( $instance['titolo'] ) ? $instance['titolo'] : esc_html__( 'Link', 'text_domain' );
	$args=array('taxonomy' => 'link_category',
	'hide_empty' => false);
	$CatsLink = get_terms($args);
	$Elenco="<select id=\"".$this->get_field_id( 'categoria' )."\" name=\"".$this->get_field_name( 'categoria' )."\">
				<option value=\"\" >--------</option>";
	foreach ( $CatsLink as $CatLink ) {
		$Elenco.= "<option value=\"".$CatLink->term_id."\"";
		if ($CatLink->term_id==isset($instance["categoria"])?$instance["categoria"]:"") {
			$Elenco.= " selected ";
		}
		$Elenco.= " >".$CatLink->name."</option>";
	}
	$Elenco.="</select>";
?>
<p>
	<label for="<?php echo $this->get_field_id( 'titolo' ); ?>">Titolo Sezione:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'titolo' ); ?>" name="<?php echo $this->get_field_name( 'titolo' ); ?>" value="<?php echo esc_attr( $titolo ); ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'categoria' ); ?>">Categoria Link:</label><br />
	<?php
	echo $Elenco;
	?>
</p>
<?php
}
}	
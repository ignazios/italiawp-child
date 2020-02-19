<?php
/****************************************************************************
Widget Blocchi
Titolo:	($title) Testo che viene visualizzato in Testa all'elenco degli articoli estratti
Blocchi:	($blocchi) Array di max 4 elementi di (Immagine,Testo,Link)
*/

class Blocchi extends WP_Widget
{

	function __construct()
	{
		parent::__construct( false, 'ItaliaWP Blocchi',
		array('classname' => 'Blocchi',
		'description' => 'Blocco Grafica-Titolo con Link max 4 elementi') );
	}

	function widget( $args, $instance )
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['titolo']);
		$bgkcolor=isset($instance['bgkcolor'])?$instance['bgkcolor']:"";
		$bgkcolorblocchi=isset($instance['bgkcolorblocchi'])?$instance['bgkcolorblocchi']:"";
		$colortit=isset($instance['colortit'])?$instance['colortit']:"";
		$colortitblocchi=isset($instance['colortitblocchi'])?$instance['colortitblocchi']:"";
		$Blocchi=unserialize($instance['blocchi']);
		$nBlocchi=0;
?>
<div class="<?php echo $instance['bgkcolor']; ?>" >
<div class="u-layout-wide u-layoutCenter u-layout-withGutter <?php echo $instance['bgkcolor']; ?>">
<?php
foreach ($Blocchi as $Index=>$Valori) {
	if ($Valori['Link']=="")
		continue;
	$D_SE=parse_url($Valori['Link']);
	$D_Me=parse_url(get_home_url());
	if ( (isset($D_SE) And count($D_SE)>0) And
		 ($D_SE["scheme"]==$D_Me["scheme"] and
	$D_SE["host"]==$D_Me["host"]) or
	empty($D_SE['host'])) {
		$StileM="width:100%;";
		$StileA="";
		$StileAC='';
	} else {
		$StileM="width:90%;";
		$StileA='style="font-size: 1.9em;font-weight: bold;text-decoration:none!important;"';
		$StileAC='class="'.$colortitblocchi.'" ';
	}
	if ($Valori['Link'] !="" And $Valori['Img']!="") {
		$nBlocchi++;
		$indice='Blocco'.$Index;
		if ($Valori['NF'])
			$destinazione='target="_blank"';
		else
			$destinazione="";
		$$indice='
	<div class="Grid-cell u-sizeFull u-md-size1of2 u-lg-size1of4">
		<div class="'.$bgkcolorblocchi.' u-margin-bottom-l u-borderRadius-m u-padding-all-m">
			<a href="'.$Valori['Link'].'" '.$StileAC.' '.$StileA.' '.$destinazione.'><img src="'.$Valori['Img'].'" alt="'.$Valori['Alt'].'" style="'.$StileM.'"/></a><br />
			<h3 id="'.str_replace(" ","_",strtolower($Valori['Titolo'])).'" class="'.$colortitblocchi.' ServiziTitle u-layout-centerLeft u-text-r-s">'.$Valori['Titolo'].'</h3>
		</div>
    </div>';
	}
}
if ($nBlocchi==0)
	return;
if ( $title ) {
	$before_title=str_replace("<h3 class=\"","<h2 class=\"u-text-h2 ",$before_title);
	echo $before_widget .str_replace("class=\"","class=\"". $colortit." ",$before_title) . $title . $after_title;
}
echo "<div class=\"Grid Grid--withGutter u-padding-left-l u-padding-right-l u-padding-bottom-xs u-padding-top-xs\">";
for ($i=0;$i<5;$i++) {
	$indice='Blocco'.$i;
	echo isset($$indice)?$$indice:"";
}
echo "</div>
	</div>
</div>";
}

function update( $new_instance, $old_instance )
{

	$instance = $old_instance;
	$instance['titolo'] = strip_tags($new_instance['titolo']);
	$Blocchi=array();
	for ($i=1;$i<5;$i++) {
		$Blocchi[]=array("Img"=>isset($new_instance["Img$i"])?$new_instance["Img$i"]:"",
		"Link"=>isset($new_instance["Link$i"])?$new_instance["Link$i"]:"",
		"Titolo"=>isset($new_instance["Titolo$i"])?$new_instance["Titolo$i"]:"",
		"Alt"=>isset($new_instance["Alt$i"])?$new_instance["Alt$i"]:"",
		"NF"=>isset($new_instance["NF$i"])?$new_instance["NF$i"]:"");
	}
	$instance['blocchi'] = strip_tags(serialize($Blocchi));
	$instance['bgkcolor']=strip_tags($new_instance['bgkcolor']);
	$instance['bgkcolorblocchi']=strip_tags($new_instance['bgkcolorblocchi']);
	$instance['colortit']=strip_tags($new_instance['colortit']);
	$instance['colortitblocchi']=strip_tags($new_instance['colortitblocchi']);
	return $instance;
}

function form( $instance )
{
	$instance = wp_parse_args( (array) $instance, array( ) );
	$titolo = ! empty( $instance['titolo'] ) ? $instance['titolo'] : esc_html__( 'Servizi', 'text_domain' );
	if (isset($instance['blocchi'])) {
		$Blocchi=unserialize($instance['blocchi']);
	} else {
		$Blocchi=array( array("Img"=>"","Link"=>"","Titolo"=>"","Alt"=>""),
		array("Img"=>"","Link"=>"","Titolo"=>"","Alt"=>""),
		array("Img"=>"","Link"=>"","Titolo"=>"","Alt"=>""),
		array("Img"=>"","Link"=>"","Titolo"=>"","Alt"=>""));
	}
	$bgkcolor=isset($instance['bgkcolor'])?$instance['bgkcolor']:"";
	$bgkcolorblocchi=isset($instance['bgkcolorblocchi'])?$instance['bgkcolorblocchi']:"";
	$colortit=isset($instance['colortit'])?$instance['colortit']:"";
	$colortitblocchi=isset($instance['colortitblocchi'])?$instance['colortitblocchi']:"";
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
<div class="Servizi">
	<h3>Blocco 1</h3>
	<label for="<?php echo $this->get_field_id( 'Img1' ); ?>">Immagine:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Img1' ); ?>" name="<?php echo $this->get_field_name( 'Img1' ); ?>" value="<?php echo esc_attr($Blocchi[0]['Img']); ?>" />
	<br />
	<label for="<?php echo $this->get_field_id( 'Link1' ); ?>">Link:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Link1' ); ?>" name="<?php echo $this->get_field_name( 'Link1' ); ?>" value="<?php echo esc_attr($Blocchi[0]['Link']); ?>" />
	<br />
	<label for="<?php echo $this->get_field_id( 'Titolo1' ); ?>">Titolo:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Titolo1' ); ?>" name="<?php echo $this->get_field_name( 'Titolo1' ); ?>" value="<?php echo esc_attr($Blocchi[0]['Titolo']); ?>" />
	<br />
	<label for="<?php echo $this->get_field_id( 'Alt1' ); ?>">Testo alternativo:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Alt1' ); ?>" name="<?php echo $this->get_field_name( 'Alt1' ); ?>" value="<?php echo esc_attr($Blocchi[0]['Alt']); ?>" />
	<label for="<?php echo $this->get_field_id( 'NF1' ); ?>">Apertura link in una nuova scheda:</label>
	<input type="checkbox" id="<?php echo $this->get_field_id('NF1'); ?>" name="<?php echo $this->get_field_name('NF1'); ?>" value="1" <?php echo ($Blocchi[0]['NF'] == '1') ? 'checked="checked"':''; ?>/>
</div>

<div class="Servizi">
	<h3>Blocco 2</h3>
	<label for="<?php echo $this->get_field_id( 'Img2' ); ?>">Immagine:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Img2' ); ?>" name="<?php echo $this->get_field_name( 'Img2' ); ?>" value="<?php echo esc_attr($Blocchi[1]['Img']); ?>" />
	<br />
	<label for="<?php echo $this->get_field_id( 'Link2' ); ?>">Link:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Link2' ); ?>" name="<?php echo $this->get_field_name( 'Link2' ); ?>" value="<?php echo esc_attr($Blocchi[1]['Link']); ?>" />
	<br />
	<label for="<?php echo $this->get_field_id( 'Titolo2' ); ?>">Titolo:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Titolo2' ); ?>" name="<?php echo $this->get_field_name( 'Titolo2' ); ?>" value="<?php echo esc_attr($Blocchi[1]['Titolo']); ?>" />
	<br />
	<label for="<?php echo $this->get_field_id( 'Alt2' ); ?>">Testo alternativo:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Alt2' ); ?>" name="<?php echo $this->get_field_name( 'Alt2' ); ?>" value="<?php echo esc_attr($Blocchi[1]['Alt']); ?>" />
	<label for="<?php echo $this->get_field_id( 'NF2' ); ?>">Apertura link in una nuova scheda:</label>
	<input type="checkbox" id="<?php echo $this->get_field_id('NF2'); ?>" name="<?php echo $this->get_field_name('NF2'); ?>" value="1" <?php echo ($Blocchi[1]['NF'] == '1') ? 'checked="checked"':''; ?>/>
</div>

<div class="Servizi">
	<h3>Blocco 3</h3>
	<label for="<?php echo $this->get_field_id( 'Img3' ); ?>">Immagine:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Img3' ); ?>" name="<?php echo $this->get_field_name( 'Img3' ); ?>" value="<?php echo esc_attr($Blocchi[2]['Img']); ?>" />
	<br />
	<label for="<?php echo $this->get_field_id( 'Link3' ); ?>">Link:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Link3' ); ?>" name="<?php echo $this->get_field_name( 'Link3' ); ?>" value="<?php echo esc_attr($Blocchi[2]['Link']); ?>" />
	<br />
	<label for="<?php echo $this->get_field_id( 'Titolo3' ); ?>">Titolo:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Titolo3' ); ?>" name="<?php echo $this->get_field_name( 'Titolo3' ); ?>" value="<?php echo esc_attr($Blocchi[2]['Titolo']); ?>" />
	<br />
	<label for="<?php echo $this->get_field_id( 'Alt3' ); ?>">Testo alternativo:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Alt3' ); ?>" name="<?php echo $this->get_field_name( 'Alt3' ); ?>" value="<?php echo esc_attr($Blocchi[2]['Alt']); ?>" />
	<label for="<?php echo $this->get_field_id( 'NF3' ); ?>">Apertura link in una nuova scheda:</label>
	<input type="checkbox" id="<?php echo $this->get_field_id('NF3'); ?>" name="<?php echo $this->get_field_name('NF3'); ?>" value="1" <?php echo ($Blocchi[2]['NF'] == '1') ? 'checked="checked"':''; ?>/>
</div>

<div class="Servizi">
	<h3>Blocco 4</h3>
	<label for="<?php echo $this->get_field_id( 'Img4' ); ?>">Immagine:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Img4' ); ?>" name="<?php echo $this->get_field_name( 'Img4' ); ?>" value="<?php echo esc_attr($Blocchi[3]['Img']); ?>" />
	<br />
	<label for="<?php echo $this->get_field_id( 'Link4' ); ?>">Link:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Link4' ); ?>" name="<?php echo $this->get_field_name( 'Link4' ); ?>" value="<?php echo esc_attr($Blocchi[3]['Link']); ?>" />
	<br />
	<label for="<?php echo $this->get_field_id( 'Titolo4' ); ?>">Titolo:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Titolo4' ); ?>" name="<?php echo $this->get_field_name( 'Titolo4' ); ?>" value="<?php echo esc_attr($Blocchi[3]['Titolo']); ?>" />
	<br />
	<label for="<?php echo $this->get_field_id( 'Alt4' ); ?>">Testo alternativo:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Alt4' ); ?>" name="<?php echo $this->get_field_name( 'Alt4' ); ?>" value="<?php echo esc_attr($Blocchi[3]['Alt']); ?>" />
	<label for="<?php echo $this->get_field_id( 'NF4' ); ?>">Apertura link in una nuova scheda:</label>
	<input type="checkbox" id="<?php echo $this->get_field_id('NF4'); ?>" name="<?php echo $this->get_field_name('NF4'); ?>" value="1" <?php echo ($Blocchi[3]['NF'] == '1') ? 'checked="checked"':''; ?>/>
</div>
<?php
}
}
<?php
/****************************************************************************
 Widget Galleria
	   Titolo:	($title) Testo che viene visualizzato in Testa all'elenco degli articoli estratti
	Categoria:  ($categoria) Id della categoria dei link di cui creare la galleria
*/

class GalleriaLinks extends WP_Widget {

        function __construct() {
			parent::__construct (false, 'ItaliaWP Galleria Link',
				array('classname' => 'GalleriaLinks',
				    'description' => 'Blocco Galleria serve per creare una galleria di link con Immagine, descrizione e link'));
        }

        function widget( $args, $instance ) {
        	extract($args);
//        	var_dump($args);
            $title = apply_filters('widget_title', $instance['titolo']);
            $idW=str_replace(" ","_",strtolower($instance['titolo']));
            $categoria=$instance['categoria'];
?>
<div class="u-layout-wide u-layoutCenter u-layout-withGutter u-padding-r-top u-padding-bottom-xs" id="Link">
	<section id="Servizi">
  		<h2 class="u-text-h2 widget-title"><?php echo $title;?></h2>
			<div class="col-xs-12">
				<div class="carousel slide" id="<?php echo $idW;?>">
					<div class="carousel-inner">
<?php 
			$Links=get_bookmarks("category=".$categoria);
			$Num=0;
			$Primo=" active";
			foreach($Links as $Link){
				if ($Num==0){
?>								<div class="item<?php echo $Primo;?>">
								<ul class="thumbnails">
<?php				}
				$Primo="";
				$Num++;
				$D_SE=parse_url($Link->link_url);
				$D_Me=parse_url(get_home_url());
				if( ($D_SE["scheme"]==$D_Me["scheme"] and
				    $D_SE["host"]==$D_Me["host"]) or
				    empty($D_SE['host'])){
				    $StileNoExt='';
				}else{
					$StileNoExt='class="share-icon"';			}
?>			
									<li class="col-sm-3 u-borderShadow-xs u-border-all-xxs u-padding-all-m u-margin-all-m ">
										<div class="casing">
											<div class="noBorder thumbnail" style="height:120px;">
												<a href="<?php echo $Link->link_url.'" '.$StileNoExt;?>><img src="<?php echo $Link->link_image;?>" alt="" <?php echo $StileM;?>"></a>	
											</div>
											<div class="caption" style="height:180px;">
												<h3><a href="<?php echo $Link->link_url.'" '.$StileNoExt;?>><?php echo $Link->link_name;?></a></h3>
												<p class="riassunto"><a href="<?php echo $Link->link_url.'" '.$StileNoExt;?>><?php echo $Link->link_description;?></a></p>
											</div>
										</div>
									</li>
<?php 	if($Num==3){
			$Num=0;
?>
								</ul>
							</div>
<?php							
		}					
} 
	 	if($Num!=3){
?>
								</ul>
							</div>
<?php	} ?>
					</div>
				   <nav>
						<ul class="control-box pager">
							<li class="left">
								<a data-slide="prev" href="#<?php echo $idW;?>" class="arrowStil"><i class="glyphicon glyphicon-chevron-left"></i></a>
							</li>
							<li class="right">
								<a data-slide="next" href="#<?php echo $idW;?>" class="arrowStil"><i class="glyphicon glyphicon-chevron-right"></i></a>
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

        function update( $new_instance, $old_instance ) {

            $instance = $old_instance;
            $instance['titolo'] = strip_tags($new_instance['titolo']);
	        $instance['categoria'] = strip_tags($new_instance['categoria']);
            return $instance;
        }

        function form( $instance ) {

           	$instance = wp_parse_args( (array) $instance, array( ) ); 
        	$titolo = ! empty( $instance['titolo'] ) ? $instance['titolo'] : esc_html__( 'Link', 'text_domain' );
        	$args=array('taxonomy' => 'link_category',
			    		'hide_empty' => false);
			$CatsLink = get_terms($args);
			$Elenco="<select id=\"".$this->get_field_id( 'categoria' )."\" name=\"".$this->get_field_name( 'categoria' )."\">
				<option value=\"\" >--------</option>";
			foreach ( $CatsLink as $CatLink ) {
				$Elenco.= "<option value=\"".$CatLink->term_id."\"";
				if($CatLink->term_id==isset($instance["categoria"])?$instance["categoria"]:""){
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
/****************************************************************************
 Widget Blocchi
	   Titolo:	($title) Testo che viene visualizzato in Testa all'elenco degli articoli estratti
	  Blocchi:	($blocchi) Array di max 4 elementi di (Immagine,Testo,Link)
*/

class Blocchi extends WP_Widget {

        function __construct() {
			parent::__construct( false, 'ItaliaWP Blocchi',
				array('classname' => 'Blocchi',
				    'description' => 'Blocco Grafica-Titolo con Link max 4 elementi') );
        }

        function widget( $args, $instance ) {
        	extract($args);
            $title = apply_filters('widget_title', $instance['titolo']);
            $bgkcolor=isset($instance['bgkcolor'])?$instance['bgkcolor']:"";
            $bgkcolorblocchi=isset($instance['bgkcolorblocchi'])?$instance['bgkcolorblocchi']:"";
            $colortit=isset($instance['colortit'])?$instance['colortit']:"";
            $colortitblocchi=isset($instance['colortitblocchi'])?$instance['colortitblocchi']:"";
 			$Blocchi=unserialize($instance['blocchi']);
 			$nBlocchi=0;
?>
	<div class="<?php echo $instance['bgkcolor'];?>" >
      <div class="u-layout-wide u-layoutCenter u-layout-withGutter <?php echo $instance['bgkcolor'];?>">
 <?php
			foreach($Blocchi as $Index=>$Valori){
				$D_SE=parse_url($Valori['Link']);
				$D_Me=parse_url(get_home_url());
				if( ($D_SE["scheme"]==$D_Me["scheme"] and
				    $D_SE["host"]==$D_Me["host"]) or
				    empty($D_SE['host'])){
				    $StileM="width:100%;";	
				    $StileA="";
				    $StileAC='';
				}else{
					$StileM="width:90%;";
					$StileA='style="font-size: 1.9em;font-weight: bold;text-decoration:none!important;"';
					$StileAC='class="'.$colortitblocchi.'" ';
				}
				if($Valori['Link'] !="" And $Valori['Img']!=""){
					$nBlocchi++;
					$indice='Blocco'.$Index;
					$$indice='	
	<div class="Grid-cell u-sizeFull u-md-size1of2 u-lg-size1of4">
		<div class="'.$bgkcolorblocchi.' u-margin-bottom-l u-borderRadius-m u-padding-all-m">
			<a href="'.$Valori['Link'].'" '.$StileAC.' '.$StileA.'><img src="'.$Valori['Img'].'" style="'.$StileM.'"/></a><br />
			<h2 id="'.str_replace(" ","_",strtolower($Valori['Titolo'])).'" class="'.$colortitblocchi.' ServiziTitle u-layout-centerLeft u-text-r-s">'.$Valori['Titolo'].'</h2>
		</div>
    </div>';
				}
			}
			if ($nBlocchi==0) return;
            if ( $title ) {
            	$before_title=str_replace("<h2 class=\"","<h2 class=\"u-text-h2 ",$before_title);
                echo $before_widget .str_replace("class=\"","class=\"". $colortit." ",$before_title) . $title . $after_title;
            }
			echo "<div class=\"Grid Grid--withGutter u-padding-left-l u-padding-right-l u-padding-bottom-xs u-padding-top-xs\">";
            for($i=0;$i<5;$i++){
            	$indice='Blocco'.$i;
				echo isset($$indice)?$$indice:"";
			}
			echo "</div>
	</div>
</div>";
        }

        function update( $new_instance, $old_instance ) {

            $instance = $old_instance;
            $instance['titolo'] = strip_tags($new_instance['titolo']);
            $Blocchi=array();
            for($i=1;$i<5;$i++){
			   $Blocchi[]=array("Img"=>isset($new_instance["Img$i"])?$new_instance["Img$i"]:"",
			                   "Link"=>isset($new_instance["Link$i"])?$new_instance["Link$i"]:"",
			                 "Titolo"=>isset($new_instance["Titolo$i"])?$new_instance["Titolo$i"]:"");
			}
            $instance['blocchi'] = strip_tags(serialize($Blocchi));
            $instance['bgkcolor']=strip_tags($new_instance['bgkcolor']);
            $instance['bgkcolorblocchi']=strip_tags($new_instance['bgkcolorblocchi']);
            $instance['colortit']=strip_tags($new_instance['colortit']);
            $instance['colortitblocchi']=strip_tags($new_instance['colortitblocchi']);   
            return $instance;
        }

        function form( $instance ) {
            $instance = wp_parse_args( (array) $instance, array( ) ); 
            $titolo = ! empty( $instance['titolo'] ) ? $instance['titolo'] : esc_html__( 'Servizi', 'text_domain' );
            if(isset($instance['blocchi'])){
            	$Blocchi=unserialize($instance['blocchi']);
			}else{
				$Blocchi=array( array("Img"=>"","Link"=>"","Titolo"=>""),
								array("Img"=>"","Link"=>"","Titolo"=>""),
								array("Img"=>"","Link"=>"","Titolo"=>""),
								array("Img"=>"","Link"=>"","Titolo"=>""));
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
		foreach($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo){
			echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.'"';
			if($KColoreSfondo==$bgkcolor){
				echo " selected ";
			}
			echo'> '.$KColoreSfondo.' </option>';
		}
?>				</select><span style="background-color:<?php echo ($bgkcolor!=""?$ColoriSfondo[$bgkcolor]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>
			</p>
            <p>
        		<label for="<?php echo $this->get_field_id( 'colortit' ); ?>">Colore del titolo della sezione:</label><br />
				<select id="<?php echo $this->get_field_id( 'colortit' ); ?>" name="<?php echo $this->get_field_name( 'colortit' ); ?>">
<?php
		foreach($ColoriTesto as $KColoreTesto=>$ColoreTesto){
			echo '<option value="'.$KColoreTesto.'" style="color: '.$ColoreTesto.'"';
			if($KColoreTesto==$colortit){
				echo " selected ";
			}
			echo'> '.$KColoreTesto.' </option>';
		}
?>				</select><span style="color:<?php echo ($colortit!=""?$ColoriTesto[$colortit]:"");?>;">&ensp;&ensp;Colore del testo</span>
			</p>
            <p>
        		<label for="<?php echo $this->get_field_id( 'bgkcolorblocchi' ); ?>">Colore di sfondo dei blocchi:</label><br />
				<select id="<?php echo $this->get_field_id( 'bgkcolorblocchi' ); ?>" name="<?php echo $this->get_field_name( 'bgkcolorblocchi' ); ?>">
<?php
		foreach($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo){
			echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.';"';
			if($KColoreSfondo==$bgkcolorblocchi){
				echo " selected ";
			}
			echo'> '.$KColoreSfondo.' </option>';
		}
?>				</select><span style="background-color:<?php echo ($bgkcolorblocchi!=""?$ColoriSfondo[$bgkcolorblocchi]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>	
			</p>			
            <p>
        		<label for="<?php echo $this->get_field_id( 'colortitblocchi' ); ?>">Colore del titolo dei blocchi:</label><br />
				<select id="<?php echo $this->get_field_id( 'colortitblocchi' ); ?>" name="<?php echo $this->get_field_name( 'colortitblocchi' ); ?>">
<?php
		foreach($ColoriTesto as $KColoreTesto=>$ColoreTesto){
			echo '<option value="'.$KColoreTesto.'" style="color: '.$ColoreTesto.'"';
			if($KColoreTesto==$colortitblocchi){
				echo " selected ";
			}
			echo'> '.$KColoreTesto.' </option>';
		}
?>				</select><span style="color:<?php echo ($colortitblocchi?$ColoriTesto[$colortitblocchi]:"");?>;">&ensp;&ensp;Colore del testo</span>
			</p>
     <div class="Servizi">
     	<h3>Blocco 1</h3>
        <label for="<?php echo $this->get_field_id( 'Img1' ); ?>">Immagine:</label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Img1' );?>" name="<?php echo $this->get_field_name( 'Img1' );?>" value="<?php echo esc_attr($Blocchi[0]['Img']); ?>" />
     <br />
        <label for="<?php echo $this->get_field_id( 'Link1' );?>">Link:</label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Link1' );?>" name="<?php echo $this->get_field_name( 'Link1' );?>" value="<?php echo esc_attr($Blocchi[0]['Link']); ?>" />
     <br />
        <label for="<?php echo $this->get_field_id( 'Titolo1' );?>">Titolo:</label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Titolo1' );?>" name="<?php echo $this->get_field_name( 'Titolo1' );?>" value="<?php echo esc_attr($Blocchi[0]['Titolo']); ?>" />
     </div>

     <div class="Servizi">
     	<h3>Blocco 2</h3>
        <label for="<?php echo $this->get_field_id( 'Img2' ); ?>">Immagine:</label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Img2' );?>" name="<?php echo $this->get_field_name( 'Img2' );?>" value="<?php echo esc_attr($Blocchi[1]['Img']); ?>" />
     <br />
        <label for="<?php echo $this->get_field_id( 'Link2' );?>">Link:</label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Link2' );?>" name="<?php echo $this->get_field_name( 'Link2' );?>" value="<?php echo esc_attr($Blocchi[1]['Link']); ?>" />
     <br />
        <label for="<?php echo $this->get_field_id( 'Titolo2' );?>">Titolo:</label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Titolo2' );?>" name="<?php echo $this->get_field_name( 'Titolo2' );?>" value="<?php echo esc_attr($Blocchi[1]['Titolo']); ?>" />
     </div>

     <div class="Servizi">
     	<h3>Blocco 3</h3>
        <label for="<?php echo $this->get_field_id( 'Img3' ); ?>">Immagine:</label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Img3' );?>" name="<?php echo $this->get_field_name( 'Img3' );?>" value="<?php echo esc_attr($Blocchi[2]['Img']); ?>" />
     <br />
        <label for="<?php echo $this->get_field_id( 'Link3' );?>">Link:</label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Link3' );?>" name="<?php echo $this->get_field_name( 'Link3' );?>" value="<?php echo esc_attr($Blocchi[2]['Link']); ?>" />
     <br />
        <label for="<?php echo $this->get_field_id( 'Titolo3' );?>">Titolo:</label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Titolo3' );?>" name="<?php echo $this->get_field_name( 'Titolo3' );?>" value="<?php echo esc_attr($Blocchi[2]['Titolo']); ?>" />
     </div>
 
     <div class="Servizi">
     	<h3>Blocco 4</h3>
        <label for="<?php echo $this->get_field_id( 'Img4' ); ?>">Immagine:</label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Img4' );?>" name="<?php echo $this->get_field_name( 'Img4' );?>" value="<?php echo esc_attr($Blocchi[3]['Img']); ?>" />
     <br />
        <label for="<?php echo $this->get_field_id( 'Link4' );?>">Link:</label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Link4' );?>" name="<?php echo $this->get_field_name( 'Link4' );?>" value="<?php echo esc_attr($Blocchi[3]['Link']); ?>" />
     <br />
        <label for="<?php echo $this->get_field_id( 'Titolo4' );?>">Titolo:</label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Titolo4' );?>" name="<?php echo $this->get_field_name( 'Titolo4' );?>" value="<?php echo esc_attr($Blocchi[3]['Titolo']); ?>" />
     </div>
      <?php
        }
    }
/****************************************************************************
 Widget Trasparenza
	   Titolo:	($title) Testo che viene visualizzato in Testa all'elenco degli articoli estratti
	  Pagina Amministrazione trasparente:	($urlAT)  Link alla pagina amministrazione trasparente
	           Pagina Albo Atti Correnti:	($urlAAC) Link alla pagina dell'albo atti correnti
	            Pagina Albo Atti Scaduti:	($urlAAS) Link alla pagina dell'albo atti storico
	  			   Pagina Accesso Civico:	($urlAC)  Link alla pagina dell'accesso civico
	  			              Pagina URP:	($urlURP) Link alla pagina dell'Ufficio relazioni con il pubblico
*/

class Trasparenza extends WP_Widget {

        function __construct() {
			parent::__construct( false, 'ItaliaWP Trasparenza',
				array('classname' => 'Trasparenza',
				    'description' => 'Blocco Trasparenza Amministrazione Trasparente - Albo Pretorio - Accesso Civico - Ufficio Relazioni Con il Pubblico') );
        }

        function widget( $args, $instance ) {
        	extract($args);
            $title = apply_filters('widget_title', $instance['titolo']);
            $Is_AT=(isset($instance['AT']) And $instance['AT']!="");
            $Link_AT=(isset($instance['LAT']) And $instance['LAT']!="");
            $Is_AAC=(isset($instance['AAC']) And $instance['AAC']!="");
            $Link_AP=(isset($instance['LAP']) And $instance['LAP']!="");
            $Is_AAS=(isset($instance['AAS']) And $instance['AAS']!="");
            $Is_AC=(isset($instance['AC']) And $instance['AC']!="");
            $Is_URP=(isset($instance['URP']) And $instance['URP']!="");
            if( !$Is_AT And !$Link_AT And !$Link_AP And !$Is_AAC AND !$Is_AAS AND !$Is_AC AND !$Is_URP){
	            	return;
			}
?>
	<div>
	<div class="u-layout-wide u-layoutCenter u-layout-withGutter u-padding-r-top u-padding-bottom-xs">
<?php
           if ( $title ) {
           	 $before_title=str_replace("<h2 class=\"","<h2 id=\"HomeTrasparenza\" class=\"u-text-h2 ",$before_title);
                echo $before_widget .$before_title . $title . $after_title;
            }
?>
   		<div class="Grid Grid--withGutter u-padding-r-top u-padding-r-bottom u-text-r-s">
<?php
			if( isset($instance['AT']) And $instance['AT']!=""){
            	echo '
            <div class="Grid-cell u-md-size1of3 u-lg-size1of3 u-flex">
                <div class="Entrypoint-item u-sizeFill u-background-50">
                    <p><a class="u-textClean u-text-h3 u-color-white" href="'.$instance['AT'].'">Amministrazione trasparente</a></p>
                </div>
            </div>';
			}
			if( isset($instance['LAT']) And $instance['LAT']!=""){
            	echo '
            <div class="Grid-cell u-md-size1of3 u-lg-size1of3 u-flex">
                <div class="Entrypoint-item u-sizeFill u-background-50">
                    <p><a class="u-textClean u-text-h3 u-color-white" href="'.$instance['LAT'].'">Amministrazione trasparente</a></p>
                </div>
            </div>';
			}
			
	 		echo '
            <div class="Grid-cell u-md-size1of3 u-lg-size1of3 '.(!$Is_AC?" u-flex ":"").'">
                <div class="Entrypoint-item '.(!$Is_AC?"u-sizeFill ":"").'u-background-50">
                <div class="HeaderAlbo u-text-h3 u-color-white">Albo OnLine</div>';
            if ($Is_AAC){
                echo '<p><a class="u-textClean u-text-h4 u-color-white" href="'.$instance['AAC'].'">Atti correnti</a></p>';
			}
            if ($Is_AAS){
                echo '<p><a class="u-textClean u-text-h4 u-color-white" href="'.$instance['AAS'].'">Atti storico</a></p>';
			}
			if( isset($instance['LAP']) And $instance['LAP']!=""){
	            echo '<p><a class="u-textClean u-text-h4 u-color-white" href="'.$instance['LAP'].'">Atti correnti</a></p>';
			}
            echo'					
                </div>';             
		   if ($Is_AC){
                	echo '
                <div class="Entrypoint-item u-background-50">
                	<p><a class="u-textClean u-text-h3 u-color-white" href="'.$instance['AC'].'">Accesso civico</a></p>
                </div>';
				}else{
					echo '<div class="Entrypoint-item u-background-50">
                	<p></p>
                </div>';
				}
             	echo'
            </div>';
 			if( $Is_URP){
 				echo '
            <div class="Grid-cell u-md-size1of3 u-lg-size1of3 u-flex">
                <div class="Entrypoint-item u-sizeFill u-background-50">
                    <p><a class="u-textClean u-text-h3 u-color-white" href="'.$instance['URP'].'">Ufficio Relazioni con il Pubblico</a></p>
                </div>
            </div>
        </div>
    </div>
</div>';
			}
        }

		function make_List_Pages($Pages,$Id,$Name,$Default){
			$Pagine="<select id=\"".$Id."\" name=\"".$Name."\">
		<option value=\"\" >--------</option>";
			foreach ( $Pages as $Pagina ) {
				$Url=get_permalink($Pagina->ID);
				$Pagine.= "<option value=\"".$Url."\"";
				if($Url==$Default){
					$Pagine.= " selected ";	
				}
				$Pagine.= " >".$Pagina->post_title."</option>";
			}
			$Pagine.="</select>";
			return $Pagine; 
		}
		
        function update( $new_instance, $old_instance ) {

            $instance = $old_instance;
            $instance['titolo'] = strip_tags($new_instance['titolo']);
            $instance['AT'] = strip_tags($new_instance['AT']);
            $instance['LAT'] = strip_tags($new_instance['LAT']);
            $instance['LAP'] = strip_tags($new_instance['LAP']);
            $instance['AAC'] = strip_tags($new_instance['AAC']);
            $instance['AAS'] = strip_tags($new_instance['AAS']);
            $instance['AC'] = strip_tags($new_instance['AC']);
            $instance['URP'] = strip_tags($new_instance['URP']);
            return $instance;
        }

        function form( $instance ) {

            $instance = wp_parse_args( (array) $instance, array( ) ); 
            $titolo = ! empty( $instance['titolo'] ) ? $instance['titolo'] : esc_html__( 'Servizi', 'text_domain' );
            $args = array(
			'post_status' => 'publish',
			'sort_order' => 'asc',
			'sort_column' => 'post_date'
			);		
            $Pagine=get_pages( $args );
            $ElencoAT=$this->make_List_Pages($Pagine,$this->get_field_id( 'AT' ),$this->get_field_name( 'AT' ),! empty( $instance['AT'] ) ? $instance['AT'] :"");
        	$Link_AT=$instance['LAT'];
           	$Link_AP=$instance['LAP'];
            $ElencoAAC=$this->make_List_Pages($Pagine,$this->get_field_id( 'AAC' ),$this->get_field_name( 'AAC' ),! empty( $instance['AAC'] ) ? $instance['AAC'] :"");
            $ElencoAAS=$this->make_List_Pages($Pagine,$this->get_field_id( 'AAS' ),$this->get_field_name( 'AAS' ),! empty( $instance['AAS'] ) ? $instance['AAS'] :"");
            $ElencoAC=$this->make_List_Pages($Pagine,$this->get_field_id( 'AC' ),$this->get_field_name( 'AC' ),! empty( $instance['AC'] ) ? $instance['AC'] :"");
            $ElencoURP=$this->make_List_Pages($Pagine,$this->get_field_id( 'URP' ),$this->get_field_name( 'URP' ),! empty( $instance['URP'] ) ? $instance['URP'] :"");
            ?>

            <p>
                <label for="<?php echo $this->get_field_id( 'titolo' ); ?>">Titolo Sezione:</label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'titolo' ); ?>" name="<?php echo $this->get_field_name( 'titolo' ); ?>" value="<?php echo esc_attr( $titolo ); ?>" />
            </p>
            <p>
			    <label for="<?php echo $this->get_field_id( 'AT' );?>">Pagina Amministrazione Trasparente:</label><br />
           		<?php echo $ElencoAT; ?>
            </p>
            <p>
			    <label for="<?php echo $this->get_field_id( 'LAT' );?>">Link Esterno Amministrazione Trasparente:</label><br />
           		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'LAT' ); ?>" name="<?php echo $this->get_field_name( 'LAT' ); ?>" value="<?php echo esc_attr( $Link_AT ); ?>" />
            </p>
           <p>
			    <label for="<?php echo $this->get_field_id( 'LAP' );?>">Link Esterno Albo OnLine:</label><br />
           		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'LAP' ); ?>" name="<?php echo $this->get_field_name( 'LAP' ); ?>" value="<?php echo esc_attr( $Link_AP ); ?>" />
            </p>
           <p>
			    <label for="<?php echo $this->get_field_id( 'AAC' );?>">Pagina Albo Atti Correnti:</label><br />
           		<?php echo $ElencoAAC; ?>
            </p>
           <p>
			    <label for="<?php echo $this->get_field_id( 'AAS' );?>">Pagina Albo Atti Storico:</label><br />
           		<?php echo $ElencoAAS; ?>
            </p>
           <p>
			    <label for="<?php echo $this->get_field_id( 'AC' );?>">Pagina Accesso Civico:</label><br />
           		<?php echo $ElencoAC; ?>
            </p>
           <p>
			    <label for="<?php echo $this->get_field_id( 'URP' );?>">Pagina Ufficio Relazioni con il Pubblico:</label><br />
           		<?php echo $ElencoURP; ?>
            </p>
      <?php
        }
    }
/**
* Widget my_EM_Widget_Calendar
*	   Titolo:	($title) Testo che viene visualizzato in Testa all'elenco degli articoli estratti
*	  Blocchi:	($blocchi) Array di max 4 elementi di (Immagine,Testo,Link)
*/
class my_EM_Widget_Calendar extends WP_Widget {
		
		var $defaults = array("title"		=> "Eventi",
							  "long_events"	=> 0,
							  "category"	=> "",
							  "limit"		=> "5",
							  "scope"		=> "12-months",
							  "orderby"		=> "event_start_date,event_start_time,event_name",
							  "order"		=> "ASC",
							  "all_events"	=> "on",
							  "all_events_text"=>"tutti gli eventi"
		);
    	
       function __construct() {

	    	$this->em_orderby_options = apply_filters('em_settings_events_default_orderby_ddm', array(
			'event_start_date,event_start_time,event_name' => __('start date, start time, event name','events-manager'),
			'event_name,event_start_date,event_start_time' => __('name, start date, start time','events-manager'),
			'event_name,event_end_date,event_end_time' => __('name, end date, end time','events-manager'),
			'event_end_date,event_end_time,event_name' => __('end date, end time, event name','events-manager'),
		)); 
	    	parent::__construct( false, 'ItaliaWP Calendario Event Manager',
				array('classname' => 'Calendario',
				    'description' => 'Blocco che visualizza il calendario settimanale del plugin Event Manager') );
			add_action( 'wp_ajax_CalendarioMese', array($this,'CalendarioMese' ));
			add_action( 'wp_ajax_nopriv_CalendarioMese', array($this,'CalendarioMese' ));
        }
        		
		function VisCalendar($argscal){
			$calendar_array  = EM_Calendar::get($argscal);
		?>			<div class="clndr u-nbfc u-borderShadow-m u-xs-borderShadow-none u-borderRadius-m u-background-white em-calendar-wrapper">
					<div class="clndr-controls clearfix">
						<div class="clndr-previous-button clearfix">
							<span class="em-calnav u-text-r-l Icon Icon-chevron-left" data-valori="<?php echo $calendar_array['month_last']."&".$calendar_array['year_last']; ?>"></span>
						</div>
						<div class="month clearfix"><?php echo esc_html(date_i18n(get_option('dbem_small_calendar_month_format'), $calendar_array['month_start'])); ?></div>
						<div class="clndr-next-button clearfix">
							<span class="em-calnav u-text-r-l Icon Icon-chevron-right" data-valori="<?php echo $calendar_array['month_next']."&".$calendar_array['year_next']; ?>"></span>
						</div>
					</div>
					<div class="days-container clearfix">
						<div class="days clearfix">
							<div class="headers clearfix">
								<div class="day-header clearfix">Lu</div>
								<div class="day-header clearfix">Ma</div>
								<div class="day-header clearfix">Me</div>
								<div class="day-header clearfix">Gi</div>
								<div class="day-header clearfix">Ve</div>
								<div class="day-header clearfix">Sa</div>
								<div class="day-header clearfix">Do</div>
							</div>
				<?php
							$cal_count = count($calendar_array['cells']);
							$col_count = 0;
							$count = 1; //this counts collumns in the $calendar_array_array['cells'] array
							$col_max = count($calendar_array['row_headers']); //each time this collumn number is reached, we create a new collumn, the number of cells should divide evenly by the number of row_headers
							foreach($calendar_array['cells'] as $date => $cell_data ){
								$class = ( !empty($cell_data['events']) && count($cell_data['events']) > 0 ) ? 'eventful':'eventless';
								if(!empty($cell_data['type'])){
									$class .= "-".$cell_data['type']; 
								}
								?>
								<div class="day past calendar-dow-<?php echo $col_count;?> <?php echo esc_attr($class); ?>">
						<?php if( !empty($cell_data['events']) && count($cell_data['events']) > 0 ): ?>
									<a href="<?php echo esc_url($cell_data['link']); ?>" title="<?php echo esc_attr($cell_data['link_title']); ?>" class="u-background-70 u-color-white"><?php echo esc_html(date('j',$cell_data['date'])); ?></a>
									<?php else:?>
									<?php echo esc_html(date('j',$cell_data['date'])); ?>
									<?php endif; ?>
								</div>

								<?php
								//create a new row once we reach the end of a table collumn
								$col_count= ($col_count == $col_max ) ? 0 : $col_count+1;
								$count ++; 
							}
				?>
						</div>
					</div>
				</div>
		<?php
			}
			function CalendarioMese(){
				check_ajax_referer('aggiornamentoCalendario','security');
				$argscal=array();
				$argscal['month'] = filter_input(INPUT_POST,'mese');
				$argscal['year'] = filter_input(INPUT_POST,'anno');
				$this->VisCalendar($argscal);
				//var_dump($_POST);
				die();
			}
    function fix_scope($instance){
    	if( !empty($instance['time_limit']) && is_numeric($instance['time_limit']) && $instance['time_limit'] > 1 ){
    		$instance['scope'] = $instance['time_limit'].'-months';
    	}elseif( !empty($instance['time_limit']) && $instance['time_limit'] == 1){
    		$instance['scope'] = 'month';
    	}elseif( !empty($instance['time_limit']) && $instance['time_limit'] == 'no-limit'){
    		$instance['scope'] = 'all';
    	}
    	return $instance;
    }			
		private function output($args = array(), $instance = true) {
			//Let month and year REQUEST override for non-JS users

			$PathInclude=get_template_directory() . '-child/plugins/events-manager/templates/';
//			var_dump($args);
			ob_start();
?>
<?php
		include_once($PathInclude.'calendar-small.php');
?>
<?php
		$calendar = ob_get_clean();
		return apply_filters('myem_calendar_output', $calendar, $args);
		}		
		
		private function explodeDataDB($Data){
			$Data=explode("-",$Data);
			return array("GG" => $Data[2],
			             "MM" => $Data[1],
			             "AA" => $Data[0]);
		}

	    function widget($args, $instance) {
	    	extract($args);
            $title = apply_filters('widget_title', $instance['title']);
            
 ?>
	<div class="u-layoutCenter u-layout-withGutter u-padding-r-top u-padding-bottom-xxl">
<?php
		echo $before_widget
?>
	<div class="u-layout-medium u-layoutCenter">
<?php 
          if ( $title ) {
          		$before_title=str_replace("<h2 class=\"","<h2 class=\"u-text-h2 ",$before_title);
                echo $before_title . $title . $after_title;
            }

	    	//Shall we show a specific month?
			if ( !empty($_REQUEST['calendar_day']) ) {
				$date = explode('-', $_REQUEST['calendar_day']);
				$instance['month'] = $date[1];
				$instance['year'] = $date[0];
			}else{
				$instance['month'] = date("m");
				$instance['year'] = date("Y");
			}
		    //Our Widget Content  
		    echo self::output($args,$instance);
?>
	</div>
<?php		    
		    echo $args['after_widget'];
?>
</div>
<?php
	    }

	    /** @see WP_Widget::update */
	    function update($new_instance, $old_instance) {
	    	//filter the new instance and replace blanks with defaults
/*	    	$new_instance['title'] = (!isset($new_instance['title'])) ? $this->defaults['title']:$new_instance['title'];
	    	$new_instance['long_events'] = ($new_instance['long_events'] == '') ? $this->defaults['long_events']:$new_instance['long_events'];
	    	$new_instance['category'] = ($new_instance['category'] == '') ? $this->defaults['category']:$new_instance['category'];
*/
   	foreach($this->defaults as $key => $value){
    		if( !isset($new_instance[$key]) ){
    			$new_instance[$key] = $value;
    		}
    		//make sure formats and the no locations text are wrapped with li tags
		    if( ($key == 'format' || $key == 'no_events_text') && !preg_match('/^<li/i', trim($new_instance[$key])) ){
            	$new_instance[$key] = '<li>'.force_balance_tags($new_instance[$key]).'</li>';
		    }
		    //balance tags and sanitize output formats
		    if( in_array($key, array('format', 'no_events_text', 'all_events_text')) ){
		        if( is_multisite() && !em_wp_is_super_admin() ) $new_instance[$key] = wp_kses_post($new_instance[$key]); //for multisite
		        $new_instance[$key] = force_balance_tags($new_instance[$key]);
		    }
    	}	    	
	    	return $new_instance;
	    }

	    /** @see WP_Widget::form */
	    function form($instance) {
	    	$instance = array_merge($this->defaults, $instance);
	        ?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'events-manager'); ?>: </label>
				<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('long_events'); ?>"><?php _e('Show Long Events?', 'events-manager'); ?>: </label>
				<input type="checkbox" id="<?php echo $this->get_field_id('long_events'); ?>" name="<?php echo $this->get_field_name('long_events'); ?>" value="1" <?php echo ($instance['long_events'] == '1') ? 'checked="checked"':''; ?>/>
			</p>
			<p>
	            <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category IDs','events-manager'); ?>: </label>
	            <input type="text" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" size="3" value="<?php echo esc_attr($instance['category']); ?>" /><br />
	            <em><?php _e('1,2,3 or 2 (0 = all)','events-manager'); ?> </em>
	        </p>
	        <h2>Paramentri Lista Eventi</h2>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>"><?php esc_html_e('Number of events','events-manager'); ?>: </label>
			<input type="text" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" size="3" value="<?php echo esc_attr($instance['limit']); ?>" />
		</p>
		<p>
			
			<label for="<?php echo $this->get_field_id('scope'); ?>"><?php esc_html_e('Scope','events-manager'); ?>: </label><br/>
			<select id="<?php echo $this->get_field_id('scope'); ?>" name="<?php echo $this->get_field_name('scope'); ?>" class="widefat" >
				<?php foreach( em_get_scopes() as $key => $value) : ?>   
				<option value='<?php echo esc_attr($key); ?>' <?php echo ($key == $instance['scope']) ? "selected='selected'" : ''; ?>>
					<?php echo esc_html($value); ?>
				</option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php esc_html_e('Order By','events-manager'); ?>: </label>
			<select  id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" class="widefat">
				<?php foreach($this->em_orderby_options as $key => $value) : ?>   
	 			<option value='<?php echo esc_attr($key); ?>' <?php echo ( !empty($instance['orderby']) && $key == $instance['orderby']) ? "selected='selected'" : ''; ?>>
	 				<?php echo esc_html($value); ?>
	 			</option>
				<?php endforeach; ?>
			</select> 
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php esc_html_e('Order','events-manager'); ?>: </label>
			<select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>" class="widefat">
				<?php 
				$order_options = apply_filters('em_widget_order_ddm', array(
					'ASC' => __('Ascending','events-manager'),
					'DESC' => __('Descending','events-manager')
				)); 
				?>
				<?php foreach( $order_options as $key => $value) : ?>   
	 			<option value='<?php echo esc_attr($key); ?>' <?php echo ($key == $instance['order']) ? "selected='selected'" : ''; ?>>
	 				<?php echo esc_html($value); ?>
	 			</option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
            <label for="<?php echo $this->get_field_id('category'); ?>"><?php esc_html_e('Category IDs','events-manager'); ?>: </label>
            <input type="text" id="<?php echo $this->get_field_id('category'); ?>" class="widefat" name="<?php echo $this->get_field_name('category'); ?>" size="3" value="<?php echo esc_attr($instance['category']); ?>" /><br />
            <em><?php esc_html_e('1,2,3 or 2 (0 = all)','events-manager'); ?> </em>
        </p>
        <p>
			<label for="<?php echo $this->get_field_id('all_events'); ?>"><?php esc_html_e('Show all events link at bottom?','events-manager'); ?>: </label>
			<input type="checkbox" id="<?php echo $this->get_field_id('all_events'); ?>" name="<?php echo $this->get_field_name('all_events'); ?>" <?php echo (!empty($instance['all_events']) && $instance['all_events']) ? 'checked':''; ?>  class="widefat">
		</p>
		<p id="<?php echo $this->get_field_id('all_events'); ?>-section">
			<label for="<?php echo $this->get_field_id('all_events'); ?>"><?php esc_html_e('All events link text?','events-manager'); ?>: </label>
			<input type="text" id="<?php echo $this->get_field_id('all_events_text'); ?>" name="<?php echo $this->get_field_name('all_events_text'); ?>" value="<?php echo esc_attr( $instance['all_events_text'] ); ?>" >
		</p>
	        <?php 
	    }

	}	
/****************************************************************************
 Widget Comunicazioni
	   Titolo:	($title) Testo che viene visualizzato in Testa all'elenco degli articoli estratti
*/

    class Comunicazioni extends WP_Widget {

        function __construct() {
			parent::__construct( false, 'ItaliaWP Comunicazioni',
				array('classname' => 'Comunicazioni',
				    'description' => 'Blocco Comunicazioni due blocchi uno per le circolari ed uno per una categoria') );
        }

        function widget( $args, $instance ) {
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
 			$pagcircolari=isset($instance['pagcircolari'])?$instance['pagcircolari']:0;
?>
	<div class="u-layoutCenter u-layout-withGutter u-padding-r-top <?php echo $instance['bgkcolor'];?>">
<?php
		echo $before_widget;
		$TipoCircolari="C";
		if ( post_type_exists( 'circolari' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );		
			if (is_plugin_active("gestione-circolari-groups/GestioneCircolari.php")){
				$TipoCircolari="G";
				$Circolari=get_ListaCircolariG(FALSE,$numelementi);
				$Gruppi=gcg_get_Circolari_Gruppi("ArrayN");
			}else{
				$Circolari=get_ListaCircolari(FALSE,$numelementi);
//				var_dump($Circolari);wp_die();
			}
		}	
		$args = array( 'cat' => $catsecondoblocco,
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
    	<div class="u-layout-wide u-layoutCenter u-layout-withGutter u-padding-r-top <?php echo $bgkcolor;?>">
    	<div class="Grid Grid--withGutter u-padding-all-xs">
			<div class="Grid-cell u-sizeFull u-md-size1of2 u-lg-size1of2">
				<div class="u-borderShadow-m u-borderRadius-l <?php echo $bgkcolorblocchi;?>">
					<h2 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi;?> u-padding-r-all">Circolari</h2>	    	 		
		<ul id="ListaCircolari" class="Linklist Linklist--padded u-text-r-xs">
<?php
if(isset($Circolari)){
	foreach($Circolari as $CircolareVis){
		$Elenco="";
		$Tipo="";
		$Protetto="";
		$numero=get_post_meta($CircolareVis->ID, "_numero",TRUE);
		$anno=get_post_meta($CircolareVis->ID, "_anno",TRUE);
		if($TipoCircolari=="C"){
			$fgs = wp_get_object_terms($CircolareVis->ID, 'gruppiutenti');
			if(!empty($fgs)){
				foreach($fgs as $fg){
					$Elenco.=$fg->name." - ";
				}
				$Elenco=substr($Elenco,0,strlen($Elenco)-3);
			}
			if (!empty($CircolareVis->post_password))
				$Protetto= '<i class="fas fa-lock"></i> Contenuto Protetto';
			else
				$Protetto="";
			if (Is_Circolare_Da_Firmare($CircolareVis->ID))
				if (!Is_Circolare_Firmata($CircolareVis->ID)) {
					$ngiorni=Get_scadenzaCircolare($CircolareVis->ID,"",True);					
					if(Is_Circolare_Scaduta($CircolareVis->ID)){
						$Tipo='<span style="color:red;"><i class="fa fa-user-edit"></i> Scaduta e non Firmata</span>';						
					}else{
						switch ($ngiorni){
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
						$sign=get_post_meta($CircolareVis->ID, "_sign",TRUE);
						if ($sign!="Firma")
							$Tipo="<span style=\"color:red;\"><i class=\"fa fa-user-edit\"></i> Esprimere adesione ".$entro."</span>";
						else
							$Tipo="<span style=\"color:red;\"><i class=\"fa fa-user-edit\"></i> Firmare ".$entro."</span>";		
					}
				}else{
					$Tipo="<span style=\"color:blue;\"><i class=\"fa fa-user-edit\"></i> Firmata</span>";
				}
			echo "<li><p><a href=\"".get_permalink($CircolareVis->ID)."\">".$CircolareVis->post_title."</a>
				<p class=\"u-textWeight-600;\">
				Del ".FormatDataItaliano($CircolareVis->post_date).($numero!=""?" Numero ".$numero."_".$anno:"")."<br />
			<i class=\"fa fa-folder-open\"></i> ".$CircolareVis->post_type." "; 
			if($CircolareVis->post_type!="post"){
				echo "<i class=\"fa fa-users\"></i> ".$Elenco." ";
			}
			if($Protetto){
				echo $Protetto;
			}
			if($Tipo){
				echo "<br />".$Tipo."</p>";
			}
			echo "</li>";
		}else{
			$Destinatari=get_post_meta($CircolareVis->ID, "_destinatari");
			$Elenco="";
			if($CircolareVis->post_type=="circolari"){
				if(count($Destinatari)>0){		
					$Destinatari=unserialize($Destinatari[0]);
					$Nomi_Des='';
		//			var_dump($Destinatari);var_dump($Gruppi);die();
					foreach($Destinatari as $Dest)
						$Nomi_Des.=$Gruppi[$Dest].", ";
					$Elenco=substr($Nomi_Des,0,-2);
				}
			}
			if (!empty($CircolareVis->post_password))
				$Protetto= '<i class="fas fa-lock"></i> Contenuto Protetto';
			else
				$Protetto="";
			if (($post->post_type=="circolari") && gcg_Is_Circolare_Da_Firmare($CircolareVis->ID)){
				if (!gcg_Is_Circolare_Firmata($CircolareVis->ID)) {
					$ngiorni=gcg_GetscadenzaCircolare($CircolareVis->ID,"",True);		
					if(gcg_Is_Circolare_Scaduta($CircolareVis->ID)){
						$Tipo='<span style="color:red;"><i class="fa fa-user-edit"></i> Scaduta e non Firmata</span>';
					}else{
						switch ($ngiorni){
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
	                    else
	                    	if (get_post_meta($CircolareVis->ID, "_sign",TRUE)!="NoFirma")				
	                    		$Tipo="Esprimere scelta $entro";
					}
				}else{
					$Tipo="<span style=\"color:blue;\"><i class=\"fa fa-user-edit\"></i> Firmata</span>";
				}
			}
			echo "<li><p><a href=\"".get_permalink($CircolareVis->ID)."\">".$CircolareVis->post_title."</a>
				<p class=\"u-textWeight-600;\">
				Del ".gcg_FormatDataItaliano($CircolareVis->post_date).($numero!=""?" Numero ".$numero."_".$anno:"")."<br />
			<i class=\"fa fa-folder-open\"></i> ".$CircolareVis->post_type." "; 
			if($CircolareVis->post_type!="post"){
				echo "<i class=\"fa fa-users\"></i> ".$Elenco." ";
			}
			if($Tipo){
				echo "<br />".$Tipo."</p>";
			}
			echo "</li>";					
		}
	}
	if($linkLT){?>
			<li>
				<div class="tab-pane-readnext">
					<p class="u-textCenter u-text-md-right u-text-lg-right u-margin-r-top">
	            		<a href="<?php echo $pagcircolari;?>" class="u-color-white u-textClean u-text-h4">Leggi tutto <span class="Icon Icon-chevron-right"></span></a>
	        		</p>
				</div>
			</li>
<?php	}?>		
		</ul>
<?php } ?>
				</div>
			</div>
			<div class="Grid-cell u-sizeFull u-md-size1of2 u-lg-size1of2">
				<div class="u-borderShadow-m u-borderRadius-l <?php echo $bgkcolorblocchi;?>">
					<h2 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi;?> u-padding-r-all">Avvisi</h2>	    	 		
		<ul id="ListaArticoli" class="Linklist Linklist--padded u-text-r-xs">
<?php
	foreach($Articoli as $Articolo){
		//var_dump($Articolo);
		echo "<li><a href=\"".get_permalink($Articolo->ID)."\">".$Articolo->post_title."</a>
			<p class=\"u-textWeight-600;\">
			Del ".IWP_FormatDataItaliano($Articolo->post_date)."<br />
		<i class=\"fas fa-user-edit\"></i> ".get_the_author_meta('display_name', $Articolo->post_author)."</p>
		</li>";
	}
	if($linkLT){?>
			<li>
				<div class="tab-pane-readnext">
					<p class="u-textCenter u-text-md-right u-text-lg-right u-margin-r-top">
	            		<a href="<?php echo get_category_link($catsecondoblocco);?>" class="u-color-white u-textClean u-text-h4">Leggi tutto <span class="Icon Icon-chevron-right"></span></a>
	        		</p>
				</div>
			</li>
<?php	}?>
		</ul>
				</div>
	    	</div>
	    	</div>
		</div>
	</div>
</div>
<?php        }

        function update( $new_instance, $old_instance ) {
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
        
        function make_List_Pages($Pages,$Id,$Name,$Default){
			$Pagine="<select id=\"".$Id."\" name=\"".$Name."\">
		<option value=\"\" >--------</option>";
			foreach ( $Pages as $Pagina ) {
				$Url=get_permalink($Pagina->ID);
				$Pagine.= "<option value=\"".$Url."\"";
				if($Url==$Default){
					$Pagine.= " selected ";	
				}
				$Pagine.= " >".$Pagina->post_title."</option>";
			}
			$Pagine.="</select>";
			return $Pagine; 
		}

        function form( $instance ) {
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
		foreach($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo){
			echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.'"';
			if($KColoreSfondo==$bgkcolor){
				echo " selected ";
			}
			echo'> '.$KColoreSfondo.' </option>';
		}
?>				</select><span style="background-color:<?php echo ($bgkcolor!=""?$ColoriSfondo[$bgkcolor]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>
			</p>
            <p>
        		<label for="<?php echo $this->get_field_id( 'colortit' ); ?>">Colore del titolo della sezione:</label><br />
				<select id="<?php echo $this->get_field_id( 'colortit' ); ?>" name="<?php echo $this->get_field_name( 'colortit' ); ?>">
<?php
		foreach($ColoriTesto as $KColoreTesto=>$ColoreTesto){
			echo '<option value="'.$KColoreTesto.'" style="color: '.$ColoreTesto.'"';
			if($KColoreTesto==$colortit){
				echo " selected ";
			}
			echo'> '.$KColoreTesto.' </option>';
		}
?>				</select><span style="color:<?php echo ($colortit!=""?$ColoriTesto[$colortit]:"");?>;">&ensp;&ensp;Colore del testo</span>
			</p>
            <p>
        		<label for="<?php echo $this->get_field_id( 'bgkcolorblocchi' ); ?>">Colore di sfondo dei blocchi:</label><br />
				<select id="<?php echo $this->get_field_id( 'bgkcolorblocchi' ); ?>" name="<?php echo $this->get_field_name( 'bgkcolorblocchi' ); ?>">
<?php
		foreach($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo){
			echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.';"';
			if($KColoreSfondo==$bgkcolorblocchi){
				echo " selected ";
			}
			echo'> '.$KColoreSfondo.' </option>';
		}
?>				</select><span style="background-color:<?php echo ($bgkcolorblocchi!=""?$ColoriSfondo[$bgkcolorblocchi]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>	
			</p>			
            <p>
        		<label for="<?php echo $this->get_field_id( 'colortitblocchi' ); ?>">Colore del titolo dei blocchi:</label><br />
				<select id="<?php echo $this->get_field_id( 'colortitblocchi' ); ?>" name="<?php echo $this->get_field_name( 'colortitblocchi' ); ?>">
<?php
		foreach($ColoriTesto as $KColoreTesto=>$ColoreTesto){
			echo '<option value="'.$KColoreTesto.'" style="color: '.$ColoreTesto.'"';
			if($KColoreTesto==$colortitblocchi){
				echo " selected ";
			}
			echo'> '.$KColoreTesto.' </option>';
		}
?>				</select><span style="color:<?php echo ($colortitblocchi?$ColoriTesto[$colortitblocchi]:"");?>;">&ensp;&ensp;Colore del testo</span>
			</p>
           <p>
        		<label for="<?php echo $this->get_field_id( 'bgkcolortitblocchi' ); ?>">Colore di sfondo del titolo dei blocchi:</label><br />
				<select id="<?php echo $this->get_field_id( 'bgkcolortitblocchi' ); ?>" name="<?php echo $this->get_field_name( 'bgkcolortitblocchi' ); ?>">
<?php
		foreach($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo){
			echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.'"';
			if($KColoreSfondo==$bgkcolortitblocchi){
				echo " selected ";
			}
			echo'> '.$KColoreSfondo.' </option>';
		}
?>				</select><span style="background-color:<?php echo ($bgkcolortitblocchi!=""?$ColoriSfondo[$bgkcolortitblocchi]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>
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
	if (function_exists("circolariG_Visualizza")){
		echo "Gestione Circolari Groups";
	}else{
		echo "Gestione Circolari ";
	}?>
		<input type="hidden" name="catprimoblocco" id="catprimoblocco" value="-1">
       	<br /><label for="<?php echo $this->get_field_id( 'pagcircolari' ); ?>">Pagina Circolari:</label>
       <?php echo $this->make_List_Pages($Pagine,$this->get_field_id( 'pagcircolari' ),$this->get_field_name( 'pagcircolari' ),! empty( $instance['pagcircolari'] ) ? $instance['pagcircolari'] :"");  
	}else{ 
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
/****************************************************************************
 Widget Articoli
	   Titolo:	($title) Testo che viene visualizzato in Testa all'elenco degli articoli estratti
*/

    class Articoli extends WP_Widget {

        function __construct() {
			parent::__construct( false, 'ItaliaWP Articoli',
				array('classname' => 'Articoli',
				    'description' => 'Blocco Articoli su due colonne con due categoria') );
        }

        function widget( $args, $instance ) {
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
	<div class="u-layoutCenter u-layout-withGutter u-padding-r-top <?php echo $instance['bgkcolor'];?>">
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
    	<div class="u-layout-wide u-layoutCenter u-layout-withGutter u-padding-r-top <?php echo $bgkcolor;?>">
    	<div class="Grid Grid--withGutter u-padding-all-xs">
    		<div class="Grid-cell u-sizeFull u-md-size1of2 u-lg-size1of2">
				<div class="u-borderShadow-m u-borderRadius-l <?php echo $bgkcolorblocchi;?>">
					<h2 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi;?> u-padding-r-all"><?php echo $TitoloPB;?></h2>    	 		
		<ul id="ListaArticoli" class="Linklist Linklist--padded u-text-r-xs">
<?php
	foreach($ArticoliPB as $Articolo){
		//var_dump($Articolo);
		echo "<li><a href=\"".get_permalink($Articolo->ID)."\">".$Articolo->post_title."</a>
			<p class=\"u-textWeight-600;\">
			Del ".IWP_FormatDataItaliano($Articolo->post_date)."<br />
		<i class=\"fas fa-user-edit\"></i> ".get_the_author_meta('display_name', $Articolo->post_author)."</p>
		</li>";
	}
	if($linkLT){?>
			<li>
				<div class="tab-pane-readnext">
					<p class="u-textCenter u-text-md-right u-text-lg-right u-margin-r-top">
	            		<a href="<?php echo get_category_link($catprimoblocco);?>" class="u-color-white u-textClean u-text-h4"> Leggi tutto <span class="Icon Icon-chevron-right"></span></a>
	        		</p>
				</div>
			</li>
<?php	}?>
			</ul>
				</div>
			</div>
			<div class="Grid-cell u-sizeFull u-md-size1of2 u-lg-size1of2">
				<div class="u-borderShadow-m u-borderRadius-l <?php echo $bgkcolorblocchi;?>">
					<h2 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi;?> u-padding-r-all"><?php echo $TitoloSB;?></h2>	    	 		
		<ul id="ListaArticoli" class="Linklist Linklist--padded u-text-r-xs">
<?php
	foreach($ArticoliSB as $Articolo){
		//var_dump($Articolo);
		echo "<li><a href=\"".get_permalink($Articolo->ID)."\">".$Articolo->post_title."</a>
			<p class=\"u-textWeight-600;\">
			Del ".IWP_FormatDataItaliano($Articolo->post_date)."<br />
		<i class=\"fas fa-user-edit\"></i> ".get_the_author_meta('display_name', $Articolo->post_author)."</p>
		</li>";
	}
	if($linkLT){?>
			<li>
				<div class="tab-pane-readnext">
										<p class="u-textCenter u-text-md-right u-text-lg-right u-margin-r-top">
	            						<a href="<?php echo get_category_link($catsecondoblocco);?>" class="u-color-white u-textClean u-text-h4"> Leggi tutto <span class="Icon Icon-chevron-right"></span></a>
	        							</p>
									</div>
			</li>
<?php	}?>
		</ul>
				</div>
	    	</div>
	    	</div>
		</div>
	</div>
</div>
<?php        }

        function update( $new_instance, $old_instance ) {
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

        function form( $instance ) {
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
		foreach($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo){
			echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.'"';
			if($KColoreSfondo==$bgkcolor){
				echo " selected ";
			}
			echo'> '.$KColoreSfondo.' </option>';
		}
?>				</select><span style="background-color:<?php echo ($bgkcolor!=""?$ColoriSfondo[$bgkcolor]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>
			</p>
            <p>
        		<label for="<?php echo $this->get_field_id( 'colortit' ); ?>">Colore del titolo della sezione:</label><br />
				<select id="<?php echo $this->get_field_id( 'colortit' ); ?>" name="<?php echo $this->get_field_name( 'colortit' ); ?>">
<?php
		foreach($ColoriTesto as $KColoreTesto=>$ColoreTesto){
			echo '<option value="'.$KColoreTesto.'" style="color: '.$ColoreTesto.'"';
			if($KColoreTesto==$colortit){
				echo " selected ";
			}
			echo'> '.$KColoreTesto.' </option>';
		}
?>				</select><span style="color:<?php echo ($colortit!=""?$ColoriTesto[$colortit]:"");?>;">&ensp;&ensp;Colore del testo</span>
			</p>
            <p>
        		<label for="<?php echo $this->get_field_id( 'bgkcolorblocchi' ); ?>">Colore di sfondo dei blocchi:</label><br />
				<select id="<?php echo $this->get_field_id( 'bgkcolorblocchi' ); ?>" name="<?php echo $this->get_field_name( 'bgkcolorblocchi' ); ?>">
<?php
		foreach($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo){
			echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.';"';
			if($KColoreSfondo==$bgkcolorblocchi){
				echo " selected ";
			}
			echo'> '.$KColoreSfondo.' </option>';
		}
?>				</select><span style="background-color:<?php echo ($bgkcolorblocchi!=""?$ColoriSfondo[$bgkcolorblocchi]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>	
			</p>			
            <p>
        		<label for="<?php echo $this->get_field_id( 'colortitblocchi' ); ?>">Colore del titolo dei blocchi:</label><br />
				<select id="<?php echo $this->get_field_id( 'colortitblocchi' ); ?>" name="<?php echo $this->get_field_name( 'colortitblocchi' ); ?>">
<?php
		foreach($ColoriTesto as $KColoreTesto=>$ColoreTesto){
			echo '<option value="'.$KColoreTesto.'" style="color: '.$ColoreTesto.'"';
			if($KColoreTesto==$colortitblocchi){
				echo " selected ";
			}
			echo'> '.$KColoreTesto.' </option>';
		}
?>				</select><span style="color:<?php echo ($colortitblocchi?$ColoriTesto[$colortitblocchi]:"");?>;">&ensp;&ensp;Colore del testo</span>
			</p>
           <p>
        		<label for="<?php echo $this->get_field_id( 'bgkcolortitblocchi' ); ?>">Colore di sfondo del titolo dei blocchi:</label><br />
				<select id="<?php echo $this->get_field_id( 'bgkcolortitblocchi' ); ?>" name="<?php echo $this->get_field_name( 'bgkcolortitblocchi' ); ?>">
<?php
		foreach($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo){
			echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.'"';
			if($KColoreSfondo==$bgkcolortitblocchi){
				echo " selected ";
			}
			echo'> '.$KColoreSfondo.' </option>';
		}
?>				</select><span style="background-color:<?php echo ($bgkcolortitblocchi!=""?$ColoriSfondo[$bgkcolortitblocchi]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>
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
class Feed_RSS extends WP_Widget {

       function __construct() {
			parent::__construct( false, 'ItaliaWP Feed RSS',
				array('classname' => 'Feed_RSS',
				    'description' => 'Visualizzatore Feed RSS') );

        }

	public function widget( $args, $instance ) {
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
		if(in_array(untrailingslashit($urlSx),array(site_url(),home_url()))
		And in_array(untrailingslashit($urlCx),array(site_url(),home_url())) 			And in_array(untrailingslashit($urlDx),array(site_url(),home_url())))			{
			return;
		}
		$NumFeed=0;
		if ( !empty( $urlSx )){
			$rssSx   = fetch_feed( $urlSx );
			$NumFeed++;
		}
		if ( !empty( $urlCx )){
			$rssSx   = fetch_feed( $urlCx );
			$NumFeed++;
		}
		if ( !empty( $urlDx )){
			$rssSx   = fetch_feed( $urlDx );
			$NumFeed++;
		}
		$title = $instance['itawprss-title'];
		$desc  = '';
		$link  = '';
?>
	<div class="u-layoutCenter u-layout-withGutter u-padding-r-top <?php echo $instance['bgkcolor'];?>">
	<section id="<?php echo $args['widget_id'];?>">
	<div class="u-layout-medium u-layoutCenter">
<?php 
          if ( $title ) {
          		$before_title=str_replace("<h2 class=\"","<h2 class=\"u-text-h2 ".$colortit." ",$before_title);
                echo $before_title . $title . $after_title;
            }
?>
    	<div class="u-layout-wide u-layoutCenter u-layout-withGutter u-padding-r-top <?php echo $bgkcolor;?>">
    	<div class="Grid Grid--withGutter u-padding-all-xs">
<?php if ( !empty( $urlSx )){?>
			<div class="Grid-cell u-sizeFull u-md-size1of<?php echo $NumFeed;?> u-lg-size1of<?php echo $NumFeed;?>">
				<div class="u-borderShadow-m u-borderRadius-l <?php echo $bgkcolorblocchi;?>">
					<h2 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi;?> u-padding-r-all"><?php echo $titoloSx; ?></h2>	  
		<?php $this->crea_VociFeed($urlSx,$numele,$viscont,$visaut,$visdata);?>
				</div>
			</div>
<?php 
} 
if ( !empty( $urlCx )){?>
			<div class="Grid-cell u-sizeFull u-md-size1of<?php echo $NumFeed;?> u-lg-size1of<?php echo $NumFeed;?>">
				<div class="u-borderShadow-m u-borderRadius-l <?php echo $bgkcolorblocchi;?>">
					<h2 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi;?> u-padding-r-all"><?php echo $titoloCx; ?></h2>	    	 		
		<?php $this->crea_VociFeed($urlCx,$numele,$viscont,$visaut,$visdata);?>
				</div>
	    	</div>
<?php 
} 
if ( !empty( $urlDx )){?>
			<div class="Grid-cell u-sizeFull u-md-size1of<?php echo $NumFeed;?> u-lg-size1of<?php echo $NumFeed;?>">
				<div class="u-borderShadow-m u-borderRadius-l <?php echo $bgkcolorblocchi;?>">
					<h2 class="<?php echo $colortitblocchi." ".$bgkcolortitblocchi;?> u-padding-r-all"><?php echo $titoloDx; ?></h2>	    	 		
		<?php $this->crea_VociFeed($urlDx,$numele,$viscont,$visaut,$visdata);?>
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
	private function crea_VociFeed($rss,$numele,$viscont,$visaut,$visdata){
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
	public function update( $new_instance, $old_instance ) {
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
	public function form( $instance ) {
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
	<label for=<?php echo $this->get_field_id( "itawprss-title");?>>Titolo del Blocco</label>
	<input class="widefat" id=<?php echo $this->get_field_id( "itawprss-title");?> name=<?php echo $this->get_field_name( 'itawprss-title' ); ?> type="text" value="<?php echo esc_attr( $titolo ); ?>" /></p>
	<p><label for=<?php echo $this->get_field_id( "itawprss-urlSx");?>>Url Feed RSS blocco di Sinistra</label>
	<input class="widefat" id=<?php echo $this->get_field_id( "itawprss-urlSx");?> name=<?php echo $this->get_field_name( 'itawprss-urlSx' ); ?> type="text" value="<?php echo esc_url( $urlSx ); ?>" /></p>
	<p><label for=<?php echo $this->get_field_id( "itawprss-titleSx");?>>Titolo del Feed Rss blocco di Sinistra</label>
	<input class="widefat" id=<?php echo $this->get_field_id( "itawprss-titleSx");?> name=<?php echo $this->get_field_name( 'itawprss-titleSx' ); ?> type="text" value="<?php echo esc_attr( $titoloSx ); ?>" /></p>
	<p><label for=<?php echo $this->get_field_id( "itawprss-urlCx");?>>Url Feed RSS blocco Centrale</label>
	<input class="widefat" id=<?php echo $this->get_field_id( "itawprss-urlCx");?> name=<?php echo $this->get_field_name( 'itawprss-urlCx' ); ?> type="text" value="<?php echo esc_url( $urlCx ); ?>" /></p>
	<p><label for=<?php echo $this->get_field_id( "itawprss-titleCx");?>>Titolo del Feed Rss blocco Centrale</label>
	<input class="widefat" id=<?php echo $this->get_field_id( "itawprss-titleCx");?> name=<?php echo $this->get_field_name( 'itawprss-titleCx' ); ?> type="text" value="<?php echo esc_attr( $titoloCx ); ?>" /></p>
	<p><label for=<?php echo $this->get_field_id( "itawprss-urlDx");?>>Url Feed RSS blocco di Destra</label>
	<input class="widefat" id=<?php echo $this->get_field_id( "itawprss-urlDx");?> name=<?php echo $this->get_field_name( 'itawprss-urlDx' ); ?> type="text" value="<?php echo esc_url( $urlDx ); ?>" /></p>
	<p><label for=<?php echo $this->get_field_id( "itawprss-titleDx");?>>Titolo del Feed Rss blocco di Destra</label>
	<input class="widefat" id=<?php echo $this->get_field_id( "itawprss-titleDx");?> name=<?php echo $this->get_field_name( 'itawprss-titleDx' ); ?> type="text" value="<?php echo esc_attr( $titoloDx ); ?>" /></p>
	<p><label for=<?php echo $this->get_field_id( "itawprss-items");?>>Numero elementi da Visualizzare</label>
	<input class="widefat" type="number" id=<?php echo $this->get_field_id( "itawprss-items");?> name=<?php echo $this->get_field_name( 'itawprss-items' ); ?> value="<?php echo esc_attr( $numele ); ?>" min="1" max="20" style="width:4em;">
	</p>
	<p><input id=<?php echo $this->get_field_id( "itawprss-vis_contenuto");?> name=<?php echo $this->get_field_name( 'itawprss-vis_contenuto' ); ?> type="checkbox" value="1" <?php checked( $viscont ); ?> />
	<label for=<?php echo $this->get_field_id( "itawprss-vis_contenuto");?>>Visualizza Contenuto Post</label></p>
	<p><input id=<?php echo $this->get_field_id( "itawprss-vis_autore");?> name=<?php echo $this->get_field_name( 'itawprss-vis_autore' ); ?> type="checkbox" value="1" <?php checked( $visaut ); ?> />
	<label for=<?php echo $this->get_field_id( "itawprss-vis_autore");?>>Visualizza Autore Post</label></p>
	<p><input id=<?php echo $this->get_field_id( "itawprss-vis_data");?> name=<?php echo $this->get_field_name( 'itawprss-vis_data' ); ?> type="checkbox" value="1" <?php checked( $visdata ); ?>/>
	<label for=<?php echo $this->get_field_id( "itawprss-vis_data");?>>Visualizza Data Post</label></p>
	        <p>
		<label for="<?php echo $this->get_field_id( 'bgkcolor' ); ?>">Colore di sfondo della sezione:</label><br />
			<select id="<?php echo $this->get_field_id( 'bgkcolor' ); ?>" name="<?php echo $this->get_field_name( 'bgkcolor' ); ?>">
	<?php
	foreach($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo){
		echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.'"';
		if($KColoreSfondo==$bgkcolor){
			echo " selected ";
		}
		echo'> '.$KColoreSfondo.' </option>';
	}
	?>				</select><span style="background-color:<?php echo ($bgkcolor!=""?$ColoriSfondo[$bgkcolor]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>
		</p>
	    <p>
		<label for="<?php echo $this->get_field_id( 'colortit' ); ?>">Colore del titolo della sezione:</label><br />
			<select id="<?php echo $this->get_field_id( 'colortit' ); ?>" name="<?php echo $this->get_field_name( 'colortit' ); ?>">
	<?php
	foreach($ColoriTesto as $KColoreTesto=>$ColoreTesto){
		echo '<option value="'.$KColoreTesto.'" style="color: '.$ColoreTesto.'"';
		if($KColoreTesto==$colortit){
			echo " selected ";
		}
		echo'> '.$KColoreTesto.' </option>';
	}
	?>				</select><span style="color:<?php echo ($colortit!=""?$ColoriTesto[$colortit]:"");?>;">&ensp;&ensp;Colore del testo</span>
		</p>
	    <p>
		<label for="<?php echo $this->get_field_id( 'bgkcolorblocchi' ); ?>">Colore di sfondo dei blocchi:</label><br />
			<select id="<?php echo $this->get_field_id( 'bgkcolorblocchi' ); ?>" name="<?php echo $this->get_field_name( 'bgkcolorblocchi' ); ?>">
	<?php
	foreach($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo){
		echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.';"';
		if($KColoreSfondo==$bgkcolorblocchi){
			echo " selected ";
		}
		echo'> '.$KColoreSfondo.' </option>';
	}
	?>				</select><span style="background-color:<?php echo ($bgkcolorblocchi!=""?$ColoriSfondo[$bgkcolorblocchi]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>	
		</p>			
	    <p>
		<label for="<?php echo $this->get_field_id( 'colortitblocchi' ); ?>">Colore del titolo dei blocchi:</label><br />
			<select id="<?php echo $this->get_field_id( 'colortitblocchi' ); ?>" name="<?php echo $this->get_field_name( 'colortitblocchi' ); ?>">
	<?php
	foreach($ColoriTesto as $KColoreTesto=>$ColoreTesto){
		echo '<option value="'.$KColoreTesto.'" style="color: '.$ColoreTesto.'"';
		if($KColoreTesto==$colortitblocchi){
			echo " selected ";
		}
		echo'> '.$KColoreTesto.' </option>';
	}
	?>				</select><span style="color:<?php echo ($colortitblocchi?$ColoriTesto[$colortitblocchi]:"");?>;">&ensp;&ensp;Colore del testo</span>
		</p>
	   <p>
		<label for="<?php echo $this->get_field_id( 'bgkcolortitblocchi' ); ?>">Colore di sfondo del titolo dei blocchi:</label><br />
			<select id="<?php echo $this->get_field_id( 'bgkcolortitblocchi' ); ?>" name="<?php echo $this->get_field_name( 'bgkcolortitblocchi' ); ?>">
	<?php
	foreach($ColoriSfondo as $KColoreSfondo=>$ColoreSfondo){
		echo '<option value="'.$KColoreSfondo.'" style="background-color: '.$ColoreSfondo.'"';
		if($KColoreSfondo==$bgkcolortitblocchi){
			echo " selected ";
		}
		echo'> '.$KColoreSfondo.' </option>';
	}?>				
	</select><span style="background-color:<?php echo ($bgkcolortitblocchi!=""?$ColoriSfondo[$bgkcolortitblocchi]:"");?>;">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>
		</p>
<?php
	}
}

?>
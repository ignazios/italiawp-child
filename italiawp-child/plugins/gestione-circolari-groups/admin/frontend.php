<?php
/**
 * Gestione Circolari Groups
 * 
 * @package Gestione Circolari Groups
 * @author Scimone Ignazio
 * @copyright 2011-2014
 * @since 2.6
 */

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }


$par = shortcode_atts( array('destinatario' => 0), $atts );
if (isset($_REQUEST['anno']))
	$Anno=(int)$_REQUEST['Anno'];
else
	$Anno=date("Y");
$Mese=0;
if (isset($_REQUEST['Mese']))
	$Mese=(int)$_REQUEST['Mese'];
$Destinatario=$par['destinatario'];
if(isset($_REQUEST['dest']))
	$Destinatario=(int)$_REQUEST['dest'];	
$ret=circolariG_Lista_Circolari($Anno,$Mese,$Destinatario);

function circolariG_Lista_Circolari($Anno,$Mese,$Destinatario){
	ob_start();
	if ($Destinatario==0){
		$Contenuto=get_option('Circolari_IntestElenco');
	}else{
			$Contenuto=get_option('Circolari_IntestElencoDest');
	}
	echo $Contenuto;
	$Circolari=get_ListaCircolariG(TRUE,0,$Anno,$Mese);
	$accesso=new Groups_Post_Access();
	$Gruppi=gcg_get_Circolari_Gruppi("ArrayN");
	global $user_ID;
?>
<div class="Grid Grid--withGutter">
	<div class="Grid-cell u-md-size9of12 u-lg-size9of12">
<?php
	foreach($Circolari as $post) {
		if($accesso->user_can_read_post($post->ID)){
			$Destinatari=get_post_meta($post->ID, "_destinatari");
			$Elenco="";
			$Protetta="";
			if($Destinatario>0 AND $post->post_type!="circolari"){
				if(count($Destinatari)>0){		
					$Destinatari=unserialize($Destinatari[0]);
					if($Destinatario>0 AND !in_array($Destinatario,$Destinatari)){
						continue;
					}
					$Nomi_Des='';
		//			var_dump($Destinatari);var_dump($Gruppi);die();
					foreach($Destinatari as $Dest)
						$Nomi_Des.=$Gruppi[$Dest].", ";
					$Elenco=substr($Nomi_Des,0,-2);
				}
				$numero=get_post_meta($post->ID, "_numero",TRUE);
				$anno=get_post_meta($post->ID, "_anno",TRUE);
				$NumeroAtto="Numero ".$numero."_".$anno;
				$Destinatari='<span class="fa fa-users"></span> '.$Elenco;
			}else{
				$Destinatari="";
			}
			if (post_password_required( $post->ID )){
			 	$Protetta=' <span class="fas fa-lock"></span> Contenuto Protetto';	
			}else{
				$riassunto=	$post->post_excerpt;
			}		
?>
		<div class="Grid-cell">
	    	<div class="u-border-top-xxs u-padding-right-xxl u-padding-r-all">
				<h3 class="u-padding-r-top u-padding-r-bottom">
					<a class="u-text-h4 u-textClean u-color-50" href="<?php echo get_permalink($post->ID);?>"><?php echo $post->post_title;?></a>
	            </h3>
				<div class="u-textWeight-600">Del <?php echo gcg_FormatDataItaliano($post->post_date);?>  <?php echo $NumeroAtto;?></div> 
				<div class="u-textWeight-600">
					<span class="fa fa-folder-open"></span> <?php echo $post->post_type." ". $Destinatari." ".$Protetta;?>
	<?php	
			if (($post->post_type=="circolari") && gcg_Is_Circolare_Da_Firmare($post->ID)){
				if (!gcg_Is_Circolare_Firmata($post->ID)) {
					$ngiorni=gcg_GetscadenzaCircolare($post->ID,"",True);		
					if(gcg_Is_Circolare_Scaduta($post->ID)){
						echo '<span style="color:red;"><span class="fa fa-user-edit"></span> Scaduta e non Firmata</span>';
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
	                    if (get_post_meta($post->ID, "_sign",TRUE)=="Firma")
	                        echo "Firmare $entro";
	                    else
	                    	if (get_post_meta($post->ID, "_sign",TRUE)!="NoFirma")				
	                    		echo "Esprimere scelta $entro";
					}
				}else{
					echo "<span style=\"color:blue;\"><span class=\"fa fa-user-edit\"></span> Firmata</span>";
				}
			} ?>
				</div>
			</div>		
				<p class="u-lineHeight-l u-text-r-xs u-padding-r-right u-padding-top-s"><?php echo $riassunto;?></p>
		</div>
<?php	  }
	}
	?>
	</div>
</div>
<?php return ob_get_clean();
}
?>
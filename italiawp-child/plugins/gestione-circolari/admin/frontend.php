<?php
/**
 * Gestione Circolari
 * 
 * @package Gestione Circolari
 * @author Scimone Ignazio
 * @copyright 2011-2014
 * @since 2.8
 */

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

if (isset($_REQUEST['Anno']))
	$Anno=(int)$_REQUEST['Anno'];
else
	$Anno=date("Y");
$Mese=0;
if (isset($_REQUEST['Mese']))
	$Mese=(int)$_REQUEST['Mese'];
$ret=Lista_Circolari($Anno,$Mese);

function Lista_Circolari($Anno,$Mese){
ob_start();
	$Circolari=get_ListaCircolari(TRUE,0,$Anno,$Mese);?>
	<div class="Grid Grid--withGutter">
		<div class="Grid-cell u-md-size9of12 u-lg-size9of12">
<?php
	foreach($Circolari as $post) {
		$Elenco=$NumeroAtto=$riassunto=$Destinatari=$Protetta="";
		if ($post->post_type=="circolari"){
			$fgs = wp_get_object_terms($post->ID, 'gruppiutenti');
			if(!empty($fgs)){
				foreach($fgs as $fg){
					$Elenco.=$fg->name." - ";
				}
				$Elenco=substr($Elenco,0,strlen($Elenco)-3);
				$numero=get_post_meta($post->ID, "_numero",TRUE);
				$anno=get_post_meta($post->ID, "_anno",TRUE);
				$NumeroAtto="Numero ".$numero."_".$anno;
				$Destinatari='<span class="fa fa-users"></span> '.$Elenco;
			}
			if (post_password_required( $post->ID ))
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
		<div class="u-textWeight-600">Del <?php echo FormatDataItaliano($post->post_date);?>  <?php echo $NumeroAtto;?></div> 
			<div class="u-textWeight-600">
					<span class="fa fa-folder-open"></span> <?php echo $post->post_type." ". $Destinatari." ".$Protetta;?>
	<?php	
			if (Is_Circolare_Da_Firmare($post->ID))
				if (!Is_Circolare_Firmata($post->ID)) {
					$ngiorni=Get_scadenzaCircolare($post->ID,"",True);					
					if(Is_Circolare_Scaduta($post->ID)){
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
						$sign=get_post_meta($post->ID, "_firma",TRUE);
						if ($sign!="Si")
							$Tipo="Esprimere adesione $entro";
						else
							$Tipo="Firmare $entro";
						echo '<span style="color:red;"><span class="fa fa-user-edit"></span> '.$Tipo.'</span>';	
				}			
			}else{
				echo '<span style="color:blue;"><span class="fa fa-user-edit"></span> Firmata</span>';				
			}?>
			</div>
				<p class="u-lineHeight-l u-text-r-xs u-padding-r-right u-padding-top-s"><?php echo $riassunto;?></p>
			</div>
			</div>
	<?php	
}?>
	</div>
</div>
<?php return ob_get_clean();
}
?>
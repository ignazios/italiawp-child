<?php
/**
 * Gestione FrontEnd.
 * @link       http://www.eduva.org
 * @since      4.2
 *
 * @package    ALbo On Line
 */

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

include_once(dirname (__FILE__) .'/frontend_filtro.php');

ob_start();

if(isset($_REQUEST['id']) And !is_numeric($_REQUEST['id'])){
	$_REQUEST['id']=0;
	echo "<br /><span style='color:red;'>ATTENZIONE:</span> E' stato indicato un VALORE non valido per il parametro <span style='color:red;'>ID</span>";
	return;
}
if(isset($_REQUEST['action']) And $_REQUEST['action']!=wp_strip_all_tags($_REQUEST['action'])){
	unset($_REQUEST['action']);
	echo "<br /><span style='color:red;'>ATTENZIONE:</span> E' stato indicato un VALORE non valido per il parametro <span style='color:red;'>Action</span>";
	return;
}
if(isset($_REQUEST['categoria']) And !is_numeric($_REQUEST['categoria'])){
	$_REQUEST['categoria']=0;
	echo "<br /><span style='color:red;'>ATTENZIONE:</span> E' stato indicato un VALORE non valido per il parametro <span style='color:red;'>Categoria</span>";
}
if(isset($_REQUEST['numero']) And $_REQUEST['numero']!="" AND !is_numeric($_REQUEST['numero'])){
	$_REQUEST['numero']="";
	echo "<br /><span style='color:red;'>ATTENZIONE:</span> E' stato indicato un VALORE non valido per il parametro <span style='color:red;'>Numero</span>";
}
if(isset($_REQUEST['anno']) And !is_numeric($_REQUEST['anno'])){
	$_REQUEST['anno']=0;
	echo "<br /><span style='color:red;'>ATTENZIONE:</span> E' stato indicato un VALORE non valido per il parametro <span style='color:red;'>Anno</span>";
}
if(isset($_REQUEST['ente']) And !is_numeric($_REQUEST['ente'])){
	$_REQUEST['ente']="-1";
	echo "<br /><span style='color:red;'>ATTENZIONE:</span> E' stato indicato un VALORE non valido per il parametro <span style='color:red;'>Ente</span>";
}
if(isset($_REQUEST['Pag']) And !is_numeric($_REQUEST['Pag'])){
	$_REQUEST['Pag']=1;
	echo "<br /><span style='color:red;'>ATTENZIONE:</span> E' stato indicato un VALORE non valido per il parametro <span style='color:red;'>Pag</span>";
}
if(isset($_REQUEST['oggetto']) And $_REQUEST['oggetto']!=wp_strip_all_tags($_REQUEST['oggetto'])){
	$_REQUEST['oggetto']="";
	echo "<br /><span style='color:red;'>ATTENZIONE:</span> E' stato indicato un VALORE non valido per il parametro <span style='color:red;'>Oggetto</span>";
}
if(isset($_REQUEST['riferimento']) And $_REQUEST['riferimento']!=wp_strip_all_tags($_REQUEST['riferimento'])){
	$_REQUEST['riferimento']="";
	echo "<br /><span style='color:red;'>ATTENZIONE:</span> E' stato indicato un VALORE non valido per il parametro <span style='color:red;'>Riferimento</span>";
}
if(isset($_REQUEST['DataInizio']) And $_REQUEST['DataInizio']!=wp_strip_all_tags($_REQUEST['DataInizio'])){
	$_REQUEST['DataInizio']="";
	echo "<br /><span style='color:red;'>ATTENZIONE:</span> E' stato indicato un VALORE non valido per il parametro <span style='color:red;'>Da Data</span>";
}
if(isset($_REQUEST['DataFine']) And $_REQUEST['DataFine']!=wp_strip_all_tags($_REQUEST['DataFine'])){
	$_REQUEST['DataFine']="";
	echo "<br /><span style='color:red;'>ATTENZIONE:</span> E' stato indicato un VALORE non valido per il parametro <span style='color:red;'>A Data</span>";
}
if(isset($_REQUEST['filtra']) And $_REQUEST['filtra']!="Filtra"){
	$_REQUEST['filtra']="Filtra";
	echo "<br /><span style='color:red;'>ATTENZIONE:</span> E' stato indicato un VALORE non valido per il parametro <span style='color:red;'>filtra</span>";
}
if(isset($_REQUEST['vf']) And ($_REQUEST['vf']!="s" OR $_REQUEST['vf']!="undefined")){
	$_REQUEST['vf']="undefined";
	echo "<br /><span style='color:red;'>ATTENZIONE:</span> E' stato indicato un VALORE non valido per il parametro <span style='color:red;'>vf</span>";
}
foreach($_REQUEST as $Key => $Val){
	$_REQUEST[$Key]=htmlspecialchars(wp_strip_all_tags($_REQUEST[$Key]));
}

if(isset($_REQUEST['action'])){
	switch ($_REQUEST['action']){
        case 'printatto':
            if (is_numeric($_REQUEST['id'])) {
                if ($_REQUEST['pdf'] == 'c') {
                    StampaAtto($_REQUEST['id'], 'c');
                } elseif ($_REQUEST['pdf'] == 'a') {
                    StampaAtto($_REQUEST['id'], 'a');
                }
            }
            break;
		case 'visatto':
			if(is_numeric($_REQUEST['id']))
				VisualizzaAtto($_REQUEST['id']);
			else{
				$ret=Lista_Atti($Parametri);
			}
				
			break;
		case 'addstatall':
			if(is_numeric($_GET['id']) and is_numeric($_GET['idAtto']))
				ap_insert_log(6,5,(int)$_GET['id'],"Download",(int)$_GET['idAtto']);
			break;
		default: 
			if (isset($_REQUEST['filtra'])){
						
			 		$ret=Lista_Atti($Parametri,$_REQUEST['categoria'],(int)$_REQUEST['numero'],(int)$_REQUEST['anno'], htmlentities($_REQUEST['oggetto']),htmlentities($_REQUEST['DataInizio']),htmlentities($_REQUEST['DataFine']), htmlentities($_REQUEST['riferimento']),$_REQUEST['ente']);
			}else if(isset($_REQUEST['annullafiltro'])){
					 unset($_REQUEST['categoria']);
					 unset($_REQUEST['numero']);
					 unset($_REQUEST['anno']);
					 unset($_REQUEST['oggetto']);
					 unset($_REQUEST['riferimento']);
					 unset($_REQUEST['DataInizio']);
					 unset($_REQUEST['DataFine']);
					 unset($_REQUEST['ente']);
					 $ret=Lista_Atti($Parametri);
				}else{
					$ret=Lista_Atti($Parametri);
				}
		}	
	}else{
		if (isset($_REQUEST['filtra'])){
	 		$ret=Lista_Atti($Parametri,$_REQUEST['categoria'],(int)$_REQUEST['numero'],(int)$_REQUEST['anno'], htmlentities($_REQUEST['oggetto']),htmlentities($_REQUEST['DataInizio']),htmlentities($_REQUEST['DataFine']), htmlentities($_REQUEST['riferimento']),$_REQUEST['ente']);			
		}else if(isset($_REQUEST['annullafiltro'])){
		 unset($_REQUEST['categoria']);
		 unset($_REQUEST['numero']);
		 unset($_REQUEST['anno']);
		 unset($_REQUEST['oggetto']);
		 unset($_REQUEST['riferimento']);
		 unset($_REQUEST['DataInizio']);
		 unset($_REQUEST['ente']);
		 $ret=Lista_Atti($Parametri);
	}else{
		$ret=Lista_Atti($Parametri);

	}
}

function VisualizzaAtto($id){
	$risultato=ap_get_atto($id);
	$risultato=$risultato[0];
	$risultatocategoria=ap_get_categoria($risultato->IdCategoria);
	$risultatocategoria=$risultatocategoria[0];
	$allegati=ap_get_all_allegati_atto($id);
	$responsabile=ap_get_responsabile($risultato->RespProc);
	$responsabile=$responsabile[0];
	ap_insert_log(5,5,$id,"Visualizzazione");
	$coloreAnnullati=get_option('opt_AP_ColoreAnnullati');
	if($risultato->DataAnnullamento!='0000-00-00')
		$Annullato='<p style="background-color: '.$coloreAnnullati.';text-align:center;font-size:1.5em;">Atto Annullato dal Responsabile del Procedimento<br /><br />Motivo: <span style="font-size:1;font-style: italic;">'.stripslashes($risultato->MotivoAnnullamento).'</span></p>';
	else
		$Annullato='';
?>
<section  id="DatiAtto">
	<div class="container clearfix">
		<button class="Button Button--info Button--shadow u-text-r-xs u-margin-bottom-m" onclick="window.location.href='<?php echo $_SERVER['HTTP_REFERER'];?>'"><span class="fas fa-arrow-circle-left"></span> Torna alla Lista</button>
		<h2>Dati atto</h2>
		<?php echo ($Annullato?"<h3>'.$Annullato.'</h3>":"");?>
		<div class="u-layout-wide u-layoutCenter u-layout-withGutter u-background-white">
				<div class="Grid Grid--withGutter u-padding-all-xs u-text-r-xxs u-margin-r-right">
					<div class="Grid-cell u-sizeFull u-size1of1 u-lg-size8of12 ">
						<table class="table table-striped table-hove">
						    <tbody id="dati-atto">
							<tr>
								<th class="d-w25 text-right" style="border-top:0;">Ente titolare dell'Atto</th>
								<td class="align-middle"><?php echo stripslashes(ap_get_ente($risultato->Ente)->Nome);?></td>
							</tr>
							<tr>
								<th class="d-w25 text-right">Numero Albo</th>
								<td class="align-middle"><?php echo $risultato->Numero."/".$risultato->Anno;?></td>
							</tr>
							<tr>
								<th class="d-w25 text-right">Codice di Riferimento</th>
								<td class="align-middle"><?php echo stripslashes($risultato->Riferimento);?></td>
							</tr>
							<tr>
								<th class="d-w25 text-right">Oggetto</th>
								<td class="align-middle"><?php echo stripslashes($risultato->Oggetto);?></td>
							</tr>
							<tr>
								<th class="d-w25 text-right">Data inizio Pubblicazione</th>
								<td class="align-middle"><?php echo ap_VisualizzaData($risultato->DataInizio);?></td>
							</tr>
							<tr>
								<th class="d-w25 text-right">Data fine Pubblicazione</th>
								<td class="align-middle"><?php echo ap_VisualizzaData($risultato->DataFine)?></td>
							</tr>
							<tr>
								<th class="d-w25 text-right">Data oblio</th>
								<td class="align-middle"><?php echo ap_VisualizzaData($risultato->DataOblio);?></td>
							</tr>
							<tr>
								<th class="d-w25 text-right">Note</th>
								<td class="align-middle"><?php echo stripslashes($risultato->Informazioni);?></td>
							</tr>
							<tr>
								<th class="d-w25 text-right">Categoria</th>
								<td class="align-middle"><?php echo stripslashes($risultatocategoria->Nome)?></td>
							</tr>
<?php
$MetaDati=ap_get_meta_atto($id);
if($MetaDati!==FALSE){
	$Meta="";
	foreach($MetaDati as $Metadato){
		$Meta.="{".$Metadato->Meta."=".$Metadato->Value."} - ";
	}
	$Meta=substr($Meta,0,-3);?>
							<h2><?php echo $Titolo;?></h2>
							<tr>
								<th>Meta Dati</th>
								<td style="vertical-align: middle;"><?php echo $Meta;?></td>
							</tr>
<?php }?>
				 	    </tbody>
					</table>
				</div>
				<div class="Grid-cell u-sizeFull u-size1of1 u-lg-size4of12 ">
<?php 
$Soggetti=unserialize($risultato->Soggetti);
$Soggetti=ap_get_alcuni_soggetti_ruolo(implode(",",$Soggetti));
$Ruolo="";
if($Soggetti){
			echo "<h3>Soggetti</h3>";
}
foreach($Soggetti as $Soggetto){
	if(ap_get_Funzione_Responsabile($Soggetto->Funzione,"Display")=="No"){
		continue;
	}
	if($Soggetto->Funzione!=$Ruolo){
			$Ruolo=$Soggetto->Funzione;?>
					<div class="Callout Callout--could u-text-r-xs">
		  				<h4 class="Callout-title u-text-r-l"><?php echo ap_get_Funzione_Responsabile($Soggetto->Funzione,"Descrizione"); ?></h4>
		 				<div>
					<?php echo $Soggetto->Cognome." ".$Soggetto->Nome;?><br />
<?php	} 
	if ($Soggetto->Email)
		echo'		<a href="mailto:'.$Soggetto->Email.'">'.$Soggetto->Email.'</a><br />';
	if ($Soggetto->Telefono)
		echo	"Tel. ".$Soggetto->Telefono."<br />";
	if ($Soggetto->Orario)
		echo 	"Orario ricevimento: ".$Soggetto->Orario.'<br />';
	if ($Soggetto->Note)
		echo	"Note: ".$Soggetto->Note;
?>
						</div>
					</div>
<?php }?>
				</div>
			</div>
		</div>
	   	<div>
			<h3 class="u-text-h2 pt-3 pb-2">Allegati</h3>
<?php
if (strpos(get_permalink(),"?")>0)
	$sep="&amp;";
else
	$sep="?";
$TipidiFiles=ap_get_tipidifiles();
foreach ($allegati as $allegato) {
	$Estensione=ap_ExtensionType($allegato->Allegato);?>
	<div class="Grid Grid--withGutter u-margin-all-s u-border-all-xxs fb-border-tratteggiato">
    	<div class="Grid-cell u-size1of12 u-padding-all-l">
<?php
	if(isset($allegato->TipoFile) and $allegato->TipoFile!="" and ap_isExtensioType($allegato->TipoFile)){
		$Estensione=ap_ExtensionType($allegato->TipoFile);
		echo '<img src="'.$TipidiFiles[$Estensione]['Icona'].'" alt="'.$TipidiFiles[$Estensione]['Descrizione'].'" height="30" width="30"/>';
	}else{
		echo '<img src="'.$TipidiFiles[strtolower($Estensione)]['Icona'].'" alt="'.$TipidiFiles[strtolower($Estensione)]['Descrizione'].'" height="30" width="30"allegato/>';
	}?>
		</div>
		<div class="Grid-cell u-size11of12 dt-piccolo">
				<?php echo (isset($allegato->TitoloAllegato)?"<span class=\"font-weight-semibold Titolo\">".strip_tags($allegato->TitoloAllegato)."</span><br />":""); ?>
 <?php	if (is_file($allegato->Allegato))
		echo '        <a href="'.ap_DaPath_a_URL($allegato->Allegato).'" class="addstatdw" rel="'.get_permalink().$sep.'action=addstatall&amp;id='.$allegato->IdAllegato.'&amp;idAtto='.$id.'" target="_blank">'. basename( $allegato->Allegato).'</a> ('.ap_Formato_Dimensione_File(filesize($allegato->Allegato)).')<br />'.htmlspecialchars_decode($TipidiFiles[strtolower($Estensione)]['Verifica']).' <a href="'.get_permalink().$sep.'action=dwnalle&amp;id='.$allegato->IdAllegato.'&amp;idAtto='.$id.'" >Scarica allegato</a>';		
			else
				echo basename( $allegato->Allegato)." File non trovato, il file &egrave; stato cancellato o spostato!";?>
			</div>
		</div>
<?php	}?>
		</div>
	</div>
</section>
<?php
}

function Lista_Atti($Parametri,$Categoria=0,$Numero=0,$Anno=0,$Oggetto='',$Dadata=0,$Adata=0,$Riferimento='',$Ente=-1){
	switch ($Parametri['stato']){
			case 0:
				$TitoloAtti="Tutti gli Atti";
				break;
			case 1:
				$TitoloAtti="Atti in corso di Validit&agrave;";
				break;
			case 2:
				$TitoloAtti="Atti Scaduti";
				break;
			case 3:
				$TitoloAtti="Atti da Pubblicare";
				break;
	}
	if (isset($Parametri['per_page'])){
		$N_A_pp=$Parametri['per_page'];	
	}else{
		$N_A_pp=10;
	}
	if (isset($Parametri['cat']) and $Parametri['cat']!=0){
		$DesCategorie="";
		$Categoria="";
		$Categorie=explode(",",$Parametri['cat']);
		foreach($Categorie as $Cate){
			$DesCat=ap_get_categoria($Cate);
			$DesCategorie.=$DesCat[0]->Nome.",";
			$Categoria.=$Cate.",";
		}
		$DesCategorie= substr($DesCategorie,0, strlen($DesCategorie)-1);
		$TitoloAtti.=" Categorie ".$DesCategorie;
		$Categoria=substr($Categoria,0, strlen($Categoria)-1);
		$cat=1;
	}else{
		$Categorie=$Categoria;
		$cat=0;
	}
	if (!isset($_REQUEST['Pag'])){
		$Da=0;
		$A=$N_A_pp;
	}else{
		$Da=($_REQUEST['Pag']-1)*$N_A_pp;
		$A=$N_A_pp;
	}
	if (!isset($_REQUEST['ente'])){
         $Ente = '-1';
	}else{
        $Ente = $_REQUEST['ente'];
	}
	$TotAtti=ap_get_all_atti($Parametri['stato'],$Numero,$Anno,$Categorie,$Oggetto,$Dadata,$Adata,'',0,0,true,false,$Riferimento,$Ente);
	$lista=ap_get_all_atti($Parametri['stato'],$Numero,$Anno,$Categorie,$Oggetto,$Dadata,$Adata,'Anno DESC,Numero DESC',$Da,$A,false,false,$Riferimento,$Ente); 
	$titEnte=get_option('opt_AP_LivelloTitoloEnte');
	if ($titEnte=='')
		$titEnte="h2";
	$titPagina=get_option('opt_AP_LivelloTitoloPagina');
	if ($titPagina=='')
		$titPagina="h3";
	$coloreAnnullati=get_option('opt_AP_ColoreAnnullati');
	$colorePari=get_option('opt_AP_ColorePari');
	$coloreDispari=get_option('opt_AP_ColoreDispari');?>
<section  id="FiltroAtti">
	<div class="u-layout-medium u-layoutCenter">
		<h2>Filtri</h2>
		<div class="u-layout-wide u-layoutCenter u-layout-withGutter u-background-white">
				<div class="Accordion Accordion--default fr-accordion js-fr-accordion" id="accordion-1">
			<div class="Grid Grid--withGutter u-padding-all-xs u-text-r-xxs u-margin-r-right">
					<div class="Grid-cell u-sizeFull u-md-size1of2 u-lg-size1of2 u-padding-bottom-xs">
			    		<h2 class="Accordion-header js-fr-accordion__header fr-accordion__header u-borderRadius-l u-border-all-xxs u-background-10" style="width:99%;" id="accordion-header-0">
			    			<span class="Accordion-link">Parametri</span>
			    		</h2>
						<div id="accordion-panel-0" class="Accordion-panel fr-accordion__panel js-fr-accordion__panel u-background-grey-10">
						    <?php echo get_FiltriParametri();?>
						</div>
					</div>
					<div class="Grid-cell u-sizeFull u-md-size1of2 u-lg-size1of2">
			    		<h2 class="Accordion-header js-fr-accordion__header fr-accordion__header u-borderRadius-l u-border-all-xxs u-background-10"  style="width:99%;" id="accordion-header-1">
			    			<span class="Accordion-link">Categorie</span>
			    		</h2>
						<div id="accordion-panel-1" class="Accordion-panel fr-accordion__panel js-fr-accordion__panel u-background-grey-10">
						    <?php echo get_FiltriCategorie();?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php				  
echo ' <div class="Visalbo">
<a name="dati"></a> ';
if (get_option('opt_AP_VisualizzaEnte')=='Si')
		echo '<'.$titEnte.' ><span  class="titoloEnte">'.stripslashes(get_option('opt_AP_Ente')).'</span></'.$titEnte.'>';
echo '<'.$titPagina.'>'.$TitoloAtti.'</'.$titPagina.'>';
$Nav="";
if ($TotAtti>$N_A_pp){
	    $Para='';
	    foreach ($_REQUEST as $k => $v){
			if ($k!="Pag" and $k!="vf")
				if ($Para=='')
					$Para.=$k.'='.$v;
				else
					$Para.='&amp;'.$k.'='.$v;
		}
		if ($Para=='')
			$Para="?Pag=";
		else
			$Para="?".$Para."&amp;Pag=";
		$Npag=(int)($TotAtti/$N_A_pp);
		if ($TotAtti%$N_A_pp>0){
			$Npag++;
		}
		$Nav.= '<nav role="navigation" aria-label="Navigazione paginata" class="u-layout-prose">
    <ul class="Grid Grid--fit Grid--alignMiddle">
		<li class="Grid-cell u-textCenter u-md-inlineBlock u-lg-inlineBlock">
			<strong>N. Atti '.$TotAtti.'</strong>
        </li>';
     	if (isset($_REQUEST['Pag']) And $_REQUEST['Pag']>1 ){
 			$Pagcur=$_REQUEST['Pag'];
			$PagPre=$Pagcur-1; 
				$Nav.= '<li class="Grid-cell u-textCenter u-md-inlineBlock u-lg-inlineBlock"><a href="'.$Para.'1" title="Vai alla prima pagina" class="u-color-50 u-textClean u-block u-md-inlineBlock u-lg-inlineBlock"><span class="fas fa-angle-double-left"></span></a></li>
					  <li class="Grid-cell u-textCenter u-md-inlineBlock u-lg-inlineBlock"><a href="'.$Para.$PagPre.'" title="Vai alla pagina precedente" class="u-color-50 u-textClean u-block u-md-inlineBlock u-lg-inlineBlock"><span class="fas fa-angle-left"></span></a></li> ';
		}else{
				$Nav.= '<li class="Grid-cell u-textCenter u-md-inlineBlock u-lg-inlineBlock"><span class="fas fa-angle-double-left u-color-grey-40  u-block u-md-inlineBlock u-lg-inlineBlock"></span></li>
					  <li class="Grid-cell u-textCenter u-md-inlineBlock u-lg-inlineBlock"><span class="fas fa-angle-left u-color-grey-40  u-block u-md-inlineBlock u-lg-inlineBlock"></span></a></li> ';			
			$Pagcur=1;
		}
		switch($Npag){
			case 1:
				$Inf=1;
				$Sup=1;
				break;
			case 2:
				$Inf=1;
				$Sup=2;
				break;
			default:
				if($Pagcur<$Npag){
					if($Pagcur<2){
						$Inf=1;
						$Sup=3;
					}else{
						$Inf=$Pagcur-1;
						$Sup=$Pagcur+1;
					}		
				}else{
						$Inf=$Npag-2;
						$Sup=$Npag;			
				}
				break;
		}
		for($i=$Inf;$i<$Sup+1;$i++){
			if($i==$Pagcur){
				$Nav.= "<li class=\"Grid-cell u-textCenter u-md-inlineBlock u-lg-inlineBlock\">
					<span class=\"u-padding-r-all u-block u-background-50 u-color-white\"><span class=\"u-text-r-s\">".$i."</span></li>";
			}else{
				$Nav.= "<li class=\"Grid-cell u-textCenter u-md-inlineBlock u-lg-inlineBlock\"><a href=\"".$Para.$i."\" class=\"u-color-50 u-textClean u-block u-md-inlineBlock u-lg-inlineBlock\">".$i."</a></li>";
			}
		}
   		if ($Npag>0 ){
   			$CurPage=(isset($_REQUEST['Pag'])?$_REQUEST['Pag']:1);
   			$PagSuc=($Pagcur==$Npag?$Npag:$Pagcur+1);
 			$Nav.= '<li class="Grid-cell u-textCenter u-md-inlineBlock u-lg-inlineBlock">';
 			if ($CurPage<$Npag)
 				$Nav.= '<a href="'.$Para.$PagSuc.'" title="Vai alla pagina successiva"><span class="fas fa-angle-right u-color-50 u-textClean u-block u-md-inlineBlock u-lg-inlineBlock"></span></a></li>';
 			else
 				$Nav.= '<span class="fas fa-angle-right u-color-grey-40 u-block u-md-inlineBlock u-lg-inlineBlock"></span></li>';
			$Nav.= '<li class="Grid-cell u-textCenter u-md-inlineBlock u-lg-inlineBlock">';
			if ($CurPage<$Npag) 
				$Nav.= '<a href="'.$Para.$Npag.'" title="Vai all\'ultima pagina"><span class="fas fa-angle-double-right u-color-50 u-textClean u-block u-md-inlineBlock u-lg-inlineBlock"></span></a></li>';
			else
				$Nav.= '<span class="fas fa-angle-double-right u-color-grey-40  u-block u-md-inlineBlock u-lg-inlineBlock"></span></li>';
		}
		$Nav.= '</ul>
		</nav>';
	}	
echo $Nav;
$FEColsOption=get_option('opt_AP_ColonneFE',array(
									"Data"=>0,
									"Ente"=>0,
									"Riferimento"=>0,
									"Oggetto"=>0,
									"Validita"=>0,
									"Categoria"=>0,
									"Note"=>0,
									"RespProc"=>0,
									"DataOblio"=>0));
if(!is_array($FEColsOption)){
	$FEColsOption=shortcode_atts(array(
				"Data"=>0,
				"Ente"=>0,
				"Riferimento"=>0,
				"Oggetto"=>0,
				"Validita"=>0,
				"Categoria"=>0,
				"Note"=>0,
				"RespProc"=>0,
				"DataOblio"=>0), json_decode($FEColsOption,TRUE),"");
}	
echo '	<div class="tabalbo">                               
		<table class="Table js-TableResponsive tablesaw tablesaw-stack" data-tablesaw-mode="stack" summary="atti validi per riferimento, oggetto e categoria"> 	
		<thead>
	    	<tr>
	        	<th scope="col">Prog.</th>';
foreach($FEColsOption as $Opzione => $Valore){
		if($Valore==1){
			echo '			<th scope="col">'.$Opzione.'</th>';
		}
}
echo '	</tr>
	    </thead>
	    <tbody>';
	    $CeAnnullato=false;
	if ($lista){
	 	$pari=true;
		if (strpos(get_permalink(),"?")>0)
			$sep="&amp;";
		else
			$sep="?";
		foreach($lista as $riga){
			$Link='<a href="'.get_permalink().$sep.'action=visatto&amp;id='.$riga->IdAtto.'"  style="text-decoration: underline;">';
			$categoria=ap_get_categoria($riga->IdCategoria);
			$cat=$categoria[0]->Nome;
			$responsabileprocedura=ap_get_responsabile($riga->RespProc);
			$respproc=$responsabileprocedura[0]->Cognome." ".$responsabileprocedura[0]->Nome;
			$NumeroAtto=ap_get_num_anno($riga->IdAtto);
	//		Bonifica_Url();
			$ParCella='';
			if($riga->DataAnnullamento!='0000-00-00'){
				$ParCella='style="background-color: '.$coloreAnnullati.';" title="Atto Annullato. Motivo Annullamento: '.$riga->MotivoAnnullamento.'"';
				$CeAnnullato=true;
			}
			echo '<tr >
			        <td '.$ParCella.'>'.$Link.$NumeroAtto.'/'.$riga->Anno .'</a> 
					</td>';
			if ($FEColsOption['Data']==1)
				echo '
					<td '.$ParCella.'>
						'.ap_VisualizzaData($riga->Data) .'
					</td>';
			if ($FEColsOption['Ente']==1)
				echo '
					<td '.$ParCella.'>
						'.stripslashes(ap_get_ente($riga->Ente)->Nome) .'
					</td>';
			if ($FEColsOption['Riferimento']==1)
				echo '
					<td '.$ParCella.'>
						'.stripslashes($riga->Riferimento) .'
					</td>';
			if ($FEColsOption['Oggetto']==1)
				echo '			
					<td '.$ParCella.'>
						'.stripslashes($riga->Oggetto) .'
					</td>';
			if ($FEColsOption['Validita']==1)
				echo '								
					<td '.$ParCella.'>
						'.ap_VisualizzaData($riga->DataInizio) .'<br />'.ap_VisualizzaData($riga->DataFine) .'  
					</td>';
			if ($FEColsOption['Categoria']==1)
				echo '								
					<td '.$ParCella.'>
						'.$cat .'
					</td>';
			if ($FEColsOption['Note']==1)
				echo '
					<td '.$ParCella.'>
						'.stripslashes($riga->Informazioni) .'
					</td>';
			if ($FEColsOption['RespProc']==1)
				echo '
					<td '.$ParCella.'>
						'.$respproc .'
					</td>';	
			if ($FEColsOption['DataOblio']==1)
				echo '
					<td '.$ParCella.'>
						'.ap_VisualizzaData($riga->DataOblio) .'
					</td>';
		echo '	
				</tr>'; 
			}
	} else {
			echo '<tr>
					<td colspan="6">Nessun Atto Codificato</td>
				  </tr>';
	}
	echo '
     </tbody>
    </table>';
echo '</div>';
	if ($CeAnnullato) 
		echo '<p>Le righe evidenziate con questo sfondo <span style="background-color: '.$coloreAnnullati.';">&nbsp;&nbsp;&nbsp;</span> indicano Atti Annullati</p>';
echo '</div><!-- /wrap -->	';
echo $Nav;
return ob_get_clean();
}
?>
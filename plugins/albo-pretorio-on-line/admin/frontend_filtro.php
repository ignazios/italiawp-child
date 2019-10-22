<?php
/**
 * Gestione Filtri FrontEnd.
 * @link       http://www.eduva.org
 * @since      4.3
 *
 * @package    Albo On Line
 */
function get_FiltriParametri($Stato=1,$cat=0,$StatoFinestra="si"){
	$anni=ap_get_dropdown_anni_atti('anno','anno','d-inline','',(isset($_REQUEST['anno'])?$_REQUEST['anno']:date("Y")),$Stato); 
	$categorie=ap_get_dropdown_ricerca_categorie('categoria','categoria','postform','',(isset($_REQUEST['categoria'])?$_REQUEST['categoria']:0),$Stato); 
	ap_Bonifica_Url();
	if (strpos($_SERVER['REQUEST_URI'],"?")>0)
		$sep="&amp;";
	else
		$sep="?";
	$titFiltri=get_option('opt_AP_LivelloTitoloFiltri');
	if ($titFiltri=='')
		$titFiltri="h3";
	$HTML='<form id="filtro-atti" action="'.htmlentities($_SERVER['REQUEST_URI']).'" method="post">';
	if (strpos(htmlentities($_SERVER['REQUEST_URI']),'page_id')>0){
		$HTML.= '<input type="hidden" name="page_id" value="'.ap_Estrai_PageID_Url().'" />';
	}	
	$HTML.= '<input type="hidden" name="categoria" value="'.$cat.'" />
<table class="Table Table--withBorder js-TableResponsive tablesaw tablesaw-stack" data-tablesaw-mode="stack">
    <thead>
        <tr>
            <th scope="col">Parametro</th>
            <th scope="col">Valore</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Ente</td>
            <td>'.ap_get_dropdown_enti("ente","ente","form-control","",(isset($_REQUEST['ente'])?$_REQUEST['ente']:"")).'</td>
        </tr>
        <tr>
            <td>Atto</td>
            <td><input class="d-inline d-w50" placeholder="N&deg; Atto" type="number" size="5" maxlength="10" id="numero" name="numero" value="'.(isset($_REQUEST['numero'])?$_REQUEST['numero']:"").'" />/'.$anni.'</td>
         </tr>
         <tr>
           <td>Riferimento</td>
            <td><input type="text" size="40" name="riferimento" id ="riferimento" value="'.(isset($_REQUEST['riferimento'])?$_REQUEST['riferimento']:"").'"/></td>
         </tr>

         <tr>
           <td>Oggetto</td>
            <td><input type="text" size="40" name="oggetto" id ="oggetto" value="'.(isset($_REQUEST['oggetto'])?$_REQUEST['oggetto']:"").'"/></td>
         </tr>
         <tr>
           <td>da Data</td>
            <td><input name="DataInizio" class="w-50" id="Calendario1" type="text" value="'.htmlentities((isset($_REQUEST['DataInizio'])?$_REQUEST['DataInizio']:"")).'" size="10"/></td>
         </tr>
         <tr>
           <td>a Data</td>
            <td><input name="DataFine" class="w-50" id="Calendario2" type="text" value="'.htmlentities((isset($_REQUEST['DataFine'])?$_REQUEST['DataFine']:"")).'" size="10"/></td>
         </tr>
         <tr>
           <td><button type="submit" class="Button Button--default Button--shadow Button--round u-text-r-xs" name="filtra" id="filtra" value="Filtra">Filtra</button></td>
            <td><button type="submit" class="Button Button--default Button--shadow Button--round u-text-r-xs" name="annullafiltro" id="annullafiltro" value="Annulla Filtro">Annulla Filtro</button></td>
         </tr>
    </tbody>
</table>
	</form>';
	return $HTML;
}

function get_FiltriCategorie(){
	$lista=ap_get_categorie_gerarchica();
	$HTMLL='<div class="ricercaCategoria">
		<ul class="Linklist u-text-r-xxs" id="ListaCategorieAlbo">';
	if ($lista){
		foreach($lista as $riga){
		 	$shift=(((int)$riga[2])*15);
	   		$numAtti=ap_num_atti_categoria($riga[0],$Stato);
		 	if (strpos(get_permalink(),"?")>0)
		  		$sep="&amp;";
	   		else
		   		$sep="?";
	   		if ($numAtti>0)
	      		$HTMLL.='               <li><a href="'.get_permalink().$sep.'filtra=Filtra&amp;categoria='.$riga[0].'"  ><span class="u-background-70 u-color-white u-text-r-s u-padding-left-xxs u-padding-right-xxs u-borderRadius-circle"> '.$numAtti.' </span> '.$riga[1].'</a></li>'; 
		}
	}else{
		$HTMLL.= '                <li>Nessuna Categoria Codificata</li>';
	}
	$HTMLL.='             </ul>';
	return $HTMLL;
}
?>
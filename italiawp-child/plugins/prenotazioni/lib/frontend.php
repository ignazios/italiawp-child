<?php
/**
 * Prenotazioni
 * Codice di gestione della componente Pubblica
 * @package Prenotazioni
 * @author Scimone Ignazio
 * @copyright 2014-2099
 * @version 1.6.5
 **/

//if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }
  global $Gest_Prenotazioni,$G_Spaces;
if (!is_user_logged_in()){
	echo $G_Spaces->get_ListaSpaziDiv();
}else{
	if (isset($_POST['navigazioneGiorni']) and $_POST['navigazioneGiorni']=="Prenota" and (int)$_POST["NumOrePren"]>0 And (int)$_POST["OraInizioPrenotazione"]>0){
//		var_dump($_POST);die();
		$ris=$Gest_Prenotazioni->newPrenotazione($_POST['DataPrenotazione'],$_POST['OraInizioPrenotazione'],$_POST['NumOrePren'],$_POST['SpazioP'],$_POST['NumSet'],$_POST['notePrenotazione'],$_POST['_wpnonce']);
		echo '<div class="Prose Alert Alert--info Alert--withIcon u-layout-prose u-padding-r-bottom u-padding-r-right u-margin-r-bottom" role="alert">
			    <h2 class="u-text-h3">Risultato prenotazione</h2>
			<p class="u-text-p">'.$ris.'</p></div>
      		<meta http-equiv="refresh" content="5;url='.get_permalink().'"/>';	
	}else{
	    $Nuovo=FALSE;
	    $Statistiche=FALSE;
	    $Spazi=FALSE;
	    $NumSchede=0;
	    if(isset($Para['schede'])){
	        $SetSC=explode(",",strtolower($Para['schede']));                 
	    }
	    else {
	        $SetSC=array("nuovo","statistiche","spazi");
	    }
	    if(isset($Para['titoli'])){
	        $Titoli=explode(",",$Para['titoli']);                 
	    }else {
	        $Titoli=array("Nuovo","Statistiche","Spazi");
	    }
	    if(in_array("nuovo", $SetSC)){
	        $Nuovo=TRUE;
	        $NumSchede++;
	    }
	    if(in_array("statistiche", $SetSC)){
	        $Statistiche=TRUE;
	        $NumSchede++;
	    }
	    if(in_array("spazi", $SetSC)){
	        $Spazi=TRUE;
	        $NumSchede++;
	    }
	    $Parametri=get_Pre_Parametri();
	    if($Statistiche){
	        if(isset($Titoli[1]) And strlen($Titoli[1])>0 and $NumSchede==1)
	            $Stat="<h3>".$Titoli[1]."</h3>";
	        else
	            $Stat="";
	        $Stat.="<div class=\"Grid Grid--withGutter\">
	            		<div class=\"Grid-cell u-sm-size1of1 u-md-size1of3 u-lg-size1of3\">
	        				<h3>Ultime 5 prenotazione passate</h3>";
	        $Elenco=$Gest_Prenotazioni->get_Prenotazioni("<");
	        if(count($Elenco)>0){
		        $Stat.="<table class=\"Table Table--withBorder js-TableResponsive tablesaw tablesaw-stack\" data-tablesaw-mode=\"stack\">
		                <thead>
		                <tr>
	                        <th scope=\"col\">Spazio</th>
	                        <th scope=\"col\">Data</th>
	                        <th scope=\"col\">Ora Inizio</th>
	                        <th scope=\"col\">Ora Fine</th>
		                </tr>
		             </thead>
		             <tbody>";
		        foreach ($Elenco as $Elemento) {
		                $Stat.='
		                <tr>
		                        <td>'.$G_Spaces->get_NomeSpazio($Elemento->IdSpazio).'</td>
		                        <td>'.DataVisualizza($Elemento->DataPrenotazione).'</td>
		                        <td>'.$Elemento->OraInizio.'</td>
		                        <td>'.$Elemento->OraFine.'</td>
		                </tr>';
		        }
		        $Stat.= "
		                        </tbody>
		                </table>";     	
	        }else{
	        	$Stat.= '<div class="Prose Alert Alert--info Alert--withIcon u-layout-prose u-padding-r-bottom u-padding-r-right u-margin-r-bottom" role="alert">
    						<p class="u-text-p">Nessuna Prenotazione</p>
						</div>';
	        }
	        $Stat.= "
	        			</div>
	        			<div class=\"Grid-cell u-sm-size1of1 u-md-size1of3 u-lg-size1of3\">
	        				<h3>Prenotazioni di oggi</h3>";
	        $Elenco=$Gest_Prenotazioni->get_Prenotazioni("=");
	        if(count($Elenco)>0){
		        $Stat.= "<table class=\"Table Table--withBorder js-TableResponsive tablesaw tablesaw-stack\" data-tablesaw-mode=\"stack\">
		                <thead>
		                <tr>
	                        <th scope=\"col\">Spazio</th>
	                        <th scope=\"col\">Data</th>
	                        <th scope=\"col\">Ora Inizio</th>
	                        <th scope=\"col\">Ora Fine</th>
		                </tr>
		             </thead>
		             <tbody>";
		        foreach ($Elenco as $Elemento) {
		                $Stat.= '
		                <tr>
	                        <td>'.$G_Spaces->get_NomeSpazio($Elemento->IdSpazio).'</td>
	                        <td>'.DataVisualizza($Elemento->DataPrenotazione).'</td>
	                        <td>'.$Elemento->OraInizio.'</td>
	                        <td>'.$Elemento->OraFine.'</td>
		                </tr>';
		        }
		        $Stat.= "
		                </tbody>
		        </table>";
			}else{
	        	$Stat.= '<div class="Prose Alert Alert--info Alert--withIcon u-layout-prose u-padding-r-bottom u-padding-r-right u-margin-r-bottom" role="alert">
    						<p class="u-text-p">Nessuna Prenotazione</p>
						</div>';				
			}
	        $Stat.= "
	        			</div>
	        			<div class=\"Grid-cell u-sm-size1of1 u-md-size1of3 u-lg-size1of3\">
							<h3>Prossime 5 Prenotazioni</h3>";
	        $Elenco=$Gest_Prenotazioni->get_Prenotazioni(">");
	        if(count($Elenco)>0){
		        $Stat.= "<table class=\"Table Table--withBorder js-TableResponsive tablesaw tablesaw-stack\" data-tablesaw-mode=\"stack\">	
		                <thead>
		                <tr>
	                        <th scope=\"col\">Spazio</th>
	                        <th scope=\"col\">Data</th>
	                        <th scope=\"col\">Ora Inizio</th>
	                        <th scope=\"col\">Ora Fine</th>
		                </tr>
		             </thead>
		             <tbody>";
		        foreach ($Elenco as $Elemento) {
		                $Stat.= '
		                <tr>
	                        <td>'.$G_Spaces->get_NomeSpazio($Elemento->IdSpazio).'</td>
	                        <td>'.DataVisualizza($Elemento->DataPrenotazione).'</td>
	                        <td>'.$Elemento->OraInizio.'</td>
	                        <td>'.$Elemento->OraFine.'</td>
		                </tr>';
		        }
		        $Stat.= "
		                </tbody>
		        </table>";
			}else{
	        	$Stat.= '<div class="Prose Alert Alert--info Alert--withIcon u-layout-prose u-padding-r-bottom u-padding-r-right u-margin-r-bottom" role="alert">
    						<p class="u-text-p">Nessuna Prenotazione</p>
						</div>';					
			}                    
		$Stat.= '
		    	</div>
	    </div>';
	    }?>
 		<div class="Accordion Accordion--default fr-accordion js-fr-accordion" id="accordion-1">
<?php if($Nuovo):
                   if(isset($Titoli[0]) And strlen($Titoli[0])>0 and $NumSchede==1)
                        $TitFinPren="<h3 style=\"margin-top:5px;\">".$Titoli[0]."</h3>";
                    else
                        $TitFinPren="<h3 style=\"margin-top:5px;\">Dati della prenotazione:</h3>";
	                $Spazio=$G_Spaces->get_ListaSpazi("SpazioP","SpazioP","Form-input"); ?>
		    <h2 class="Accordion-header js-fr-accordion__header fr-accordion__header" id="accordion-header-0">
		        <span class="Accordion-link"><?php echo ((isset($Titoli[0]) And strlen($Titoli[0]))>0?$Titoli[0]:"Nuova");?></span>
		    </h2>
		<div id="accordion-panel-0" class="Accordion-panel fr-accordion__panel js-fr-accordion__panel">
		<form name="Memo_Prenotazioni"  action="<?php echo $_SERVER["REQUEST_URI"];?>" method="post" class="Form Form--spaced u-padding-all-xl u-text-r-xs"> 
			<fieldset id="CampiPrenotazioniSpazi" class="Form-fieldset">
	            <legend class="Form-legend u-border-bottom-xxs">
	    			<h3>Ordine di compilazione</h3>
				</legend>	
				<div class="Form-field">
					<div class="Grid Grid--withGutter">
						<div class="Grid-cell u-sizeFull">
							<ol class="Bullets">
		                        <li><h3>Selezionare lo spazio</h3></li>
		                        <li><h3>Selezionare la Data prenotazione</h3></li>
		                        <li><h3>Nella tabella Ora Inizio cliccare sul pulsante 'Imposta ora inizio' corrispondenete all'ora in cui deve iniziare la prenotazione</h3></li>
		                        <li><h3>Selezionare il N° Ore della prenotazione</h3></li>
		                        <li><h3>Se la prenotazione deve essere ripetuta più volte in settimane diverse, bisogna in dicare il N° settimane</h3></li>
		                        <li><h3>Indicare opzionalmente il Motivo Prenotazione</h3></li>
		                        <li><h3>Cliccare su Prenota</h3></li>
		                	</ol>
		                </div>
		            </div>
                </div>
				<legend class="Form-legend u-border-bottom-xxs"><h3>Spazio</h3></legend>
				<div id="loading">LOADING!</div>
				<div class="Form-field">
		            <div class="Grid Grid--withGutter">
	            		<div class="Grid-cell u-sm-size6of12 u-md-size2of12 u-lg-size2of12">
                			<img src="<?php echo $G_Spaces->get_Foto();?>" id="imgSpazio" />
                		</div>
                		<div class="Grid-cell u-sm-size6of12 u-md-size8of12 u-lg-size8of12">
                			<?php echo $Spazio;?>
                		</div>
                	</div>
		        </div>
				<legend class="Form-legend u-border-bottom-xxs"><h3>Data e Ora prenotazione</h3></legend>
				<div class="Form-field">
					<div class="Grid Grid--alignMiddle Grid--withGutter">
						<div class="Grid-cell u-sizeFull u-sm-size6of12 u-md-size1of4 u-lg-size1of4 u-padding-bottom-l">
			                <div class="Grid Grid--alignMiddle Grid--withGutter">
			                    <div class="Grid-cell u-size1of2">
			            			<input class="Form-input u-text-r-s u-borderRadius-m js-Datepicker" type="date" id="DataPrenotazione" name="DataPrenotazione" value="<?php echo get_pre_Oggi();?>"/>
			        			</div>
			                    <div class="Grid-cellu-size1of2">
					            <button type="button" aria-describedby="appointment-label" aria-controls="DataPrenotazione">
					            	<span class="u-hiddenVisually">Seleziona la data</span>
			  							<span class="Icon-calendar u-text-r-l"></span>
								</button>
			        			</div>
			                </div>
			            </div>
			            <div class="Grid-cell u-sm-size6of12 u-md-size1of4 u-lg-size1of4 u-padding-bottom-l">
			                <label>Ora Inizio: <span id="VisOraInizio"></span></label>
			                <div id="InizioPre">
			                        <?php echo createTablePrenotazioniSpazio($G_Spaces->get_FirstID());?>
			                </div>
		           		</div>
			            <div class="Grid-cell u-sizeFull u-sm-size6of12 u-md-size1of4 u-lg-size1of4 u-padding-bottom-l">
			                <label>N&deg; ore:</label> 
			                <select class="Form-input" aria-required="true" id="NumOrePren" name="NumOrePren">
			                        <option value="0">----</option>		
			                </select>
			            </div>
			            <div class="Grid-cell u-sizeFull u-size1of1 u-sm-size6of12 u-md-size1of4 u-lg-size1of4 u-padding-bottom-l">
			                <label> N&deg; settimane:</label> 
			                <select class="Form-input" aria-required="true" id="NumSet" name="NumSet">
			                    <option value="1">1</option>
			                    <option value="2">2</option>
			                    <option value="3">3</option>
			                    <option value="4">4</option>
			                    <option value="5">5</option>
			                    <option value="6">6</option>
			                    <option value="7">7</option>
			                    <option value="8">8</option>
			                    <option value="9">9</option>
			                    <option value="10">10</option>		
			                </select>
			        	</div>
		        	</div>
		        </div>
				<legend class="Form-legend u-border-bottom-xxs"><h3>Note</h3></legend>
				<div class="Form-field">
			        <textarea rows="8" id="notePrenotazione" class="Form-input Form-textarea" name="notePrenotazione"></textarea>
				</div>
				<div class="Form-field">
                    <input type="hidden" id="OraInizioPrenotazione" value="" name="OraInizioPrenotazione"/>
                    <input type="hidden" id="UrlAjax" value="<?php echo admin_url( 'admin-ajax.php' );?>" name="UrlAjax"/>
                    <input type="hidden" id="ColPrenotato" value="<?php echo $Parametri['ColPrenotato'];?>" />
                    <input type="hidden" id="OraInizio" value="<?php echo $Parametri['OraInizio'];?>" />
                    <input type="hidden" id="OraFine" value="<?php echo $Parametri['OraFine'];?>" />
                    <input type="hidden" id="NumMaxOre" value="<?php echo $Parametri['MaxOrePrenotabili'];?>" />
                    <input type="hidden" id="MinOrePrima" value="<?php echo $Parametri['PrenEntro'];?>" />
                    <input type="hidden" id="_wpnonce" value="<?php echo wp_create_nonce( 'secmemopren' );?>" name="_wpnonce" />
                    <button type="submit" class="Button Button--default Button--shadow Button--round u-text-r-xs" value="Prenota" name="navigazioneGiorni">Prenota</button>   
	            </div>
                </fieldset>
           </form>     
        </div>
<?php endif;
	if($Statistiche):?>
		    <h2 class="Accordion-header js-fr-accordion__header fr-accordion__header" id="accordion-header-1">
		        <span class="Accordion-link"><?php echo ((isset($Titoli[1]) And strlen($Titoli[1]))>0?$Titoli[1]:"Statistiche");?></span>
		    </h2>
		    <div id="accordion-panel-1" class="Accordion-panel fr-accordion__panel js-fr-accordion__panel">
		       <?php echo $Stat;?>
		    </div>
<?php endif;
	if($Spazi):?>
		    <h2 class="Accordion-header js-fr-accordion__header fr-accordion__header" id="accordion-header-3">
		        <span class="Accordion-link"><?php echo ((isset($Titoli[2]) And strlen($Titoli[2]))>0?$Titoli[2]:"Catalogo Spazi");?></span>
		    </h2>
		    <div id="accordion-panel-3" class="Accordion-panel fr-accordion__panel js-fr-accordion__panel">
		        <?php echo $G_Spaces->get_ListaSpaziDiv();?>
		    </div>
<?php endif;?>

		</div>

<?php	}
}?>
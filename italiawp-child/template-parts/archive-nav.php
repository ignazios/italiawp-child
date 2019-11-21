<?php
//if(!get_query_var('cat') and !get_query_var('author') And !get_query_var('tag'))
	//return;
		global $wpdb, $wp_locale;
		$mesi = array(1=>'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre','Dicembre');
	$Result="";
	$Origine="";
	$Origine_valore="";
	if (get_query_var('cat')){
		$Origine="cat";
		$Origine_valore=get_query_var('cat');
		$args=array('post_status'    => array( 'publish', 'private' ),
					'post_type'      => 'post',
					'posts_per_page' => -1,
					'cat'            => $Origine_valore);
	}elseif(get_query_var('author')){
		$Origine="author";
		$Origine_valore=get_query_var('author');
		$args=array('post_status'    => array( 'publish', 'private' ),
					'post_type'      => 'post',
					'posts_per_page' => -1,
					'author'         => $Origine_valore);
	}elseif(get_query_var('tag')){
		$Origine="tag";
		$Origine_valore=get_query_var('tag');
		$args=array('post_status'    => array( 'publish', 'private' ),
		'post_type'      => 'post',
		'posts_per_page' => -1,
		'tag'            => $Origine_valore);
	}else{
		$Origine="";
		$Origine_valore="";
		$args=array('post_status'    => array( 'publish', 'private' ),
		'post_type'      => 'post',
		'posts_per_page' => -1);
		
	}
	//		echo "<br />".$Sql;exit;
			$ArchivioDate= new WP_Query($args);
//			$ArchivioDate = $wpdb->get_results($Sql);
//print_r($ArchivioDate->posts);wp_die();
			if(count($ArchivioDate->posts)==0){
?>
				<h4>Archivio Vuoto</h4>
<?php				
			wp_die("Errore archivio vuoto");
			}?>
<div class="Grid-cell u-sizeFull u-md-size3of12 u-lg-size3of12">
	<div id="subnav" class="Grid-cell u-sizeFull u-md-size9of12 u-lg-size11of12 u-md-before1of12 u-lg-before1of12">
	    <div class="u-nbfc u-color-grey-30 u-xs-padding-all-none u-sizeFull u-borderShadow-m u-borderRadius-m u-background-white BoxArchivioTop">
        	<div class="u-padding-r-all">
            	<div  style="min-height: 100px;">
                	<h3 class="u-textWeight-400 u-text-r-xs u-color-grey-80 u-margin-r-bottom"><span class="far fa-calendar-alt"></span> Date archivio</h3>
 					<div class="Accordion Accordion--default fr-accordion js-fr-accordion" id="accordion-page">
<?php			$Anno=0;
			foreach ($ArchivioDate->posts as $Data){
				if ($Anno!=$Data->Anno){
					if($Anno!=0){
?>
					</ul>
				</div>
<?php						
					}
?>
				<h4 class="MenuHeader Accordion-header js-fr-accordion__header fr-accordion__header" id="accordion-header-<?php echo $Data->Anno;?>">
					<span class="Accordion-link"><?php echo $Data->Anno;?></span>
				</h4>
				<div id="accordion-panel-<?php echo $Data->Anno;?>" class="Accordion-panel fr-accordion__panel js-fr-accordion__panel">
					<ul class="Linklist u-text-r-xxs">
<?php					
					$Anno=$Data->Anno;
				}
				$Link=esc_url(home_url('/')).$Data->Anno."/".$Data->Mese."/?".$Origine."=".$Origine_valore;
				echo '<li><a href="'.$Link.'"><span class="u-background-70 u-color-white u-text-r-s u-padding-left-xxs u-padding-right-xxs u-borderRadius-circle">'.$Data->NumArt.'</span> '.$mesi[$Data->Mese].'</a></li>';
			}
?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    

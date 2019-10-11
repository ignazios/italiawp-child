<?php
/* 
 * Remember that this file is only used if you have chosen to override event pages with formats in your event settings!
 * You can also override the single event page completely in any case (e.g. at a level where you can control sidebars etc.), as described here - http://codex.wordpress.org/Post_Types#Template_Files
 * Your file would be named single-event.php
 */
/*
 * This page displays a single event, called during the the_content filter if this is an event page.
 * You can override the default display settings pages by copying this file to yourthemefolder/plugins/events-manager/templates/ and modifying it however you need.
 * You can display events however you wish, there are a few variables made available to you:
 * 
 * $args - the args passed onto EM_Events::output() 
 */
global $EM_Event;
		function cv_DataDB($Data){
			$Data=explode("-",$Data);
			return implode("/",array($Data[2],$Data[1],$Data[0]));
		}
/* @var $EM_Event EM_Event */
echo $EM_Event->output_single();
$DataInizio=cv_DataDB($EM_Event->event_start_date);
$DataFine=isset($EM_Event->event_end_date)&&$EM_Event->event_end_date!=$EM_Event->event_start_date?cv_DataDB($EM_Event->event_end_date):"";
?>
<div>
	<p>
		<span class="Icon Icon-calendar"></span> Data Ora evento:
		<ul class="listaDati">
			<li><?php echo $DataInizio. ($DataFine!=""?" - ".$DataFine:"");?></li>
			<li><?php echo $EM_Event->event_start_time." - ".$EM_Event->event_end_time;?></li>
		</ul>
	</p>
	<p>
		<span class="Icon Icon-pin"></span> Luogo:
		<ul class="listaDati">
			<li><a href="<?php echo get_permalink($EM_Event->location->post_id);?>"><?php echo $EM_Event->location->location_name;?></a></li>
		</ul>
	</p>	
</div>
<?php
var_dump($EM_Event);
?>
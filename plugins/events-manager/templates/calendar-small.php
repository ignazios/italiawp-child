<?php 
/*
 * This file contains the HTML generated for small calendars. You can copy this file to yourthemefolder/plugins/events-manager/templates and modify it in an upgrade-safe manner.
 * 
 * There are two variables made available to you: 
 * 
 * 	$calendar_array - contains an array of information regarding the calendar and is used to generate the content
 *  $args - the arguments passed to EM_Calendar::output()
 * 
 * Note that leaving the class names for the previous/next links will keep the AJAX navigation working.
 */
// var_dump($calendar_array);
    /**
     * Backwards compatability for an old setting which is now just another scope.
     * @param unknown_type $instance
     * @return string
     */
?>
<div  id="CalendarioEventi" class="Grid Grid--withGutter u-padding-all-xs">
		<div id="loading"></div>
	<div class="Grid-cell u-sizeFull u-sm-size1of1 u-md-size1of3 u-lg-size1of4 u-flex loading">
<?php
// Inizioalizzazione calendario al mese/anno corrente
	$argscal=array();
	$argscal['month'] = date("M");
	$argscal['year'] = date("Y");
	$this->VisCalendar($argscal);
    echo $args['after_widget'];
?>

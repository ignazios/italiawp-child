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
<div class="Grid Grid--withGutter u-padding-all-xs">
		<div id="loading"></div>
	<div id="CalendarioEventi" class="Grid-cell u-sizeFull u-sm-size1of1 u-md-size1of3 u-lg-size1of4 u-flex loading">
<?php
// Inizioalizzazione calendario al mese/anno corrente
	$argscal=array();
	$argscal['month'] = date("M");
	$argscal['year'] = date("Y");
	$this->VisCalendar($argscal);
?>
	</div>

<?php
		//remove owner searches
    	$this->defaults = array(
    		'title' => __('Events','events-manager'),
    		'scope' => 'future',
    		'order' => 'ASC',
    		'limit' => 5,
    		'category' => 0,
    		'format' => '<li>#_EVENTLINK<ul><li>#_EVENTDATES</li><li>#_LOCATIONTOWN</li></ul></li>',
    		'nolistwrap' => false,
    		'orderby' => 'event_start_date,event_start_time,event_name',
			'all_events' => 0,
			'all_events_text' => __('all events', 'events-manager'),
			'no_events_text' => '<li>'.__('No events', 'events-manager').'</li>'
    	);
//		$args['owner'] = false;
		$instance = array_merge($this->defaults, $instance);
    	$instance = $this->fix_scope($instance); // depcreciate	
		if( !array_key_exists($instance['orderby'], $this->em_orderby_options) ){
			//replace old values
			$old_vals = array(
				'name' => 'event_name',
				'end_date' => 'event_end_date',
				'start_date' => 'event_start_date',
				'end_time' => 'event_end_time',
				'start_time' => 'event_start_time'
			);
			foreach($old_vals as $old_val => $new_val){
				$instance['orderby'] = str_replace($old_val, $new_val, $instance['orderby']);
			}
		}
		
		//get events
		//var_dump($args);
		$events = EM_Events::get(apply_filters('em_widget_events_get_args',$instance));
		//output events
		if ( count($events) > 0 ){
	//		var_dump($events);
			foreach($events as $event){
	//			var_dump($event);
				$DataInizio=self::explodeDataDB($event->event_start_date);
				$DataFine=isset($event->event_end_date)&&$event->event_end_date!=$event->event_start_date?self::explodeDataDB($event->event_end_date):"";
?>
		<div class="Grid-cell u-sizeFull u-sm-size1of1 u-md-size1of3 u-lg-size1of4">
		<div class="clndr u-nbfc u-sizeFull u-xs-padding-all-none u-borderShadow-m u-xs-borderShadow-none u-borderRadius-m u-background-white">
			<div class="box_data_evento">
                <div class="box_data_calendario_number">
                    <span><?php echo $DataInizio['GG'];?></span>
                    <p><?php echo date("M",mktime(0, 0, 0, $DataInizio['MM'], 1, $DataInizio['AA']));?></p>
                    <small><?php echo $DataInizio['AA'];?></small>
                </div>
				<hr size="1"/>
				<div class="box_data_calendario_number">
                  <span><?php echo is_array($DataFine)?$DataFine['GG']:"";?></span>
                    <p><?php echo is_array($DataFine)?date("M",mktime(0, 0, 0, $DataFine['MM'], 1, $DataFine['AA'])):"";?></p>
                    <small><?php echo is_array($DataFine)?$DataFine['AA']:"";?></small>	
            	</div>
        	</div>
        	<div class="box_contenuto_evento u-text-r-xxs u-padding-r-all">
        		<h3><a href='<?php echo get_permalink($event->post_id);?>'><?php echo $event->post_title;?></a></h3>
        		<p><?php echo isset($event->post_excerpt)?$event->post_excerpt:$event->post_excerpt;?></p>
        	</div>
        	</div>
        </div>
<?php //				echo $event->output( $args['format'] );

			}
		}else{
		    echo $args['no_events_text'];
		}
		if ( !empty($args['all_events']) ){
			$events_link = (!empty($args['all_events_text'])) ? em_get_link($args['all_events_text']) : em_get_link(__('all events','events-manager'));
			$events_link=str_replace('">','" class="u-color-50 u-textClean u-text-h4">',$events_link);
			$events_link=str_replace('</a>',' <span class="Icon Icon-chevron-right"></span></a>',$events_link);
?>
</div>
			<p class="u-textCenter u-text-md-right u-text-lg-right u-margin-r-top u-text-r-xl">
            <?php echo $events_link;?>
        	</p>

<?php		}
		
	    echo $args['after_widget'];
?>

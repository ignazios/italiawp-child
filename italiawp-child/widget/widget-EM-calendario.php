<?php
/**
* Widget my_EM_Widget_Calendar
*	   Titolo:	($title) Testo che viene visualizzato in Testa all'elenco degli articoli estratti
*	  Blocchi:	($blocchi) Array di max 4 elementi di (Immagine,Testo,Link)
*/
class my_EM_Widget_Calendar extends WP_Widget
{

	var $defaults = array("title"		=> "Eventi",
	"long_events"	=> 0,
	"category"	=> "",
	"limit"		=> "5",
	"scope"		=> "12-months",
	"orderby"		=> "event_start_date,event_start_time,event_name",
	"order"		=> "ASC",
	"all_events"	=> "on",
	"all_events_text"=>"tutti gli eventi");

	function __construct()
	{

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

	function VisCalendar($argscal, $Parametri)
	{
		//			echo $Parametri;
		$Parametri=json_decode($Parametri);
		$calendar_array  = EM_Calendar::get($argscal);
?>
<div class="clndr u-nbfc u-borderShadow-m u-xs-borderShadow-none u-borderRadius-m u-background-white em-calendar-wrapper">
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
			$EventiMese=array();
			foreach ($calendar_array['cells'] as $date => $cell_data ) {
				if ( !empty($cell_data['events'])) {
					$EventiMese[]=array("Inizio"	=>$cell_data['events']['event_start_date'],
					"Fine"		=>$cell_data['events']['event_end_date'],
					"Oggetto"	=>$cell_data['events']);
				}
			}
			//echo "<pre>";var_dump($EventiMese);echo "</pre>";

			//echo "<pre>";var_dump($calendar_array['cells']);echo "</pre>";
			$cal_count = count($calendar_array['cells']);
			$col_count = 0;
			$count = 1; //this counts collumns in the $calendar_array_array['cells'] array
			$col_max = count($calendar_array['row_headers']); //each time this collumn number is reached, we create a new collumn, the number of cells should divide evenly by the number of row_headers
			foreach ($calendar_array['cells'] as $date => $cell_data ) {
				$class = ( !empty($cell_data['events']) && count($cell_data['events']) > 0 ) ? 'eventful':'eventless';
				if (!empty($cell_data['type'])) {
					$class .= "-".$cell_data['type'];
				}
			?>
			<div class="day past calendar-dow-<?php echo $col_count; ?> <?php echo esc_attr($class); ?>">
				<?php
				if ( !empty($cell_data['events']) && count($cell_data['events']) > 0 )
					: ?>
				<a href="<?php echo esc_url($cell_data['link']); ?>" title="<?php echo esc_attr($cell_data['link_title']); ?>" class="u-background-70 u-color-white"><?php echo esc_html(date('j',$cell_data['date'])); ?></a>
				<?php else
					: ?>
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
</div>
<div id="loading"></div>
<?php
//echo "<pre>";var_dump($instance);echo "</pre>";
//get events
//		echo $argscal["month"];
$instance["month"]=(is_numeric($argscal["month"])?$argscal["month"]:date("m"));
$instance["year"]=$argscal["year"];
$events = EM_Events::get(apply_filters('em_widget_events_get_args',$instance));

//output events
//		echo "<pre>";var_dump($events);echo "</pre>";
$NumeroEvento=0;
if ( count($events) > 0 ) {
	//		var_dump($events);
	foreach ($events as $event) {
		$NumeroEvento++;
		if ($NumeroEvento>$Parametri->limit) {

		} else {
			//			var_dump($event);
			$DataInizio=self::explodeDataDB($event->event_start_date);
			$DataFine=isset($event->event_end_date)&&$event->event_end_date!=$event->event_start_date?self::explodeDataDB($event->event_end_date):"";
?>
<div class="Grid-cell u-sizeFull u-sm-size1of1 u-md-size1of3 u-lg-size1of4 u-flex loading">
	<div class="clndr u-nbfc u-sizeFull u-xs-padding-all-none u-borderShadow-m u-xs-borderShadow-none u-borderRadius-m u-background-white">
		<div class="box_data_evento">
			<div class="box_data_calendario_number">
				<span><?php echo $DataInizio['GG']; ?></span>
				<p><?php echo date("M",mktime(0, 0, 0, $DataInizio['MM'], 1, $DataInizio['AA'])); ?></p>
				<small><?php echo $DataInizio['AA']; ?></small>
			</div>
			<hr size="1"/>
			<div class="box_data_calendario_number">
				<span><?php echo is_array($DataFine)?$DataFine['GG']:""; ?></span>
				<p><?php echo is_array($DataFine)?date("M",mktime(0, 0, 0, $DataFine['MM'], 1, $DataFine['AA'])):""; ?></p>
				<small><?php echo is_array($DataFine)?$DataFine['AA']:""; ?></small>
			</div>
		</div>
		<div class="box_contenuto_evento u-text-r-xxs u-padding-r-all">
			<h3>
				<a href='<?php echo get_permalink($event->post_id); ?>'><?php echo $event->post_title; ?></a></h3>
			<p><?php echo isset($event->post_excerpt)?$event->post_excerpt:$event->post_excerpt; ?></p>
		</div>
	</div>
</div>
<?php //				echo $event->output( $args['format'] );
}
}
} else {
?>
<div class="Grid-cell u-sizeFull u-sm-size1of1 u-md-size1of3 u-lg-size1of4">
	<div class="clndr u-nbfc u-sizeFull u-xs-padding-all-none u-borderShadow-m u-xs-borderShadow-none u-borderRadius-m u-background-white">
		<h3 class="u-textCenter u-text-h3"><?php echo $Parametri->no_events_text; ?></h3>
	</div>
</div>
<?php	}
}
function CalendarioMese()
{
	check_ajax_referer('aggiornamentoCalendario','security');
	$argscal=array();
	$argscal['month'] = filter_input(INPUT_POST,'mese');
	$argscal['year'] = filter_input(INPUT_POST,'anno');
	$Parametri=filter_input(INPUT_POST,'parametri');
	$this->VisCalendar($argscal,$Parametri);
	//var_dump($_POST);
	die();
}
function fix_scope($instance)
{
	if ( !empty($instance['time_limit']) && is_numeric($instance['time_limit']) && $instance['time_limit'] > 1 ) {
		$instance['scope'] = $instance['time_limit'].'-months';
	}elseif( !empty($instance['time_limit']) && $instance['time_limit'] == 1){
		$instance['scope'] = 'month';
	}elseif( !empty($instance['time_limit']) && $instance['time_limit'] == 'no-limit'){
		$instance['scope'] = 'all';
	}
	return $instance;
}
private function output($args = array(), $instance = true, $Parametri)
{
	//Let month and year REQUEST override for non-JS users
?>
<div  id="CalendarioEventi" class="Grid Grid--withGutter u-padding-all-xs">
<div class="Grid-cell u-sizeFull u-sm-size1of1 u-md-size1of3 u-lg-size1of4 u-flex loading">
	<?php
	// Inizioalizzazione calendario al mese/anno corrente
	$argscal=array();
	$argscal['month'] = date("M");
	$argscal['year'] = date("Y");
	$this->VisCalendar($argscal,$Parametri);
	$calendar = ob_get_clean();
	return apply_filters('myem_calendar_output', $calendar, $args);
}

private function explodeDataDB($Data)
{
	$Data=explode("-",$Data);
	return array("GG" => $Data[2],
	"MM" => $Data[1],
	"AA" => $Data[0]);
}

function widget($args, $instance)
{
	extract($args);
	$title = apply_filters('widget_title', $instance['title']);

	$defaults = array(
	'title' => __('Events','events-manager'),
	'scope' => 'future',
	'order' => 'ASC',
	'limit' => 5,
	'category' => 0,
	'format' => '',
	'nolistwrap' => false,
	'orderby' => 'event_start_date,event_start_time,event_name',
	'all_events' => NULL,
	'all_events_text' => __('all events', 'events-manager'),
	'no_events_text' => __('No events', 'events-manager'));
	$em_orderby_options = apply_filters('em_settings_events_default_orderby_ddm', array(
	'event_start_date,event_start_time,event_name' => __('start date, start time, event name','events-manager'),
	'event_name,event_start_date,event_start_time' => __('name, start date, start time','events-manager'),
	'event_name,event_end_date,event_end_time' => __('name, end date, end time','events-manager'),
	'event_end_date,event_end_time,event_name' => __('end date, end time, event name','events-manager'),
	));
	$instance = array_merge($defaults,$instance);
	$instance['owner'] = false;

	//orderby fix for previous versions with old orderby values
	if ( !array_key_exists($instance['orderby'], $em_orderby_options) ) {
		//replace old values
		$old_vals = array(
		'name' => 'event_name',
		'end_date' => 'event_end_date',
		'start_date' => 'event_start_date',
		'end_time' => 'event_end_time',
		'start_time' => 'event_start_time'
		);
		foreach ($old_vals as $old_val => $new_val) {
			$instance['orderby'] = str_replace($old_val, $new_val, $instance['orderby']);
		}
	}
	$Parametri=json_encode($instance);
	?>
	<div class="u-layoutCenter u-layout-withGutter u-padding-r-top u-background-white">
		<?php
		echo $before_widget
		?>
		<div class="u-layout-medium u-layoutCenter">
			<input type="hidden" value='<?php echo $Parametri; ?>' name="Parametri" id="Parametri"/>
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
			} else {
				$instance['month'] = date("m");
				$instance['year'] = date("Y");
			}
			//Our Widget Content
			echo self::output($args,$instance,$Parametri);
			?> </div> <?php

			$Parametri=json_decode($Parametri);
			//		var_dump($Parametri);
			if ( $Parametri->all_events=="1" ) {
				$events_link = (!empty($Parametri->all_events_text)) ? em_get_link($Parametri->all_events_text) : em_get_link(__('all events','events-manager'));
				$events_link=str_replace('">','" class="u-color-50 u-textClean u-text-h4">',$events_link);
				$events_link=str_replace('</a>',' <span class="Icon Icon-chevron-right"></span></a>',$events_link);
			?>
		<p class="u-textCenter u-text-md-right u-text-lg-right u-text-r-xl">
			<?php echo $events_link; ?>
		</p>
		<?php		}
	echo $args['after_widget'];
		?>



	</div>
</div>
<?php
}

/** @see WP_Widget::update */
function update($new_instance, $old_instance)
{
	//		    var_dump($new_instance)	;wp_die();
	//filter the new instance and replace blanks with defaults
/*	    	$new_instance['title'] = (!isset($new_instance['title'])) ? $this->defaults['title']:$new_instance['title'];
$new_instance['long_events'] = ($new_instance['long_events'] == '') ? $this->defaults['long_events']:$new_instance['long_events'];
$new_instance['category'] = ($new_instance['category'] == '') ? $this->defaults['category']:$new_instance['category'];
*/
	foreach ($this->defaults as $key => $value) {
		//		   		echo $key." - ".$value." - ";
		$new_instance[$key]=(!isset($new_instance[$key])) ? $this->defaults[$key]:$new_instance[$key];
		//	   			echo $new_instance[$key]."<br />";
	}
	//	    	wp_die();
	return $new_instance;
}

/** @see WP_Widget::form */
function form($instance)
{
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
<h2>Paramentri Lista Eventi</h2>
<p>
	<label for="<?php echo $this->get_field_id('limit'); ?>"><?php esc_html_e('Number of events','events-manager'); ?>: </label>
	<input type="text" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" size="3" value="<?php echo esc_attr($instance['limit']); ?>" />
</p>
<p>

	<label for="<?php echo $this->get_field_id('scope'); ?>"><?php esc_html_e('Scope','events-manager'); ?>: </label><br/>
	<select id="<?php echo $this->get_field_id('scope'); ?>" name="<?php echo $this->get_field_name('scope'); ?>" class="widefat" >
		<?php
		foreach ( em_get_scopes() as $key => $value)
			: ?>
		<option value='<?php echo esc_attr($key); ?>' <?php echo ($key == $instance['scope']) ? "selected='selected'" : ''; ?>>
			<?php echo esc_html($value); ?>
		</option>
		<?php endforeach; ?>
	</select>
</p>
<p>
	<label for="<?php echo $this->get_field_id('order'); ?>"><?php esc_html_e('Order By','events-manager'); ?>: </label>
	<select  id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" class="widefat">
		<?php
		foreach ($this->em_orderby_options as $key => $value)
			: ?>
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
		<?php
		foreach ( $order_options as $key => $value)
			: ?>
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
	<label for="<?php echo $this->get_field_id('all_events'); ?>"><?php _e('Show all events link at bottom?', 'events-manager'); ?>: </label>
	<input type="checkbox" id="<?php echo $this->get_field_id('all_events'); ?>" name="<?php echo $this->get_field_name('all_events'); ?>" value="1" <?php echo ($instance['all_events'] == '1') ? 'checked="checked"':''; ?>/>





</p>
<p id="<?php echo $this->get_field_id('all_events'); ?>-section">
	<label for="<?php echo $this->get_field_id('all_events'); ?>"><?php esc_html_e('All events link text?','events-manager'); ?>: </label>
	<input type="text" id="<?php echo $this->get_field_id('all_events_text'); ?>" name="<?php echo $this->get_field_name('all_events_text'); ?>" value="<?php echo esc_attr( $instance['all_events_text'] ); ?>" >
</p>
<?php
}
}	
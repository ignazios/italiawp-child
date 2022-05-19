<?php
/****************************************************************************
Widget Amministrazione Trasparente
Titolo:	($title) Testo che viene visualizzato in Testa al blocco del widget
Logic:	($logic) Indica se visualizzare solo nella pagina indicata nelle impostazioni, pagina archivio e singola dei documenti

*/

class my_atWidget extends WP_Widget {

    function __construct(){
        parent::__construct( 'my_atwidget', 'ItaliaWP Amministrazione Trasparente', array( 'description' => 'Personalizzazione della lista delle sezioni relative alla trasparenza per il template ItaliaWP' ) );
    }

    function widget( $args, $instance ) {
        extract($args);

		if ( $instance['logic'] && !( is_tax( 'tipologie' ) || is_singular( 'amm-trasparente' ) || is_page( at_option('page_id') )) ) {
			return;
		}

        echo $before_widget;

        echo $before_title.$instance['title'].$after_title;
?>
		<ul>
			<li>
		<div class="Accordion Accordion--default fr-accordion js-fr-accordion u-text-r-m u-padding-r-left" id="AT-ListaSezioni">
<?php
		foreach (amministrazionetrasparente_getarray() as $inner) {
?>
			<h4 class="MenuHeader Accordion-header js-fr-accordion__header fr-accordion__header d-tPiccolo" id="accordion-header-<?php echo $inner[0];?>"  style="font-size: 0.5em!important;">
        		<span class="Accordion-link" style="font-size: 1.5em!important;"><?php echo $inner[0];?></span>
   			 </h4>
	   		<div id="accordion-panel-<?php echo $inner[0];?>" class="Accordion-panel fr-accordion__panel js-fr-accordion__panel">
        		<ul class="Linklist u-text-r-xxs">
<?php 
		    $atreturn = '';
		    foreach ($inner[1] as $value) {
		        echo '<li><a href="' . get_term_link( get_term_by('name', $value, 'tipologie'), 'tipologie' ) . '" title="' . $value . '">' . $value . '</a></li>';
		    }?>
		    	</ul>
		    </div>   				
<?php	} ?>		
		</div>
			</li>
		</ul>
<?php

        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
		delete_option( 'at_option_widget' );
		delete_option( 'at_logic_widget' );

		$instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['logic'] = isset($new_instance['logic']) ? 1 : 0;

        return wp_parse_args( (array) $instance, self::get_defaults() );

    }

	 private static function get_defaults() {
        $defaults = array(
            'title' => 'Amministrazione Trasparente',
            'expandable' => 0,
            'logic' => 0
        );
        return $defaults;
    }

    function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, self::get_defaults() );

        $title = esc_attr($instance['title']); ?>
        <p><label for="<?php echo $this->get_field_id('title');?>">
        Titolo: <input class="widefat" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" type="text" value="<?php echo $title; ?>" />
        </label></p>
		<p><input type="checkbox" id="<?php echo $this->get_field_id('logic');?>" name="<?php echo $this->get_field_name('logic');?>"
		<?php checked( $instance[ 'logic' ] ); ?>/> Visualizza solo nella pagina indicata nelle impostazioni, pagina archivio e singola dei documenti</p>
		<input type="hidden" name="submitted" value="1" />
        <?php
    }
}



?>
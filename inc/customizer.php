<?php

function italiawp_child_customize_register($wp_customize) {

$categories = get_categories('hide_empty=0');
$cate=array();
if (count($categories)!=0)
	foreach ($categories as $category) {
		$cate[$category->term_id]=$category->cat_name." (".$category->category_count.")";
	}
$pages=get_pages();	
$pagine=array();
if (count($pages)!=0)
	foreach ($pages as $pages) {
		$pagine[$pages->ID]=$pages->post_title;
	}    
/**
* Template Home Sezione In Evidenza
*/
    $wp_customize->add_section('scuola_settings', array(
        'title' => 'Blocchi Home Page per la scuola',
        'description'	 => 'Opzioni valide solo se si utilizza il template di pagina Home Page',
        'priority' => 2,
    ));
    
    $wp_customize->add_setting('active_slide_inevidenza', array(
        'default' => false, 
        'capability' => 'edit_theme_options', 
        'sanitize_callback' => 'italiawp_sanitize_checkbox'));
    $wp_customize->add_control('active_slide_inevidenza', array(
        'type' => 'checkbox', 
        'label' => 'Visualizza Slide Post in evidenza',
        'section' => 'scuola_settings', 
        'settings' => 'active_slide_inevidenza',
        'priority'	=> 1));
    $wp_customize->add_setting( 'Home_blocco_InEvidenza_categoria' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'Home_blocco_InEvidenza_categoria', array(
        'type' 		=> 'select',
        'label' 	=> 'Seleziona la categoria in Evidenza',
        'section' 	=> 'scuola_settings',
        'settings' => 'Home_blocco_InEvidenza_categoria',
        'priority'	=> 2,
        'choices'   => $cate));			
    $wp_customize->add_setting( 'Home_blocco_InEvidenza_numart' , array(
		'sanitize_callback' => 'italiawp_child_sanitize_number',
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'Home_blocco_InEvidenza_numart', array(
        'type' 		=> 'number',
        'input_attrs' => array( 'min' => 0, 'max' => 10),
        'label' 	=> 'Quanti articoli ciclare?',
        'section' 	=> 'scuola_settings',
        'settings' => 'Home_blocco_InEvidenza_numart',
        'priority'	=> 3,
        'choices'   => 4));	
    $wp_customize->add_setting('active_blocco_scuola', array(
        'default' => false, 
        'capability' => 'edit_theme_options', 
        'sanitize_callback' => 'italiawp_sanitize_checkbox'));
    $wp_customize->add_control('active_blocco_scuola', array(
        'type' => 'checkbox', 
        'label' => 'Visualizza Blocco Scuola',
        'section' => 'scuola_settings', 
        'settings' => 'active_blocco_scuola',
        'priority'	=> 4));
    $wp_customize->add_setting( 'Scuola_Testo_SinUp' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'Scuola_Testo_SinUp', array(
        'type' 		=> 'text',
        'label' 	=> 'Blocco Sinistra Alto Testo:',
        'section' 	=> 'scuola_settings',
        'settings' => 'Scuola_Testo_SinUp',
        'priority'	=> 5));	
	$wp_customize->add_setting('Scuola_Logo_SinUp', array(
	    'type' => 'theme_mod',
	    'capability' => 'edit_theme_options',
	    'sanitize_callback' => 'absint'
	));
	$wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'Scuola_Logo_SinUp', array(
	    'section' => 'scuola_settings',
	    'label' => 'Immagine dim. 280x150',
	    'width' => 280,
	    'height' => 150,
	    'priority'	=> 6))); 
    $wp_customize->add_setting( 'Scuola_categoria_SinUp' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'Scuola_categoria_SinUp', array(
        'type' 		=> 'select',
        'label' 	=> 'Categoria',
        'section' 	=> 'scuola_settings',
        'settings' => 'Scuola_categoria_SinUp',
        'priority'	=> 7,
        'choices'   => $cate));	
    $wp_customize->add_setting( 'Scuola_Testo_DesUp' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'Scuola_Testo_DesUp', array(
        'type' 		=> 'text',
        'label' 	=> 'Blocco Destra Alto Testo:',
        'section' 	=> 'scuola_settings',
        'settings' => 'Scuola_Testo_DesUp',
        'priority'	=> 8));	
	$wp_customize->add_setting('Scuola_Logo_DesUp', array(
	    'type' => 'theme_mod',
	    'capability' => 'edit_theme_options',
	    'sanitize_callback' => 'absint'
	));
	$wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'Scuola_Logo_DesUp', array(
	    'section' => 'scuola_settings',
	    'label' => 'Immagine dim. 280x150',
	    'width' => 280,
	    'height' => 150,
	    'priority'	=> 9))); 
    $wp_customize->add_setting( 'Scuola_categoria_DesUp' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'Scuola_categoria_DesUp', array(
        'type' 		=> 'select',
        'label' 	=> 'Categoria',
        'section' 	=> 'scuola_settings',
        'settings' => 'Scuola_categoria_DesUp',
        'priority'	=> 10,
        'choices'   => $cate));	
    $wp_customize->add_setting( 'Scuola_Testo_SinDw' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'Scuola_Testo_SinDw', array(
        'type' 		=> 'text',
        'label' 	=> 'Blocco Sinistra Basso Testo:',
        'section' 	=> 'scuola_settings',
        'settings' => 'Scuola_Testo_SinDw',
        'priority'	=> 11));	
 	$wp_customize->add_setting('Scuola_Logo_SinDw', array(
	    'type' => 'theme_mod',
	    'capability' => 'edit_theme_options',
	    'sanitize_callback' => 'absint'
	));
	$wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'Scuola_Logo_SinDw', array(
	    'section' => 'scuola_settings',
	    'label' => 'Immagine dim. 280x150',
	    'width' => 280,
	    'height' => 150,
	    'priority'	=> 12))); 
    $wp_customize->add_setting( 'Scuola_categoria_SinDw' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'Scuola_categoria_SinDw', array(
        'type' 		=> 'select',
        'label' 	=> 'Categoria',
        'section' 	=> 'scuola_settings',
        'settings' => 'Scuola_categoria_SinDw',
        'priority'	=> 13,
        'choices'   => $cate));	
    $wp_customize->add_setting( 'Scuola_Testo_DesDw' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'Scuola_Testo_DesDw', array(
        'type' 		=> 'text',
        'label' 	=> 'Blocco Destra Basso Testo:',
        'section' 	=> 'scuola_settings',
        'settings' => 'Scuola_Testo_DesDw',
        'priority'	=> 14));	
 	$wp_customize->add_setting('Scuola_Logo_DesDw', array(
	    'type' => 'theme_mod',
	    'capability' => 'edit_theme_options',
	    'sanitize_callback' => 'absint'
	));
	$wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'Scuola_Logo_DesDw', array(
	    'section' => 'scuola_settings',
	    'label' => 'Immagine dim. 280x150',
	    'width' => 280,
	    'height' => 150,
	    'priority'	=> 15))); 
    $wp_customize->add_setting( 'Scuola_categoria_DesDw' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'Scuola_categoria_DesDw', array(
        'type' 		=> 'select',
        'label' 	=> 'Categoria',
        'section' 	=> 'scuola_settings',
        'settings' => 'Scuola_categoria_DesDw',
        'priority'	=> 16,
        'choices'   => $cate));	
    $wp_customize->add_setting('Scuola_primaTabs_testo', array(
        'default' => "", 
        'capability' => 'edit_theme_options'));
    $wp_customize->add_control('Scuola_primaTabs_testo', array(
        'type' => 'text', 
        'label' => 'Testo della prima Cartella',
        'section' => 'scuola_settings', 
        'settings' => 'Scuola_primaTabs_testo',
        'priority'	=> 17));
    $wp_customize->add_setting( 'Scuola_primaTabs_pagina' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'Scuola_primaTabs_pagina', array(
        'type' 		=> 'select',
        'label' 	=> 'Seleziona la pagina Prima Cartella',
        'section' 	=> 'scuola_settings',
        'settings' => 'Scuola_primaTabs_pagina',
        'priority'	=> 18,
        'choices'   => $pagine));	
    $wp_customize->add_setting('Scuola_primaTabs_testo_leggitutto', array(
        'default' => "", 
        'capability' => 'edit_theme_options'));
    $wp_customize->add_control('Scuola_primaTabs_testo_leggitutto', array(
        'type' => 'text', 
        'label' => 'Testo del link leggi tutto',
        'section' => 'scuola_settings', 
        'settings' => 'Scuola_primaTabs_testo_leggitutto',
        'priority'	=> 19));
    $wp_customize->add_setting('Scuola_secondaTabs_testo', array(
        'default' => "", 
        'capability' => 'edit_theme_options'));
    $wp_customize->add_control('Scuola_secondaTabs_testo', array(
        'type' => 'text', 
        'label' => 'Testo della seconda Cartella',
        'section' => 'scuola_settings', 
        'settings' => 'Scuola_secondaTabs_testo',
        'priority'	=> 20));
    $wp_customize->add_setting( 'Scuola_secondaTabs_pagina' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'Scuola_secondaTabs_pagina', array(
        'type' 		=> 'select',
        'label' 	=> 'Seleziona la pagina Seconda Cartella',
        'section' 	=> 'scuola_settings',
        'settings' => 'Scuola_secondaTabs_pagina',
        'priority'	=> 21,
        'choices'   => $pagine));
    $wp_customize->add_setting('Scuola_secondaTabs_testo_leggitutto', array(
        'default' => "", 
        'capability' => 'edit_theme_options'));
    $wp_customize->add_control('Scuola_secondaTabs_testo_leggitutto', array(
        'type' => 'text', 
        'label' => 'Testo del link leggi tutto',
        'section' => 'scuola_settings', 
        'settings' => 'Scuola_secondaTabs_testo_leggitutto',
        'priority'	=> 22));
    $wp_customize->add_setting('Scuola_terzaTabs_testo', array(
        'default' => "", 
        'capability' => 'edit_theme_options'));
    $wp_customize->add_control('Scuola_terzaTabs_testo', array(
        'type' => 'text', 
        'label' => 'Testo della terza Cartella',
        'section' => 'scuola_settings', 
        'settings' => 'Scuola_terzaTabs_testo',
        'priority'	=> 23));
    $wp_customize->add_setting( 'Scuola_terzaTabs_pagina' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'Scuola_terzaTabs_pagina', array(
        'type' 		=> 'select',
        'label' 	=> 'Seleziona la pagina Terza Cartella',
        'section' 	=> 'scuola_settings',
        'settings' => 'Scuola_terzaTabs_pagina',
        'priority'	=> 24,
        'choices'   => $pagine));
    $wp_customize->add_setting('Scuola_terzaTabs_testo_leggitutto', array(
        'default' => "", 
        'capability' => 'edit_theme_options'));
    $wp_customize->add_control('Scuola_terzaTabs_testo_leggitutto', array(
        'type' => 'text', 
        'label' => 'Testo del link leggi tutto',
        'section' => 'scuola_settings', 
        'settings' => 'Scuola_terzaTabs_testo_leggitutto',
        'priority'	=> 25));
    $wp_customize->add_setting('Scuola_Mappa', array(
        'default' => "", 
        'capability' => 'edit_theme_options'));
    $wp_customize->add_control('Scuola_Mappa', array(
        'type' => 'textarea', 
        'label' => 'Codice della Mappa da incorporare',
        'section' => 'scuola_settings', 
        'settings' => 'Scuola_Mappa',
        'priority'	=> 26));
    $wp_customize->add_setting('Scuola_Mappa_Link', array(
        'default' => "", 
        'capability' => 'edit_theme_options'));
    $wp_customize->add_control('Scuola_Mappa_Link', array(
        'type' => 'text', 
        'label' => 'URL visualizza Mappa ingrandita',
        'section' => 'scuola_settings', 
        'settings' => 'Scuola_Mappa_Link',
        'priority'	=> 27));
}
add_action('customize_register', 'italiawp_child_customize_register');
function italiawp_child_sanitize_number( $input ) {
    if (is_numeric($input)) { 
    	return $input; 
  } 
  return 0; 
}


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
* 
* Sezione Dati Ente
* 
*/  
/* Sezione "Sezioni Homepage" nel customizer */
    $wp_customize->add_section('site_ente', array(
        'title' => 'Dati Ente',
        'priority' => 1,
    ));

    $wp_customize->add_setting( 'dettagli-ammin-afferente' , array('capability' => 'edit_theme_options') );
	$wp_customize->add_control( new WP_Customize_Title_Control( $wp_customize,'dettagli-ammin-afferente', array(
			'label'	=> "Amministrazione Afferente",
			'section' => 'site_ente',
			'settings' => 'dettagli-ammin-afferente',
			'priority'	=> 1) 
	));

    $wp_customize->add_setting( 'dettagli-nome-ammin-afferente' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-nome-ammin-afferente', array(
        'type' 		=> 'text',
        'label' 	=> 'Nome:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-nome-ammin-afferente',
        'priority'	=> 3));
    $wp_customize->add_setting( 'dettagli-url-ammin-afferente' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-url-ammin-afferente', array(
        'type' 		=> 'text',
        'label' 	=> 'URL (con HTTP o HTTPS):',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-url-ammin-afferente',
        'priority'	=> 4));	

	$wp_customize->add_setting('dettagli-logo-ammin-afferente', array(
	    'type' => 'theme_mod',
	    'capability' => 'edit_theme_options',
	    'sanitize_callback' => 'absint'
	));
	$wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'dettagli-logo-ammin-afferente', array(
	    'section' => 'site_ente',
	    'label' => 'Immagine dim. 120x40',
	    'width' => 120,
	    'height' => 40,
        'priority'	=> 5)));     
// Titolo Contatti
    $wp_customize->add_setting( 'dettagli-contatti' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( new WP_Customize_Title_Control( $wp_customize,'dettagli-contatti', array(
			'label'	=> "Contatti",
			'section' => 'site_ente',
			'settings' => 'dettagli-contatti',
			'priority'	=> 8) 
	));
// Campo Indirizzo
    $wp_customize->add_setting( 'dettagli-contatti-indirizzo' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-indirizzo', array(
        'type' 		=> 'text',
        'label' 	=> 'Indirizzo:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-indirizzo',
        'priority'	=> 9));	
// Campo CAP
    $wp_customize->add_setting( 'dettagli-contatti-cap' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-cap', array(
        'type' 		=> 'text',
        'label' 	=> 'CAP:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-cap',
        'priority'	=> 10));	
// Campo Città
    $wp_customize->add_setting( 'dettagli-contatti-citta' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-citta', array(
        'type' 		=> 'text',
        'label' 	=> 'Città:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-citta',
        'priority'	=> 11));
// Campo Des Telefono
    $wp_customize->add_setting( 'dettagli-contatti-des-telefono' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-des-telefono', array(
        'type' 		=> 'text',
        'label' 	=> 'Descrizione Telefono:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-des-telefono',
        'priority'	=> 12));        
// Campo Telefono
    $wp_customize->add_setting( 'dettagli-contatti-telefono' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-telefono', array(
        'type' 		=> 'text',
        'label' 	=> 'Telefono:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-telefono',
        'priority'	=> 13));        
// Campo Des Telefono2
    $wp_customize->add_setting( 'dettagli-contatti-des-telefono2' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-des-telefono2', array(
        'type' 		=> 'text',
        'label' 	=> 'Descrizione Secondo Telefono:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-des-telefono2',
        'priority'	=> 14));        
// Campo Telefono2
    $wp_customize->add_setting( 'dettagli-contatti-telefono2' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-telefono2', array(
        'type' 		=> 'text',
        'label' 	=> 'Secondo Telefono:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-telefono2',
        'priority'	=> 15));        
// Campo Des Telefono3
    $wp_customize->add_setting( 'dettagli-contatti-des-telefono3' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-des-telefono3', array(
        'type' 		=> 'text',
        'label' 	=> 'Descrizione Terzo Telefono:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-des-telefono3',
        'priority'	=> 16));        
// Campo Telefono3
    $wp_customize->add_setting( 'dettagli-contatti-telefono3' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-telefono3', array(
        'type' 		=> 'text',
        'label' 	=> 'Terzo Telefono:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-telefono3',
        'priority'	=> 17));        
// Campo Des Telefono4
    $wp_customize->add_setting( 'dettagli-contatti-des-telefono4' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-des-telefono4', array(
        'type' 		=> 'text',
        'label' 	=> 'Descrizione Quarto Telefono:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-des-telefono4',
        'priority'	=> 18));        
// Campo Telefono4
    $wp_customize->add_setting( 'dettagli-contatti-telefono4' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-telefono4', array(
        'type' 		=> 'text',
        'label' 	=> 'Quarto Telefono:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-telefono4',
        'priority'	=> 19));
// Campo Email
    $wp_customize->add_setting( 'dettagli-contatti-email' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-email', array(
        'type' 		=> 'text',
        'label' 	=> 'Email:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-email',
        'priority'	=> 20));
// Campo Seconda Email
    $wp_customize->add_setting( 'dettagli-contatti-email2' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-email2', array(
        'type' 		=> 'text',
        'label' 	=> 'Seconda Email:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-email2',
        'priority'	=> 21));
// Campo PEC
    $wp_customize->add_setting( 'dettagli-contatti-pec' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-pec', array(
        'type' 		=> 'text',
        'label' 	=> 'PEC:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-pec',
        'priority'	=> 22));
// Campo C.F.
    $wp_customize->add_setting( 'dettagli-contatti-cfpa' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-cfpa', array(
        'type' 		=> 'text',
        'label' 	=> 'Codice Fiscale:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-cfpa',
        'priority'	=> 23));
// Campo Partita IVA
    $wp_customize->add_setting( 'dettagli-contatti-pipa' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-pipa', array(
        'type' 		=> 'text',
        'label' 	=> 'Partita IVA:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-pipa',
        'priority'	=> 24));
// Campo Codice Meccanografico
    $wp_customize->add_setting( 'dettagli-contatti-CM' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-CM', array(
        'type' 		=> 'text',
        'label' 	=> 'Cod. Meccanografico:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-CM',
        'priority'	=> 25));
// Campo Cod. Univoco
    $wp_customize->add_setting( 'dettagli-contatti-coduni' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-contatti-coduni', array(
        'type' 		=> 'text',
        'label' 	=> 'Cod. Univoco:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-contatti-coduni',
        'priority'	=> 26));
// Titolo Social
    $wp_customize->add_setting( 'dettagli-social' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( new WP_Customize_Title_Control( $wp_customize,'dettagli-social', array(
			'label'	=> "Social",
			'section' => 'site_ente',
			'settings' => 'dettagli-social',
			'priority'	=> 27) 
	));
// Campo Facebook
    $wp_customize->add_setting( 'dettagli-social-facebook' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-social-facebook', array(
        'type' 		=> 'text',
        'label' 	=> 'Facebook:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-social-facebook',
        'priority'	=> 28));
// Campo Twitter
    $wp_customize->add_setting( 'dettagli-social-twitter' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-social-twitter', array(
        'type' 		=> 'text',
        'label' 	=> 'Twitter:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-social-twitter',
        'priority'	=> 29));
// Campo YouTube
    $wp_customize->add_setting( 'dettagli-social-youtube' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-social-youtube', array(
        'type' 		=> 'text',
        'label' 	=> 'YouTube:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-social-youtube',
        'priority'	=> 30));
// Campo Instagram
    $wp_customize->add_setting( 'dettagli-social-instagram' , array(
		'capability' => 'edit_theme_options') );
	$wp_customize->add_control( 'dettagli-social-instagram', array(
        'type' 		=> 'text',
        'label' 	=> 'Instagram:',
        'section' 	=> 'site_ente',
        'settings' => 'dettagli-social-instagram',
        'priority'	=> 31));
/**
*  Rimozione delle sezioni non utilizzate dal child
* 
*/	
	$wp_customize->remove_section("site_settings");
	
/* Sezione "Sezioni Homepage" nel customizer */
    $wp_customize->add_section('site_settings_child', array(
        'title' => 'Sito & Homepage',
        'priority' => 2,
    ));
    
/* Menu Fixed */
    $wp_customize->add_setting('menu_fixed', array(
        'default' => true, 'capability' => 'edit_theme_options', 'sanitize_callback' => 'italiawp_sanitize_checkbox'
    ));
    $wp_customize->add_control('menu_fixed', array(
        'label' => 'Menu Fixed',
        'type' => 'checkbox', 'section' => 'site_settings_child', 'settings' => 'menu_fixed'
    ));
    
/* Settings e i controls per le sezioni */
/* Hero */
    $wp_customize->add_setting('active_section_hero', array(
        'default' => false, 'capability' => 'edit_theme_options', 'sanitize_callback' => 'italiawp_sanitize_checkbox'
    ));
    $wp_customize->add_control('active_section_hero', array(
        'label' => 'Hero',
        'type' => 'checkbox', 'section' => 'site_settings_child', 'settings' => 'active_section_hero'
    ));
	$wp_customize->add_setting('sfondo_hero', array(
	    'type' => 'theme_mod',
	    'capability' => 'edit_theme_options',
	    'sanitize_callback' => 'absint'
	));
	$wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'sfondo_hero', array(
	    'section' => 'site_settings_child',
	    'label' => 'Immagine dim. 280x150',
	    'width' => 1920,
	    'height' => 480)));     
/* Gallerie Fotografiche */
    $wp_customize->add_setting('active_section_galleries', array(
        'default' => false, 'capability' => 'edit_theme_options', 'sanitize_callback' => 'italiawp_sanitize_checkbox'
    ));
    $wp_customize->add_control('active_section_galleries', array(
        'label' => 'Gallerie fotografiche',
        'type' => 'checkbox', 'section' => 'site_settings_child', 'settings' => 'active_section_galleries'
    ));
    
/* Map */
    $wp_customize->add_setting('active_section_map', array(
        'default' => false, 'capability' => 'edit_theme_options', 'sanitize_callback' => 'italiawp_sanitize_checkbox'
    ));
    $wp_customize->add_control('active_section_map', array(
        'label' => 'Mappa',
        'type' => 'checkbox', 'section' => 'site_settings_child', 'settings' => 'active_section_map'
    ));

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
add_action('customize_register', 'italiawp_child_customize_register',99);
function italiawp_child_sanitize_number( $input ) {
    if (is_numeric($input)) { 
    	return $input; 
  } 
  return 0; 
}
if( class_exists( 'WP_Customize_Control' ) ):
	class WP_Customize_Title_Control extends WP_Customize_Control {
		public $type = 'title';
 
		public function render_content() {
		?>
			<label>
				<h2><?php echo esc_html( $this->label ); ?></h2>
			</label>
		<?php
		}
	}
endif;

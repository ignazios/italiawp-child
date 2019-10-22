<?php
/**
 * italiawp-child  funzioni tema figlio 
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package italiawp-child
 */
add_action('wp_enqueue_scripts', 'carica_stili_parent');
function carica_stili_parent() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
//	wp_enqueue_style('Icone_fonts_Awesome', get_stylesheet_directory_uri() . '/font/css/all.css');	
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'DI-child-Js-carousel', get_stylesheet_directory_uri() . '/owlcarousel/owl.carousel.js',array(), false, true  );
	wp_enqueue_script( 'italiawp-child-script', get_stylesheet_directory_uri() . '/js/italiawp.js', array(), false, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if (is_front_page()){
		wp_enqueue_script( 'italiawp-child-carousel', get_stylesheet_directory_uri() . '/js/carousel.js', array(), false, false );
   		wp_enqueue_style('parent-style-carousel', get_stylesheet_directory_uri() . '/css/carousel.css');
    	wp_enqueue_style('parent-style-galleria', get_stylesheet_directory_uri() . '/css/galleria.css');
	}
	if (function_exists("circolariG_Visualizza") or function_exists("VisualizzaCircolari")){	
		wp_enqueue_style('Icone_fonts_Awesome', get_stylesheet_directory_uri() . '/font/css/all.css');		
	}
}

// add the filter 
/**
* Riattiva la gestione dei link standard di Wordpress 
* I link vengono utilizzati in home page nel widget GalleraLinks
* @return
*/
add_filter( 'pre_option_link_manager_enabled', '__return_true' );
add_action('wp_head',"italiawp_child_Head");
function italiawp_child_Head(){
	if(!is_admin()){
?>
<script type='text/javascript'>
			//<![CDATA[
  var ajaxsec = '<?php echo wp_create_nonce('aggiornamentoCalendario');?>'; 
  var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';
			//]]>		
</script>
<?php
	}
?>
    <!-- Custom <head> content -->
<?php if (is_admin_bar_showing ()) {
		if(get_option('dettagli-nome-ammin-afferente')!=""){ ?>
		    <style type="text/css">
				.Header-banner{
					margin-top: 32px;
				}
				.site-content{
					margin-top: -32px;
				}
			</style>
<?php 	}else{ ?>
		    <style type="text/css">
				.Header-navbar{
					margin-top: 32px;
				}
			</style>
<?php 	}
	}
	if (is_front_page()){
?>
<script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<?php
		}	
}

function pdfprnt_disable_special_page($content){
	if(is_home() or is_front_page()){
		remove_filter( 'the_content', 'pdfprnt_content' );	
	}
	return $content;	
}
add_filter('the_content', 'pdfprnt_disable_special_page', 0);

/**
* Filtro che permette di personalizzare l'URL del BreadCrumb per le Tassonomie
* @param undefined $url
* @param undefined $this_type
* @param undefined $this_id
* 
* @return
*/
function filter_bcn_breadcrumb_url( $url, $this_type, $this_id ) { 
	$Archivio="";
	if (is_date()){
		$Archivio="";
		if (isset($_GET['taxonomy'])) {
			$Archivio="?taxonomy=".$_GET['taxonomy'];
		}
		if (isset($_GET['term'])) {
			$Archivio.=(substr($Archivio,0,1) == "?" ? "&" : "?")."term=".$_GET['term'];
		}
		if (isset($_GET['cat'])){
			$Archivio="?cat=".$_GET['cat'];
		}
	}
	if( isset($this_type[1]) And $this_type[1] == "post-avcp-archive" ){
		$url=get_home_url()."/trasparenza/bandi-di-gara-e-contratti/";
	}
    return $url.$Archivio; 
}; 
add_filter( 'bcn_breadcrumb_url', 'filter_bcn_breadcrumb_url', 10, 3 ); 
/**
* Gestione dei Widgets personalizzati per il tema Child
* 
* @return
*/
require (get_template_directory() . '-child/widget/widget.php' ); 
add_action( 'widgets_init', 'italiawp_child_Register_Widget' );
function italiawp_child_Register_Widget(){
	register_widget( 'my_atWidget' );
	register_widget( 'Articoli' );
	register_widget( 'Comunicazioni' );
	register_widget( 'Blocchi' );
	register_widget( 'Trasparenza' );
	register_widget( 'GalleriaLinks' );
	register_widget( 'Feed_RSS' );
	if(class_exists("EM_Event")){
		register_widget( 'my_EM_Widget_Calendar' );
	}
	for ( $i = 1; $i < 4; $i++ ) {
	register_sidebar( array(
		'name'          => 'Home '.$i,
		'id'            => 'home-'.$i,
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>') );
	}
}

add_filter( 'get_the_archive_title', function ($title) {
	if ( is_author()) {
	    $title = "Autore: ".get_the_author() ;
	  }      
	  return $title;  
	});
function IWP_FormatDataItaliano($Data){
			$mesi = array('', 'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio',  'Agosto', 'Settembre', 'Ottobre', 'Novembre','Dicembre');
		list($anno,$mese,$giorno) = explode('-',substr($Data,0,10)); 
		return $giorno.' '.substr($mesi[intval($mese)],0,3).' '.$anno;
}

require get_template_directory() . '-child/inc/customizer.php';

if (function_exists("VisualizzaCircolari")){
	remove_shortcode('VisCircolari');
	function myVisualizzaCircolari($atts) {
		require_once ( dirname (__FILE__) . '/plugins/gestione-circolari/admin/frontend.php' );
		return $ret;
	} add_shortcode('VisCircolari', 'myVisualizzaCircolari');
}
if (function_exists("circolariG_Visualizza")){
	remove_shortcode('VisCircolari');
	function myVisualizzaCircolariG($atts) {
		require_once ( dirname (__FILE__) . '/plugins/gestione-circolari-groups/admin/frontend.php' );
		return $ret;
	} add_shortcode('VisCircolari', 'myVisualizzaCircolariG');
}

function get_ListaCircolari($Output=False,$NumCirc=0,$Anno=0,$Mese=0){
	$IdCircolari=get_option('Circolari_Categoria');
	$mesecorrente = date('n');
	if ($Anno!=0)
		$annocorrente = $Anno;
	else
		$annocorrente = date('Y');
	if ($Mese!=0)
		$mesecorrente=$Mese;
	else
		$mesecorrente=date('n');
	$args = array( 'category' => $IdCircolari,
			       'post_type' => array('post','circolari'),
				   'year' => $annocorrente,
				   'monthnum' => $mesecorrente,
				   'posts_per_page'  => ($NumCirc==0?-1:$NumCirc),
				   'post_status' => 'publish');
	$Circolari = get_posts($args);

	if (empty($Circolari)){
		if($Output){
?>			
		<div class="Prose Alert Alert--info Alert--withIcon u-padding-r-bottom u-padding-r-right u-margin-r-bottom" role="alert">
  		  	<h2 class="u-text-h3">Circolari del mese</h2>
    		<p class="u-text-p">Non risultano circolari per <?php echo circ_MeseLettere($mesecorrente).' '.$annocorrente;?> verranno visualizzate le ultime 5</p>
		</div>
<?php		}
		$args = array( 'category' => $IdCircolari,
		       'post_type' => array('post','circolari'),
			   'posts_per_page'  => ($NumCirc==0?5:$NumCirc),
			   'post_status' => 'publish');	
			   
		$Circolari = get_posts($args);

	}
	if (!empty($Circolari)){
		$Ret=array();
		foreach($Circolari as $Circolare) {
			$visibilita=get_post_meta($post->ID, "_visibilita",true);
		 	if(!$visibilita)
		 		$visibilita="p";
			if ((Is_Circolare_per_User($Circolare->ID) and $visibilita=="d") or $visibilita=="p"){
				$Ret[]=$Circolare;
			}
		}
	}
	return $Ret;
}

function get_ListaCircolariG($Output=False,$NumCirc=0,$Anno=0,$Mese=0){
	$IdCircolari=get_option('Circolari_Categoria');
	$mesecorrente = date('n');
	if ($Anno!=0)
		$annocorrente = $Anno;
	else
		$annocorrente = date('Y');
	if ($Mese!=0)
		$mesecorrente=$Mese;
	else
		$mesecorrente=date('n');
	$args = array( 'category' => $IdCircolari,
			       'post_type' => array('post','circolari'),
				   'year' => $annocorrente,
				   'monthnum' => $mesecorrente,
				   'posts_per_page'  => -1,
				   'post_status' => 'publish');
	$Circolari = get_posts($args);
	if (empty($Circolari)){
		if($Output){
?>			
		<div class="Prose Alert Alert--info Alert--withIcon u-padding-r-bottom u-padding-r-right u-margin-r-bottom" role="alert">
  		  	<h2 class="u-text-h3">Circolari del mese</h2>
    		<p class="u-text-p">Non risultano circolari per <?php echo circ_MeseLettere($mesecorrente).' '.$annocorrente;?> verranno visualizzate le ultime 5</p>
		</div>
<?php	}
		$args = array( 'category' => $IdCircolari,
		       'post_type' => array('post','circolari'),
			   'posts_per_page'  => -1,
			   'post_status' => 'publish');	
		$Circolari = get_posts($args);
	}
	if (!empty($Circolari)){
		$accesso=new Groups_Post_Access();
		global $user_ID;
		$Ret=array();
		$Cont=0;
		$MaxCirc=($NumCirc==0?5:$NumCirc);
//		echo $NumCirc." ".$MaxCirc." ".count($Circolari);
		foreach($Circolari as $Circolare) {
			if($accesso->user_can_read_post($Circolare->ID)){
				$Ret[]=$Circolare;
				$Cont=$Cont+1;
			}
			if($MaxCirc==$Cont)
				 break;
		}
	}
//	echo count($Ret);die();
	return $Ret;
}
function italiawp_custom_classes_menu_utilita_child( $classes, $item, $args ) {
    if ( 'menu-utilita' === $args->theme_location ) {
        $classes = array('Grid-cell u-sizeFull');
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'italiawp_custom_classes_menu_utilita_child', 11, 3 );

class Mobile_Detect {
	protected $accept;
	protected $userAgent;
	protected $isMobile = false;
	protected $isAndroid = null;
	protected $isBlackberry = null;
	protected $isIphone = null;
	protected $isIpad = null;
	protected $isOpera = null;
	protected $isPalm = null;
	protected $isWindows = null;
	protected $isGeneric = null;
	protected $devices = array(
		"android" => "android",
		"blackberry" => "blackberry",
		"iphone" => "(iphone|ipod)",
		"ipad" => "ipad",
		"opera" => "opera mini",
		"palm" => "(avantgo|blazer|elaine|hiptop|palm|plucker|xiino)",
		"windows" => "windows ce; (iemobile|ppc|smartphone)",
		"generic" => "(kindle|mobile|mmp|midp|o2|pda|pocket|psp|symbian|smartphone|treo|up.browser|up.link|vodafone|wap)"
	);
	public function __construct() {
		$this->userAgent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '';
		$this->accept = isset( $_SERVER['HTTP_ACCEPT'] ) ? $_SERVER['HTTP_ACCEPT'] : '';
		if (isset($_SERVER['HTTP_X_WAP_PROFILE'])|| isset($_SERVER['HTTP_PROFILE'])) {
			$this->isMobile = true;
		} elseif (strpos($this->accept,'text/vnd.wap.wml') > 0 || strpos($this->accept,'application/vnd.wap.xhtml+xml') > 0) {
			$this->isMobile = true;
		} else {
			foreach ($this->devices as $device => $regexp) {
				if ($this->isDevice($device)) {
					$this->isMobile = true;
				}
			}
		}
	}
	public function __call($name, $arguments) {
		$device = strtolower(substr($name, 2));
		if ($name == "is" . ucfirst($device)) {
			return $this->isDevice($device);
		} else {
			trigger_error("Method $name not defined", E_USER_ERROR);
		}
	}
	public function isMobile() {
		return $this->isMobile;
	}
	protected function isDevice($device) {
		$var = "is" . ucfirst($device);
		$return = $this->$var === null ? (bool) preg_match("/" . $this->devices[$device] . "/i", $this->userAgent) : $this->$var;
		if ($device != 'generic' && $return == true) {
			$this->isGeneric = false;
		}
		return $return;
	}
}
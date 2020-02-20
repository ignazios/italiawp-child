<?php

//Check for rights
$path  = '';

if (!defined('WP_LOAD_PATH')) {
	$root = dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/';
	if (file_exists($root.'wp-load.php') ) {
		define('WP_LOAD_PATH', $root);
	} else {
		if (file_exists($path.'wp-load.php'))
			define('WP_LOAD_PATH', $path);
	}
}

//Load wp-load.php
if (defined('WP_LOAD_PATH'))
	require_once(WP_LOAD_PATH.'wp-load.php');
	
if ( !is_user_logged_in() || !current_user_can('edit_posts') )
	wp_die(__("You are not allowed to access this file."));

@header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Gallerie ItaliaWP-child</title>
	<base target="_self" />
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript">

		function init() {
			tinyMCEPopup.resizeToInnerSize();
		}

		function insertGalleriaShortCode() {
			
			var ID= document.getElementById('listaGallerie').value;
			if (window.tinyMCE) {
				window.tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[Galleria id=\"" + ID+ "\"]");
			}
			tinyMCEPopup.close();
			return;
		}
	</script>
</head>
<body onload="tinyMCEPopup.executeOnLoad('init();');">
<?php 
	$EleGallerie="<select id=\"listaGallerie\" name=\"ListaGallerie\">";
	$args = array('posts_per_page' => -1,'post_type' => 'gallerie');
	$the_query = new WP_Query($args);
//		var_dump($the_query->posts);
		foreach ($the_query->posts as $Galleria) {
			$EleGallerie.="<option value=\"".$Galleria->ID."\">".$Galleria->post_title."</option>";
		}
		$EleGallerie.="</select>";
?>
		<div class="mceActionPanel" style="margin-top: 1em;">
		<form name="form" action="#" method="get" accept-charset="utf-8">
				<p>
					<label for="listaGallerie">
						<strong>Gallerie disponibili</strong></label>
						<?php echo $EleGallerie;?>
				</p>
		</form>
	</div>
		<div style="float: left;">
			<input type="submit" id="insert" name="insert" value="Inserisci" onclick="insertGalleriaShortCode();" />
		</div>
		<div style="float: right">
			<input type="button" id="cancel" name="cancel" value="Annulla" onclick="tinyMCEPopup.close();" />
		</div>
</body>
</html>
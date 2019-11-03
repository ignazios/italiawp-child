<?php
/*
 * ### ALLEGATI ###
 * Scaricare ed installare il plugin "Attachments"
 * da https://it.wordpress.org/plugins/attachments/
 * 
 * Info su GitHub https://github.com/jchristopher/attachments
 *
 */
?>

<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('attachments/index.php')) { ?>

        <?php $attachments = new Attachments('attachments'); ?>
        <?php if ($attachments->exist()) : ?>
    <div class="u-sizeFull u-md-size11of12 u-lg-size11of12">
        <h3 class="u-padding-all-m">Allegati (<?php echo $attachments->total(); ?>)</h3>
        <ul>
        <?php while ($attachments->get()) : 
        echo "<pre>";var_dump($attachments);echo "</pre>";?>
            <li>
            	<div class="Grid Grid--withGutter u-padding-all-l">
				    <div class="Grid-cell u-size1of2 u-lg-size4of12">
				        <div class="u-margin-bottom-l u-borderRadius-m u-padding-all-m"><?php echo $attachments->field('type'); ?></div>
				    </div>
 				    <div class="Grid-cell u-size1of2 u-lg-size4of12">
				        <div class="u-margin-bottom-l u-borderRadius-m u-padding-all-m"><?php echo  $attachments->field('title'); ?>[<?php echo $attachments->filesize(); ?>]</div>
				    </div>           		
            	</div><a class="u-border-all-xxs" target="_blank" href="<?php echo $attachments->url(); ?>"><?php echo $attachments->field('title'); ?> [<?php echo $attachments->filesize(); ?>]</a></li>
        <?php endwhile; ?>
        </ul>
        <?php endif; ?>

    </div>

<?php }

<footer class="Footer u-background-95">

<div class="u-cf">
<img class="Footer-logo" src="<?php echo wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' )[0]; ?>" alt="">
<p class="Footer-siteName"><?php bloginfo( 'name' ); ?></p>
</div>

<div class="Grid Grid--withGutter">
<?php 
	if(is_dynamic_sidebar('footer-1') OR 
	   is_dynamic_sidebar('footer-2') OR
	   is_dynamic_sidebar('footer-3') OR
	   is_dynamic_sidebar('footer-4')){?>
      <div class="Footer-block Grid-cell u-md-size1of4 u-lg-size1of4">
        <?php dynamic_sidebar('footer-1'); ?>
      </div>
      <div class="Footer-block Grid-cell u-md-size1of4 u-lg-size1of4">
        <?php dynamic_sidebar('footer-2'); ?>
      </div>
      <div class="Footer-block Grid-cell u-md-size1of4 u-lg-size1of4">
        <?php dynamic_sidebar('footer-3'); ?>
      </div>
      <div class="Footer-block Grid-cell u-md-size1of4 u-lg-size1of4">
        <?php dynamic_sidebar('footer-4'); ?>
      </div>
<?php	   }?>

<?php get_template_part( 'template-parts/footer', 'contact' );?>
<?php get_template_part( 'template-parts/footer', 'datiente' );?>
<?php get_template_part( 'template-parts/footer', 'social' );?>
<?php get_template_part( 'template-parts/footer', 'credit' );?>

</div>

<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'Footer-links u-cf', 'fallback_cb' => false, 'depth' => 1 )) ; ?>

</footer>



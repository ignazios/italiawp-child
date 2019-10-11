<?php ob_start();?>
<header class="Header  u-hiddenPrint">

    <div class="Header-banner ">
        <div class="Header-owner Headroom-hideme ">
            <a href="<?php echo get_theme_mod( 'amministrazione_afferente_url' ); ?>"><span><?php echo get_theme_mod( 'amministrazione_afferente' ); ?></span></a>
            <?php get_template_part( 'template-parts/header', 'login' ); ?>
			<?php get_template_part( 'template-parts/header', 'languages' ); ?>		
        </div>
    </div>

    <div class="Header-navbar ">
        <div class="u-layout-wide Grid Grid--alignMiddle u-layoutCenter">
            <div class="Header-logo Grid-cell" aria-hidden="true">
                <?php the_custom_logo(); ?>
        </a>
            </div>

            <div class="Header-title Grid-cell">
                <h1 class="Header-titleLink">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <div class="site-title"><?php bloginfo( 'name' ); ?></div>
                    <div class="site-description"><small><?php bloginfo( 'description', 'display' ); ?></small></div>
          </a>
                </h1>
            </div>

            <div class="Header-searchTrigger Grid-cell">
                <button aria-controls="header-search" class="js-Header-search-trigger Icon Icon-search " title="attiva il form di ricerca" aria-label="attiva il form di ricerca" aria-hidden="false">
        </button>
                <button aria-controls="header-search" class="js-Header-search-trigger Icon Icon-close u-hidden " title="disattiva il form di ricerca" aria-label="disattiva il form di ricerca" aria-hidden="true">
        </button>
            </div>

            <div class="Header-utils Grid-cell">
              <?php get_template_part( 'template-parts/header', 'social' ); ?>

                <div class="Header-search" id="header-search">
                    <?php get_search_form(); ?>
                </div>
            </div>

            <div class="Header-toggle Grid-cell">
                <a class="Hamburger-toggleContainer js-fr-offcanvas-open u-nojsDisplayInlineBlock u-lg-hidden u-md-hidden" href="#menu" aria-controls="menu" aria-label="accedi al menu" title="accedi al menu">
          <span class="Hamburger-toggle" role="presentation"></span>
          <span class="Header-toggleText" role="presentation">Menu</span>
        </a>
            </div>

        </div>
    </div>
    <!-- Header-navbar -->

    <div class="Headroom-hideme u-textCenter u-hidden u-sm-hidden u-md-block u-lg-block fixed-top">

        <nav class="Megamenu Megamenu--default js-megamenu u-background-50" data-rel=".Offcanvas .Treeview" id="MenuFisso"></nav>

    </div>


</header>


<section class="Offcanvas Offcanvas--right Offcanvas--modal js-fr-offcanvas u-jsVisibilityHidden u-nojsDisplayNone u-hiddenPrint u-block u-sm-block u-md-hidden u-lg-hidden" id="menu">
    <h2 class="u-hiddenVisually">Menu di navigazione</h2>
    <div class="Offcanvas-content u-background-white">
        <div class="Offcanvas-toggleContainer u-background-70 u-jsHidden">
            <a class="Hamburger-toggleContainer u-block u-color-white u-padding-bottom-xxl u-padding-left-s u-padding-top-xxl js-fr-offcanvas-close" aria-controls="menu" aria-label="esci dalla navigazione" title="esci dalla navigazione" href="#">
        <span class="Hamburger-toggle is-active" aria-hidden="true"></span>
      </a>
        </div>
        <nav>
          <?php
            wp_nav_menu(
              array(
                'theme_location' => 'primary',
                'depth' => 3,
                'menu_id' => 'primary-menu',
                'menu_class' => 'Linklist Linklist--padded Treeview Treeview--default js-Treeview u-text-r-xs',
                'walker'  => new my_Walker_Burger_Menu(),
              )
            );
          ?>

        </nav>
    </div>
</section>
<?php ob_end_flush();?>
<?php
$menu = wp_nav_menu(
    array(
      'theme_location' => 'language',
      'fallback_cb' => false,
      'echo' => false,
      'depth' => 1
    )
  );

  if ( ! empty ( $menu ) ) {
    $menuLocations = get_nav_menu_locations();
    $items = wp_get_nav_menu_items(  $menuLocations['language'] );
     ?>
<div class="Header-languages ">

<a href="#languages" data-menu-trigger="languages" class="Header-language u-border-none u-zindex-max u-inlineBlock">
<span class="u-hiddenVisually">lingua attiva:</span>
<span class=""><?php echo $items[0]->title;; ?></span>
<span class="Icon Icon-expand u-padding-left-xs"></span>
</a>
    <div id="languages" data-menu class="Dropdown-menu Header-language-other u-jsVisibilityHidden u-nojsDisplayNone">
        <span class="Icon-drop-down Dropdown-arrow u-color-white"></span>
        <?php echo $menu; ?>
    </div>
</div>
<?php } ?>

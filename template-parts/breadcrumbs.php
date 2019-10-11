<?php
	if(!(is_front_page()||is_home())){
?>		
<div class="u-layout-wide u-layoutCenter u-layout-withGutter u-padding-r-bottom u-padding-top-s">
            <nav aria-label="sei qui:" role="navigation">
            
<?php
    if(function_exists('bcn_display')) { echo '<ul class="Breadcrumb">'; bcn_display();echo '</ul>'; }
?>
            </nav>

        </div>
<?php	} ?>


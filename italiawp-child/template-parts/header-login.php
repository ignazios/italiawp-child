<?php
if ( is_user_logged_in() ) {
	$link = '<a class="icon-logout" href="' . wp_logout_url() . '" id="btn-logout">Logout <span class="fas fa-sign-out-alt"></span></a>';
} else {
	$link = '<a class="icon-login" href="' . wp_login_url() . '" id="btn-login">Login <span class="fas fa-sign-in-alt"></span></a>';
}
?>

<div class="Header-login">
<?php echo $link; ?>
</div>


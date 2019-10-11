<?php
if ( is_user_logged_in() ) {
	$link = '<a class="icon-logout" href="' . wp_logout_url() . '" id="btn-logout">Logout <i class="fas fa-sign-out-alt"></i></a>';
} else {
	$link = '<a class="icon-login" href="' . wp_login_url() . '" id="btn-login">Login <i class="fas fa-sign-in-alt"></i></a>';
}
?>

<div class="Header-login">
<?php echo $link; ?>
</div>


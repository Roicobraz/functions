<?php
function darkmod_script() {
	wp_enqueue_script( 'darkmod', get_template_directory_uri() . '/inc/darkmod/darkmod.js', array(), _S_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'darkmod_script' );
	
require get_template_directory() . '/inc/darkmod/switcher.php';

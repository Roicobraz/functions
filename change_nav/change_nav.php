<?php
/**
* Changement au scroll de la navbar
*/

function test2() 
{
  $dependencies = [ [
    'id' => 'module-1',
    'import' => 'dynamic',
  ] ];

  wp_register_script_module( 'module-1', get_stylesheet_directory_uri() . '/inc/change_nav/js/cstm_nav.js' );
  wp_enqueue_script_module( 'initialize', get_stylesheet_directory_uri() . '/inc/change_nav/js/init.js', $dependencies );
}
add_action( 'wp_enqueue_scripts', 'test2' );

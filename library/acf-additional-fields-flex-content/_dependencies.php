<?php
function mythemename_all_scriptsandstyles {
//Load JS and CSS files in here
  wp_register_script ('placeholder', get_stylesheet_directory_uri() . '/js/placeholder.js', array( 'jquery' ),'1.0.0',true);
  // wp_register_style ('googlefonts', 'http://fonts.googleapis.com/css?family=Hammersmith+One', array(),'1.0.0','all');

  wp_enqueue_script('placeholder');
  wp_enqueue_style( 'googlefonts');
}

// add_action( 'wp_enqueue_scripts', 'mythemename_all_scriptsandstyles' );
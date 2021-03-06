<?php
/*-----------------------------------------------------------------------------------*/
/* ADMIN BODY CLASS */
/*-----------------------------------------------------------------------------------*/
// Hides all upgrade notices in dashboard

add_action('admin_menu','hide_admin_notices');
function hide_admin_notices() {
    remove_action( 'admin_notices', 'update_nag', 3 );
}

// Remove the 'Updates' menu item from the admin interface
add_action('admin_menu', 'remove_menus', 102);
function remove_menus() {
	global $submenu;
	remove_submenu_page ( 'index.php', 'update-core.php' );
}


# 2.8+:
remove_action( 'wp_version_check', 'wp_version_check' );
remove_action( 'admin_init', '_maybe_update_core' );
add_filter( 'pre_transient_update_core', create_function( '$a', "return null;" ) );



//core updates
remove_action( 'load-update-core.php', 'wp_update_core' );
add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );


//theme updates
remove_action( 'load-update-core.php', 'wp_update_themes' );
add_filter( 'pre_site_transient_update_themes', create_function( '$a', "return null;" ) );


//plugin updates
remove_action( 'load-update-core.php', 'wp_update_plugins' );
add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );

?>
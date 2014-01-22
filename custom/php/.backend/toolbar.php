<?php
/*-----------------------------------------------------------------------------------*/
/* ADMIN TOOLBAR */
/*-----------------------------------------------------------------------------------*/


//*
// remove toolbar nodes
function wpmy_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('view-site');
    $wp_admin_bar->remove_menu('updates'); 
	$wp_admin_bar->remove_menu('comments'); 

	//$wp_admin_bar->remove_menu('site-name'); 
	//$wp_admin_bar->remove_menu('new-content'); 
    //$wp_admin_bar->remove_menu('my-account'); 
}
add_action( 'wp_before_admin_bar_render', 'wpmy_admin_bar' );
// */




//*
// REMOVE HOWDY TOOLBAR
add_filter('gettext', 'change_howdy', 10, 3);
function change_howdy($translated, $text, $domain) {
    if (!is_admin() || 'default' != $domain)
        return $translated;
    if (false !== strpos($translated, 'Howdy'))
        return str_replace('Howdy,', '', $translated);
    return $translated;
}
// */



?>
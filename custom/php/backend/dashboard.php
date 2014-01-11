<?php
/*-----------------------------------------------------------------------------------*/
/* ADMIN DASHBOARD */
/*-----------------------------------------------------------------------------------*/

//* REMOVE DASHBOARD WELCOME
remove_action('welcome_panel', 'wp_welcome_panel');
// */

//* REMOVE ADMIN DASHBOARD WIDGETS

// Create the function to use in the action hook
function remove_default_dashboard_widgets() {
	
    // Main column:
    remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );

	// Side Column:
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
	
	// Extras
    remove_meta_box('rg_forms_dashboard', 'dashboard', 'normal;');    

} 

// Hook into the 'wp_dashboard_setup' action to register our function
add_action('wp_dashboard_setup', 'remove_default_dashboard_widgets' );
// */



// force one-column dashboard
function shapeSpace_screen_layout_columns($columns) {
    $columns['dashboard'] = 2;
    return $columns;
}
add_filter('screen_layout_columns', 'shapeSpace_screen_layout_columns');

function shapeSpace_screen_layout_dashboard() { return 2; }
add_filter('get_user_option_screen_layout_dashboard', 'shapeSpace_screen_layout_dashboard');




?>
<?php
/*-----------------------------------------------------------------------------------*/
/* ADMIN MENU REMOVE ITEMS */
/*-----------------------------------------------------------------------------------*/

//*
function my_remove_admin_items() {
	
	//Dashboard
	//remove_menu_page( 'index.php' ); 
	remove_submenu_page( 'index.php', 'update-core.php' ); //Updates

	//Posts
	//remove_menu_page( 'edit.php' ); 
	//remove_submenu_page( 'edit.php', 'post-new.php' ); //Add New [post]
	//remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' ); //Categories [post]
	//remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' ); //Tags [post]
	
	//Media
	//remove_menu_page( 'upload.php' ); 
	//remove_submenu_page( 'upload.php', 'media-new.php' ); //Add New [media]
	
	//Pages
	//remove_menu_page( 'edit.php?post_type=page' );
	//remove_submenu_page( 'edit.php?post_type=page', 'post-new.php?post_type=page' ); //Add New [page]
	
	//Comments
	remove_menu_page( 'edit-comments.php' ); 
	
	//Appearance
	//remove_menu_page( 'themes.php' ); 
	//remove_submenu_page( 'themes.php', 'widgets.php' ); //Widgets
	//remove_submenu_page( 'themes.php', 'nav-menus.php' ); //Menus
	remove_submenu_page( 'themes.php', 'theme-editor.php' ); //Editor [theme]
	
	//Plugins
	//remove_menu_page( 'plugins.php' ); 
	//remove_submenu_page( 'plugins.php', 'plugin-install.php' ); //Add New [plugins]
	remove_submenu_page( 'plugins.php', 'plugin-editor.php' ); //Editor [plugins]
	
	//Users
	//remove_menu_page( 'users.php' ); 
	//remove_submenu_page( 'users.php', 'user-new.php' ); //Add New [users]
	//remove_submenu_page( 'users.php', 'profile.php' ); //Your Profile
	
	//Tools
	//remove_menu_page( 'tools.php' ); 
	//remove_submenu_page( 'tools.php', 'import.php' ); //Import
	//remove_submenu_page( 'tools.php', 'export.php' ); //Export
	
	//Settings
	//remove_menu_page( 'options-general.php' ); //Settings
	//remove_submenu_page( 'options-general.php', 'options-writing.php' ); //Writing
	//remove_submenu_page( 'options-general.php', 'options-reading.php' ); //Reading
	//remove_submenu_page( 'options-general.php', 'options-discussion.php' ); //Discussion
	//remove_submenu_page( 'options-general.php', 'options-media.php' ); //Media
	//remove_submenu_page( 'options-general.php', 'options-privacy.php' ); //Privacy
	//remove_submenu_page( 'options-general.php', 'options-permalink.php' ); //Permalinks
	
	
	
	//Profile
    remove_menu_page( 'profile.php' );
	
	//Plugins Added
    remove_menu_page( 'wp_admin_ui_customize' ); //Settings	
	//remove_menu_page( 'snippets' ); //Settings	
    remove_menu_page( 'shortcodes-ultimate' );
}

add_action( 'admin_init', 'my_remove_admin_items', 999 );
// */









add_action( 'admin_menu', 'pending_posts_bubble_wpse_89028', 999 );

function pending_posts_bubble_wpse_89028() 
{
    global $menu;

    // Get all post types and remove Attachments from the list
    // Add '_builtin' => false to exclude Posts and Pages
    $args = array( 'public' => true ); 
    $post_types = get_post_types( $args );
    unset( $post_types['attachment'] );

    foreach( $post_types as $pt )
    {
        // Count posts
        $cpt_count = wp_count_posts( $pt );

        if ( $cpt_count->pending ) 
        {
            // Menu link suffix, Post is different from the rest
            $suffix = ( 'post' == $pt ) ? '' : "?post_type=$pt";

            // Locate the key of 
            $key = recursive_array_search_php_91365( "edit.php$suffix", $menu );

            // Not found, just in case 
            if( !$key )
                return;

            // Modify menu item
            $menu[$key][0] .= sprintf(
                '<span class="update-plugins count-%1$s" style="background-color:white;color:black"><span class="plugin-count">%1$s</span></span>',
                $cpt_count->pending 
            );
        }
    }
}

// http://www.php.net/manual/en/function.array-search.php#91365
function recursive_array_search_php_91365( $needle, $haystack ) 
{
    foreach( $haystack as $key => $value ) 
    {
        $current_key = $key;
        if( 
            $needle === $value 
            OR ( 
                is_array( $value )
                && recursive_array_search_php_91365( $needle, $value ) !== false 
            )
        ) 
        {
            return $current_key;
        }
    }
    return false;
}


function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Press Release';
    $submenu['edit.php'][5][0] = 'All Press Releases';
    $submenu['edit.php'][10][0] = 'Add Article';
    $submenu['edit.php'][15][0] = 'News Categories'; // Change name for categories
    $submenu['edit.php'][16][0] = 'News Labels'; // Change name for tags
    echo '';
}

function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'Press Release';
        $labels->singular_name = 'Press Release';
        $labels->add_new = 'Add News';
        $labels->add_new_item = 'Add News';
        $labels->edit_item = 'Edit News';
        $labels->new_item = 'New Press Release';
        $labels->view_item = 'View All News';
        $labels->search_items = 'Search News';
        $labels->not_found = 'No News found';
        $labels->not_found_in_trash = 'No News found in Trash';
    }
    add_action( 'init', 'change_post_object_label' );
    add_action( 'admin_menu', 'change_post_menu_label' );




?>
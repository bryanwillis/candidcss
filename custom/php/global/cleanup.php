<?php
/*-----------------------------------------------------------------------------------*/
/* CLEAN HEAD */
/*-----------------------------------------------------------------------------------*/


// remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator'); 
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action('wp_head', 'rel_canonical');


// remove wordpress from admin head title tag
add_filter('admin_title', 'my_admin_title', 10, 2);

function my_admin_title($admin_title, $title)
{
	return get_bloginfo('name').' | '.$title;
}


// try and remove html inline comments
function callback($buffer) {
    $buffer = preg_replace('/<!--(.|s)*?-->/', '', $buffer);
    return $buffer;
}
function buffer_start() {
    ob_start("callback");
}
function buffer_end() {
    ob_end_flush();
}
add_action('get_header', 'buffer_start');
add_action('wp_footer', 'buffer_end');


// remove script/style versioning
add_filter( 'style_loader_src', 't5_remove_version' );
add_filter( 'script_loader_src', 't5_remove_version' );

function t5_remove_version( $url )
{
    return remove_query_arg( 'ver', $url );
}







?>
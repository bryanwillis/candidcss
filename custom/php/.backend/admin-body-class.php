<?php
/*-----------------------------------------------------------------------------------*/
/* ADMIN BODY CLASS */
/*-----------------------------------------------------------------------------------*/
function wpa66834_role_admin_body_class( $classes ) {
    global $current_user;
    foreach( $current_user->roles as $role )
        $classes .= ' role-' . $role;
	
    return trim( $classes );
}
add_filter( 'admin_body_class', 'wpa66834_role_admin_body_class' );


?>
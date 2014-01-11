<?php
/*-----------------------------------------------------------------------------------*/
/* ADMIN FOOTER */
/*-----------------------------------------------------------------------------------*/



 // left side
add_filter( 'admin_footer_text', 'my_footer_text' );
function my_footer_text() {
 return '&nbsp;';
 }

  // right side
add_filter( 'update_footer', 'change_footer_version', 11 );
function change_footer_version() {
    return '&nbsp;';
}



?>
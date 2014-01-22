<?php
//*
// Hide ALL admin 'Help' tab
function remove_help_tabs() {
    $screen = get_current_screen();
    $screen->remove_help_tabs();
}
add_action('admin_head', 'remove_help_tabs');
// */

?>
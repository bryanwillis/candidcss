<?php
/*-----------------------------------------------------------------------------------*/
/* MANAGE POST/PAGE TABLES also use defaults instead of coumsns*/
/*-----------------------------------------------------------------------------------*/

//*
function my_remove_pages_columns($columns) {
  unset($columns['comments']);
  unset($columns['author']);
  return $columns;
   
 }
add_filter('manage_pages_columns', 'my_remove_pages_columns');




function my_remove_post_columns( $columns ) {
   unset($columns['comments']);
   //unset($columns['cb']);
   //unset($columns['title']);
   //unset($columns['date']);
   //unset($columns['categories']);
   unset($columns['author']);
   //unset($columns['tags'])
   return $columns; 
 }
add_filter ( 'manage_edit-post_columns', 'my_remove_post_columns' );
// */




add_action('admin_footer','posts_status_color');
function posts_status_color(){
?>
<style>
.status-draft{background: #FCE3F2 !important;}
.status-pending{background: #87C5D6 !important;}
.status-publish{/* no background keep wp alternating colors */}
.status-future{background: #C6EBF5 !important;}
.status-private{background:#F2D46F;}
</style>
<?php
}





?>
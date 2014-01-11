<?php
// disable wordpress from compressing jpeg quality
add_filter('jpeg_quality', function($arg){return 100;});


// plugin last updated
add_filter( 'plugin_row_meta', 'range_plu_plugin_meta', 10, 2 );

function range_plu_plugin_meta( $plugin_meta, $plugin_file ) {
	list( $slug ) = explode( '/', $plugin_file );


	$slug_hash = md5( $slug );
	$last_updated = get_transient( "range_plu_{$slug_hash}" );
	if ( false === $last_updated ) {
		$last_updated = range_plu_get_last_updated( $slug );
		set_transient( "range_plu_{$slug_hash}", $last_updated, 86400 );
	}

	if ( $last_updated )
		$plugin_meta['last_updated'] = 'Last Updated: ' . esc_html( $last_updated );

	return $plugin_meta;
}

function range_plu_get_last_updated( $slug ) {
	$request = wp_remote_post(
		'http://api.wordpress.org/plugins/info/1.0/',
		array(
			'body' => array(
				'action' => 'plugin_information',
				'request' => serialize(
					(object) array(
						'slug' => $slug,
						'fields' => array( 'last_updated' => true )
					)
				)
			)
		)
	);
	if ( 200 != wp_remote_retrieve_response_code( $request ) )
		return false;

	$response = unserialize( wp_remote_retrieve_body( $request ) );
	// Return an empty but cachable response if the plugin isn't in the .org repo
	if ( empty( $response ) )
		return '';
	if ( isset( $response->last_updated ) )
		return sanitize_text_field( $response->last_updated );

	return false;
}







add_filter('manage_upload_columns', 'size_column_register');

function size_column_register($columns) {

    $columns['dimensions'] = 'Dimensions';

    return $columns;
}

add_action('manage_media_custom_column', 'size_column_display', 10, 2);

function size_column_display($column_name, $post_id) {

    if( 'dimensions' != $column_name || !wp_attachment_is_image($post_id))
        return;

    list($url, $width, $height) = wp_get_attachment_image_src($post_id, 'full');

    echo esc_html("{$width}&times;{$height}");
}







if( is_admin() )
{
    add_filter( 'manage_upload_columns', 'wpse_7757_all_thumbs_column_register' );
    add_action( 'manage_media_custom_column', 'wpse_7757_all_thumbs_columns_display', 10, 2 );
}

function wpse_7757_all_thumbs_column_register( $columns ) 
{
    $columns['all_thumbs'] = 'All Thumbs';

    return $columns;
}

function wpse_7757_all_thumbs_columns_display( $column_name, $post_id ) 
{
    if( 'all_thumbs' != $column_name || !wp_attachment_is_image($post_id) )
        return;

    $full_size = wp_get_attachment_image_src( $post_id, 'full' );
    echo '<div style="clear:both">FULL SIZE : '.$full_size[1].' x '.$full_size[2].'</div>';

    $size_names = get_intermediate_image_sizes();

    foreach( $size_names as $name )
    {
        // CHECK THIS: http://wordpress.org/support/topic/wp_get_attachment_image_src-problem
        $the_list = wp_get_attachment_image_src( $post_id, $name );

        if ( $the_list[3] )
            echo '<div style="clear:both"><a href="'.$the_list[0].'" target="_blank">'.$name.'</a> : '.$the_list[1].' x '.$the_list[2].'</div>';
    }
}







add_filter('media_row_actions', 'wpse_30159_qe_download_link', 10, 2);

function wpse_30159_qe_download_link($actions, $post) {
    /* Almost sure this is not necessary. Just in case... */
    global $current_screen;
    if ( 'upload' != $current_screen->id ) 
        return $actions; 

    // if not PDF file, return default $actions
    if ( 'application/pdf' != $post->post_mime_type )
        return $actions;

    // relative path/name of the file
    $the_file = str_replace(WP_CONTENT_URL, '.', $post->guid);

    // adding the Action to the Quick Edit row
    $actions['Download'] = '<a href="'.WP_CONTENT_URL.'/download.php?file='.$the_file.'">Download</a>';

    return $actions;    
}













function upload_columns($columns) {
	unset($columns['parent']);
	$columns['better_parent'] = __( 'Parent' );
	return $columns;
}

function media_custom_columns($column_name, $id) {
	$post = get_post($id);
	
	if ( $column_name != 'better_parent' )
		return;
	
	if ( $post->post_parent > 0 ) {
		if ( get_post($post->post_parent) )
			$title = _draft_or_post_title($post->post_parent);
		?>
		<strong>
			<a href="<?php echo get_edit_post_link( $post->post_parent ); ?>"><?php echo $title ?></a>
		</strong>, <?php echo get_the_time( get_option('date_format') ); ?>
		<br />
		<a class="hide-if-no-js" onclick="findPosts.open('media[]','<?php echo $post->ID ?>');return false;" href="#the-list"><?php _e( 'Re-', 'textdomain' ); _e('Attach'); ?></a>
		<?php
	} else {
		_e( '(Unattached)' ); ?>
		<br />
		<a class="hide-if-no-js" onclick="findPosts.open('media[]','<?php echo $post->ID ?>');return false;" href="#the-list"><?php _e('Attach'); ?></a>
	<?php
	}
}
add_filter( 'manage_upload_columns', 'upload_columns' );
add_action( 'manage_media_custom_column' , 'media_custom_columns', 0, 2 );









class Page_Template_Filter {
    private $templates = array();
    public function __construct() {
        // If it's not the admin area or the current user can't edit pages let's just bail here
        if( !is_admin() || !current_user_can('edit_pages') )
            return;
        add_action( 'parse_query',           array( $this, 'pt_parse_query' ) );
        add_action( 'restrict_manage_posts', array( $this, 'pt_restrict_manage_posts' ) );
    }
    public function pt_parse_query( $query ) {
        global $pagenow, $post_type;
        if( 'edit.php' != $pagenow )
            return;

        switch( $post_type ) {
            case 'post':

            break;
            case 'page':
                $this->templates = get_page_templates();

                if( empty( $this->templates ) )
                    return;

                if( !$this->is_set_template() )
                    return;

                $meta_group = array( 'key' => '_wp_page_template', 'value' => $this->get_template() );
                set_query_var( 'meta_query', array( $meta_group ) );
            break;
        }
    }
    public function pt_restrict_manage_posts() {
        if( empty( $this->templates ) )
            return;
        $this->template_dropdown();
    }
    private function get_template() {
        if( $this->is_set_template() )
            foreach( $this->templates as $template ) {
                if( $template != $_GET['page_template'] )
                    continue;
                return $template;
            }
        return '';
    }
    private function is_set_template() {
        return (bool) ( isset( $_GET['page_template'] ) && ( in_array( $_GET['page_template'], $this->templates ) ) );
    }
    private function template_dropdown() {
        ?>
        <select name="page_template" id="page_template">
            <option value=""> - no template - </option>
            <?php foreach( $this->templates as $name => $file ): ?>
            <option value="<?php echo $file; ?>"<?php selected( $this->get_template() == $file ); ?>><?php _e( $name ); ?></option>
            <?php endforeach;?>
        </select>
        <?php 
    }
}

add_action('admin_init', 'load_ptf');
function load_ptf() {
    $Page_Template_Filter = new Page_Template_Filter;
}







?>
<?php
add_filter( 'login_headerurl', 'namespace_login_headerurl' );
/**
 * Replaces the login header logo URL
 *
 * @param $url
 */
function namespace_login_headerurl( $url ) {
    $url = home_url( '/' );
    return $url;
}

add_filter( 'login_headertitle', 'namespace_login_headertitle' );
/**
 * Replaces the login header logo title
 *
 * @param $title
 */
function namespace_login_headertitle( $title ) {
    $title = get_bloginfo( 'name' );
    return $title;
}

add_action( 'login_head', 'namespace_login_style' );
/**
 * Replaces the login header logo
 */
function namespace_login_style() {
    if( function_exists('get_custom_header') ){
        $width = get_custom_header()->width;
        $height = get_custom_header()->height;
    } else {
        $width = HEADER_IMAGE_WIDTH;
        $height = HEADER_IMAGE_HEIGHT;
    }
    echo '<style>'.PHP_EOL;
    echo '.login h1 a {'.PHP_EOL; 
    echo '  background-image: url( '; header_image(); echo ' ) !important; '.PHP_EOL;
    echo '  width: 80px !important;'.PHP_EOL;
    echo '  height: 80px !important;'.PHP_EOL;
    echo '  background-size: 80px 80px !important;'.PHP_EOL;
    echo '}'.PHP_EOL;
    echo '</style>'.PHP_EOL;
}








function custom_login_styled() {
    echo '<style type="text/css">
		


div.updated, .login .message, .press-this #message {
border-left: 4px solid #797979;
}

.wp-core-ui .button-primary {
background: #D30000;
border-color: #CA2828;
-webkit-box-shadow: inset 0 1px 0 rgba(230, 120, 120, 0.5),0 1px 0 rgba(0, 0, 0, 0.15);
box-shadow: inset 0 1px 0 rgba(230, 119, 119, 0.5),0 1px 0 rgba(0,0,0,.15);
color: #fff;
text-decoration: none;
}



.wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:hover, .wp-core-ui .button-primary.focus, .wp-core-ui .button-primary:focus {
background: #D30000;
border-color: #CA2828;
-webkit-box-shadow: inset 0 1px 0 rgba(230, 120, 120, 0.5),0 1px 0 rgba(0, 0, 0, 0.15);
box-shadow: inset 0 1px 0 rgba(230, 119, 119, 0.5),0 1px 0 rgba(0,0,0,.15);
color: #fff;
}


    </style>';
}

add_action('login_head', 'custom_login_styled');





/*
// Login Logo From Theme Directory
//  h1 a { background-image:url('.get_bloginfo('template_directory').'/images/login_logo.png) !important; }

function custom_login_logo() {
    echo '<style type="text/css">
    div.updated, .login .message, .press-this #message {
border-left: 4px solid #7E7E7E;
-webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
    </style>';
}
add_action('login_head', 'custom_login_logo');
// */



/*
// Hide Login errors
php add_filter('login_errors', create_function('$a', "return null;")); 
// */


/*
// or for exact login url / disable above if use this
add_filter( 'login_headerurl', 'my_custom_login_url' );
function my_custom_login_url($url) {
	return 'http://www.example.com';
}
// */



/*
//MBI VERSION
function custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url(http://mbistaffing.com/wp-content/uploads/2013/11/MBI_Logo_color_lorez1.jpg) !important; }
		#login_error {
display: none !important;
}
body.login {
background: #FFF !important;
}

.wp-core-ui .button-primary {
background: #3479A0 !important;
border-color: rgba(157, 172, 185, 0.86) !important;
-webkit-box-shadow: inset 0 1px 0 rgba(204, 204, 204, 0.5), 0 1px 0 rgba(0, 0, 0, 0.15) !important;
box-shadow: inset 0 1px 0 rgba(202, 202, 202, 0.5), 0 1px 0 rgba(0, 0, 0, 0.15) !important;
color: #FFF;
text-decoration: none;
text-transform: uppercase;
}
    </style>';
}

add_action('login_head', 'custom_login_logo');




function loginpage_custom_link() {
	return 'http://mbistaffing.com';
}
add_filter('login_headerurl','loginpage_custom_link');


// Your own login logo title text
function isacustom_wp_login_title() {
    return 'MBI STAFFING - IT STAFFING SOLUTIONS';
}
add_filter('login_headertitle', 'isacustom_wp_login_title');

// */






?>
<?php

/* Loading important files for ReactJS */
$GLOBALS['plugin_dir'] = plugin_dir_url( __FILE__ );

function add_required_files() {
    $plugin_dir = $GLOBALS['plugin_dir'];

    // ReactJS core files go here
    wp_enqueue_script( 'react', $plugin_dir . 'react/core/react.min.js' );
    wp_enqueue_script( 'react-dom', $plugin_dir . 'react/core/react-dom.min.js' );
    wp_enqueue_script( 'babel', 'https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser' . $suffix . '.js', array(), null );

    // Other styles go here
    wp_enqueue_style( 'gia-templates', $plugin_dir . '../templates/styles/landing-page.css', null, '1.0', 'screen' );
}

add_action( 'wp_enqueue_scripts', 'add_required_files' );

/* Grab JSON data from ACF, then add a special endpoint for React consumption */
function fetch_json( $data ) {
    $args = array (
        'child_of' => get_page_by_path('homes',OBJECT,'page') -> ID
    );

    $pages = get_pages( $args );
    $result = [];

    foreach($pages as $page) {
        $info = [
            'ID'=> $page->ID,
            'acf'=> get_fields($page->ID)
        ];
        array_push($result, $info);
    };

    return $result;
}

add_action( 'rest_api_init', 'fetch_json' );

function register_gia_endpoint() {
    register_rest_route('gia-data/v1', '/homes', [
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'fetch_json'
    ]);
}

add_action( 'rest_api_init', 'register_gia_endpoint' );

/* ReactJS custom components go here */
// TODO: Fix bugs later on

// Generalized versions of attaching the components (since they essentially have the same structure)
function attach_required_files($component) {
    $plugin_dir = $GLOBALS['plugin_dir'];

    echo '<div id="' . $component . '"></div>';

    /* Auto search filter */
    wp_enqueue_script( $component . '-js', plugins_url('react/components/'. $component . '/script.js', __FILE__),array(),  '0.0.1', true );
    wp_enqueue_style( $component . '-css', $plugin_dir . 'react/components/' . $component . '/styles.css');
}

function add_component($name) {
    add_shortcode('gia-' . $name, attach_required_files($name));
}


// Attachment of components actually happens here.
add_component("search-form");
add_component("house-list");

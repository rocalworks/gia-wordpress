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

/* ReactJS custom components go here */
// TODO: Add shotcode to each components
// TODO: Fix bugs later on

// Auto-search form
// TODO: Need to connect with the other components (how do we )
function add_search_form() {
    $plugin_dir = $GLOBALS['plugin_dir'];

    echo '<div id="search-form"></div>';

    /* Auto search filter */
    wp_enqueue_script( 'search-form-js', plugins_url('react/components/search-form/script.js', __FILE__),array(),  '0.0.1', true );
    wp_enqueue_style( 'search-form-css', $plugin_dir . 'react/components/search-form/styles.css');
}

add_shortcode( 'gia-search-form', 'add_search_form' );

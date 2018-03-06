<?php

/**
 * Add styles first
 */
function wp_gia_react_port() {
    echo '<div id="root"></div>';
}

function add_required_files() {
    // Directory of the plugin here
    $plugin_dir = plugin_dir_url( __FILE__ );

    // ReactJS core files go here
    wp_enqueue_script( 'react', $plugin_dir . 'react/core/react.min.js' );
    wp_enqueue_script( 'react-dom', $plugin_dir . 'react/core/react-dom.min.js' );
    wp_enqueue_script( 'babel', 'https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser' . $suffix . '.js', array(), null );

    // ReactJS builds go here
    // DEBUG: Copy-paste method (for now huhuhuhu)

    // TODO: Separate components according
    wp_enqueue_script( 'react-scripts', plugins_url('react/build/static/js/script.js', __FILE__),array(),  '0.0.1', true );

    // Styles
    wp_enqueue_style( 'gia-react-css', $plugin_dir . 'react/build/styles.css');

    // Other styles go here
    wp_enqueue_style( 'gia-templates', $plugin_dir . '../templates/styles/landing-page.css', null, '1.0', 'screen' );
}


add_action( 'wp_enqueue_scripts', 'add_required_files' );

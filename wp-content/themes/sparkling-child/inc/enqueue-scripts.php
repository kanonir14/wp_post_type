<?php 

add_action('wp_enqueue_scripts', 'child_theme' );

function child_theme() {
    wp_enqueue_style('child-theme-fancybox', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css' );
    wp_enqueue_style('child-theme-css', get_stylesheet_directory_uri() .'/assets/css/style.css' );
    wp_deregister_script('jquery');
    wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js');
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'child-theme-fancybox', 'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js', array('jquery'), true);
    wp_enqueue_script('child-theme-js', get_stylesheet_directory_uri() .'/assets/js/scripts.js' );
    wp_localize_script( 'child-theme-js', 'myajax',
        array(
            'url' => admin_url('admin-ajax.php')
        )
    );
}




?>
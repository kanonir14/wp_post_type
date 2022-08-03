<?php 

// Add post type ADS
function create_ads_posttype() {
    register_post_type( 'ads',
        array(
            'labels' => array(
            'name' => __( 'Объявления' ),
            'singular_name' => __( 'Объявление' ),
            'add_new' => __( 'Добавить' )
        ),
        'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', ),
        'public' => true,
        'menu_position' => 5,
        'has_archive' => true,
        'rewrite' => array('slug' => 'ads'),
        )
    );
}

add_action( 'init', 'create_ads_posttype' );

// Include enqueue scripts file 
require_once( get_stylesheet_directory() . '/inc/enqueue-scripts.php');

// Include ajax form handler 
add_action( 'wp_ajax_my_action_callback', 'my_action_callback' );
add_action( 'wp_ajax_nopriv_my_action_callback', 'my_action_callback' );


function my_action_callback() {

    require( dirname(__FILE__) . '/../../../wp-load.php' );

    // wp_handle_upload()
    require_once( ABSPATH . 'wp-admin/includes/file.php' );

    // validate img
    $file_type = $_FILES['profile_picture']['type'];
    $allowed = array("image/jpeg", "image/jpg", "image/png");

    if(!in_array($file_type, $allowed)) {
      $error_message = 'false';

      wp_die($error_message);  

    }

    $upload = wp_handle_upload( 
        $_FILES[ 'profile_picture' ], 
        array( 'test_form' => false ) 
    );

    if( ! empty( $upload[ 'error' ] ) ) {
        wp_die( $upload[ 'error' ] );
    }

    // add image on wp lbrary
    $attachment_id = wp_insert_attachment(
        array(
            'guid'           => $upload[ 'url' ],
            'post_mime_type' => $upload[ 'type' ],
            'post_title'     => basename( $upload[ 'file' ] ),
            'post_content'   => '',
            'post_status'    => 'inherit',
        ),
        $upload[ 'file' ]
    );

    if( is_wp_error( $attachment_id ) || ! $attachment_id ) {
        wp_die( 'Upload error.' );
    }

    // update medatata image sizes
    require_once( ABSPATH . 'wp-admin/includes/image.php' );

    wp_update_attachment_metadata(
        $attachment_id,
        wp_generate_attachment_metadata( $attachment_id, $upload[ 'file' ] )
    );

    // Create post 
    $title = sanitize_text_field( $_POST['title'] );
    $email = $_POST['email'];

    $new_post = array(
        'ID' => '',
        'post_author' => $user->ID,
        'post_type' => 'ads',
        'post_content' => $title,
        'post_title' => $title,
        'post_author' => user_id,
        'meta_input' => array(
            'Email' => $email
        ),
        'post_status' => 'publish'
    );

    $post_id = wp_insert_post($new_post);

    // Send mail to admin
    if ( $post_id ) {
        $to = "kanonir1886@gmail.com"; //get_option('admin_email');
        $subject = $title;
        $message = $title;

        wp_mail( $to, $subject, $message);
        send_mail_to_user($email);
        
        // set text/html
        remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

        function set_html_content_type() {
            return 'text/html';
        }
    }

    // set thumb
    set_post_thumbnail( $post_id, $attachment_id );
    // add_post_meta($post_id, 'email_sent', 'yes', true);

    exit;
    
}

// Send mail to user
function send_mail_to_user($email) {
    $subject = "Спасибо!";
    $message = "Спасибо, что воспользовались нашим сервисом. Ваше объявление опубликовано и доступно на сайте. ";
    wp_mail( $email, $subject, $message);
    // sleep(5);

}



?>
<?php
/**
 * In this file
 *
 * @package CC_Contacts
 * @since 0.0.0
 */


add_action( 'wp_ajax_nopriv_cc_contacts_submit', 'cc_contact_form_submit' );
add_action( 'wp_ajax_cc_contacts_submit', 'cc_contact_form_submit' );
function cc_contact_form_submit(){
    $nonce = $_POST['nonce'];

    // check nonce code, if verifying is fail, abort actions
    if( ! wp_verify_nonce( $nonce, 'cc_contacts_nonce' ) )
        wp_die( 'Forbidden!');


    $contact = array(
        'post_type' => 'cc_contacts',
        'post_title' => $_POST['form_data'][0]['value']
    );

    $contact_id = wp_insert_post($contact);

    foreach ( $_POST['form_data'] as $field ) {
        add_post_meta($contact_id, '_' . $field['name'] . '_value', $field['value']);
    }
    echo json_encode( array(
        'success' => true,
        'response_message' => __('Your form submited')
    ) );
    // Не забываем завершать PHP
    wp_die();
}
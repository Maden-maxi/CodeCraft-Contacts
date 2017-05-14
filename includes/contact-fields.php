<?php

/**
 * Array contact form fields
 * @since 0.0.0
 *
 * @return array
 */
function cc_contact_form_fields(){
    $cc_contact_form_fields = array(
        array(
            'type' => 'input',
            'input_type' => 'text',
            'name' => 'cc_contact_name',
            'label' => __( 'Name', 'cc-contacts' )
        ),
        array(
            'type' => 'input',
            'input_type' => 'email',
            'name' => 'cc_contact_email',
            'label' => __( 'Email', 'cc-contacts' )
        ),
        array(
            'type' => 'textarea',
            'input_type' => 'text',
            'name' => 'cc_contact_message',
            'label' => __( 'Message', 'cc-contacts' )
        )
    );
    apply_filters( 'cc_contact_form_fields', $cc_contact_form_fields );
    return $cc_contact_form_fields;
}
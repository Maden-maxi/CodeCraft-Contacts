<?php

add_action( 'rest_api_init', 'cc_contact_form_rest_fields' );

/**
 * Registering form fields in WP-REST API
 *
 */
function cc_contact_form_rest_fields() {
	$fields = cc_contact_form_fields();

	foreach ($fields as $field) {
		register_rest_field(
			'cc_contacts', $field['name'], array(
				'get_callback' => function( $contact_arr ) use ( $field ) {
					$value = get_post_meta( $contact_arr['id'], '_' . $field['name'] . '_value', true );
					return $value;
				},
				'update_callback' => function( $contact_name, $contact_obj ) use ( $field ) {
					$contact = update_post_meta( $contact_obj->ID, $field['name'], $contact_name );
					update_post_meta( $contact_obj->ID, '_' . $field['name'] . '_value', $contact_name );
					if ( $contact === false ) {
						return new WP_Error( 'rest_cc_contact_name_failed', __( 'Failed to update cc_contact_name.' ), array( 'status' => 500 ) );
					}
					return true;
				},
				'schema' => array(
					'description' => $field['label'],
					'type' => 'string'
				)
			)
		);
	}

}
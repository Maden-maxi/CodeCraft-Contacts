<?php

/**
 * @since 0.0.0
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$keys = cc_contact_form_fields();

// cleanup plugin data
foreach ( $keys as $key )
    delete_post_meta_by_key('_' . $key . '_value');

global $wpdb;

$wpdb->query("DELETE FROM wp_posts WHERE post_type='cc_contacts'");
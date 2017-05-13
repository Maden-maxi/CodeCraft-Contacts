<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
$keys = cc_contact_form_fields();
foreach ( $keys as $key )
    delete_post_meta_by_key('_' . $key . '_value');

global $wpdb;

$wpdb->query("DELETE FROM wp_posts WHERE post_type='cc_contacts'");
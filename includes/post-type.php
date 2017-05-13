<?php
/**
 * Register a custom post type
 *
 * @package CC_Contacts
 * @since 0.0.0
 */

/*
 * Register Custom Post Type
 */
function cc_contacts_post_type() {

    $labels = array(
        'name'                  => _x( 'CC Contacts', 'Post Type General Name', 'cc_contacts' ),
        'singular_name'         => _x( 'CC Contact', 'Post Type Singular Name', 'cc_contacts' ),
        'menu_name'             => __( 'CC Contacts', 'cc_contacts' ),
        'name_admin_bar'        => __( 'CC Contact', 'cc_contacts' ),

    );
    $args = array(
        'label'                 => __( 'CC Contact', 'cc_contacts' ),
        'description'           => __( 'CodeCraft Contacts', 'cc_contacts' ),
        'labels'                => $labels,
        'supports'              => array( 'title' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 25,
        'menu_icon'             => 'dashicons-email-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => false,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'cc-contacts',
        'rest_controller_class' => 'WP_REST_CC_Contacts_Controller',
    );
    register_post_type( 'cc_contacts', $args );

}
add_action( 'init', 'cc_contacts_post_type', 0 );
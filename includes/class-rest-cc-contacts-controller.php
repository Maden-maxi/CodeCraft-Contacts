<?php
/**
 * Created by PhpStorm.
 * User: anonymous
 * Date: 11.05.17
 * Time: 21:33
 */

class WP_REST_CC_Contacts_Controller extends WP_REST_Posts_Controller{
    public function create_item_permissions_check($request)
    {

        if( !wp_verify_nonce('cc_contacts', $request['nonce']) ){
            return new WP_Error( 'rest_cannot_edit_others', __( 'Sorry, you are not allowed to create posts as11 this user.', 'cc-contacts' ), array( 'status' => rest_authorization_required_code() ) );
        }
        return true;
    }
}
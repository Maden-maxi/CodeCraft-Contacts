<?php

/**
 * @since 0.0.0
 * @package CC_Contacts
 * @subpackage CC_Contacts_Meta_Box
 */
class CC_Contacts_Meta_Box {
    /**
     * Default values for creating meta fields
     *
     * @var array
     */
    public $field_defaults = array(
        'type' => 'input',
        'input_type' => 'text',
        'name' => '',
        'label' => ''
    );

    /**
    * Install hooks in moment initialization class.
    */
    public function __construct() {
        $this->setDefaultFields();
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post', array( $this, 'save' ) );
    }

    /**
     * Set a fields in meta box
     */
    public function setDefaultFields()
    {
        $this->default_fields = cc_contact_form_fields();
    }

    /**
     *
     * @param $post_type
     */
    public function add_meta_box( $post_type ) {

        $post_types = array('cc_contacts');
        if ( in_array( $post_type, $post_types )) {
            add_meta_box(
                'cc_contacts_meta_box'
                ,__( 'Contact', 'cc-contacts' )
                ,array( $this, 'render_meta_box_content' )
                ,$post_type
                ,'advanced'
                ,'high'
            );
        }
    }

    /**
     * Save data in save post action
     *
     * @param $post_id
     * @return mixed
     */
    public function save( $post_id ) {


        if ( ! isset( $_POST['cc_contacts_meta_box_nonce'] ) )
            return $post_id;

        $nonce = $_POST['cc_contacts_meta_box_nonce'];


        if ( ! wp_verify_nonce( $nonce, 'cc_contacts_meta_box' ) )
            return $post_id;


        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $post_id;


        foreach ( $this->default_fields as $field )
            $this->save_field($post_id , $field['name']);

    }

    /**
     * Render box function
     *
     * @param $post WP_Post
     */
    public function render_meta_box_content( $post ) {

        wp_nonce_field( 'cc_contacts_meta_box', 'cc_contacts_meta_box_nonce' );
        echo "<table>";
        cc_contact_form_fields();
        foreach ( $this->default_fields as $field )
            $this->render_box_field( $post ,$field );
        echo "</table>";
    }

    /**
     * Render meta box field
     *
     * @param $post WP_Post
     * @param $field array
     *      Required. An array of arguments used to build meta field
     *      @type string $name          Required.Name attribute of field
     *      @type string $input         Required.Tag of field
     *      @type string $input_type    Required.Type attribute of field
     *      @type string $label         Optional.Label text of field
     */
    public function render_box_field( $post, $field ){
        $field = wp_parse_args( $field, $this->field_defaults );

        $value = get_post_meta( $post->ID, '_' . $field['name'] . '_value', true );

        echo '<tr><td><label for="' . $field['name'] . '_field">';
        _e( $field['label'], 'cc-contacts' );
        echo '</label></td>';
        if( $field['type'] === 'input' ) {
            echo '<td><' . $field['type'] . ' type="' . $field['input_type'] . '" id="' . $field['name'] . '_field" name="'. $field['name']. '_field"';
            echo ' value="' . esc_attr( $value ) . '"/></td></tr>';
        }elseif($field['type'] === 'textarea') {
            echo '<td><' . $field['type'] . '  id="' . $field['name'] . '_field" name="'. $field['name']. '_field"';
            echo ' value="' . esc_attr( $value ) . '">' . esc_attr( $value ) . '</' . $field['type'] . '></td></tr>';
        }

    }

    /**
     * Save field value
     *
     * @param $post_id int
     * @param $name string
     */
    public function save_field( $post_id, $name ){
        $data =  $_POST[$name . '_field'] ;

        update_post_meta( $post_id, '_' . $name . '_value', $data );
    }
}

/**
 * Call class on the edit page.
 */
function cc_contacts_call_meta_box() {
    new CC_Contacts_Meta_Box();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'cc_contacts_call_meta_box' );
    add_action( 'load-post-new.php', 'cc_contacts_call_meta_box' );
}
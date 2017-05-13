<?php
/**
 * @since 0.0.0
 * @package CC_Contacts
 * @subpackage CC_Contacts_Shortcode_Form
 */

class CC_Contacts_Shortcode_Form {

    /**
     * Initialization filters and hooks of shortcode
     *
     * CC_Contacts_Shortcode_Form constructor.
     */
    function __construct()
    {
        // Register Shortcode
        add_action( 'init', array($this, 'shortcode'), 0 );

        add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
        add_shortcode( 'cc_contact_form', array( $this, 'shortcode' ) );
    }

    /**
     * Load shortcode javascript and css files
     */
    function assets(){
        $path = plugin_dir_url(__FILE__);

        wp_register_script( 'cc_contacts_shortcode', $path . 'js/shortcode.js', array('wp-api'), '0.0.0', true );
        wp_enqueue_script( 'cc_contacts_shortcode' );
        wp_localize_script('cc_contacts_shortcode', 'CC_CONTACTS', array(
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( 'cc_contacts_nonce' )
        ));

        wp_register_style( 'cc_contacts_shortcode', $path . 'css/shortcode.css', array( 'dashicons' ) );
        wp_enqueue_style( 'cc_contacts_shortcode' );
    }

    /**
     * @param array $atts
     * @param null $content
     * @param string $tag
     * @return string
     */
    function shortcode( $atts, $content = null, $tag = 'cc_contact_form' ){

        $atts = shortcode_atts(
            array(
                'custom_class' => ''
            ),
            $atts,
            'cc_contact_form'
        );
        $fields = array(
            array(
                'name' => 'cc_contacts_name',
                'type' => 'input',
                'input_type' => 'text',
                'label' => ''
            )
        );
        $fields = cc_contact_form_fields();

        ob_start();
        ?>
        <form action="#" method="post" class="cc_contacts_form<?php echo !empty($atts['custom_class']) ? esc_attr($atts['custom_class']) : '' ?>">
            <?php foreach ( $fields as $field ): ?>
                <fieldset class="material">
                    <?php if( $field['type'] === 'input' ): ?>
                        <input type="<?php echo esc_attr( $field['input_type'] ) ?>" id="<?php echo esc_attr( $field['name'] ) ?>" name="<?php echo esc_attr( $field['name'] ) ?>" required>
                    <?php elseif ( $field['type'] === 'textarea' ): ?>
                        <textarea name="<?php echo esc_attr( $field['name'] ) ?>" id="<?php echo esc_attr( $field['name'] ) ?>" required></textarea>
                    <?php endif; ?>
                    <label for="<?php echo esc_attr( $field['name'] ) ?>"><?php echo esc_attr( $field['label'] ) ?></label>
                </fieldset>
                <?php endforeach; ?>

            <button type="submit"><?php _e('Submit', 'cc-contacts') ?></button>
            <div class="response">
                <span class="dashicons dashicons-update hidden"></span>
            </div>
        </form>
        <?php
        return ob_get_clean();
    }


}
new CC_Contacts_Shortcode_Form();
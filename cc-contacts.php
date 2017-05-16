<?php
/**
 * @since 0.0.0
 * @package CC_Contacts
 *
 * Plugin Name: CodeCraft Contacts
 * Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
 * Description: Contact forms plugin
 * Version:     1.0.1
 * Author:      Denys Dnishchneko
 * Author URI:  https://developer.wordpress.org/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cc-contacts
 * Domain Path: /languages
 *
 * CodeCraft Contacts is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * CodeCraft Contacts is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CodeCraft Contacts. If not, see  https://www.gnu.org/licenses/gpl-2.0.html.
 */

if( ! defined('WPINC') ) {
    die('Forbidden');
}

define( 'CC_CONTACTS_URI',  plugin_dir_url(__FILE__) );
define( 'CC_CONTACTS_DIR',  plugin_dir_path(__FILE__) );

class CC_Contacts {
    /**
     * Version of the class
     *
     * @var string
     */

    private $version = '1.0.1';

    /**
     * Get a version of this class
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    public static $instance = null;

    /**
     * Get instance only once. Singleton
     *
     * @return null
     */
    public static function getInstance()
    {
        if( null === self::$instance ){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * CC_Contacts constructor.
     * Initializing actions such as enqueueing scripts and style, hooking to actions and filters
     */
    function __construct(){
        $this->load();
    }

    /**
     * Load all files
     */
    protected function load(){
        require_once('includes/post-type.php');
        require_once('includes/contact-fields.php');
        require_once('includes/ajax.php');
        require_once('includes/additional-rest-field.php');
        require_once('includes/class-rest-cc-contacts-controller.php');
        require_once('admin/class-meta-box.php');
        require_once('admin/class-cc-contacts-table-list.php');
        require_once('public/class-cc-contacts-shortcode-form.php');
    }

}
// Init plugin
CC_Contacts::getInstance();
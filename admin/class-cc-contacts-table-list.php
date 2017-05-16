<?php

/**
 * @since 1.1.0
 * @package CC_Contacts
 * @subpackage CC_Contacts_List_Table
 */

class CC_Contacts_List_Table{
    /**
     * Instance
     *
     * @var null
     */
    private static $instance = null;

    /**
     * Slug
     *
     * @var string
     */
    private $slug = 'cc_contacts';

    /**
     * Table columns
     *
     * @var array
     */
    private $table_columns = array();

    /**
     * Instantinate class only once. Singleton
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
     * MM_Fkickity_List_Table constructor.Initalize hooks
     */
    function __construct(){
        $this->setTableColumns();
        add_filter( "manage_edit-{$this->slug}_columns", array( $this, "header_columns" ) );
        add_filter( "manage_edit-{$this->slug}_sortable_columns", array( $this, "header_columns" ) );

        add_action("manage_{$this->slug}_posts_custom_column",  array( $this ,'output_cell_content_column' ), 10, 2);

        //add_action( "admin_menu", array( $this, "row_actions_hook" ) );
    }

    /**
     *
     */
    public function setTableColumns()
    {
        $this->table_columns = cc_contact_form_fields();
    }

    /**
     * Adding table head
     *
     * @param $columns
     * @return array
     */
    public function header_columns( $columns ){
        $new_columns = array();
        foreach ( $this->table_columns as $column )
            $new_columns[$column['name']] = $column['label'];
        $new_columns['date'] = $columns['date'];
        unset( $columns['date'] );

        return array_merge($columns, $new_columns );
    }

    /**
     *
     *
     * @param $column_name
     * @param $post_id
     */
    public function output_cell_content_column( $column_name, $post_id ) {

        foreach ( $this->table_columns as $column ) {
            if( $column['name'] === $column_name ) {
                echo get_post_meta( $post_id, $column['name'], true );
            }
        }

    }

}

CC_Contacts_List_Table::getInstance();
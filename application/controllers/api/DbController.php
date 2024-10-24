<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DbController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function createDatabase()
    {
        $this->load->dbforge();
        if (!$this->db->database_exists('coryphamtha')) {
            if ($this->dbforge->create_database('coryphamtha')) {
                echo 'Database created!';
            } else {
                echo 'Failed to create database.';
            }
        } else {
            echo 'Database already exists.';
        }
    }

    public function createUsersTable()
    {
        $this->load->dbforge();

        if (!$this->db->table_exists('users')) {
            $fields = array(
                'id' => array(
                    'type' => 'CHAR',
                    'constraint' => '36',
                    'primary' => TRUE
                ),
                'email' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '320',
                    'null' => TRUE
                ),
                'emailVerificationCode' => array(
                    'type' => 'CHAR',
                    'constraint' => '5',
                    'null' => FALSE
                ),
                'phone' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '15',
                    'unique' => TRUE,
                    'null' => TRUE
                ),
                'phoneVerificationCode' => array(
                    'type' => 'CHAR',
                    'constraint' => '5',
                    'null' => TRUE
                ),
                'loginVerificationCode' => array(
                    'type' => 'CHAR',
                    'constraint' => '5',
                    'null' => TRUE
                ),
                'address_id' => array(
                    'type' => 'CHAR',
                    'constraint' => '36',
                    'null' => FALSE
                ),
                'sex' => array(
                    'type' => 'TINYINT',
                    'constraint' => '1',
                    'null' => FALSE
                ),
                'firstName' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => TRUE
                ),
                'lastName' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => TRUE
                ),
                'birthday' => array(
                    'type' => 'DATE',
                    'null' => TRUE
                )
            );
            $this->dbforge->add_field($fields);
            $this->dbforge->create_table('users');
            echo 'Users table created!';
        } else {
            echo 'Users table already exists.';
        }
    }

    public function createAddressesTable()
    {
        $this->load->dbforge();

        if (!$this->db->table_exists('addresses')) {
            $fields = array(
                'id' => array(
                    'type' => 'CHAR',
                    'constraint' => '36',
                    'primary' => TRUE
                ),
                'region' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => TRUE
                ),
                'city' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => TRUE
                ),
                'street' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => TRUE
                ),
                'house' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => TRUE
                )
            );
            $this->dbforge->add_field($fields);
            $this->dbforge->create_table('addresses');
            echo 'Addresses table created!';
        } else {
            echo 'Addresses table already exists.';
        }
    }

    public function createProductsTable()
    {
        $this->load->dbforge();

        if (!$this->db->table_exists('products')) {
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'auto_increment' => TRUE,
                    'null' => FALSE
                ),
                'title' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => TRUE
                ),
                'vendor_code' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => FALSE
                ),
                'price' => array(
                    'type' => 'INT',
                    'null' => FALSE
                ),
                'availability' => array(
                    'type' => 'TINYINT',
                    'null' => FALSE
                ),
                'category_id' => array(
                    'type' => 'INT',
                    'null' => FALSE
                ),
                'description' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '500',
                    'null' => FALSE
                )
            );
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('products');
            echo 'Products table created!';
        } else {
            echo 'Products table already exists.';
        }
    }

    public function createProductCategoriesTable()
    {
        $this->load->dbforge();

        if (!$this->db->table_exists('product_categories')) {
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'auto_increment' => TRUE,
                    'null' => FALSE
                ),
                'title' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => TRUE
                ),
                'level' => array(
                    'type' => 'TINYINT',
                    'constraint' => '1',
                    'null' => FALSE
                ),
                'main' => array(
                    'type' => 'INT',
                    'null' => FALSE
                )
            );
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('product_categories');
            echo 'Product categories table created!';
        } else {
            echo 'Product categories table already exists.';
        }
    }

    public function createProductFilterTagCategoriesTable()
    {
        $this->load->dbforge();

        if (!$this->db->table_exists('product_filter_tag_categories')) {
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'auto_increment' => TRUE,
                    'null' => FALSE
                ),
                'title' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => FALSE
                )
            );
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('product_filter_tag_categories');
            echo 'Product filter tag categories table created!';
        } else {
            echo 'Product filter tag categories table already exists.';
        }
    }

    public function createProductFilterTagsTable()
    {
        $this->load->dbforge();

        if (!$this->db->table_exists('product_filter_tags')) {
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'auto_increment' => TRUE,
                    'null' => FALSE
                ),
                'product_filter_tag_category_id' => array(
                    'type' => 'INT',
                    'null' => FALSE
                ),
                'title' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => TRUE
                )
            );
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('product_filter_tags');
            echo 'Product filter tags table created!';
        } else {
            echo 'Product filter tags table already exists.';
        }
    }

    public function createProducts2ProductFilterTagsTable()
    {
        $this->load->dbforge();

        if (!$this->db->table_exists('products2product_filter_tags')) {
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'auto_increment' => TRUE,
                    'null' => FALSE
                ),
                'product_filter_tags_id' => array(
                    'type' => 'INT',
                    'null' => FALSE
                ),
                'product_id' => array(
                    'type' => 'INT',
                    'null' => FALSE
                )
            );
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('products2product_filter_tags');
            echo 'Products to product filter tags table created!';
        } else {
            echo 'Products to product filter tags table already exists.';
        }
    }
}


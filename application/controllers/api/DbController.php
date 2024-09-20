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
}
?>

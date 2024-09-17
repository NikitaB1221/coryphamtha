<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    private function generate_guid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    // CRUD для таблицы users
    public function get_users()
    {
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function get_user($id)
    {
        $query = $this->db->get_where('users', array('id' => $id));
        return $query->row_array();
    }

    public function create_user($data)
    {
        $data['id'] = $this->generate_guid();
        return $this->db->insert('users', $data);
    }

    public function update_user($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function delete_user($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

    // CRUD для таблицы addresses
    public function get_addresses()
    {
        $query = $this->db->get('addresses');
        return $query->result_array();
    }

    public function get_address($id)
    {
        $query = $this->db->get_where('addresses', array('id' => $id));
        return $query->row_array();
    }

    public function create_address($data)
    {
        $data['id'] = $this->generate_guid();
        return $this->db->insert('addresses', $data);
    }

    public function update_address($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('addresses', $data);
    }

    public function delete_address($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('addresses');
    }
}
?>

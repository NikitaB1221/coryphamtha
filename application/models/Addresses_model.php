<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addresses_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_address($data) {
        $this->db->insert('addresses', $data);
        return $this->db->insert_id();
    }

    public function get_all() {
        return $this->db->get('addresses')->result_array();
    }

    public function get_by_id($id = null) {
        if ($id === null) {
            $query = $this->db->get('addresses');
            return $query->result_array();
        } else {
            $query = $this->db->get_where('addresses', array('id' => $id));
            return $query->row_array();
        }
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('addresses', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('addresses');
    }
}
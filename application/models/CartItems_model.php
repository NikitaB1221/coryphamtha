<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CartItems_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        return $this->db->get('cart_items')->result_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where('cart_items', array('id' => $id))->row_array();
    }

    public function create_cart_items($data) {
        return $this->db->insert('cart_items', $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('cart_items', $data);
        return $this->db->affected_rows();
    }

    public function delete($id) {
        return $this->db->delete('cart_items', array('id' => $id));
    }
}
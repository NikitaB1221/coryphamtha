<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WishlistItems_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        return $this->db->get('wishlist_items')->result_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where('wishlist_items', array('id' => $id))->row_array();
    }

    public function insert($data) {
        return $this->db->insert('wishlist_items', $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('wishlist_items', $data);
        return $this->db->affected_rows();
    }

    public function delete($id) {
        return $this->db->delete('wishlist_items', array('id' => $id));
    }
}
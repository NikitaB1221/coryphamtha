<?php
class Order_model extends CI_Model {

public function __construct() {
    parent::__construct();
    $this->load->database();
}
public function get_orders() {
    $this->db->select('*');
    $this->db->from('order');
    $query = $this->db->get();
    return $query->result_array();
}

public function create_order($data) {
    $this->db->insert('order', $data);
    return $this->db->insert_id();
}

public function get_order($id) {
    return $this->db->get_where('order', array('id' => $id))->row_array();
}

public function update_order($id, $data) {
    $this->db->where('id', $id);
    return $this->db->update('order', $data);
}

public function delete_order($id) {
    $this->db->where('id', $id);
    return $this->db->delete('order');
}
public function get_cart_items_by_user_id($user_id) {
    $this->db->select('*');
    $this->db->from('cart_items');
    $this->db->where('user_id', $user_id);
    return $this->db->get()->result_array();
}
public function calculate_total_price($cart_items) {
    $total_price = 0;
    foreach ($cart_items as $item) {
        $total_price += $item['prise'] * $item['quantity'];
    }
    return $total_price;
}
}
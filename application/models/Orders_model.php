<?php
class Orders_model extends CI_Model {

public function __construct() {
    parent::__construct();
    $this->load->database();
}
public function get_orders() {
    $this->db->select('*');
    $this->db->from('orders');
    $query = $this->db->get();
    return $query->result_array();
}

public function create_order($data) {
    $this->db->insert('orders', $data);
    return $this->db->insert_id();
}

public function get_order($id) {
    return $this->db->get_where('orders', array('id' => $id))->row_array();
}

public function update_order($id, $data) {
    $this->db->where('id', $id);
    return $this->db->update('orders', $data);
}

public function delete_order($id) {
    $this->db->where('id', $id);
    return $this->db->delete('orders');
}
public function get_cart_items_by_user_id($user_id) {
    $this->db->select('*');
    $this->db->from('cart_items');
    $this->db->where('user_id', $user_id);
    return $this->db->get()->result_array();
}
public function get_product_price($product_id) {
    $this->db->select('price');
    $this->db->from('products');
    $this->db->where('id', $product_id);
    $query = $this->db->get();
    return $query->row_array()['price'];
}
public function calculate_total_price($user_id) {
    $total_price = 0;
    $cart_items = $this->get_cart_items_by_user_id($user_id);
    foreach ($cart_items as $item) {
        $product_price = $this->get_product_price($item['product_id']);
        $total_price += $product_price * $item['quantity'];
    }
    return $total_price;
}

}
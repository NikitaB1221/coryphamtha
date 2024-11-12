<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Orders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Order_model');
    }    
    public function create() {
        $u_id = $this->input->post('user_id');
        $data = array(
            'id' => uniqid(),
            'user_phone' => $this->input->post('user_phone'),
            'user_id' => $u_id,
            'order_time' => date('Y-m-d H:i:s'),
            'total_prise' => $this->calculate_total_price($u_id),
        );
        $order_id = $this->Order_model->create_order($data);
        echo json_encode(array("data" => $data, 'Orders created successfuly'));
        return $order_id;
    }
    public function index() {
        $orders = $this->Order_model->get_orders();
        echo json_encode($orders);
    }
    public function view($id) {
        $order = $this->Order_model->get_order($id);
        echo json_encode($order);
    }
    public function update($id) {
        $data = array(
            'user_phone' => $this->input->post('user_phone'),
            'user_id' => $this->input->post('user_id'),
            'order_time' => $this->input->post('order_time'),
            'total_prise' => $this->input->post('total_prise'),
        );
        $this->Order_model->update_order($id, $data);
        echo json_encode(array('status' => 'success'));
    }
    public function delete($id) {
        $this->Order_model->delete_order($id);
        echo json_encode(array('Order successfuly deleted'));
    }
    public function get_cart_items_by_user_id($user_id) {
        $cart_items = $this->Order_model->get_cart_items_by_user_id($user_id);
        echo json_encode($cart_items);
    }
    public function calculate_total_price($user_id) {
        $cart_items = $this->Order_model->get_cart_items_by_user_id($user_id);
        $total_price = $this->Order_model->calculate_total_price($cart_items);
        echo json_encode(array('total_price' => $total_price));
    }
}
<?php
class OrderItems extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('OrderItems_model');
    }

    public function index()
    {
        $data['order_items'] = $this->OrderItems_model->get_all();
        echo json_encode($data);
    }

    public function create()
    {
        $data = array(
            'order_id' => $this->input->post('order_id'),
            'product_id' => $this->input->post('product_id'),
            'quantity' => $this->input->post('quantity')
        );
        $id = $this->OrderItems_model->create_order_items($data);
        echo json_encode(array('status' => 'Order item created successfully'));
    }

    public function view($id)
    {
        $data['order_item'] = $this->OrderItems_model->get_by_id($id);
        if ($data['order_item']) {
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    public function update($id)
    {
        $data = array(
            'order_id' => $this->input->post('order_id'),
            'product_id' => $this->input->post('product_id'),
            'quantity' => $this->input->post('quantity')
        );
        $this->OrderItems_model->update($id, $data);
        echo json_encode(array('status' => 'Order item updated successfully'));
    }

    public function delete($id)
    {
        $this->OrderItems_model->delete($id);
        echo json_encode(array('status' => 'Order item deleted successfully'));
    }
}
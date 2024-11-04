<?php
class CartItems extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('CartItems_model');
    }

    public function index()
    {
        $data['cart_items'] = $this->CartItems_model->get_all();
        echo json_encode($data);
    }

    public function create()
    {
        $data = array(
            'user_id' => $this->input->post('user_id'),
            'product_id' => $this->input->post('product_id'),
            'quantity' => $this->input->post('quantity')
        );
        $id = $this->CartItems_model->create_cart_items($data);
        echo json_encode(array('status' => 'Cart item created successfully','id' => $id['id']));
    }

    public function view($id)
    {
        $data['cart_item'] = $this->CartItems_model->get_by_id($id);
        if ($data['cart_item']) {
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    public function update($id)
    {
        $data = array(
            'user_id' => $this->input->post('user_id'),
            'product_id' => $this->input->post('product_id'),
            'quantity' => $this->input->post('quantity')
        );
        $this->CartItems_model->update($id, $data);
        echo json_encode(array('status' => 'Cart item updated successfully'));
    }

    public function delete($id)
    {
        $this->CartItems_model->delete($id);
        echo json_encode(array('status' => 'Cart item deleted successfully'));
    }
}
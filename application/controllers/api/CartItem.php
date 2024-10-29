<?php
class CartItems_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('CartItems_model');
    }

    public function index()
    {
        $data['records'] = $this->CartItems_model->get_all();
        $this->load->view('cart_items_view', $data);
    }

    public function create()
    {
        $this->load->view('create_cart_items_view');
    }

    public function store()
    {
        $data = array(
            'user_id' => $this->input->post('user_id'),
            'product_id' => $this->input->post('product_id'),
            'quantity' => $this->input->post('quantity')
        );
        $this->CartItems_model->insert($data);
        redirect('cart_items');
    }

    public function edit($id)
    {
        $data['record'] = $this->CartItems_model->get_by_id($id);
        $this->load->view('edit_cart_items_view', $data);
    }

    public function update($id)
    {
        $data = array(
            'user_id' => $this->input->post('user_id'),
            'product_id' => $this->input->post('product_id'),
            'quantity' => $this->input->post('quantity')
        );
        $this->CartItems_model->update($id, $data);
        redirect('cart_items');
    }

    public function delete($id)
    {
        $this->CartItems_model->delete($id);
        redirect('cart_items');
    }
}
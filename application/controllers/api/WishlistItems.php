<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WishlistItems_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('WishlistItems_model');
    }

    public function index()
    {
        $data['records'] = $this->WishlistItems_model->get_all();
        $this->load->view('wishlist_items_view', $data);
    }

    public function create()
    {
        $this->load->view('create_wishlist_items_view');
    }

    public function store()
    {
        $data = array(
            'user_id' => $this->input->post('user_id'),
            'product_id' => $this->input->post('product_id'),
            'quantity' => $this->input->post('quantity')
        );
        $this->WishlistItems_model->insert($data);
        redirect('wishlist_items');
    }

    public function edit($id)
    {
        $data['record'] = $this->WishlistItems_model->get_by_id($id);
        $this->load->view('edit_wishlist_items_view', $data);
    }

    public function update($id)
    {
        $data = array(
            'user_id' => $this->input->post('user_id'),
            'product_id' => $this->input->post('product_id'),
            'quantity' => $this->input->post('quantity')
        );
        $this->WishlistItems_model->update($id, $data);
        redirect('wishlist_items');
    }

    public function delete($id)
    {
        $this->WishlistItems_model->delete($id);
        redirect('wishlist_items');
    }
}
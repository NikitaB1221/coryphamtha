<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WishlistItems extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('WishlistItems_model');
    }

    public function index()
    {
        $data['wishlist_items'] = $this->WishlistItems_model->get_all();
        echo json_encode($data);
    }

    public function create()
    {
        $data = array(
            'user_id' => $this->input->post('user_id'),
            'product_id' => $this->input->post('product_id'),
            'quantity' => $this->input->post('quantity')
        );
        $id = $this->WishlistItems_model->create_wishlist_items($data);
        echo json_encode(array('status' => 'Wishlist item created successfully','id' => $id['id']));
    }

    public function view($id)
    {
        $data['wishlist_item'] = $this->WishlistItems_model->get_by_id($id);
        if ($data['wishlist_item']) {
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
        $this->WishlistItems_model->update($id, $data);
        echo json_encode(array('status' => 'Wishlist item updated successfully'));
    }

    public function delete($id)
    {
        $this->WishlistItems_model->delete($id);
        echo json_encode(array('status' => 'Wishlist item deleted successfully'));
    }
}
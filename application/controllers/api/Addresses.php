<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addresses extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Addresses_model');
    }

    public function index()
    {
        $data['addresses'] = $this->Addresses_model->get_all();
        echo json_encode($data);
    }

    public function create() {
        $data = array(
            'id' => uniqid(), 
            'region' => $this->input->post('region'),
            'city' => $this->input->post('city'),
            'street' => $this->input->post('street'),
            'house' => $this->input->post('house')
        );
        $id = $this->Addresses_model->create_address($data);
        echo json_encode(array('status' => 'Address created successfully', 'id' => $id));
    }

    public function view($id)    {
        $data['address'] = $this->Addresses_model->get_by_id($id);
        if ($data['address']) {
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    public function update($id) {
        $data = array(
            'region' => $this->input->post('region'),
            'city' => $this->input->post('city'),
            'street' => $this->input->post('street'),
            'house' => $this->input->post('house')
        );
        $this->Addresses_model->update($id, $data);
        echo json_encode(array('status' => 'Address updated successfully'));
    }

    public function delete($id) {
        $this->Addresses_model->delete($id);
        echo json_encode(array('status' => 'Address deleted successfully'));
    }
}

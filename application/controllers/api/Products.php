<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function index()
    {
        $data['products'] = $this->Product_model->get_products();
        echo json_encode($data);
    }

    public function view($id)
    {
        $data['product'] = $this->Product_model->get_product($id);
        if ($data['product']) {
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    public function create()
    {
        $data = array(
            'title' => $this->input->post('title'),
            'vendor_code' => $this->input->post('vendor_code'),
            'price' => $this->input->post('price'),
            'availability' => $this->input->post('availability'),
            'category_id' => $this->input->post('category_id'),
            'description' => $this->input->post('description')
        );

        $this->Product_model->create_product($data);
        echo json_encode(array('status' => 'Product created successfully'));
    }

    public function update($id)
    {
        $data = array(
            'title' => $this->input->post('title'),
            'vendor_code' => $this->input->post('vendor_code'),
            'price' => $this->input->post('price'),
            'availability' => $this->input->post('availability'),
            'category_id' => $this->input->post('category_id'),
            'description' => $this->input->post('description')
        );

        $this->Product_model->update_product($id, $data);
        echo json_encode(array('status' => 'Product updated successfully'));
    }

    public function delete($id)
    {
        $this->Product_model->delete_product($id);
        echo json_encode(array('status' => 'Product deleted successfully'));
    }

    public function get_categories()
    {
        $data['categories'] = $this->Product_model->get_categories();
        echo json_encode($data);
    }

    public function view_category($id)
    {
        $data['category'] = $this->Product_model->get_category($id);
        if ($data['category']) {
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    public function create_category()
    {
        $data = array(
            'title' => $this->input->post('title'),
            'level' => $this->input->post('level'),
            'main' => $this->input->post('main')
        );

        $this->Product_model->create_category($data);
        echo json_encode(array('status' => 'Category created successfully'));
    }

    public function update_category($id)
    {
        $data = array(
            'title' => $this->input->post('title'),
            'level' => $this->input->post('level'),
            'main' => $this->input->post('main')
        );

        $this->Product_model->update_category($id, $data);
        echo json_encode(array('status' => 'Category updated successfully'));
    }

    public function delete_category($id)
    {
        $this->Product_model->delete_category($id);
        echo json_encode(array('status' => 'Category deleted successfully'));
    }

    public function get_filter_tag_categories()
    {
        $data['filter_tag_categories'] = $this->Product_model->get_filter_tag_categories();
        echo json_encode($data);
    }

    public function view_filter_tag_category($id)
    {
        $data['filter_tag_category'] = $this->Product_model->get_filter_tag_category($id);
        if ($data['filter_tag_category']) {
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    public function create_filter_tag_category()
    {
        $data = array(
            'title' => $this->input->post('title')
        );

        $this->Product_model->create_filter_tag_category($data);
        echo json_encode(array('status' => 'Filter tag category created successfully'));
    }

    public function update_filter_tag_category($id)
    {
        $data = array(
            'title' => $this->input->post('title')
        );

        $this->Product_model->update_filter_tag_category($id, $data);
        echo json_encode(array('status' => 'Filter tag category updated successfully'));
    }

    public function delete_filter_tag_category($id)
    {
        $this->Product_model->delete_filter_tag_category($id);
        echo json_encode(array('status' => 'Filter tag category deleted successfully'));
    }

    public function get_filter_tags()
    {
        $data['filter_tags'] = $this->Product_model->get_filter_tags();
        echo json_encode($data);
    }

    public function view_filter_tag($id)
    {
        $data['filter_tag'] = $this->Product_model->get_filter_tag($id);
        if ($data['filter_tag']) {
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    public function create_filter_tag()
    {
        $data = array(
            'product_fiterter_tag_category_id' => $this->input->post('product_fiterter_tag_category_id'),
            'title' => $this->input->post('title')
        );

        $this->Product_model->create_filter_tag($data);
        echo json_encode(array('status' => 'Filter tag created successfully'));
    }

    public function update_filter_tag($id)
    {
        $data = array(
            'product_fiterter_tag_category_id' => $this->input->post('product_fiterter_tag_category_id'),
            'title' => $this->input->post('title')
        );

        $this->Product_model->update_filter_tag($id, $data);
        echo json_encode(array('status' => 'Filter tag updated successfully'));
    }

    public function delete_filter_tag($id)
    {
        $this->Product_model->delete_filter_tag($id);
        echo json_encode(array('status' => 'Filter tag deleted successfully'));
    }

    public function get_product_filter_tags($product_id)
    {
        $data['product_filter_tags'] = $this->Product_model->get_product_filter_tags($product_id);
        echo json_encode($data);
    }

    public function create_product_filter_tag()
    {
        $data = array(
            'product_fiterter_tags_id' => $this->input->post('product_fiterter_tags_id'),
            'product_id' => $this->input->post('product_id')
        );

        $this->Product_model->create_product_filter_tag($data);
        echo json_encode(array('status' => 'Product filter tag created successfully'));
    }

    public function delete_product_filter_tag($id)
    {
        $this->Product_model->delete_product_filter_tag($id);
        echo json_encode(array('status' => 'Product filter tag deleted successfully'));
    }
}


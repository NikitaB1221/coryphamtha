<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    // CRUD для таблицы products
    public function get_products()
    {
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function get_product($id)
    {
        $query = $this->db->get_where('products', array('id' => $id));
        return $query->row_array();
    }

    public function create_product($data)
    {
        return $this->db->insert('products', $data);
    }

    public function update_product($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('products', $data);
    }

    public function delete_product($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('products');
    }

    // CRUD для таблицы product_categories
    public function get_categories()
    {
        $query = $this->db->get('product_categories');
        return $query->result_array();
    }

    public function get_category($id)
    {
        $query = $this->db->get_where('product_categories', array('id' => $id));
        return $query->row_array();
    }

    public function create_category($data)
    {
        return $this->db->insert('product_categories', $data);
    }

    public function update_category($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('product_categories', $data);
    }

    public function delete_category($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('product_categories');
    }

    // CRUD для таблицы product_fiterter_tag_categories
    public function get_filter_tag_categories()
    {
        $query = $this->db->get('product_fiterter_tag_categories');
        return $query->result_array();
    }

    public function get_filter_tag_category($id)
    {
        $query = $this->db->get_where('product_fiterter_tag_categories', array('id' => $id));
        return $query->row_array();
    }

    public function create_filter_tag_category($data)
    {
        return $this->db->insert('product_fiterter_tag_categories', $data);
    }

    public function update_filter_tag_category($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('product_fiterter_tag_categories', $data);
    }

    public function delete_filter_tag_category($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('product_fiterter_tag_categories');
    }

    // CRUD для таблицы product_fiterter_tags
    public function get_filter_tags()
    {
        $query = $this->db->get('product_fiterter_tags');
        return $query->result_array();
    }

    public function get_filter_tag($id)
    {
        $query = $this->db->get_where('product_fiterter_tags', array('id' => $id));
        return $query->row_array();
    }

    public function create_filter_tag($data)
    {
        return $this->db->insert('product_fiterter_tags', $data);
    }

    public function update_filter_tag($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('product_fiterter_tags', $data);
    }

    public function delete_filter_tag($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('product_fiterter_tags');
    }

    // CRUD для таблицы products2product_fiterter_tags
    public function get_product_filter_tags($product_id)
    {
        $this->db->select('products2product_fiterter_tags.*, product_fiterter_tags.title as tag_title');
        $this->db->from('products2product_fiterter_tags');
        $this->db->join('product_fiterter_tags', 'products2product_fiterter_tags.product_fiterter_tags_id = product_fiterter_tags.id');
        $this->db->where('products2product_fiterter_tags.product_id', $product_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function create_product_filter_tag($data)
    {
        return $this->db->insert('products2product_fiterter_tags', $data);
    }

    public function delete_product_filter_tag($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('products2product_fiterter_tags');
    }
}
?>

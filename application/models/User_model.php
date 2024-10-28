<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    private function generate_guid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    // CRUD для таблицы users
    public function get_users()
    {
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function get_user($id)
    {
        $query = $this->db->get_where('users', array('id' => $id));
        return $query->row_array();
    }

    public function create_user($data)
    {
        $data['id'] = $this->generate_guid();
        return $this->db->insert('users', $data);
    }

    public function update_user($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function delete_user($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

    // CRUD для таблицы addresses
    public function get_addresses()
    {
        $query = $this->db->get('addresses');
        return $query->result_array();
    }

    public function get_address($id)
    {
        $query = $this->db->get_where('addresses', array('id' => $id));
        return $query->row_array();
    }

    public function create_address($data)
    {
        $data['id'] = $this->generate_guid();
        return $this->db->insert('addresses', $data);
    }

    public function update_address($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('addresses', $data);
    }

    public function delete_address($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('addresses');
    }

    public function check_credentials($identifier, $VerificationCode, $type = 'login')
    {
        if ($type == 'login') {
            return $this->verify_login($identifier, $VerificationCode);
        } else {
            return $this->verify_phone($identifier, $VerificationCode);
        }
    }
    public function verify_phone($identifier, $VerificationCode)
    {
        $query = $this->db->get_where('users', array('phone' => $identifier, 'phoneVerificationCode' => $VerificationCode));

        $user = $query->row_array();

        $query2 = $this->db->get_where('users', array('id !=' => $user['id'], 'phone' => $identifier));

        foreach ($query2->result_array() as &$u) {
            $this->delete_user($u);
        }
        $this->update_user($user['id'], array('phoneVerificationCode' => null));
        if ($user && password_verify($VerificationCode, $user['phoneVerificationCode'])) {
            return $user;
        } else {
            return false;
        }
    }
    public function verify_login($identifier, $VerificationCode)
    {
        $query = $this->db->get_where('users', array('phone' => $identifier, 'loginVerificationCode' => $VerificationCode));

        $user = $query->row_array();

        $query2 = $this->db->get_where('users', array('id !=' => $user['id'], 'phone' => $identifier));

        foreach ($query2->result_array() as &$u) {
            $this->delete_user($u);
        }
        $this->update_user($user['id'], array('loginVerificationCode' => null));
        if ($user && password_verify($VerificationCode, $user['loginVerificationCode'])) {
            return $user;
        } else {
            return false;
        }
    }

    public function update_phone_verification_code($phone)
    {
        $this->db->where('phone', $phone);
        return $this->db->update('users', ['phoneVerificationCode' => rand(10000, 99999)]);
    }

    public function update_login_verification_code($phone)
    {
        $this->db->where('phone', $phone);
        return $this->db->update('users', ['loginVerificationCode' => rand(10000, 99999)]);
    }

}


?>
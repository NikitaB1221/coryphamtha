<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['users'] = $this->User_model->get_users();
        echo json_encode($data);
    }

    public function view($id)
    {
        $data['user'] = $this->User_model->get_user($id);
        if ($data['user']) {
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    public function register()
    {
        $data = array(
            'email' => $this->input->post('email'),
            'emailVerificationCode' => $this->input->post('emailVerificationCode'),
            'phone' => $this->input->post('phone'),
            // 'phoneVerificationCode' => $this->input->post('phoneVerificationCode'),
            // 'loginVerificationCode' => $this->input->post('loginVerificationCode'),
            // 'address_id' => $this->input->post('address_id'),
            // 'sex' => $this->input->post('sex'),
            'firstName' => $this->input->post('firstName'),
            'lastName' => $this->input->post('lastName'),
            'birthday' => $this->input->post('birthday'),
            // 'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT)
        );
    
        $this->User_model->create_user($data);
        $this->User_model->update_phone_verification_code($data['phone']);
        echo json_encode(array('status' => 'User registered successfully'));
    }

    public function login()
    {
        $email = $this->input->post('email');
        $LVC = $this->input->post('code');
    
        $user = $this->User_model->check_credentials($email, $LVC, 'email');
    
        if ($user) {
            echo json_encode(array('status' => 'Login successful', 'user' => $user));
        } else {
            echo json_encode(array('status' => 'Invalid email or code'));
        }
    }

    public function verify_login(){
        $phone = $this->input->post('phone');
        $LVC = $this->input->post('code');

        $user = $this->User_model->check_credentials($phone, $LVC, 'login');
        if($user){
            echo json_encode(array('status' => 'Login successful', 'user' => $user));
            $this->session->set_userdata('user_id',$user['id']);
        }
    }

    public function verify_phone(){
        $phone = $this->input->post('phone');
        $PVC = $this->input->post('code');

        $user = $this->User_model->check_credentials($phone, $PVC, 'phone');
        if($user){
            echo json_encode(array('status' => 'Verification successful', 'user' => $user));
        }
    }

    public function login_by_phone()
    {
        $phone = $this->input->post('phone');
    
        $this->User_model->update_login_verification_code($phone);
        
        echo json_encode(array('status' => 'Code sent'));

    }
    
    public function logout(){
        $this->session->unset_userdata('user_id');
        echo json_encode(array('status' => 'Logout successful'));
    }

    //  Проверка кода верификации:
    //      URL: /users/verify_phone_code
    //      Метод: POST
    //      Параметры: phone, code
    
    public function verify_phone_code()
    {
        $phone = $this->input->post('phone');
        $code = $this->input->post('code');
    
        $user = $this->User_model->verify_phone($phone, $code);
    
        if ($user) {
            echo json_encode(array('status' => 'Phone verified successfully'));
        } else {
            echo json_encode(array('status' => 'Invalid verification code'));
        }
    }
    
    public function update($id)
    {
        $data = array(  
            'email' => $this->input->post('email'),
            'emailVerificationCode' => $this->input->post('emailVerificationCode'),
            'phoneVerificationCode' => $this->input->post('phoneVerificationCode'),
            'loginVerificationCode' => $this->input->post('loginVerificationCode'),
            'address_id' => $this->input->post('address_id'),
            'sex' => $this->input->post('sex'),
            'firstName' => $this->input->post('firstName'),
            'lastName' => $this->input->post('lastName'),
            'birthday' => $this->input->post('birthday')
        );

        $this->User_model->update_user($id, $data);
        echo json_encode(array('status' => 'User updated successfully'));
    }

    public function delete($id)
    {
        $this->User_model->delete_user($id);
        echo json_encode(array('status' => 'User deleted successfully'));
    }
}

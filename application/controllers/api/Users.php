<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper('url');
        $this->load->library('input');
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
            'phoneVerificationCode' => $this->input->post('phoneVerificationCode'),
            'loginVerificationCode' => $this->input->post('loginVerificationCode'),
            //'address_id' => $this->input->post('address_id'),
            //'sex' => $this->input->post('sex'),
            'firstName' => $this->input->post('firstName'),
            'lastName' => $this->input->post('lastName'),
            'birthday' => $this->input->post('birthday'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT)
        );
    
        $this->User_model->create_user($data);
        echo json_encode(array('status' => 'User registered successfully'));
    }

    public function login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
    
        $user = $this->User_model->check_credentials($email, $password, 'email');
    
        if ($user) {
            echo json_encode(array('status' => 'Login successful', 'user' => $user));
        } else {
            echo json_encode(array('status' => 'Invalid email or password'));
        }
    }


    public function login_by_phone()
    {
        $phone = $this->input->post('phone');
        $password = $this->input->post('password');
    
        $user = $this->User_model->check_credentials($phone, $password, 'phone');
    
        if ($user) {
            echo json_encode(array('status' => 'Login successful', 'user' => $user));
        } else {
            echo json_encode(array('status' => 'Invalid phone or password'));
        }
    }
    
    //  Отправка кода верификации:
    //    URL: /users/send_verification_code
    //    Метод: POST
    //    Параметры: phone

    public function send_verification_code()
    {
        $phone = $this->input->post('phone');
        $code = rand(10000, 99999); // Генерация случайного кода из 5 цифр
    
        // Обновление кода верификации в базе данных
        if ($this->User_model->update_phone_verification_code($phone, $code)) {
            // Отправка кода верификации (в режиме отладки просто возвращаем код)
            echo json_encode(array('status' => 'Verification code sent', 'code' => $code));
        } else {
            echo json_encode(array('status' => 'Failed to send verification code'));
        }
    }
    
    //  Проверка кода верификации:
    //      URL: /users/verify_phone_code
    //      Метод: POST
    //      Параметры: phone, code
    
    public function verify_phone_code()
    {
        $phone = $this->input->post('phone');
        $code = $this->input->post('code');
    
        $user = $this->User_model->verify_phone_code($phone, $code);
    
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

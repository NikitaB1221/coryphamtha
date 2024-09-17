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
            'address_id' => $this->input->post('address_id'),
            'sex' => $this->input->post('sex'),
            'firstName' => $this->input->post('firstName'),
            'lastName' => $this->input->post('lastName'),
            'birthday' => $this->input->post('birthday')
        );

        $this->User_model->create_user($data);
        echo json_encode(array('status' => 'User registered successfully'));
    }

    public function login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        // Реализуйте логику авторизации по email и паролю
    }

    public function login_by_phone()
    {
        $phone = $this->input->post('phone');
        $password = $this->input->post('password');
        // Реализуйте логику авторизации по телефону и паролю
    }

    public function verify_phone()
    {
        $phone = $this->input->post('phone');
        $code = $this->input->post('code');
        // Реализуйте логику верификации номера телефона
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
?>


    /*
    public function hello_user()
    {
        header("Content-Type: application/json; charset=utf-8", true);
        $array = ["1" => "2"];
        echo json_encode($array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS);
    }

    public function getUser($requestedId)
    {
        session_start();
        $userId = 0;
        if (isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId']; // table users field id
        }
        if ($userId !== $requestedId) { // access only to your own data
            // http 403 Forbidden
            header('HTTP/1.0 403 Forbidden');
            exit;
        }

        if (empty($user_data)) { // if such user does not exist
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                "type" => "error",
                "message" => "Такий аккаунт не існує",
                "input" => [
                    "id" => [
                        "valid" => false,
                        "message" => "Такий аккаунт не існує",
                    ],
                ],
            ]);
            exit;
        }

        // if such a user DOES exist and access IS accepted
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            "type" => "success",
            "data" => $user_data,
        ]);
    }
    public function updateUser($requestedId)
    {
        session_start();
        $userId = 0;
        if (isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId']; 
        }
        if ($userId !== $requestedId) { 

            header('HTTP/1.0 403 Forbidden');
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!empty($validation_errors)) { 
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                "type" => "error",
                "message" => "Тут Щось не так",
                "input" => $validation_errors,
            ]);
            exit;
        }

        if ($update_result = null) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                "type" => "success",
            ]);
        } else { 
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                "type" => "error",
                "message" => "Не удалось обновить данные",
            ]);
        }
    }
    public function createUser()
{
    header("Content-Type: application/json; charset=utf-8", true);

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['phone']) || empty($data['phone'])) {
        echo json_encode([
            "type" => "error",
            "message" => "Заповніть всі обов'язкові поля",
            "input" => [
                "phone" => [
                    "valid" => false,
                ],
            ],
        ]);
        exit;
    }

    // Проверка наличия пользователя с таким телефоном
    $user = null; \\ здесь ваш код для поиска пользователя по телефону 
    if ($user && $user->phoneVerified) {
        echo json_encode([
            "type" => "error",
            "message" => "Аккаунт з таким телефоном вже існує",
            "input" => [
                "phone" => [
                    "valid" => false,
                    "message" => "Аккаунт з таким телефоном вже існує",
                ],
            ],
        ]);
        exit;
    }

    // Создание или обновление пользователя
    $phoneVerificationCode = 12345; \\ здесь ваш код для генерации кода верификации 
    \\ здесь ваш код для создания или обновления пользователя с новым кодом верификации 

    // Отправка ответа
    echo json_encode([
        "type" => "success",
        "data" => [
            "phone" => $data['phone'],
        ],
        "_debug" => [
            "phoneVerificationCode" => $phoneVerificationCode,
        ],
    ]);
    }
    public function loginUser()
{
    header("Content-Type: application/json; charset=utf-8", true);

    // Получение данных из запроса
    $data = json_decode(file_get_contents('php://input'), true);

    // Проверка наличия телефона
    if (!isset($data['phone']) || empty($data['phone'])) {
        echo json_encode([
            "type" => "error",
            "message" => "Заповніть всі обов'язкові поля",
            "input" => [
                "phone" => [
                    "valid" => false,
                ],
            ],
        ]);
        exit;
    }

    // Проверка наличия пользователя с таким телефоном
    $user = null; \\ здесь ваш код для поиска пользователя по телефону 
    if (!$user || !$user->phoneVerified) {
        echo json_encode([
            "type" => "error",
            "message" => "Аккаунт з таким телефоном не існує",
            "input" => [
                "phone" => [
                    "valid" => false,
                    "message" => "Аккаунт з таким телефоном не існує",
                ],
            ],
        ]);
        exit;
    }

    // Создание кода верификации для входа
    $loginVerificationCode = 12345; здесь ваш код для генерации кода верификации 
    \\ здесь ваш код для обновления пользователя с новым кодом верификации для входа 

    // Отправка ответа
    echo json_encode([
        "type" => "success",
        "data" => [
            "phone" => $data['phone'],
        ],
        "_debug" => [
            "loginVerificationCode" => $loginVerificationCode,
        ],
    ]);
    }
    public function verify_phone_code()
{
    header("Content-Type: application/json; charset=utf-8", true);

    // Получение данных из запроса
    $data = json_decode(file_get_contents('php://input'), true);

    // Проверка наличия телефона и кода верификации
    if (!isset($data['phone']) || empty($data['phone']) || !isset($data['phoneVerificationCode']) || empty($data['phoneVerificationCode'])) {
        echo json_encode([
            "type" => "error",
            "message" => "Заповніть всі обов'язкові поля",
            "input" => [
                "phone" => [
                    "valid" => false,
                ],
                "phoneVerificationCode" => [
                    "valid" => false,
                ],
            ],
        ]);
        exit;
    }

    // Проверка длины кода верификации
    if (strlen($data['phoneVerificationCode']) < 5) {
        echo json_encode([
            "type" => "error",
            "message" => "Код має складатися з п'яти символів",
            "input" => [
                "phone" => [
                    "valid" => true,
                ],
                "phoneVerificationCode" => [
                    "valid" => false,
                    "message" => "Код має складатися з п'яти символів",
                ],
            ],
        ]);
        exit;
    }

    // Проверка наличия пользователя с таким телефоном и правильности кода
    $user = null; \\ здесь ваш код для поиска пользователя по телефону 
    if (!$user || $user->phoneVerificationCode !== $data['phoneVerificationCode']) {
        echo json_encode([
            "type" => "error",
            "message" => "Неправильний код або аккаунта за цим номером телефону не існує",
            "input" => [
                "phone" => [
                    "valid" => false,
                    "message" => "Перевірте номер телефону",
                ],
                "phoneVerificationCode" => [
                    "valid" => false,
                    "message" => "Перевірте код",
                ],
            ],
        ]);
        exit;
    }

    // Обновление статуса верификации пользователя
    \\ здесь ваш код для обновления статуса верификации пользователя 

    // Отправка успешного ответа
    echo json_encode([
        "type" => "success",
        "data" => [
            "id" => $user->id,
        ],
    ]);
    }
    */

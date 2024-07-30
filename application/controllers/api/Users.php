<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function index()
    {
        echo "Hello there!";
    }

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
            $userId = $_SESSION['userId']; // таблица users поле id
        }
        if ($userId !== $requestedId) { // доступ только к своим данным
            // http 403 Forbidden
            header('HTTP/1.0 403 Forbidden');
            exit;
        }

        // Получение данных из запроса
        $data = json_decode(file_get_contents('php://input'), true);

        // Здесь вы можете добавить код для валидации данных
        // Предположим, что $validation_errors - это массив ошибок валидации

        if (!empty($validation_errors)) { // если есть ошибки валидации
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                "type" => "error",
                "message" => "Тут Щось не так",
                "input" => $validation_errors,
            ]);
            exit;
        }

        // Здесь вы можете добавить код для обновления данных пользователя в базе данных
        // Предположим, что $update_result - это результат обновления данных в базе данных

        if ($update_result = null) { // если данные успешно обновлены
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                "type" => "success",
            ]);
        } else { // если произошла ошибка при обновлении данных
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
    $user = null/* здесь ваш код для поиска пользователя по телефону */;
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
    $phoneVerificationCode = 12345/* здесь ваш код для генерации кода верификации */;
    /* здесь ваш код для создания или обновления пользователя с новым кодом верификации */

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
    $user = null/* здесь ваш код для поиска пользователя по телефону */;
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
    $loginVerificationCode = 12345/* здесь ваш код для генерации кода верификации */;
    /* здесь ваш код для обновления пользователя с новым кодом верификации для входа */

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
    $user = null/* здесь ваш код для поиска пользователя по телефону */;
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
    /* здесь ваш код для обновления статуса верификации пользователя */

    // Отправка успешного ответа
    echo json_encode([
        "type" => "success",
        "data" => [
            "id" => $user->id,
        ],
    ]);
    }

}
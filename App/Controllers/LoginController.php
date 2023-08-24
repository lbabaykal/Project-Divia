<?php

namespace App\Controllers;

use App\Cdb;
use App\Controller;
use App\Session;
use App\View;
use App\Models\LoginModel;

class LoginController extends Controller
{
    public static function login()
    {
        if ( UserController::getStatus() ) {
            $UserData = LoginModel::getUserData();
            $viewLogin = new View();
            return $viewLogin->render_v3( TEMPLATES_DIR . '/Login', $UserData, ['ADMIN_PANEL' => $UserData['access_AP'], 'AUTHORIZED' => '1', 'NOT_AUTHORIZED' => '0']);
        }
        else {
            $viewLogin = new View();
            return $viewLogin->render_v3( TEMPLATES_DIR . '/Login', [], ['AUTHORIZED' => '0', 'NOT_AUTHORIZED' => '1']);
        }
    }






    public function actionLogout() {
        $Session = new Session();
        $Session->destroySession();
        header('Location: /');
    }

    public function actionTemplate_Recovery_Password() {
        if (isset($_SESSION['UserData'])) {
            header('Location: /');
        }
        $viewAuthorization = new View();
        return $viewAuthorization->display(ADMIN_TEMPLATES_DIR . 'Recovery_Password');
    }

    public function actionRecovery_Password() {

        $answer['success'] = $success = 'No';

        if ( !empty($_POST) ) {
            extract($_POST, EXTR_SKIP);

            if ( isset($email) ) {

                $email = filter_var( $email,  FILTER_SANITIZE_EMAIL);

                if ( !filter_var($email, FILTER_VALIDATE_EMAIL ) ) {
                    $textData = 'Введите корректный Email';
                }
                elseif ( !LoginModel::checkEmailForExist($email) ) {
                    $textData = 'Такой Email зарегистрирован';
                }
                else {
                    $password = bin2hex(random_bytes(5));
                    $passwordHash = password_hash($password, PASSWORD_BCRYPT );

                    $Cdb = Cdb::getInstance();
                    $data = [
                        'password' => $passwordHash,
                        'email' => $email
                    ];
                    $sql = "UPDATE users 
                            SET password=:password
                            WHERE email=:email";
                    $Cdb->execute($sql, $data);

                    $to      = $email;
                    $subject = "=?UTF-8?B?".base64_encode('Восстановление пароля на сайте LIBRARY HARMONY.')."?=";
                    $message = 'Ваш новый пароль: ' . $password;
                    $headers = 'From: harmony@libharmony.com';
                    mail($to, $subject, $message, $headers);

                    $success = 'Yes';
                    $textData = 'Новый пароль отправлен на Email';
                }
            }
            else {
                $textData = 'Проблемы с отправленными данными';
            }
        }
        else {
            $textData = 'Проблемы работы AJAX';
        }
        $answer = [ "success" => $success, "text" => $textData ];

        return json_encode($answer);
    }

    public function actionTemplateAuthorization(): string
    {
        if (isset($_SESSION['sessionUserData'])) {
            header('Location: /');
        }
        $viewAuthorization = new View();
        return $viewAuthorization->display(ADMIN_TEMPLATES_DIR . 'Authorization');

    }

    public function actionAuthorization(): string
    {
        $answer['success'] = $success = 'No';
        if ( !empty($_POST) ) {
            extract($_POST, EXTR_SKIP);

            if ( isset($email, $password) ) {

                $email = filter_var( $email,  FILTER_SANITIZE_EMAIL);
                if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
                    $textData = 'Введите корректный Email';
                }
                elseif ( mb_strlen($password) < 1 ) {
                    $textData = 'Введите Пароль';
                }
                elseif ( !LoginModel::checkEmailForExist($email)  ) {
                    $textData = 'Неверный email или пароль';
                }
                else {
                    $Cdb = Cdb::getInstance();
                    $sql = "SELECT * FROM users WHERE email='{$email}'";
                    $UserData = $Cdb->queryFetch($sql);

                    if ( !password_verify($password, $UserData['password']) ) {
                        $textData = 'Неверный email или пароль';
                    }
                    else {
                        $userData = [
                            'id_user' => $UserData['id_user'],
                            'nickname' => $UserData['nickname'],
                            'email' => $UserData['email'],
                            'user_group' => $UserData['user_group'],
                            'avatar' => $UserData['avatar']
                        ];
                        (new Session)->setSession('UserData', $userData);
                        $success = 'Yes';
                        $textData = 'Авторизация прошла успешно!';
                    }
                }
            }
            else {
                $textData = 'Проблемы с отправленными данными';
            }
        }
        else {
            $textData = 'Проблемы работы AJAX';
        }
        $answer = [ "success" => $success, "text" => $textData ];

        return json_encode($answer);
    }

    public function actionTemplateRegistration(): string
    {
        if (isset($_SESSION['sessionUserData'])) {
            header('Location: /');
        }
        $viewRegistration = new View();
        return $viewRegistration->display(ADMIN_TEMPLATES_DIR . 'Registration');
    }


    public function actionRegistration(): string
    {
        $answer['success'] = $success = 'No';

        if ( !empty($_POST) ) {
            extract($_POST, EXTR_SKIP);


            if ( isset($nickname, $email, $password, $password_repeat) ) {

                $nickname = $this->sanitizeString($nickname);
                $email = filter_var( $email,  FILTER_SANITIZE_EMAIL);

                if ( preg_match('/[^а-яА-ЯёЁa-zA-Z]/u', $nickname) OR mb_strlen($nickname) < 1 ) {
                    $textData = 'Введите корректный Никнейм';
                }
                elseif ( mb_strlen($nickname) > 20 ) {
                    $textData = 'Никнейм слишком длинный';
                }
                elseif ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
                    $textData = 'Введите корректный Email';
                }
                elseif ( LoginModel::checkEmailForExist($email) ) {
                    $textData = 'Email уже зарегистрирован';
                }
                elseif ( mb_strlen($password) < 8 )  {
                    $textData = 'Пароль слишком короткий';
                }
                elseif ( mb_strlen($password) > 100 )  {
                    $textData = 'Пароль слишком длинный';
                }
                elseif ( $password != $password_repeat )   {
                    $textData = 'Введенные пароли не совпадают';
                }
                else {
                    $passwordHash = password_hash($password, PASSWORD_BCRYPT );
                    $dateNow = date('Y-m-d');

                    $data = [
                        'nickname' => $nickname,
                        'email' => $email,
                        'password' => $passwordHash,
                        'subscription' => 'default',
                        'user_group' => '3',
                        'reg_date' => $dateNow,
                        'avatar' => 'default.jpg'
                    ];
                    $db = Cdb::getInstance();
                    $db->insert('users', $data);

                    $success = 'Yes';
                    $textData = 'Регистрация прошла успешно!';
                }
            }
            else {
                $textData = 'Проблемы с отправленными данными';
            }
        }
        else {
            $textData = 'Проблемы работы AJAX';
        }
        $answer = [ "success" => $success, "text" => $textData ];

        return json_encode($answer);
    }
}
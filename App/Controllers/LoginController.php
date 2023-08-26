<?php

namespace App\Controllers;

use App\App;
use App\Controller;
use App\Session;
use App\View;
use App\Models\LoginModel;

class LoginController extends Controller
{
    public static function login(): false|string
    {
        if ( UserController::getStatus() ) {
            $UserData = UserController::getData();
            $UserData['password'] = '';
            $UserData['phone'] = '';
            return (new View)->render_v3( TEMPLATES_DIR . '/Login', $UserData, ['ADMIN_PANEL' => $UserData['access_admin'], 'AUTHORIZED' => '1', 'NOT_AUTHORIZED' => '0']);
        }
        else {
            return (new View)->render_v3( TEMPLATES_DIR . '/Login', [], ['AUTHORIZED' => '0', 'NOT_AUTHORIZED' => '1']);
        }
    }

    public function actionLogout(): void
    {
        Session::destroySession();
        header('Location: /');
    }

    //================TEMPLATES================
    public function actionTemplateAuthorization(): string
    {
        if (UserController::getStatus()) {
            header('Location: /');
        }
        return (new View)->display(ADMIN_TEMPLATES_DIR . '/Authorization');
    }

    public function actionTemplateRegistration(): string
    {
        if (UserController::getStatus()) {
            header('Location: /');
        }
        return (new View)->display(ADMIN_TEMPLATES_DIR . '/Registration');
    }

    public function actionTemplateRecoveryPassword(): string
    {
        if (UserController::getStatus()) {
            header('Location: /');
        }
        return (new View)->display(ADMIN_TEMPLATES_DIR . '/Recovery_Password');
    }

    //================ACTIONS================
    public function actionAuthorization(): string
    {
        $answer = [ 'success' => 'No'];
        if ( !empty($_POST) ) {
            extract($_POST, EXTR_SKIP);

            if ( isset($email, $password) ) {

                $email = filter_var( $email,  FILTER_SANITIZE_EMAIL);
                if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
                    $answer['text'] = 'Введите корректный Email.';
                    return  json_encode($answer);
                }
                $UserData = LoginModel::getUserDataEmail($email);
                if ( !$UserData ) {
                    $answer['text'] = 'Неверный email или пароль.';
                } elseif (!password_verify($password, $UserData['password'])) {
                    $answer['text'] = 'Неверный email или пароль.';
                } else {
                    $userData = [
                        'id_user' => $UserData['id_user'],
                        'nickname' => $UserData['nickname'],
                        'email' => $UserData['email'],
                        'user_group' => $UserData['user_group'],
                        'avatar' => $UserData['avatar']
                    ];
                    (new Session)->setSession('UserData', $userData);
                    $answer['success'] = 'Yes';
                    $answer['text'] = 'Авторизация прошла успешно!';
                }
            }
            else {
                $answer['text'] = 'Проблемы с отправленными данными.';
            }
        }
        else {
            $answer['text'] = 'Проблемы работы AJAX.';
        }
        return json_encode($answer);
    }

    public function actionRecovery_Password(): string
    {
        $answer = ['success' => 'No'];

        if ( !empty($_POST) ) {
            extract($_POST, EXTR_SKIP);

            if ( isset($email) ) {

                $email = filter_var( $email,  FILTER_SANITIZE_EMAIL);

                if ( !filter_var($email, FILTER_VALIDATE_EMAIL ) ) {
                    $answer['text'] = 'Введите корректный Email.';
                }
                elseif ( !LoginModel::checkEmailForExist($email) ) {
                    $answer['text'] = 'Такой Email не зарегистрирован!';
                }
                else {
                    $password = bin2hex(random_bytes(5));
                    $passwordHash = password_hash($password, PASSWORD_BCRYPT );
                    LoginModel::updatePasswordUser($email,$passwordHash);

                    $to      = $email;
                    $subject = "=?UTF-8?B?".base64_encode('Восстановление пароля на сайте ' . App::getConfigSite('site_name') . '.')."?=";
                    $message = 'Ваш новый пароль: ' . $password;
                    $headers = 'From: ' . App::getConfigSite('email_support');
                    //НАСТРОИТЬ ОТПРАВКУ ПИСЕМ
                    //mail($to, $subject, $message, $headers);

                    $answer['success'] = 'Yes';
                    $answer['text'] = 'Новый пароль отправлен на Email.';
                }
            }
            else {
                $answer['text'] = 'Проблемы с отправленными данными.';
            }
        }
        else {
            $answer['text'] = 'Проблемы работы AJAX.';
        }
        return json_encode($answer);
    }

    public function actionRegistration(): string
    {
        $answer = ['success' => 'No'];

        if ( !empty($_POST) ) {
            extract($_POST, EXTR_SKIP);

            if ( isset($nickname, $email, $password, $password_repeat) ) {

                $nickname = $this->sanitizeString($nickname);
                $email = filter_var( $email,  FILTER_SANITIZE_EMAIL);

                if ( preg_match('/[^a-zA-Z0-9_\-|]/u', $nickname) OR mb_strlen($nickname) < 1 ) {
                    $answer['text'] = 'Введите корректный Никнейм.';
                }
                elseif ( mb_strlen($nickname) > 20 ) {
                    $answer['text'] = 'Никнейм слишком длинный';
                }
                elseif ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
                    $answer['text'] = 'Введите корректный Email.';
                }
                elseif ( LoginModel::checkEmailForExist($email) ) {
                    $answer['text'] = 'Email уже зарегистрирован.';
                }
                elseif ( mb_strlen($password) < 8 )  {
                    $answer['text'] = 'Пароль слишком короткий.';
                }
                elseif ( mb_strlen($password) > 64 )  {
                    $answer['text'] = 'Пароль слишком длинный.';
                }
                elseif ( $password != $password_repeat )   {
                    $answer['text'] = 'Введенные пароли не совпадают.';
                }
                else {
                    $passwordHash = password_hash($password, PASSWORD_BCRYPT );
                    $dateNow = date('Y-m-d');
                    $data = [
                        'nickname' => $nickname,
                        'email' => $email,
                        'password' => $passwordHash,
                        'subscription' => 'default',
                        'user_group' => '4',
                        'reg_date' => $dateNow
                    ];
                    LoginModel::registrationUser($data);
                    $answer['success'] = 'Yes';
                    $answer['text'] = 'Регистрация прошла успешно!';
                }
            }
            else {
                $answer['text'] = 'Проблемы с отправленными данными.';
            }
        }
        else {
            $answer['text'] = 'Проблемы работы AJAX.';
        }
        return json_encode($answer);
    }
}
<?php

namespace App\Controllers;

use App\Cdb;
use App\Controller;
use App\Session;
use App\View;
use App\Models\Login as Model_Login;
#[\AllowDynamicProperties]
class Login extends Controller
{
    public static function login()
    {
        if ( isset($_SESSION['sessionUserData']) ) {
            $Cdb = new Cdb();
            $sql = "SELECT id_user,nickname,email,user_group,avatar
                    FROM users 
                    WHERE id_user=" . $_SESSION['sessionUserData']['id_user'];
            $dataUser = $Cdb->query($sql, static::class);

            $viewLogin = new View();
            $templateLogin = $viewLogin->render( TEMPLATES_DIR . 'Login.php', $dataUser);

            if ( $dataUser[0]->user_group == '1' OR $dataUser[0]->user_group == '2' ) {
                $templateAdmin_link = '<a class="profile-menu-button" href="/Admin_Panel">
                                        <img src="/Templates/AnoTheR/images/admin.png" alt="">
                                        <span>Admin_Panel</span>
                                    </a>';
                $Answer  = str_replace( '{ADMIN_PANEL}', $templateAdmin_link, $templateLogin );
                            }
            else {
                $Answer  = str_replace( '{ADMIN_PANEL}', '', $templateLogin );
            }
            return $Answer;
        }
        else {
            $viewLogin = new View();
            return $viewLogin->display(TEMPLATES_DIR . 'Login_off.php');
        }
    }

    public function actionLogout() {
        $Session = new Session();
        $Session->destroySession();
        header('Location: /');
    }

    public function actionTemplate_Recovery_Password() {
        if (isset($_SESSION['sessionUserData'])) {
            header('Location: /');
        }
        $viewAuthorization = new View();
        return $viewAuthorization->display(ADMIN_TEMPLATES_DIR . 'Recovery_Password.php');
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
                elseif ( !Model_Login::checkEmail($email) ) {
                    $textData = 'Такой Email не зарегистрирован';
                }
                else {
                    $password = bin2hex(random_bytes(5));
                    $passwordHash = password_hash($password, PASSWORD_BCRYPT );

                    $Cdb = new Cdb();
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
        return $viewAuthorization->display(ADMIN_TEMPLATES_DIR . 'Authorization.php');

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
                elseif ( !Model_Login::checkEmail($email)  ) {
                    $textData = 'Неверный email или пароль';
                }
                else {
                    $Cdb = new Cdb();
                    $sql = "SELECT * FROM users WHERE email='$email'";
                    $UserData = $Cdb->query($sql, static::class);
                    if ( !password_verify($password, $UserData[0]->password) ) {
                        $textData = 'Неверный email или пароль';
                    }
                    else {
                        $userData = [
                            'id_user' => $UserData[0]->id_user,
                            'nickname' => $UserData[0]->nickname,
                            'email' => $UserData[0]->email,
                            'user_group' => $UserData[0]->user_group,
                            'avatar' => $UserData[0]->avatar
                        ];
                        $Session = new Session();
                        $Session->setSession('sessionUserData', $userData);
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
        return $viewRegistration->display(ADMIN_TEMPLATES_DIR . 'Registration.php');
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
                elseif ( Model_Login::checkEmail($email) ) {
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
                    $db = new Cdb;
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
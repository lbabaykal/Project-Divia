<?php

namespace App\Controllers;

use App\Cdb;
use App\Controller;
use App\Models\UserModel;
use App\View;

class UserController extends Controller
{
    public function actionTemplate_User_Add(): string
    {
        $this->CheckAccess();
        $viewUser_Add = new View();
        return $viewUser_Add->display(ADMIN_TEMPLATES_DIR . '/AJAX/User_Add.php');
    }

    public function actionUser_Add(): string
    {
        $this->CheckAccess();

        $answer['success'] = $success = 'No';

        if ( !empty($_POST) ) {
            extract($_POST, EXTR_SKIP);

            if ( isset($nickname, $birthday, $phone, $email, $password, $password_repeat) ) {

                $nickname = $this->sanitizeString($nickname);
                $birthday = date_parse($this->sanitizeString($birthday));
                $phone = preg_replace('/[+-]/u', '', filter_var($phone,  FILTER_SANITIZE_NUMBER_INT));
                $email = filter_var( $email,  FILTER_SANITIZE_EMAIL);

                if ( preg_match('/[^а-яА-ЯёЁa-zA-Z]/u', $nickname) OR mb_strlen($nickname) < 1 ) {
                    $textData = 'Введите корректный Никнейм';
                }
                elseif ( mb_strlen($nickname) > 20 ) {
                    $textData = 'Никнейм слишком длинный';
                }
                elseif ( !checkdate($birthday['month'], $birthday['day'], $birthday['year']) OR
                    ($birthday['year'] < 1950) OR
                    ($birthday['year'] > date('Y')) ) {
                    $textData = 'Введите корректную Дату Рождения';
                }
                elseif ( mb_strlen($phone) != 11 ) {
                    $textData = 'Введите корректный Номер телефона';
                }
                elseif ( UserModel::checkPhone($phone) ) {
                    $textData = 'Номер телефона уже зарегистрирован';
                }
                elseif ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
                    $textData = 'Введите корректный Email';
                }
                elseif ( UserModel::checkEmail($email) ) {
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
                    $birthdayReady = $birthday['year'] . '-' . $birthday['month'] . '-' . $birthday['day'];
                    $dateNow = date('Y-m-d');
                    $data = [
                        'nickname' => $nickname,
                        'birthday' => $birthdayReady,
                        'phone' => $phone,
                        'email' => $email,
                        'password' => $passwordHash,
                        'subscription' => 'Default',
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

    public function actionTemplate_User_Edit(): string
    {
        $id_user = filter_var($_POST['id_user'], FILTER_SANITIZE_NUMBER_INT);
        if ( !is_numeric($id_user) ) {
            header('Location: /');
        }
        $viewUser_Edit = new View();
        $dataUser_Edit = UserModel::showOneUser($id_user);
        $Answer = $viewUser_Edit->render(ADMIN_TEMPLATES_DIR . '/AJAX/User_Edit.php', $dataUser_Edit);

        if ( $dataUser_Edit[0]->user_group != '1') {
            $select = '';
            $AllUser_Group = UserModel::showAllUser_Group();
            foreach ($AllUser_Group as $key => $value) {
                if ( $value->id_group == '1' ) continue;
                $select  .= '<option value="' . $value->id_group . '" ';
                if ( $value->id_group == $dataUser_Edit[0]->user_group ) {
                    $select .= 'selected';
                }
                $select  .= ' >' . $value->group_name . '</option>';
            }
            $Answer = str_replace( '{SELECT}', $select, $Answer );
        }

        return $Answer;
    }

    public function actionUser_Edit(): string
    {
        $this->CheckAccess();

        $answer['success'] = $success = 'No';

        if ( !empty($_POST) ) {
            extract($_POST, EXTR_SKIP);

            if ( isset($nickname, $birthday, $phone, $email, $user_group, $id_user) )
            {
                $id_user = preg_replace('/[+-]/u', '', filter_var($id_user,  FILTER_SANITIZE_NUMBER_INT));
                $nickname = $this->sanitizeString($nickname);
                $user_group = preg_replace('/[+-]/u', '', filter_var($user_group,  FILTER_SANITIZE_NUMBER_INT));
                $birthday = date_parse($this->sanitizeString($birthday));
                $phone = preg_replace('/[+-]/u', '', filter_var($phone,  FILTER_SANITIZE_NUMBER_INT));
                $email = filter_var( $email,  FILTER_SANITIZE_EMAIL);

                if ( preg_match('/[^а-яА-ЯёЁa-zA-Z]/u', $name) OR mb_strlen($name) < 1 ) {
                    $textData = 'Введите корректный Никнейм';
                }
                elseif ( mb_strlen($name) > 20 ) {
                    $textData = 'Никнейм слишком длинный';
                }
                elseif ( !checkdate($birthday['month'], $birthday['day'], $birthday['year']) OR
                    ($birthday['year'] < 1950) OR
                    ($birthday['year'] > date('Y')) ) {
                    $textData = 'Введите корректную Дату Рождения';
                }
                elseif ( mb_strlen($phone) != 11 ) {
                    $textData = 'Введите корректный Номер телефона';
                }
                elseif ( UserModel::checkPhone_Update($id_user, $phone) ) {
                    $textData = 'Номер телефона уже зарегистрирован';
                }
                elseif ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
                    $textData = 'Введите корректный Email';
                }
                elseif ( UserModel::checkEmail_Update($id_user, $email) ) {
                    $textData = 'Email уже зарегистрирован';
                }
                elseif ( !UserModel::checkUser_Group($user_group) ) {
                    $textData = 'Такой Группы пользователей не существует!';
                }
                else {
                    $birthdayReady = $birthday['year'] . '-' . $birthday['month'] . '-' . $birthday['day'];
                    $data = [
                        'id_user' => $id_user,
                        'nickname' => $nickname,
                        'birthday' => $birthdayReady,
                        'phone' => $phone,
                        'email' => $email,
                        'user_group' => $user_group
                    ];
                    $db = new Cdb;
                    $sql = "UPDATE users
                            SET nickname=:nickname, birthday=:birthday, phone=:phone, email=:email, user_group=:user_group
                            WHERE id_user=:id_user";
                    $db->execute($sql, $data);

                    $success = 'Yes';
                    $textData = 'Информация о пользователи обновлена!';
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
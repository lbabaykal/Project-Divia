<?php

namespace App\Models;

use App\Cdb;
use App\Model;

class LoginModel extends Model
{
    public static function getUserData(): array|false
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT users.id_user, users.nickname, users.birthday, users.phone, users.email, 
                        users.subscription, users.user_group, users.reg_date, users.avatar, user_group.*
                FROM users
                INNER JOIN user_group 
                ON users.user_group = user_group.id_group 
                WHERE id_user=" . $_SESSION['sessionUserData']['id_user'];
        return $Cdb->queryFetch($sql);
    }

    public static function checkEmailForExist($email): array|false
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT email
                FROM users
                WHERE email='{$email}'";
        return $Cdb->queryFetch($sql);
    }

}
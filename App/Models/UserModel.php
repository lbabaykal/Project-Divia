<?php

namespace App\Models;

use App\Cdb;
use App\Model;

class UserModel extends Model
{

    public static function getUserDataDB(): array|false
    {
        $id_user = $_SESSION['UserData']['id_user'];
        $Cdb = Cdb::getInstance();
        $sql = "SELECT *
                FROM users
                INNER JOIN user_group
                ON users.user_group = user_group.id_group
                WHERE users.id_user = {$id_user}";
        return $Cdb->queryFetch($sql);
    }

    public static function getAllUsers(): false|array
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT *
                FROM users
                INNER JOIN user_group
                ON users.user_group = user_group.id_group
                WHERE 1
        ";
        return $Cdb->queryFetchAll($sql);
    }






    public static function showOneUser($id_user)
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT *, DATE_FORMAT(birthday, '%d.%m.%Y') birthday
                FROM users
                WHERE id_user='$id_user'
        ";
        return $Cdb->query($sql, static::class);
    }

    public static function checkPhone($phone) {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT phone FROM users WHERE phone='$phone'";
        return $Cdb->query($sql, static::class);
    }

    public static function checkEmail($email) {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT email FROM users WHERE email='$email'";
        return $Cdb->query($sql, static::class);
    }

    public static function checkPhone_Update($id_user, $phone) {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT phone FROM users WHERE phone='$phone'";
        $sql2 = "SELECT passport FROM users WHERE id_user='$id_user' AND phone='$phone'";
        $lol = $Cdb->query($sql, static::class);
        $lol2 = $Cdb->query($sql2, static::class);

        if ( $lol AND $lol2) {
            $answer = false;
        }
        elseif ( $lol AND !$lol2) {
            $answer = true;
        }
        else {
            $answer = false;
        }
        return $answer;
    }

    public static function checkEmail_Update($id_user, $email) {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT email FROM users WHERE email='$email'";
        $sql2 = "SELECT passport FROM users WHERE id_user='$id_user' AND email='$email'";
        $lol = $Cdb->query($sql, static::class);
        $lol2 = $Cdb->query($sql2, static::class);

        if ( $lol AND $lol2) {
            $answer = false;
        }
        elseif ( $lol AND !$lol2) {
            $answer = true;
        }
        else {
            $answer = false;
        }
        return $answer;
    }

    public static function showAllUser_Group(): array
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT * FROM user_group";
        return $Cdb->query($sql, static::class);
    }

    public static function checkUser_Group($user_group)
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT * FROM user_group WHERE id_group=".$user_group;
        return $Cdb->query($sql, static::class);
    }

}
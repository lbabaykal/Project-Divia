<?php

namespace App\Models;

use App\Cdb;
use App\Model;
#[\AllowDynamicProperties]
class Users extends Model
{

    public static function showAllUsers()
    {
        $Cdb = new Cdb();
        $sql = "SELECT *
                FROM users
                INNER JOIN user_group
                ON users.user_group = user_group.id_group
                WHERE 1
        ";
        return $Cdb->query($sql, static::class);
    }

    public static function showOneUser($id_user)
    {
        $Cdb = new Cdb();
        $sql = "SELECT *, DATE_FORMAT(birthday, '%d.%m.%Y') birthday
                FROM users
                WHERE id_user='$id_user'
        ";
        return $Cdb->query($sql, static::class);
    }

    public static function checkPhone($phone) {
        $Cdb = new Cdb();
        $sql = "SELECT phone FROM users WHERE phone='$phone'";
        return $Cdb->query($sql, static::class);
    }

    public static function checkEmail($email) {
        $Cdb = new Cdb();
        $sql = "SELECT email FROM users WHERE email='$email'";
        return $Cdb->query($sql, static::class);
    }

    public static function checkPhone_Update($id_user, $phone) {
        $Cdb = new Cdb();
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
        $Cdb = new Cdb();
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
        $Cdb = new Cdb();
        $sql = "SELECT * FROM user_group";
        return $Cdb->query($sql, static::class);
    }

    public static function checkUser_Group($user_group)
    {
        $Cdb = new Cdb();
        $sql = "SELECT * FROM user_group WHERE id_group=".$user_group;
        return $Cdb->query($sql, static::class);
    }

}
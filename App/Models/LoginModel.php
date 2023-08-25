<?php

namespace App\Models;

use App\Cdb;
use App\Model;

class LoginModel extends Model
{
    public static function getUserDataEmail(string $email): array|false
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT *
                FROM users
                INNER JOIN user_group 
                ON users.user_group = user_group.id_group 
                WHERE users.email = '{$email}'";
        return $Cdb->queryFetch($sql);
    }

    public static function checkEmailForExist(string $email): array|false
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT *
                FROM users
                WHERE email = '{$email}'";
        return $Cdb->queryFetch($sql);
    }

    public static function updatePasswordUser(string $email, string $newPasswordHash): void
    {
        $Cdb = Cdb::getInstance();
        $dataSet = [
            'password' => $newPasswordHash
        ];
        $dataWhere = [
            'email' => $email
        ];
        $Cdb->update('users', $dataSet, $dataWhere);
    }

    public static function registrationUser(array $data): void
    {
        $db = Cdb::getInstance();
        $db->insert('users', $data);
    }

}
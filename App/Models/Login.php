<?php

namespace App\Models;

use App\Cdb;
use App\Model;
#[\AllowDynamicProperties]
class Login extends Model
{
    public static function checkEmail($email): array
    {
        $Cdb = new Cdb();
        $sql = "SELECT email
                FROM users
                WHERE email='$email'
        ";
        return $Cdb->query($sql, static::class);
    }


}
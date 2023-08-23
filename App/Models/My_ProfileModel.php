<?php

namespace App\Models;

use App\Cdb;
use App\Model;
#[\AllowDynamicProperties]
class My_ProfileModel extends Model
{
    public static function showUser_Profile(): array
    {
        $id_user = $_SESSION['sessionUserData']['id_user'];
        $Cdb = new Cdb();
        $sql = "SELECT *, DATE_FORMAT(birthday, '%d.%m.%Y') birthday, DATE_FORMAT(reg_date, '%d.%m.%Y') reg_date
                FROM users
                INNER JOIN user_group 
                ON users.user_group = user_group.id_group 
                WHERE id_user = '$id_user'
        ";
        return $Cdb->query($sql, static::class);
    }

}
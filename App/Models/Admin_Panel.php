<?php

namespace App\Models;

use App\Cdb;
use App\Model;

#[\AllowDynamicProperties]
class Admin_Panel extends Model
{

    public static function countUser(): int
    {
        $Cdb = new Cdb();
        $sql = 'SELECT id_user FROM users';
        return count($Cdb->query($sql, static::class));
    }

    public static function countBooks(): int
    {
        $Cdb = new Cdb();
        $sql = 'SELECT id_article FROM articles';
        return count($Cdb->query($sql, static::class));
    }

    public static function countComments(): int
    {
        $Cdb = new Cdb();
        $sql = 'SELECT id_comments FROM comments';
        return count($Cdb->query($sql, static::class));
    }
}
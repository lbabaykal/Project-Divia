<?php

namespace App\Models;

use App\Cdb;
use App\Model;

class Admin_PanelModel extends Model
{

    public static function countUser(): int
    {
        $Cdb = new Cdb();
        $sql = 'SELECT id_user FROM users';
        return count($Cdb->query($sql));
    }

    public static function countBooks(): int
    {
        $Cdb = new Cdb();
        $sql = 'SELECT id_article FROM articles';
        return count($Cdb->query($sql));
    }

    public static function countComments(): int
    {
        $Cdb = new Cdb();
        $sql = 'SELECT id_comments FROM comments';
        return count($Cdb->query($sql));
    }
}
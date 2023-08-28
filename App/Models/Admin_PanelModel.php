<?php

namespace App\Models;

use App\Cdb;
use App\Model;

class Admin_PanelModel extends Model
{

    public static function countUser(): int
    {
        $Cdb = Cdb::getInstance();
        $sql = 'SELECT id_user FROM users';
        return count($Cdb->queryFetchAll($sql));
    }

    public static function countArticles(): int
    {
        $Cdb = Cdb::getInstance();
        $sql = 'SELECT id_article FROM articles';
        return count($Cdb->queryFetchAll($sql));
    }

    public static function countComments(): int
    {
        $Cdb = Cdb::getInstance();
        $sql = 'SELECT id_comments FROM comments';
        return count($Cdb->queryFetchAll($sql));
    }
}
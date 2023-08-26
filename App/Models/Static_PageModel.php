<?php

namespace App\Models;

use App\Cdb;
use App\Model;

class Static_PageModel extends Model
{
    public static function getStaticPage($name_page): false|array
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT *
                FROM static_page
                WHERE name_eng='$name_page'
        ";
        return $Cdb->queryFetch($sql);
    }





    public static function showOneStaticPage($id_SP)
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT *
                FROM static_page
                WHERE id_static_page='$id_SP'
        ";
        return $Cdb->queryFetch($sql);
    }


    public static function showAllStaticPages()
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT id_static_page, name, name_eng
                FROM static_page
                WHERE 1
        ";
        return $Cdb->queryFetchAll($sql);
    }

}
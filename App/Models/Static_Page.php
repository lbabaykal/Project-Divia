<?php

namespace App\Models;

use App\Cdb;
use App\Model;
#[\AllowDynamicProperties]
class Static_Page extends Model
{

    public static function showAllStaticPages()
    {
        $Cdb = new Cdb();
        $sql = "SELECT id_static_page, name, name_eng
                FROM static_page
                WHERE 1
        ";
        return $Cdb->query($sql, static::class);
    }

    public static function showOneStaticPageNAME($name_page)
    {
        $Cdb = new Cdb();
        $sql = "SELECT *
                FROM static_page
                WHERE name_eng='$name_page'
        ";
        return $Cdb->query($sql, static::class);
    }

    public static function showOneStaticPage($id_SP)
    {
        $Cdb = new Cdb();
        $sql = "SELECT *
                FROM static_page
                WHERE id_static_page='$id_SP'
        ";
        return $Cdb->query($sql, static::class);
    }

}
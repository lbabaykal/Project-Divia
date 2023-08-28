<?php

namespace App\Models;

use App\Cdb;
use App\Model;

class Static_PageModel extends Model
{
    public const TABLE = 'static_page';

    public static function getStaticPage($name_page): false|array
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT *
                FROM " . self::TABLE . "
                WHERE name_eng={$name_page}";
        return $Cdb->queryFetch($sql);
    }

    public static function getAllStaticPages(): false|array
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT * 
                FROM " . self::TABLE . " 
                WHERE 1";
        return $Cdb->queryFetchAll($sql);
    }

    public static function getOneStaticPage(int $id): false|array
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT *
                FROM " . SELF::TABLE . "
                WHERE id_static_page={$id}";
        return $Cdb->queryFetch($sql);
    }

    public static function updateStaticPage(array $dataSet, array $dataWhere): array|false|null
    {
        $Cdb = Cdb::getInstance();
        return $Cdb->update(self::TABLE, $dataSet, $dataWhere);
    }

    public static function insertStaticPage(array $dataInsert): array|false|null
    {
        $Cdb = Cdb::getInstance();
        return $Cdb->insert(self::TABLE, $dataInsert);
    }

    public static function deleteStaticPage(array $dataDelete): array|false|null
    {
        $Cdb = Cdb::getInstance();
        return $Cdb->delete(self::TABLE, $dataDelete);
    }

}
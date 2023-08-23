<?php

namespace App\Models;

use App\Cdb;
use App\Model;
#[\AllowDynamicProperties]
class SearchModel extends Model
{
    public static function SearchArticles($sting): array
    {
        $Cdb = new Cdb();
        $sql = "SELECT *
                FROM articles
                INNER JOIN rating
                ON articles.id_article = rating.id_article
                WHERE title LIKE '%" . $sting . "%' 
                    OR title_eng LIKE '%" . $sting . "%' 
                    OR description LIKE '%" . $sting . "%'
                ORDER BY articles.id_article DESC LIMIT 20
        ";
        return $Cdb->query($sql, static::class);
    }
}
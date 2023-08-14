<?php

namespace App\Models;

use App\Cdb;
use App\Model;
#[\AllowDynamicProperties]
class Main extends Model
{
    public static function showMainPage($chapter): array
    {
        $Cdb = new Cdb();
        $sql = "SELECT *
                FROM articles 
                INNER JOIN rating
                ON articles.id_article = rating.id_article
                WHERE chapter='$chapter'  AND show_article=1
                ORDER BY articles.id_article
                DESC LIMIT 6";
        return $Cdb->query($sql, static::class);
    }

    public static function showAllChapter(): array
    {
        $Cdb = new Cdb();
        $sql = "SELECT * FROM chapter";
        return $Cdb->query($sql, static::class);
    }

}

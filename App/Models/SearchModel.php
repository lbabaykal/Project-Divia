<?php

namespace App\Models;

use App\App;
use App\Cdb;
use App\Model;

class SearchModel extends Model
{
    public static function getSearchArticles(string $sting): array
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT *
                FROM articles
                INNER JOIN rating
                ON articles.id_article = rating.id_article
                WHERE title LIKE '%" . $sting . "%' 
                    OR title_eng LIKE '%" . $sting . "%' 
                    OR description LIKE '%" . $sting . "%'
                ORDER BY articles.id_article DESC LIMIT " . App::getConfigSite('count_article_all');
        return $Cdb->queryFetchAll($sql);
    }
}
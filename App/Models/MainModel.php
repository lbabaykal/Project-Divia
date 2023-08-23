<?php

namespace App\Models;

use App\App;
use App\Cdb;
use App\Model;

class MainModel extends Model
{
    public static function showArticlesCustom(string $chapterName): array
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT *
                FROM articles 
                INNER JOIN rating
                    ON articles.id_article = rating.id_article                
                INNER JOIN chapter
                    ON articles.chapter = chapter.id_chapter
                WHERE chapter.chapter_name_eng='{$chapterName}'
                    AND articles.show_article=1
                ORDER BY articles.id_article
                DESC LIMIT " . App::getConfigSite('count_article_main');
        return $Cdb->queryFetchAll($sql);
    }

    public static function showArticles(): array
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT *
                FROM articles 
                INNER JOIN rating
                    ON articles.id_article = rating.id_article                
                WHERE articles.show_article=1
                ORDER BY articles.id_article
                DESC LIMIT " . App::getConfigSite('count_article_chapter');
        return $Cdb->queryFetchAll($sql);
    }

}

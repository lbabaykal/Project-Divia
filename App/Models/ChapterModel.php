<?php

namespace App\Models;

use App\App;
use App\Cdb;
use App\Model;

class ChapterModel extends Model
{
    public const TABLE = 'chapter';

    public static function showArticlesChapter($chapter_name): array
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT * FROM articles
                INNER JOIN chapter
                ON articles.chapter = chapter.id_chapter
                INNER JOIN rating
                ON articles.id_article = rating.id_article
                WHERE chapter_name_eng='{$chapter_name}'
                AND articles.show_article=1
                ORDER BY articles.id_article
                DESC LIMIT " . App::getConfigSite('count_article_all');
        return $Cdb->queryFetchAll($sql);
    }

    public static function dataChapter($chapter_name)
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT * FROM " . self::TABLE . " WHERE chapter_name_eng='{$chapter_name}'";
        return $Cdb->queryFetch($sql);
    }
}
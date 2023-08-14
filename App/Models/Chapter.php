<?php

namespace App\Models;

use App\Cdb;
#[\AllowDynamicProperties]
class Chapter
{
    public static function showArticles($chapter_name): array
    {
        $Cdb = new Cdb();
        $sql = "SELECT * FROM articles
                INNER JOIN chapter
                ON articles.chapter = chapter.id_chapter
                INNER JOIN rating
                ON articles.id_article = rating.id_article
                WHERE chapter_name_eng='{$chapter_name}'
                AND articles.show_article=1
                ORDER BY articles.id_article
                DESC LIMIT 20";
        return $Cdb->query($sql, static::class);
    }

    public static function showChapter($chapter_name): array
    {
        $Cdb = new Cdb();
        $sql = "SELECT * FROM chapter 
                WHERE chapter_name_eng='{$chapter_name}'
                ORDER BY id_chapter";
        return $Cdb->query($sql, static::class);
    }

    public static function checkChapter($chapter_name)
    {
        $Cdb = new Cdb();
        $sql = "SELECT chapter_name_eng FROM chapter WHERE chapter_name_eng='{$chapter_name}'";
        return $Cdb->query($sql, static::class);
    }
}
<?php

namespace App\Models;

use App\Cdb;
use App\Model;
#[\AllowDynamicProperties]
class Article extends Model
{
    public static function showAll(): array
    {
        $Cdb = new Cdb();
        $sql = "SELECT DISTINCT articles.id_article, articles.title, articles.author, chapter.chapter_name
                FROM articles
                INNER JOIN chapter
                ON articles.chapter = chapter.id_chapter
                ";
        return $Cdb->query($sql, static::class);
    }

    public static function showOne($id_article): array
    {
        $Cdb = new Cdb();
        $sql = 'SELECT * FROM articles WHERE id_article=' . $id_article;
        return $Cdb->query($sql, static::class);
    }

    public static function checkIdBook($id_article): array
    {
        $Cdb = new Cdb();
        $sql = 'SELECT id_article FROM articles WHERE id_article=' . $id_article;
        return $Cdb->query($sql, static::class);
    }

    public static function showChapters(): array
    {
        $Cdb = new Cdb();
        $sql = "SELECT * FROM chapter";
        return $Cdb->query($sql, static::class);
    }

    public static function showCategories(): array
    {
        $Cdb = new Cdb();
        $sql = "SELECT * FROM category ORDER BY id_category";
        return $Cdb->query($sql, static::class);
    }

}
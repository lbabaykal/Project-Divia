<?php

namespace App\Models;

use App\Cdb;
use App\Model;

class ArticleModel extends Model
{
    public const TABLE = 'articles';

    public static function getDataArticle($id_article): array
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT * FROM " . self::TABLE . " WHERE id_article={$id_article}";
        return $Cdb->queryFetch($sql);
    }

    public static function getAllArticles(): array
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT DISTINCT articles.id_article, articles.title, articles.category, chapter.chapter_name
                FROM articles
                INNER JOIN chapter
                ON articles.chapter = chapter.id_chapter
                ";
        return $Cdb->queryFetchAll($sql);
    }







    public static function showChapters(): array
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT * FROM chapter";
        return $Cdb->query($sql);
    }

    public static function showCategories(): array
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT * FROM category ORDER BY id_category";
        return $Cdb->query($sql);
    }

}
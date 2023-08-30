<?php

namespace App\Models;

use App\Cdb;
use App\Model;

class ArticleModel extends Model
{
    public const TABLE = 'articles';

    public static function getDataArticle($id_article): array|false
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT * FROM " . self::TABLE . " WHERE id_article={$id_article}";
        return $Cdb->queryFetch($sql);
    }

    public static function getAllArticles(): array|false
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT DISTINCT articles.id_article, articles.title, articles.category, chapter.chapter_name
                FROM articles
                INNER JOIN chapter
                ON articles.chapter = chapter.id_chapter
                ";
        return $Cdb->queryFetchAll($sql);
    }

    public static function getChapters(): array|false
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT * FROM chapter";
        return $Cdb->queryFetchAll($sql);
    }

    public static function getCategories(): array|false
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT * FROM category ORDER BY id_category";
        return $Cdb->queryFetchAll($sql);
    }

    public static function save(string $sql1, string $sql2): void
    {
        $Cdb = Cdb::getInstance();
        $Cdb->transact([$sql1, $sql2]);
    }

    public static function updateWithImage(array $dataSet, array $dataWhere): void
    {
        $Cdb = Cdb::getInstance();
        $Cdb->update(self::TABLE, $dataSet, $dataWhere);
    }

    public static function updateWithoutImage(array $dataSet, array $dataWhere): void
    {
        $Cdb = Cdb::getInstance();
        $Cdb->update(self::TABLE, $dataSet, $dataWhere);
    }

    public static function delete(int $id_article): void
    {
        $Cdb = Cdb::getInstance();
        $sql1 = "DELETE FROM articles WHERE id_article=" . $id_article;
        $sql2 = "DELETE FROM rating WHERE id_article=" . $id_article;
        $sql3 = "DELETE FROM rating_assessment WHERE id_article=" . $id_article;
        $sql4 = "DELETE FROM article_category WHERE id_article=" . $id_article;
        $Cdb->transact([$sql1, $sql2, $sql3, $sql4]);
    }

}
<?php

namespace App\Models;

use App\Cdb;
use App\Model;
#[\AllowDynamicProperties]
class My_FavoritesModel extends Model
{
    public static function showUser_Favourites(): array
    {
        $id_user = $_SESSION['sessionUserData']['id_user'];
        $Cdb = new Cdb();
        $sql = "SELECT *
                FROM favourites
                INNER JOIN articles
                ON favourites.id_article = articles.id_article
                INNER JOIN rating
                ON favourites.id_article = rating.id_article
                INNER JOIN chapter
                ON articles.chapter = chapter.id_chapter
                WHERE favourites.id_user='$id_user'
                ORDER BY favourites.id_favourites ASC
        ";
        return $Cdb->query($sql, static::class);
    }

    public static function checkMy_Favorites($id_article) {
        $id_user = $_SESSION['sessionUserData']['id_user'];
        $Cdb = new Cdb();
        $sql = "SELECT *
                FROM favourites 
                WHERE id_article='$id_article' 
                    AND id_user=" . $id_user;
        return $Cdb->query($sql, static::class);
    }

    public static function deleteMy_Favorites($id_article) {
        $id_user = $_SESSION['sessionUserData']['id_user'];
        $Cdb = new Cdb();
        $sql = "DELETE FROM favourites
                WHERE  id_article='$id_article'
                    AND id_user='$id_user'
        ";
        return $Cdb->query($sql, static::class);
    }

    public static function insertMy_Favorites($id_article) {
        $id_user = $_SESSION['sessionUserData']['id_user'];
        $Cdb = new Cdb();
        $sql = "INSERT INTO favourites ( id_user, id_article )
                VALUES ( '$id_user', '$id_article' )
        ";
        return $Cdb->query($sql, static::class);
    }



}
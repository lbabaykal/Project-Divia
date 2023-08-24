<?php

namespace App\Models;

use App\Cdb;
use App\Controllers\UserController;
use App\Model;

class FavoritesModel extends Model
{

    public static function getFavouriteUser(int $id_article): array|false
    {
        $id_user = UserController::getDataField('id_user');
        $Cdb = Cdb::getInstance();
        $sql = "SELECT id_favourites
                FROM favourites
                WHERE id_article={$id_article}
                AND id_user={$id_user}";
        return $Cdb->queryFetch($sql);
    }

    public static function deleteUserFavorites($id_article): null
    {
        $id_user = UserController::getDataField('id_user');
        $Cdb = Cdb::getInstance();
        $data = [
            'id_user' => $id_user,
            'id_article' => $id_article,
        ];
        return $Cdb->delete('favourites', $data);
    }

    public static function insertUserFavorites($id_article): null
    {
        $id_user = UserController::getDataField('id_user');
        $Cdb = Cdb::getInstance();
        $data = [
            'id_user' => $id_user,
            'id_article' => $id_article,
        ];
        return $Cdb->insert('favourites', $data);
    }








    public static function showUser_Favourites(): array
    {
        $id_user = UserController::getDataField('id_user');
        $Cdb = Cdb::getInstance();
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
        return $Cdb->query($sql);
    }


}
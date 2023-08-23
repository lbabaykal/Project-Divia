<?php

namespace App\Models;

use App\Cdb;
use App\Model;

class RatingModel extends Model
{
    public static function user_rating_assessment($id_article)
    {
        $id_user = $_SESSION['sessionUserData']['id_user'];
        $Cdb = new Cdb();
        $sql = "SELECT *
                FROM rating_assessment
                WHERE id_article={$id_article}
                AND id_user={$id_user}";
        return $Cdb->queryFetch($sql);
    }

    public static function rating($id_article)
    {
        $Cdb = new Cdb();
        $sql = "SELECT *
                FROM rating
                WHERE id_article={$id_article}";
        return $Cdb->queryFetch($sql);
    }



}
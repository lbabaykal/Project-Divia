<?php

namespace App\Models;

use App\Cdb;
use App\Controllers\UserController;
use App\Model;

class RatingModel extends Model
{

    public static function getRating(int $id_article): array
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT rating.rating, rating.count_assessments
                FROM rating
                WHERE id_article={$id_article}";
        return $Cdb->queryFetch($sql);
    }

    public static function doRating(int $id_article, int $assessment): bool
    {
        $id_user = UserController::getDataField('id_user');
        $DataRatingUser = self::getRatingUser($id_article);
        $DataRatingArticle = self::getRatingArticle($id_article);

        if ($DataRatingUser) {
            $RatingNew = round(($DataRatingArticle['rating'] * $DataRatingArticle['count_assessments'] + ($assessment - $DataRatingUser['assessment'])) / ($DataRatingArticle['count_assessments']), 2);
            $Cdb = Cdb::getInstance();
            $sql1 = "UPDATE rating_assessment
                    SET assessment={$assessment}
                    WHERE id_article={$id_article}
                    AND id_user={$id_user}";
            $sql2 = "UPDATE rating
                    SET rating={$RatingNew}
                    WHERE id_article={$id_article}";
            $Cdb->transact([$sql1, $sql2]);

            return true;
        }
        else {
            $count_assessmentsNew = $DataRatingArticle['count_assessments'] + 1;
            $RatingNew = round(($DataRatingArticle['rating'] * $DataRatingArticle['count_assessments'] + $assessment) / ($DataRatingArticle['count_assessments'] + 1), 2);

            $sql1 = "INSERT INTO rating_assessment (
                        id_article,
                        id_user,
                        assessment
                    )
                    VALUES (
                        '$id_article',
                        '$id_user',
                        '$assessment'
                    )";
            $sql2 = "UPDATE rating
                    SET rating={$RatingNew}, count_assessments={$count_assessmentsNew}
                    WHERE id_article={$id_article}";
            $Cdb = Cdb::getInstance();
            $Cdb->transact([$sql1, $sql2]);

            return false;
        }
    }

    public static function getRatingUser(int $id_article): array|false
    {
        $id_user = UserController::getDataField('id_user');
        $Cdb = Cdb::getInstance();
        $sql = "SELECT *
                FROM rating_assessment
                WHERE id_article={$id_article}
                AND id_user={$id_user}";
        return $Cdb->queryFetch($sql);
    }

    public static function getRatingArticle($id_article): array|false
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT *
                FROM rating
                WHERE id_article={$id_article}";
        return $Cdb->queryFetch($sql);
    }

}
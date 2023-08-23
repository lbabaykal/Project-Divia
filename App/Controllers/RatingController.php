<?php

namespace App\Controllers;

use App\Cdb;
use App\Controller;
use App\View;
use App\Models\RatingModel;

class RatingController extends Controller
{
//    Rc - старый рейтинг
//    Rн - новый рейтинг
//    S - кол голосов
//    A - голос
//    Rн = ( Rc * S + A ) / ( S + 1 )

    public static function showRating($id_article)
    {
        $Cdb = new Cdb();
        $sql = "SELECT *
                FROM rating
                WHERE id_article={$id_article}";
        $RatingArticle = $Cdb->queryFetch($sql);

        $viewRating = new View();
        $Answer = $viewRating->render( TEMPLATES_DIR . 'Rating.php', $RatingArticle);

        $id_user = $_SESSION['sessionUserData']['id_user'] ?? false;
        $dbRatingUser = new Cdb();
        $sqlRatingUser = "SELECT *
                            FROM rating_assessment
                            WHERE id_article={$id_article} 
                            AND id_user={$id_user}";
        $RatingUser = $dbRatingUser->queryFetch($sqlRatingUser);

        if ($RatingUser) {
            $Answer = str_replace( 'value="' . $RatingUser['assessment'] . '"', 'value="' . $RatingUser['assessment'] . '" checked', $Answer );
        }
        return $Answer;
    }

    public function actionDo_Rating()
    {
        $answer['success'] = $success = 'No';

        if ( !empty($_POST) ) {
            extract($_POST, EXTR_SKIP);

            if ( !isset($rating, $id_article) ) {
                $textData = 'Проблемы с отправленными данными';
            }
            else {
                $id_article = explode('/', $id_article);
                $id_article = preg_replace('/[+-]/u', '', filter_var( $id_article[2], FILTER_SANITIZE_NUMBER_INT));
                $rating = preg_replace('/[+-]/u', '',filter_var( $rating, FILTER_SANITIZE_NUMBER_INT));
                $id_user = $_SESSION['sessionUserData']['id_user'] ?? false;

                $dataRatingOld = RatingModel::user_rating_assessment($id_article);
                $dataRatingNew = RatingModel::rating($id_article);

                if ( $id_user === false  ) {
                    $textData = 'Необходимо авторизоваться!';
                }
                elseif ( ($rating < 1) OR ($rating > 10) )
                {
                    $textData = 'Неверное значение оценки!';
                }
                elseif ( $dataRatingOld )  {
                    $Rating_assessmentsOld = $dataRatingOld['assessment'];
                    $RatingOld = $dataRatingNew['rating'];
                    $count_assessmentsOld = $dataRatingNew['count_assessments'];
                    $RatingNew = round(($RatingOld * $count_assessmentsOld + ($rating - $Rating_assessmentsOld)) / ($count_assessmentsOld), 2);
                    $sql1 = "UPDATE rating_assessment
                            SET assessment={$rating}
                            WHERE id_article={$id_article}
                            AND id_user={$id_user}";
                    $sql2 = "UPDATE rating
                            SET rating={$RatingNew}
                            WHERE id_article={$id_article}";
                    $Cdb = new Cdb();
                    $Cdb->transact([$sql1, $sql2]);
                    $success = 'Yes';
                    $textData = 'Ваша оценка изменена на ' . $rating ;
                }
                else {
                    $RatingOld = $dataRatingNew['rating'];
                    $count_assessmentsOld = $dataRatingNew['count_assessments'];
                    $count_assessmentsNew = $count_assessmentsOld + 1;
                    $RatingNew = round(($RatingOld * $count_assessmentsOld + $rating) / ($count_assessmentsOld + 1), 2);

                    $sql1 = "INSERT INTO rating_assessment (
                        id_article,
                        id_user,
                        assessment
                    )
                    VALUES (
                        '$id_article',
                        '$id_user',
                        '$rating'
                    )";
                    $sql2 = "UPDATE rating
                            SET rating={$RatingNew}, count_assessments={$count_assessmentsNew}
                            WHERE id_article={$id_article}";
                    $Cdb = new Cdb();
                    $Cdb->transact([$sql1, $sql2]);
                    $success = 'Yes';
                    $textData = 'Оценка успешно добавлена!';
                }
            }
        }
        else {
            $textData = 'Проблемы работы AJAX';
        }
        $answer = [ "success" => $success, "text" => $textData ];
        echo json_encode($answer);
    }



}
<?php

namespace App\Controllers;

use App\Cdb;
use App\Controller;
use App\Models\My_FavoritesModel;

class My_FavoritesController extends Controller
{
    public static function checkFavourite($id_article)
    {
        $id_user = $_SESSION['sessionUserData']['id_user'] ?? false;

        $CheckFavourite = new Cdb();
        $sql = "SELECT *
                FROM favourites
                WHERE id_article={$id_article}
                AND id_user={$id_user}";
        $RatingsArticle = $CheckFavourite->query($sql);

        $NumberRatings = count($RatingsArticle);

        if ( $NumberRatings == 1 ) {
            $Ansver = 'favourite_active';
        } else {
            $Ansver = '';
        }

        return $Ansver;
    }

    public function actionDo_Favourite()
    {
        $answer['success'] = $success = 'No';

        if (!empty($_POST)) {

            extract($_POST, EXTR_SKIP);

            if ( !isset($id_article) ) {
                $textData = 'Проблемы с отправленными данными';
            }
            else {
                $id_article = explode('/', $id_article);
                $id_article = preg_replace('/[+-]/u', '', filter_var( $id_article[2], FILTER_SANITIZE_NUMBER_INT));
                $id_user = $_SESSION['sessionUserData']['id_user'] ?? false;

                if ($id_user === false) {
                    $textData = 'Необходимо авторизоваться!';
                }
                elseif ( My_FavoritesModel::checkMy_Favorites($id_article) ) {
                    My_FavoritesModel::deleteMy_Favorites($id_article);
                    $success = 'Yess';
                    $textData = 'Успешно убрано из Избранного!';
                }
                else {
                    My_FavoritesModel::insertMy_Favorites($id_article);
                    $success = 'Yes';
                    $textData = 'Успешно добавлено в Избранное!';
                }
            }
        }
        else {
            $textData = 'Проблемы работы AJAX';
        }
        $answer = ["success" => $success, "text" => $textData];

        echo json_encode($answer);
    }
}
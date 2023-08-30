<?php

namespace App\Controllers;

use App\Controller;
use App\Models\FavoritesModel;

class FavoritesController extends Controller
{

    public static function checkFavouriteUser(int $id_article): string
    {
        if (!UserController::getStatus()) {
            return '';
        }
        return FavoritesModel::getFavouriteUser($id_article) ? 'favourite_active' : '';
    }

    public function actionDo_Favourite(): string
    {
        $answer = [ 'success' => 'No'];

        if (!empty($_POST)) {
            extract($_POST, EXTR_SKIP);

            if ( isset($id_article) ) {
                $id_article = explode('/', $id_article);
                $id_article = $this->sanitizeInt($id_article[2]);

                if (!UserController::getStatus()) {
                    $answer['text'] = 'Необходимо авторизоваться!';
                    return json_encode($answer);
                }

                if ( FavoritesModel::getFavouriteUser($id_article) ) {
                    FavoritesModel::deleteUserFavorites($id_article);
                    $answer = ['success' => 'Yess', 'text' => 'Убрано из Избранного!'];
                }
                else {
                    FavoritesModel::insertUserFavorites($id_article);
                    $answer = ['success' => 'Yes', 'text' => 'Добавлено в Избранное!'];
                }
            }
            else {
                $answer['text'] = 'Проблемы с отправленными данными.';
            }
        }
        else {
            $answer['text'] = 'Проблемы работы AJAX.';
        }
        return json_encode($answer);
    }
}
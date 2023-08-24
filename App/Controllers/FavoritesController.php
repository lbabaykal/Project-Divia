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
        $answer = [
            'success' => 'No',
        ];

        if (!empty($_POST)) {
            extract($_POST, EXTR_SKIP);

            if ( isset($id_article) ) {
                $id_article = explode('/', $id_article);
                $id_article = preg_replace('/[+-]/u', '', filter_var( $id_article[2], FILTER_SANITIZE_NUMBER_INT));

                if (!UserController::getStatus()) {
                    $answer['text'] = 'Необходимо авторизоваться!';
                    return json_encode($answer);
                }

                if ( FavoritesModel::getFavouriteUser($id_article) ) {
                    FavoritesModel::deleteUserFavorites($id_article);
                    $answer['success'] = 'Yess';
                    $answer['text'] = 'Успешно убрано из Избранного!';
                }
                else {
                    FavoritesModel::insertUserFavorites($id_article);
                    $answer['success'] = 'Yes';
                    $answer['text'] = 'Успешно добавлено в Избранное!';
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
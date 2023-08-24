<?php

namespace App\Controllers;

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

    public static function showRating(int $id_article, int $status): string
    {
        $dataRating = RatingModel::getRating($id_article);
        $dataRating['RATING-'. round($dataRating['rating'], 0)] = 'checked';
        return (new View)->render_v3(TEMPLATES_DIR . '/Rating', $dataRating , ['RATING' => $status]);
    }

    public function actionDo_Rating(): string
    {
        $answer = [
            'success' => 'No',
        ];

        if (!empty($_POST)) {
            extract($_POST, EXTR_SKIP);

            if (!isset($rating, $id_article)) {
                $answer['text'] = 'Проблемы с отправленными данными.';
            } else {
                $id_article = explode('/', $id_article);
                $id_article = preg_replace('/[+-]/u', '', filter_var($id_article[2], FILTER_SANITIZE_NUMBER_INT));
                $rating = preg_replace('/[+-]/u', '', filter_var($rating, FILTER_SANITIZE_NUMBER_INT));

                if (!UserController::getStatus()) {
                    $answer['text'] = 'Необходимо авторизоваться!';
                    return json_encode($answer);
                }

                if (($rating < 1) or ($rating > 10)) {
                    $answer['text'] = 'Неверное значение оценки!';
                    return json_encode($answer);
                }

                if (RatingModel::doRating($id_article, $rating) === true) {
                    $answer['success'] = 'Yes';
                    $answer['text'] = 'Ваша оценка изменена на ' . $rating;
                } else {
                    $answer['success'] = 'Yes';
                    $answer['text'] = 'Оценка успешно добавлена!';
                }
            }
        } else {
            $answer['text'] = 'Проблемы работы AJAX.';
        }
        return json_encode($answer);
    }


}
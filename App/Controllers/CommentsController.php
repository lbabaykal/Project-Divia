<?php

namespace App\Controllers;


use App\Controller;
use App\Models\CommentsModel;
use App\View;

class CommentsController extends Controller
{
    public static function showComments(int $id_article, int $status): string
    {
        if ($status) {
            $dataComments = CommentsModel::getComments($id_article);
            return $dataComments ? (new View)->render(TEMPLATES_DIR . '/Comment', $dataComments) : 'Комментариев нет, будь первым!';
        } else {
            return 'Комментарии для данной статьи отключены.';
        }
    }

    public static function showAddComments(): string
    {
            return (new View)->render_v3(TEMPLATES_DIR . '/Add_Comment');
    }

    public function actionComment_Add(): string
    {
        $answer = ['success' => 'No'];

        if (!empty($_POST)) {
            extract($_POST, EXTR_SKIP);

            if (isset($comment, $id_article)) {
                $comment = $this->sanitizeString($comment);
                $id_article = explode('/', $id_article);
                $id_article = preg_replace('/[+-]/u', '', filter_var($id_article[2], FILTER_SANITIZE_NUMBER_INT));
                $id_user = UserController::getDataField('id_user');

                $dateNow = date('d-m-Y h:i');
                if (!$id_user) {
                    $answer['text'] = 'Необходимо авторизоваться!';
                    return json_encode($answer);
                }

                if (mb_strlen($comment) < 10) {
                    $answer['text'] = 'Комментарий слишком короткий!';
                } elseif (mb_strlen($comment) > 3000) {
                    $answer['text'] = 'Комментарий слишком длинный!';
                } else {
                    $data = [
                        'id_article' => $id_article,
                        'id_user' => $id_user,
                        'comment' => $comment,
                        'comment_date' => $dateNow,
                    ];
                    CommentsModel::commentAdd($data);
                    $answer = ['success' => 'Yes', 'text' => 'Комментарий успешно добавлен!'];
                }
            } else {
                $answer['text'] = 'Проблемы с отправленными данными.';
            }
        } else {
            $answer['text'] = 'Проблемы работы AJAX.';
        }
        return json_encode($answer);
    }

}
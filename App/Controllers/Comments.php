<?php

namespace App\Controllers;

use App\Cdb;
use App\Controller;

class Comments extends Controller
{
    public function actionComment_Add()
    {
        $answer['success'] = $success = 'No';

        if ( !empty($_POST) ) {
            extract($_POST, EXTR_SKIP);

            if ( isset($comment, $id_article) ) {
                $comment = $this->sanitizeString($comment);
                $id_article = preg_replace('/[+-]/u', '', filter_var( $id_article, FILTER_SANITIZE_NUMBER_INT));
                $id_user = $_SESSION['sessionUserData']['id_user'] ?? false;

                $dateNow = date('d-m-Y h:i');
                if ( $id_user === false )  {
                    $textData = 'Необходимо авторизоваться!';
                }
                elseif ( mb_strlen($comment) < 10 )  {
                    $textData = 'Рецензия слишком короткая!';
                }
                elseif ( mb_strlen($comment) > 3000 )  {
                    $textData = 'Рецензия слишком длинная!';
                }
                else {
                    $data = [
                        'id_article' => $id_article,
                        'id_user' => $id_user,
                        'comment' => $comment,
                        'comment_date' => $dateNow,
                    ];
                    $db = new Cdb;
                    $db->insert('comments', $data);
                    $success = 'Yes';
                    $textData = 'Рецензия добавлена!';
                }
            }
            else {
                $textData = 'Проблемы с отправленными данными';
            }
        }
        else {
            $textData = 'Проблемы работы AJAX';
        }
        $answer = [ "success" => $success, "text" => $textData ];

        echo json_encode($answer);
    }

}
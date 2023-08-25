<?php

namespace App;

use App\Controllers\UserController;

abstract class Controller
{
    public function __construct(public $route = [])
    {

    }

    public function actionIndex()
    {
        $this->Not_Found_404();
    }

    public function limitterDesc(string $string): string
    {
        return mb_strimwidth($string, 0, 145, "...");
    }

    public function CheckAccess(): void
    {
        if ( !UserController::getDataField('access_admin') ) {
            $this->Not_Found_404();
        }
    }

    public function CheckUser(): void
    {
        if (!UserController::getStatus()) {
            header('Location: /');
        }
    }

    public function Not_Found_404(): void
    {
        header('Location: /404.php');
    }



    public function sanitizeString($string): string
    {
        $string = trim($string); //Убирает пробелы
        $string = strip_tags($string); //Убирает html теги
        return htmlspecialchars($string); // Преобразует специальные символы в HTML-сущности
    }
}
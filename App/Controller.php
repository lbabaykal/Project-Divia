<?php

namespace App;


abstract class Controller
{
    public function __construct(public $route = [])
    {

    }

    public function actionIndex()
    {
        $this->Not_Found_404();
    }








    public function sanitizeString($string): string
    {
        $string = trim($string); //Убирает пробелы
        $string = strip_tags($string); //Убирает html теги
        return htmlspecialchars($string); // Преобразует специальные символы в HTML-сущности
    }

    public function CheckAccess(): void
    {
        if ( ($_SESSION['sessionUserData']['user_group'] != '1' AND $_SESSION['sessionUserData']['user_group'] != '2' ) OR !isset($_SESSION['sessionUserData'])) {
            $this->Not_Found_404();
        }
    }

    public function CheckUser(): void
    {
        if ( !isset($_SESSION['sessionUserData']) ) {
            header('Location: /');
        }
    }

    public function Not_Found_404(): void
    {
        header('Location: /404.php');
    }
}
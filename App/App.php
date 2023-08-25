<?php

namespace App;

use App\Controllers\UserController;
use App\Registry;

class App {

    /**
     * @var Registry
     */
    private static Registry $ConfigSite;

    public static function start(): void
    {
        new Error;
        self::setConfigSite();

        define('TEMPLATES_DIR', $_SERVER['DOCUMENT_ROOT'] . '/Templates/' . self::getConfigSite('template'));
        define('ADMIN_TEMPLATES_DIR', $_SERVER['DOCUMENT_ROOT'] . '/admin');

        require_once 'Configuration/Routes.php';
        session_start();
        (new UserController)->getUserData();

        /*
            > аутентификацию
            > кеширование
            > абстракции для доступа к данным
            > ORM
            > Backup
        */

        Router::dispatcher();
    }

    public static function setConfigSite(): void
    {
        self::$ConfigSite = new Registry;
        self::$ConfigSite::setDataArray(require_once 'Configuration/Config.php');
    }

    public static function getConfigSite(string $string): string|int|null
    {
        return self::$ConfigSite::getData($string);
    }

}

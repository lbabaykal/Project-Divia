<?php

namespace App;

new Error;

$Config = require_once 'App/Configuration/Config.php';

define('TEMPLATES_DIR', $_SERVER['DOCUMENT_ROOT'] . '/Templates/' . $Config['Template'] . '/');
define('ADMIN_TEMPLATES_DIR', $_SERVER['DOCUMENT_ROOT'] . '/App/Templates/');

require_once 'Configuration/Routes.php';
session_start();
require_once 'Controller.php';   //
require_once 'Model.php';        //
require_once 'View.php';         //
require_once 'Cdb.php';          //

/*
	> аутентификацию
	> кеширование
	> абстракции для доступа к данным
	> ORM
	> Backup
*/

//$string = "[FIELD_EMAIL]<h1>[VALUE_EMAIL]</h1>[/FIELD_EMAIL]";
//$field = 'EMAIL';
//$field_replace = 'trololo@yandex.ru';
//$string = preg_replace( '/\[FIELD_' . $field . '\](.+?)\[VALUE_' . $field . '\](.+?)\[\/FIELD_' . $field . '\]/', '$1' . $field_replace . '$2', $string );
//echo $string;
//exit();

/*$lol = require_once 'App/Configuration/Main.php';
$lol += ['lol' => 'lol'];
var_dump($lol );
exit();*/
Router::start(); // запускаем маршрутизатор

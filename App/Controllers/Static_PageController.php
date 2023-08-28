<?php

namespace App\Controllers;

use App\App;
use App\Controller;
use App\Models\Static_PageModel;
use App\View;

class Static_PageController extends Controller
{
    public function actionIndex()
    {
        $NamePage =  $this->route['name'];
        $DataStaticPage = Static_PageModel::getStaticPage($NamePage);
        if (!$DataStaticPage) {
            $this->Not_Found_404();
        }

        $DataMain = [
            'title' => '🌸' . App::getConfigSite('site_name') . '🌸' . $DataStaticPage['name'] . '📜︎',
            'description' => '',
            'template'=> App::getConfigSite('dir_template'),
            'login' => LoginController::login()
        ];

        $templateStatic_Page = (new View)->render_v3(TEMPLATES_DIR . '/Static_Page', $DataStaticPage);
        $DataMain += [
            'CONTENT' => $templateStatic_Page
        ];

        return (new View)->render_v3(TEMPLATES_DIR . '/Main', $DataMain);
    }

    //================TEMPLATES================
    public function actionTemplate_Static_Page_Add(): string
    {
        $this->CheckAccess();
        return (new View)->render_v3(ADMIN_TEMPLATES_DIR . '/AJAX/Static_Page_Add');
    }

    public function actionTemplate_Static_Page_Edit(): string
    {
        $this->CheckAccess();
        $id_StaticPage = $this->sanitizeInt($_POST['id_StaticPage']);
        $dataStaticPage = Static_PageModel::getOneStaticPage($id_StaticPage);
        if (!$dataStaticPage) {
            return $this->Not_Found_404();
        }
        return (new View)->render_v3(ADMIN_TEMPLATES_DIR . '/AJAX/Static_Page_Edit', $dataStaticPage);
    }

    public function actionTemplate_Static_Page_Delete(): string
    {
        $this->CheckAccess();
        $id_StaticPage = $this->sanitizeInt($_POST['id_StaticPage']);
        $dataStaticPage = Static_PageModel::getOneStaticPage($id_StaticPage);
        if (!$dataStaticPage) {
            return $this->Not_Found_404();
        }
        return (new View)->render_v3(ADMIN_TEMPLATES_DIR . '/AJAX/Static_Page_Delete', $dataStaticPage);
    }

    //================ACTIONS================
    public function actionStatic_Page_Add(): string
    {
        $this->CheckAccess();

        $answer = [ 'success' => 'No'];
        if (!empty($_POST)) {
            extract($_POST, EXTR_SKIP);

            if (!isset($name, $name_eng, $description)) {
                $answer['text'] = 'Проблемы с отправленными данными.';
            } else {
                $name = $this->sanitizeString($name);
                $name_eng = $this->sanitizeString($name_eng);
                $description = $this->sanitizeString($description);

                if ($name == '') {
                    $answer['text'] = 'Введите Название!';
                } elseif (mb_strlen($name) > 50) {
                    $answer['text'] = 'Название должно быть меньше 50 символов!';
                } elseif ($name_eng == '') {
                    $answer['text'] = 'Введите Название на Английском!';
                } elseif (mb_strlen($name_eng) > 50) {
                    $answer['text'] = 'Название на Английском должно быть меньше 50 символов!';
                } else {
                    $data = [
                        'name' => $name,
                        'name_eng' => $name_eng,
                        'description' => $description,
                    ];
                    Static_PageModel::insertStaticPage($data);
                    $answer['success'] = 'Yes';
                    $answer['text'] = 'Статическая страница добавлена!';
                }
            }
        } else {
            $answer['text'] = 'Проблемы работы AJAX.';
        }
        return json_encode($answer);
    }

    public function actionStatic_Page_Edit(): string
    {
        $this->CheckAccess();
        $answer = [ 'success' => 'No'];
        if (!empty($_POST)) {
            extract($_POST, EXTR_SKIP);

            if ( !isset($id_StaticPage, $name, $name_eng, $description) ) {
                $answer['text'] = 'Проблемы с отправленными данными.';
            } else {
                $id_StaticPage = $this->sanitizeInt($id_StaticPage);
                $name = $this->sanitizeString($name);
                $name_eng = $this->sanitizeString($name_eng);
                $description = $this->sanitizeString($description);

                if ($name == '') {
                    $answer['text'] = 'Введите Название!';
                } elseif (mb_strlen($name) > 50) {
                    $answer['text'] = 'Название должно быть меньше 50 символов!';
                } elseif ($name_eng == '') {
                    $answer['text'] = 'Введите Название на Английском!';
                } elseif (mb_strlen($name_eng) > 50) {
                    $answer['text'] = 'Название на Английском должно быть меньше 50 символов!';
                } else {
                    $dataSet = [
                        'name' => $name,
                        'name_eng' => $name_eng,
                        'description' => $description
                    ];
                    $dataWhere = [
                        'id_static_page' => $id_StaticPage
                    ];
                    Static_PageModel::updateStaticPage($dataSet, $dataWhere);
                    $answer['success'] = 'Yes';
                    $answer['text'] = 'Статическая страница изменена!';
                }
            }
        } else {
            $answer['text'] = 'Проблемы работы AJAX.';
        }
        return json_encode($answer);
    }

    public function actionStatic_Page_Delete(): string
    {
        $this->CheckAccess();
        $answer = [ 'success' => 'No'];

        if (!empty($_POST)) {
            extract($_POST, EXTR_SKIP);

            if ( !isset($id_StaticPage) ) {
                $answer['text'] = 'Проблемы с отправленными данными.';
            }
            else {
                $id_StaticPage = $this->sanitizeInt($id_StaticPage);

                if ( !Static_PageModel::getOneStaticPage($id_StaticPage) ) {
                    $answer['text'] = 'Такой Статической страницы не существует!';
                }
                else {
                    Static_PageModel::deleteStaticPage(['id_static_page' => $id_StaticPage]);
                    $answer['success'] = 'Yes';
                    $answer['text'] = 'Статическая страница удалена!';
                }
            }
        }
        else {
            $answer['text'] = 'Проблемы работы AJAX.';
        }
        return json_encode($answer);
    }

}
















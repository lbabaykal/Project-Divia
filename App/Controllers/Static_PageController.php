<?php

namespace App\Controllers;

use App\App;
use App\Cdb;
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
            'description' => $this->limitterDesc($DataStaticPage['description']),
            'template'=> App::getConfigSite('dir_template'),
            'login' => LoginController::login()
        ];

        $templateStatic_Page = (new View)->render_v3(TEMPLATES_DIR . '/Static_Page', $DataStaticPage);
        $DataMain += [
            'CONTENT' => $templateStatic_Page
        ];

        return (new View)->render_v3(TEMPLATES_DIR . '/Main', $DataMain);
    }









    public function actionTemplate_Static_Page_Add(): string
    {
        $this->CheckAccess();
        $viewSP = new View();
        return $viewSP->display(ADMIN_TEMPLATES_DIR . '/AJAX/Static_Page_Add.php');
    }

    public function actionStatic_Page_Add(): string
    {
        $this->CheckAccess();

        $answer['success'] = $success = 'No';
        if (!empty($_POST)) {
            extract($_POST, EXTR_SKIP);

            if (!isset($name, $name_eng, $description)) {
                $textData = 'Проблемы с отправленными данными';
            } else {
                $name = $this->sanitizeString($name);
                $name_eng = $this->sanitizeString($name_eng);
//                $description = $this->sanitizeInput($description);

                if ($name == '') {
                    $textData = 'Введите Название!';
                } elseif (mb_strlen($name) > 50) {
                    $textData = 'Название должно быть меньше 50 символов';
                } elseif ($name_eng == '') {
                    $textData = 'Введите Название на Английском!';
                } elseif (mb_strlen($name_eng) > 50) {
                    $textData = 'Название на Английском должно быть меньше 50 символов';
                } else {
                    $data = [
                        'name' => $name,
                        'name_eng' => $name_eng,
                        'description' => $description,
                    ];
                    $Cdb = Cdb::getInstance();
                    $Cdb->insert('static_page', $data);
                    $success = 'Yes';
                    $textData = 'Статическая страница успешно добавлена!';
                }
            }
        } else {
            $textData = 'Проблемы работы AJAX';
        }
        $answer = ["success" => $success, "text" => $textData];

        return json_encode($answer);
    }

    public function actionTemplate_Static_Page_Edit()
    {
        $this->CheckAccess();
        $id_SP = filter_var($_POST['id_SP'], FILTER_SANITIZE_NUMBER_INT);
        if (!is_numeric($id_SP)) {
            $this->Not_Found_404();
        }
        $viewSP = new View();
        $dataSP = Static_PageModel::showOneStaticPage($id_SP);
        return $viewSP->render(ADMIN_TEMPLATES_DIR . '/AJAX/Static_Page_Edit.php', $dataSP);
    }

    public function actionStatic_Page_Edit(): string
    {
        $this->CheckAccess();

        $answer['success'] = $success = 'No';
        if (!empty($_POST)) {
            extract($_POST, EXTR_SKIP);

            if ( !isset($id_SP, $name, $name_eng, $description) ) {
                $textData = 'Проблемы с отправленными данными';
            } else {
                $id_SP = preg_replace('/[+-]/u', '', filter_var($id_SP, FILTER_SANITIZE_NUMBER_INT));
                $name = $this->sanitizeString($name);
                $name_eng = $this->sanitizeString($name_eng);
//                $description = $this->sanitizeInput($description);

                if ($name == '') {
                    $textData = 'Введите Название!';
                } elseif (mb_strlen($name) > 50) {
                    $textData = 'Название должно быть меньше 50 символов';
                } elseif ($name_eng == '') {
                    $textData = 'Введите Название на Английском!';
                } elseif (mb_strlen($name_eng) > 50) {
                    $textData = 'Название на Английском должно быть меньше 50 символов';
                } else {
                    $data = [
                        'id_static_page' => $id_SP,
                        'name' => $name,
                        'name_eng' => $name_eng,
                        'description' => $description,
                    ];
                    $Cdb = Cdb::getInstance();
                    $sql = "UPDATE static_page
                            SET name=:name, name_eng=:name_eng, description=:description
                            WHERE id_static_page=:id_static_page";
                    $Cdb->execute($sql, $data);
                    $success = 'Yes';
                    $textData = 'Статическая страница успешно изменена!';
                }
            }
        } else {
            $textData = 'Проблемы работы AJAX';
        }
        $answer = ["success" => $success, "text" => $textData];

        return json_encode($answer);
    }

    public function actionTemplate_Static_Page_Delete()
    {
        $this->CheckAccess();
        $id_SP = filter_var($_POST['id_SP'], FILTER_SANITIZE_NUMBER_INT);
        if (!is_numeric($id_SP)) {
            $this->Not_Found_404();
        }
        $viewSP = new View();
        $dataSP = Static_PageModel::showOneStaticPage($id_SP);
        return $viewSP->render(ADMIN_TEMPLATES_DIR . '/AJAX/Static_Page_Delete.php', $dataSP);
    }

    public function actionStatic_Page_Delete(): string
    {
        $this->CheckAccess();

        $answer['success'] = $success = 'No';

        if (!empty($_POST)) {
            extract($_POST, EXTR_SKIP);

            if ( !isset($id_SP) ) {
                $textData = 'Проблемы с отправленными данными';
            }
            else {

                $id_SP = preg_replace('/[+-]/u', '', filter_var($id_SP, FILTER_SANITIZE_NUMBER_INT));

                if ( !Static_PageModel::showOneStaticPage($id_SP) ) {
                    $textData = 'Такой Статической страницы не существует!';
                }
                else {
                    $sql = "DELETE FROM static_page 
                            WHERE id_static_page=?
                    ";
                    $Cdb = Cdb::getInstance();
                    $Cdb->execute($sql, [$id_SP]);
                    $success = 'Yes';
                    $textData = 'Статическая страница успешно удалена!';
                }
            }
        }
        else {
            $textData = 'Проблемы работы AJAX';
        }
        $answer = ["success" => $success, "text" => $textData];

        return json_encode($answer);
    }

}
















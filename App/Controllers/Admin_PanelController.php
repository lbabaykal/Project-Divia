<?php

namespace App\Controllers;

use App\App;
use App\Controller;
use App\Models\Static_PageModel;
use App\Models\UserModel;
use App\Models\Admin_PanelModel;
use App\View;
use App\Models\ArticleModel;

class Admin_PanelController extends Controller
{

    public function actionIndex(): string
    {
        $this->CheckAccess();

        $DataAdmin = [
            'title' => '🌸' . App::getConfigSite('site_name') . '🌸' . 'Admin_Panel',
            'description' => '',
            'template' => App::getConfigSite('dir_template'),
            'login' => LoginController::login()
        ];

        $DataMainAdmin = [
            'COUNT_USER' => Admin_PanelModel::countUser(),
            'COUNT_BOOKS' => Admin_PanelModel::countArticles(),
            'COUNT_COMMENT' => Admin_PanelModel::countComments(),
            'COUNT_VISITORS' => 9999,
        ];
        $templateAdmin_Panel = (new View)->render_v3(ADMIN_TEMPLATES_DIR . '/Admin_Main', $DataMainAdmin);
        $DataAdmin += [
            'CONTENT' => $templateAdmin_Panel
        ];

        return (new View)->render_v3(ADMIN_TEMPLATES_DIR . '/Admin_Panel', $DataAdmin);
    }

    public function actionUsers():string {
        $this->CheckAccess();

        $DataAdmin = [
            'title' => '🌸' . App::getConfigSite('site_name') . '🌸' . 'Admin_Panel - Пользователи',
            'description' => '',
            'template' => App::getConfigSite('dir_template'),
            'login' => LoginController::login()
        ];


        $DataAP_Users = [
            'USER_ITEMS' => (new View)->render(ADMIN_TEMPLATES_DIR . '/User_item', UserModel::getAllUsers())
        ];

        $templateAP_User = (new View)->render_v3(ADMIN_TEMPLATES_DIR . '/Users', $DataAP_Users);
        $DataAdmin += [
            'CONTENT' => $templateAP_User
        ];

        return (new View)->render_v3(ADMIN_TEMPLATES_DIR . '/Admin_Panel', $DataAdmin);
    }

    public function actionArticles(): string
    {
        $this->CheckAccess();

        $DataAdmin = [
            'title' => '🌸' . App::getConfigSite('site_name') . '🌸' . 'Admin_Panel - Статьи',
            'description' => '',
            'template' => App::getConfigSite('dir_template'),
            'login' => LoginController::login()
        ];

        $DataAP_Articles = [
            'ARTICLES_ITEMS' => (new View)->render(ADMIN_TEMPLATES_DIR . '/Article_item', ArticleModel::getAllArticles())
        ];

        $templateAP_User = (new View)->render_v3(ADMIN_TEMPLATES_DIR . '/Articles', $DataAP_Articles);
        $DataAdmin += [
            'CONTENT' => $templateAP_User
        ];
        return (new View)->render_v3(ADMIN_TEMPLATES_DIR . '/Admin_Panel', $DataAdmin);
    }

    public function actionStatic_Pages(): string
    {
        $this->CheckAccess();

        $DataAdmin = [
            'title' => '🌸' . App::getConfigSite('site_name') . '🌸' . 'Admin_Panel - Статические страницы',
            'description' => '',
            'template' => App::getConfigSite('dir_template'),
            'login' => LoginController::login()
        ];

        $DataAP_Articles = [
            'STATIC_PAGES_ITEMS' => (new View)->render(ADMIN_TEMPLATES_DIR . '/Static_Pages_Items', Static_PageModel::getAllStaticPages())
        ];

        $templateAP_User = (new View)->render_v3(ADMIN_TEMPLATES_DIR . '/Static_Pages', $DataAP_Articles);
        $DataAdmin += [
            'CONTENT' => $templateAP_User
        ];
        return (new View)->render_v3(ADMIN_TEMPLATES_DIR . '/Admin_Panel', $DataAdmin);
    }

}
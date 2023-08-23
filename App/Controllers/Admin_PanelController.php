<?php

namespace App\Controllers;

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

        $viewAP = new View();
        $TemplateAP = $viewAP->display( ADMIN_TEMPLATES_DIR . 'Admin_Panel.php');

        $data[0] = [
            'COUNT_USER' => Admin_PanelModel::countUser(),
            'COUNT_BOOKS' => Admin_PanelModel::countBooks(),
            'COUNT_COMMENT' => Admin_PanelModel::countComments(),
            'COUNT_VISITORS' => 9999
        ];
        $viewAP_Main = new View();
        $TemplateAP_Main = $viewAP_Main->render( ADMIN_TEMPLATES_DIR . 'Admin_Main.php', $data );

        $InsertAdP_Main = str_replace( '{CONTENT}', $TemplateAP_Main, $TemplateAP );

        $Login = new LoginController();
        $InsertLogin = str_replace( '{LOGIN}', $Login::login(), $InsertAdP_Main );

        return $InsertLogin;
    }

    public function actionUsers():string {
        $this->CheckAccess();

        $viewAdmin_Panel = new View();
        $TemplateAdmin_Panel = $viewAdmin_Panel->display( ADMIN_TEMPLATES_DIR . 'Admin_PanelController.php');

        $viewStatic_Pages = new View();
        $TemplateStatic_Pages =  $viewStatic_Pages->display( ADMIN_TEMPLATES_DIR . 'Users.php');

        $InsertStatic_Page  = str_replace( '{CONTENT}', $TemplateStatic_Pages, $TemplateAdmin_Panel );

        $viewStatic_PagesItems = new View();
        $dataStaticPages = UserModel::showAllUsers();
        $TemplateStaticPagesItems = $viewStatic_PagesItems->render( ADMIN_TEMPLATES_DIR . 'User_item.php', $dataStaticPages);

        $InsertStaticPagesItems  = str_replace( '{STATIC_PAGES_ITEMS}', $TemplateStaticPagesItems, $InsertStatic_Page );

        $Login = new LoginController();
        $InsertLogin = str_replace( '{LOGIN}', $Login::login(), $InsertStaticPagesItems );

        return $InsertLogin;
    }

    public function actionStatic_Pages(): string
    {
        $this->CheckAccess();

        $viewAdmin_Panel = new View();
        $TemplateAdmin_Panel = $viewAdmin_Panel->display( ADMIN_TEMPLATES_DIR . 'Admin_PanelController.php');

        $viewStatic_Pages = new View();
        $TemplateStatic_Pages =  $viewStatic_Pages->display( ADMIN_TEMPLATES_DIR . 'Static_Pages.php');

        $InsertStatic_Page  = str_replace( '{CONTENT}', $TemplateStatic_Pages, $TemplateAdmin_Panel );

        $viewStatic_PagesItems = new View();
        $dataStaticPages = Static_PageModel::showAllStaticPages();
        $TemplateStaticPagesItems = $viewStatic_PagesItems->render( ADMIN_TEMPLATES_DIR . 'Static_Page.php', $dataStaticPages);

        $InsertStaticPagesItems  = str_replace( '{STATIC_PAGES_ITEMS}', $TemplateStaticPagesItems, $InsertStatic_Page );

        $Login = new LoginController();
        $InsertLogin = str_replace( '{LOGIN}', $Login::login(), $InsertStaticPagesItems );

        return $InsertLogin;
    }

    public function actionArticles(): string
    {
        $this->CheckAccess();

        $viewAdmin_Panel = new View();
        $TemplateAdmin_Panel = $viewAdmin_Panel->display( ADMIN_TEMPLATES_DIR . 'Admin_PanelController.php');

        $viewBooks = new View();
        $TemplateBooks =  $viewBooks->display( ADMIN_TEMPLATES_DIR . 'Articles.php');

        $InsertStatic_Page  = str_replace( '{CONTENT}', $TemplateBooks, $TemplateAdmin_Panel );

        $viewBooks_Items = new View();
        $dataBooks = ArticleModel::showAll();

        $TemplateStaticPagesItems = $viewBooks_Items->render( ADMIN_TEMPLATES_DIR . 'Article_item.php', $dataBooks);

        $InsertStaticPagesItems  = str_replace( '{BOOKS_ITEMS}', $TemplateStaticPagesItems, $InsertStatic_Page );

        $Login = new LoginController();
        $InsertLogin = str_replace( '{LOGIN}', $Login::login(), $InsertStaticPagesItems );

        return $InsertLogin;
    }


}
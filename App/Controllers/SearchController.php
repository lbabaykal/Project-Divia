<?php
namespace App\Controllers;

use App\Controller;
use App\Models\SearchModel;
use App\View;


class SearchController extends Controller
{
    public function actionIndex()
    {
        $SearchSting = htmlspecialchars(strip_tags(trim($_GET['search'])));

        $viewMain = new View();
        $TemplateMain = $viewMain->display(TEMPLATES_DIR . 'Main.php');

        $viewChapters_Articles =  new View();
        $TemplateChapters_Articles = $viewChapters_Articles->display(TEMPLATES_DIR . 'Chapters_Short_Articles.php');

        if ( $SearchSting == '') {
            $AnsverSearch = '<h1 style="margin: 0 auto;">ПУСТО</h1>';
        }
        else {
            $viewSearch = new View();
            $dataSearch = SearchModel::SearchArticles($SearchSting);

            if ( count($dataSearch) > 0 ) {
                $AnsverSearch = $viewSearch->render(TEMPLATES_DIR . 'Short_Article.php', $dataSearch);
            } else {
                $AnsverSearch = '<h1 style="margin: 0 auto;">ПУСТО</h1>';
            }
        }

        $InsertAnsverSearch = str_replace( '{CHAPTER}', $AnsverSearch, $TemplateChapters_Articles );

        $InsertChapters = str_replace( '{CONTENT}', $InsertAnsverSearch, $TemplateMain );

        $Login = new LoginController();
        $InsertLogin = str_replace( '{LOGIN}', $Login::login(), $InsertChapters );

        return $InsertLogin;
    }
}

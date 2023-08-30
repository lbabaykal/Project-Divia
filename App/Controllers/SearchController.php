<?php
namespace App\Controllers;

use App\App;
use App\Controller;
use App\Models\SearchModel;
use App\View;

class SearchController extends Controller
{
    //====Not Working====
    public function actionIndex()
    {
        var_dump($_GET);
        echo '<br>';

        //$SearchText = $this->sanitizeString($_GET['search']);

        $dataSearchArticles = SearchModel::getSearchArticles('kek');
//        $dataSearchArticles = SearchModel::getSearchArticles($SearchText);
        if ( !$dataSearchArticles ) {
            return '<h1 style="margin: 0 auto;">ПУСТО</h1>';
        }

        $templateSearchArticles = (new View)->render(TEMPLATES_DIR . '/Short_Article', $dataSearchArticles);

        $DataMain = [
            'title'=> App::getConfigSite('site_name') . '🔍Поиск🔎',
            'description'=> '',
            'template'=> App::getConfigSite('dir_template'),
            'login'=> LoginController::login(),
            'CONTENT'=> $templateSearchArticles,
        ];
        return (new View)->render_v3(TEMPLATES_DIR . '/Main', $DataMain);
    }
}

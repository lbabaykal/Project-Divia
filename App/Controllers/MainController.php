<?php

namespace App\Controllers;

use App\App;
use App\Controller;
use App\Models\MainModel;
use App\View;

class MainController extends Controller
{

    public function actionIndex()
    {
//        $Cdb = Cdb::getInstance();
//        $sql1 = "SELECT *
//                FROM articles
//                WHERE id_article = 61";
//        $sql1 = $Cdb->queryFetch($sql1);
//        echo '<pre>';
//
//        $sql2 = "SELECT *
//                FROM article_category
//                INNER JOIN category
//                ON article_category.id_category = category.id_category
//                WHERE article_category.id_article = 61";
//        $sql2 = $Cdb->queryFetchAll($sql2);
//        echo '<pre>';
//        var_dump($_SERVER);
//        var_dump($sql1);
//        var_dump($sql2);
//        die;

        $DataMain = [
            'title' => App::getConfigSite('site_name'),
            'description' => $this->limitterDesc(App::getConfigSite('site_description')),
            'template' => App::getConfigSite('dir_template'),
            'login' => LoginController::login()
        ];

        if (App::getConfigSite('main_page') === 'custom') {
            $templateArticleAnime = (new View)->render(TEMPLATES_DIR . '/Short_Article', MainModel::showArticlesCustom('anime'));
            $templateArticleDorams = (new View)->render(TEMPLATES_DIR . '/Short_Article', MainModel::showArticlesCustom('dorams'));
            $templateArticleManga = (new View)->render(TEMPLATES_DIR . '/Short_Article', MainModel::showArticlesCustom('manga'));
            $DataCustomMain = [
                'ANIME_SHORT_ARTICLE' => $templateArticleAnime,
                'DORAMS_SHORT_ARTICLE' => $templateArticleDorams,
                'MANGA_SHORT_ARTICLE' => $templateArticleManga
            ];
            $templateCustomMain = (new View)->render_v3(TEMPLATES_DIR . '/Custom_Main', $DataCustomMain);

            $DataMain += [
                'CONTENT' => $templateCustomMain
            ];
        } else {
            $templateShortArticle = (new View)->render(TEMPLATES_DIR . '/Short_Article', MainModel::showArticles());
            $DataMain += [
                'CONTENT' => $templateShortArticle
            ];
        }
        return (new View)->render_v3(TEMPLATES_DIR . '/Main', $DataMain);
    }

}
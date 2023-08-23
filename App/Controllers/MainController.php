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
        $DataMain = [
            'title'=> '🌸' . App::getConfigSite('site_name') . '🌸',
            'description'=> App::getConfigSite('site_description'),
            'template'=> App::getConfigSite('dir_template'),
            'login'=> LoginController::login(),
            ];

        if (App::getConfigSite('main_page') === 'custom') {
            $templateArticleAnime = (new View)->render(TEMPLATES_DIR . '/Short_Article', MainModel::showArticlesCustom('anime'));
            $templateArticleDorams = (new View)->render(TEMPLATES_DIR . '/Short_Article', MainModel::showArticlesCustom('dorams'));
            $templateArticleManga = (new View)->render(TEMPLATES_DIR . '/Short_Article', MainModel::showArticlesCustom('manga'));
            $DataCustomMain = [
                'ANIME_SHORT_ARTICLE'=> $templateArticleAnime,
                'DORAMS_SHORT_ARTICLE'=> $templateArticleDorams,
                'MANGA_SHORT_ARTICLE'=> $templateArticleManga,
            ];
            $templateCustomMain =  (new View)->render_v3(TEMPLATES_DIR . '/Custom_Main', $DataCustomMain, []);

            $DataMain += [
                'CONTENT'=> $templateCustomMain,
            ];
        } else {
            $templateShortArticle = (new View)->render(TEMPLATES_DIR . '/Short_Article', MainModel::showArticles());
            $DataMain += [
                'CONTENT'=> $templateShortArticle,
            ];
        }

        return (new View)->render_v3(TEMPLATES_DIR . '/Main', $DataMain, []);
    }

}
<?php

namespace App\Controllers;

use App\App;
use App\Controller;
use App\Models\ChapterModel;
use App\View;

class ChapterController extends Controller
{
    public function actionIndex()
    {
        $chapter_name = $this->route['chapter_name'];
        $dataChapter = ChapterModel::dataChapter($chapter_name);
        if ( !$dataChapter ) {
            $this->Not_Found_404();
        }

        $templateChapter = (new View)->render(TEMPLATES_DIR . '/Short_Article', ChapterModel::showArticlesChapter($chapter_name));

        $DataMain = [
            'title'=> '🌸' . App::getConfigSite('site_name') . '🌸' . $dataChapter['chapter_name'] . '☘︎',
            'description'=> $this->limitterDesc($dataChapter['description']),
            'template'=> App::getConfigSite('dir_template'),
            'login'=> LoginController::login(),
            'CONTENT'=> $templateChapter,
        ];
        return (new View)->render_v3(TEMPLATES_DIR . '/Main', $DataMain);
    }

    public function actionPage() {
        $chapter_name = $this->route['chapter_name'];
        $chapter_page = $this->route['page'];
        return "Chapter - {$chapter_name}<br> Page - {$chapter_page}";
    }

}
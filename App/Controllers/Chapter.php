<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Chapter as Model_Chapter;
use App\View;

class Chapter extends Controller
{

    public function actionIndex() {
        if (empty($_GET['chapter_name_eng'])) {
            $this->Not_Found_404();
        }

        $chapter_name = $this->sanitizeString($_GET['chapter_name_eng']);

        if ( !Model_Chapter::checkChapter($chapter_name) ) {
            $this->Not_Found_404();
        }

        $viewMain = new View();
        $dataMain = $viewMain->display(TEMPLATES_DIR . 'Main.php');

        $viewChapterFull = new View();
        $dataChapter = Model_Chapter::showChapter($chapter_name);
        $AnsverChapterFull = $viewChapterFull->render(TEMPLATES_DIR . 'Chapters_Short_Articles.php', $dataChapter);

        $Ansver = str_replace( '{CONTENT}', $AnsverChapterFull, $dataMain );

        $viewChapter = new View();
        $dataChapter = Model_Chapter::showArticles($chapter_name);
        $dataChapter = $viewChapter->render( TEMPLATES_DIR . 'Short_Article.php', $dataChapter);

        $Ansver = str_replace( '{CHAPTER}', $dataChapter, $Ansver );

        $Login = new Login();
        $Ansver = str_replace( '{LOGIN}', $Login::login(), $Ansver );

        return $Ansver;
    }
}
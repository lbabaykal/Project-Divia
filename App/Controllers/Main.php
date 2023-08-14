<?php

namespace App\Controllers;

use App\Controller;
use App\View;

class Main extends Controller
{

    public function actionIndex()
    {
        $viewMain = new View();
        $dataMain = $viewMain->display(TEMPLATES_DIR . 'Main.php');

        $AnsverAllChapter = \App\Models\Main::showAllChapter();


        $lol = '';
        foreach ($AnsverAllChapter as $Chapters) {

            $viewChapters = new View();
            $dataChapters = $viewChapters->display( TEMPLATES_DIR . 'Chapter_Article.php');
            $ChangeID = str_replace( '{ID_CHAPTER}', $Chapters->id_chapter, $dataChapters );
            $ChangeName = str_replace( '{NAME}', $Chapters->chapter_name, $ChangeID );

                $viewChapter = new View();
                $dataChapter = \App\Models\Main::showMainPage( $Chapters->id_chapter );
                $RenderChapter = $viewChapter->render( TEMPLATES_DIR . 'Short_Article.php', $dataChapter);

                $lol .= $ChangeChapter = str_replace( '{CHAPTER}', $RenderChapter, $ChangeName );
        }

        $viewMain_Chapters_Articles = new View();
        $dataMain_Chapters_Articles = $viewMain_Chapters_Articles->display(TEMPLATES_DIR . 'Chapters_Articles.php');

        $ChangeChapters = str_replace( '{CHAPTERS}', $lol, $dataMain_Chapters_Articles );


        $InsertContent = str_replace( '{CONTENT}', $ChangeChapters, $dataMain );

        $Login = new Login();
        $Ansver = str_replace( '{LOGIN}', $Login::login(), $InsertContent );
        return $Ansver;
    }

}
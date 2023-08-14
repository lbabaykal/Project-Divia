<?php

namespace App\Controllers;

use App\Controller;
use App\Models\My_Favorites;
use App\View;

class My_Profile extends Controller
{

    public function actionIndex()
    {
        $this->CheckUser();
        $view_Main = new View();
        $template_Main = $view_Main->display(TEMPLATES_DIR . 'Main.php');

        $view_My_Profile = new View();
        $data_My_Profile = \App\Models\My_Profile::showUser_Profile();
        $template_My_Profile = $view_My_Profile->render(TEMPLATES_DIR . 'My_Profile.php', $data_My_Profile);

        $Ansver = str_replace( '{CONTENT}', $template_My_Profile, $template_Main );

        $Login = new Login();
        $Ansver = str_replace( '{LOGIN}', $Login::login(), $Ansver );

        return $Ansver;
    }

    public function actionMy_Favorites()
    {
        $this->CheckUser();
        $view_Main = new View();
        $template_Main = $view_Main->display(TEMPLATES_DIR . 'Main.php');

        $view_My_Favorites = new View();
        $template_My_Favorites = $view_My_Favorites->display(TEMPLATES_DIR . 'My_Favorites.php');

        $view_My_Favorites_Item = new View();
        $data_My_Favorites_Item = My_Favorites::showUser_Favourites();

        $template_My_Favorites_Item = $view_My_Favorites_Item->render(TEMPLATES_DIR . 'My_Favorites_Item.php', $data_My_Favorites_Item);

        $Insert_My_Favorites_Item = str_replace( '{MY_FAVOURITE_ITEMS}', $template_My_Favorites_Item,  $template_My_Favorites);

        $Insert_My_Favorites = str_replace( '{CONTENT}', $Insert_My_Favorites_Item, $template_Main );

        $Login = new Login();
        $Ansver = str_replace( '{LOGIN}', $Login::login(), $Insert_My_Favorites );

        return $Ansver;
    }

    public function actionSettings()
    {
        $this->CheckUser();
        $view_Main = new View();
        $template_Main = $view_Main->display(TEMPLATES_DIR . 'Main.php');

        $Insert_My_Books = str_replace( '{CONTENT}', 'SETTINGS', $template_Main );

        $Login = new Login();
        $Ansver = str_replace( '{LOGIN}', $Login::login(), $Insert_My_Books );

        return $Ansver;
    }


}
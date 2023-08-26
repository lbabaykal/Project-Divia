<?php

namespace App\Controllers;

use App\App;
use App\Controller;
use App\Models\FavoritesModel;
use App\View;

class My_ProfileController extends Controller
{

    public function actionIndex()
    {
        $this->CheckUser();
        $dataUser = UserController::getData();

        $DataMain = [
            'title' => '🌸' . App::getConfigSite('site_name') . '🌸' . $dataUser['nickname'] . '🍓',
            'description' => '',
            'template' => App::getConfigSite('dir_template'),
            'login' => LoginController::login()
        ];

        $templateShortArticle = (new View)->render_v3(TEMPLATES_DIR . '/My_Profile', $dataUser);

        $DataMain += [
            'CONTENT' => $templateShortArticle
        ];
        return (new View)->render_v3(TEMPLATES_DIR . '/Main', $DataMain);
    }

    public function actionMy_Favorites(): false|string
    {
        $this->CheckUser();
        $dataUser = UserController::getData();
        $DataMain = [
            'title' => '🌸' . App::getConfigSite('site_name') . '🌸' . 'Избранное' . '💖︎',
            'description' => '',
            'template' => App::getConfigSite('dir_template'),
            'login' => LoginController::login()
        ];

        $templateFavoritesAnime = (new View)->render(TEMPLATES_DIR . '/My_Favorites_Item', FavoritesModel::getFavouritesUser('anime'));
        $templateFavoritesDorams = (new View)->render(TEMPLATES_DIR . '/My_Favorites_Item', FavoritesModel::getFavouritesUser('dorams'));
        $templateFavoritesManga = (new View)->render(TEMPLATES_DIR . '/My_Favorites_Item', FavoritesModel::getFavouritesUser('manga'));
        $templateMy_Favorites = (new View)->render_v3(TEMPLATES_DIR . '/My_Favorites', $dataUser);

        $DataMain += [
            'CONTENT' => $templateMy_Favorites,
            'FAVOURITES_ANIME' => $templateFavoritesAnime,
            'FAVOURITES_MANGA' => $templateFavoritesManga,
            'FAVOURITES_DORAMS' => $templateFavoritesDorams
        ];
        return (new View)->render_v3(TEMPLATES_DIR . '/Main', $DataMain);
    }

    public function actionSettings(): false|string
    {
        $this->CheckUser();
        $dataUser = UserController::getData();

        $DataMain = [
            'title' => '🌸' . App::getConfigSite('site_name') . '🌸' . 'Настройки' . '⚙🛠',
            'description' => '',
            'template' => App::getConfigSite('dir_template'),
            'login' => LoginController::login()
        ];

        $templateMy_Favorites = (new View)->render_v3(TEMPLATES_DIR . '/My_Settings', $dataUser);

        $DataMain += [
            'CONTENT' => $templateMy_Favorites,

        ];
        return (new View)->render_v3(TEMPLATES_DIR . '/Main', $DataMain);
    }

}
<?php

namespace App\Controllers;

use App\App;
use App\Controller;
use App\Extensions\Image;
use App\Models\ArticleModel;
use App\View;

class ArticleController extends Controller
{
    public function actionIndex()
    {
        $id_article = $this->route['id_article'];

        $dataArticle = ArticleModel::getDataArticle($id_article);
        if (!$dataArticle) {
            return $this->Not_Found_404();
        }

        $templateRating = RatingController::showRating($id_article, $dataArticle['allow_rating']);
        $templateMy_Favorite = FavoritesController::checkFavouriteUser($id_article);
        $templateComments = CommentsController::showComments($id_article, $dataArticle['allow_comment']);
        $templateAdd_Comment = CommentsController::showAddComments();
        $dataArticle += [
            'RATING_ARTICLE'=> $templateRating,
            'FAVOURITE_ARTICLE'=> $templateMy_Favorite,
            'COMMENTS_ARTICLE'=> $templateComments,
            'ADD_COMMENT'=> $templateAdd_Comment,
        ];

        $dataArticleNo = [
            'ADD_COMMENTS'=> UserController::getStatus() && $dataArticle['allow_comment'],
        ];

        $TemplateFull_Article =(new View)->render_v3(TEMPLATES_DIR . '/Full_Article', $dataArticle, $dataArticleNo);

        $dataMain = [
            'title'=> App::getConfigSite('site_name') . $dataArticle['title'] . '🔥︎',
            'description'=> $this->limitterDesc($dataArticle['description']),
            'template'=> App::getConfigSite('dir_template'),
            'login'=> LoginController::login(),
            'CONTENT'=> $TemplateFull_Article,
        ];
        return (new View)->render_v3(TEMPLATES_DIR . '/Main', $dataMain);
    }

    //================TEMPLATES================
    public function actionTemplate_Article_Add(): false|string
    {
        $this->CheckAccess();

        $templateSelect = '';
        $allChapter = ArticleModel::getChapters();
        foreach ($allChapter as $key => $value) {
            $templateSelect  .= '<option value="' . $value['id_chapter'] . '">' . $value['chapter_name'] . '</option>';
        }

        $templateCheckbox = '';
        $allCategory = ArticleModel::getCategories();
        foreach ($allCategory as $key => $value) {
            $templateCheckbox   .= '<option value="' . $value['id_category'] . '">' . $value['category_name'] . '</option>';
        }

        $dataArticle = [
            'SELECT'=> $templateSelect,
            'CHECKBOX'=> $templateCheckbox,
        ];
        return (new View)->render_v3(ADMIN_TEMPLATES_DIR . '/AJAX/Article_Add', $dataArticle);
    }

    public function actionTemplate_Article_Edit(): false|string
    {
        $this->CheckAccess();
        $id_article = $this->sanitizeInt($_POST['id_article']);
        if (!is_numeric($id_article)) {
            $this->Not_Found_404();
        }
        $dataArticle = ArticleModel::getDataArticle($id_article);

        $templateSelect = '';
        $allChapter = ArticleModel::getChapters();
        foreach ($allChapter as $key => $value) {
            $templateSelect  .= '<option value="' . $value['id_chapter'] . '" ';
            if ( $value['id_chapter'] == $dataArticle['chapter'] ) {
                $templateSelect .= 'selected';
            }
            $templateSelect  .= ' >' . $value['chapter_name'] . '</option>';
        }

        $CategoryBook = explode(',', $dataArticle['category']);
        $templateCheckbox = '';
        $allCategory = ArticleModel::getCategories();
        foreach ($allCategory as $key => $value) {
            $templateCheckbox   .= '<option value="' . $value['id_category'] . '" ';
            if ( in_array($value['id_category'], $CategoryBook) ) {
                $templateCheckbox .= 'selected';
            }
            $templateCheckbox .= '>' . $value['category_name'] . '</option>';
        }

        $dataArticle += [
            'SELECT'=> $templateSelect,
            'CHECKBOX'=> $templateCheckbox,
        ];
        return (new View)->render_v3(ADMIN_TEMPLATES_DIR . '/AJAX/Article_Edit', $dataArticle);
    }

    public function actionTemplate_Article_Delete(): false|string
    {
        $this->CheckAccess();
        $id_article = $this->sanitizeInt($_POST['id_article']);
        if (!is_numeric($id_article)) {
            $this->Not_Found_404();
        }
        return (new View)->render_v3(ADMIN_TEMPLATES_DIR . '/AJAX/Article_Delete', ArticleModel::getDataArticle($id_article));
    }

    //================ACTIONS================
    public function actionArticle_Add(): string
    {
        $this->CheckAccess();
        $answer = [ 'success' => 'No'];

        if ( !empty($_POST) ) {
            extract($_POST, EXTR_SKIP);

            $category = array_key_exists( 'category', $_POST) ? $_POST['category'] : [];

            if ( isset($title, $title_eng, $chapter, $category, $description) ) {
                $title = $this->sanitizeString($title);
                $title_eng = $this->sanitizeString($title_eng);
                $id_author = UserController::getDataField('id_user');
                $description = $this->sanitizeString($description);

                $chapter = $chapter == '' ? 0 : $this->sanitizeInt($chapter);
                $category = implode(',', $category);

                if ( mb_strlen($title) < 1 OR mb_strlen($title) > 100 ) {
                    $answer['text'] = 'Введите название';
                }
                elseif ( mb_strlen($title_eng) < 1 OR mb_strlen($title_eng) > 100 ) {
                    $answer['text'] = 'Введите название на английском';
                }
                elseif ( $chapter === 0 ) {
                    $answer['text'] = 'Выберите Раздел';
                }
                elseif ( $category == '' ) {
                    $answer['text'] = 'Выберите Жанр';
                }
                elseif ( mb_strlen($description) > 4000 ) {
                    $answer['text'] = 'Описание не должно превышать 4000 символов.';
                }
                else {
                    if (!is_uploaded_file($_FILES['image']['tmp_name'])) {
                        $PathFileBD = 'no_image.png';
                    }
                    elseif ($_FILES['image']['size'] > App::getConfigSite('image_size')) {
                        $answer['text'] = 'Изображение должно весить меньше 1Мб.';
                        return json_encode($answer);
                    }
                    elseif (!in_array($_FILES['image']['type'], ['image/png', 'image/jpeg'])) {
                        $answer['text'] = 'Изображение должно иметь расширение .png, .jpeg, .jpg';
                        return json_encode($answer);
                    }
                    else {
                        $Image = new Image();
                        $PathFileBD = $Image->saveForArticle();
                    }

                    $dateNow = date('Y-m-d h:i:s');
                    $sql1 = "INSERT INTO articles
                    (image, title, title_eng, id_author, chapter, category, description, date)
                    VALUES
                    ( '$PathFileBD', '$title', '$title_eng', '$id_author', '$chapter', '$category', '$description', '$dateNow')
                    ";
                    $sql2 = "INSERT INTO rating
                    (id_article, rating, count_assessments)
                    VALUES
                    ( LAST_INSERT_ID(), '0', '0')";

                    ArticleModel::save($sql1, $sql2);
                    $answer = ['success' => 'Yes', 'text' => 'Статья добавлена!'];
                }
            }
            else {
                $answer['text'] = 'Проблемы с отправленными данными.';
            }
        }
        else {
            $answer['text'] = 'Проблемы работы AJAX.';
        }
        return json_encode($answer);
    }

    public function actionArticle_Edit(): string
    {
        $this->CheckAccess();
        $answer = [ 'success' => 'No'];

        if ( !empty($_POST) ) {
            extract($_POST, EXTR_SKIP);

            $category = array_key_exists( 'category', $_POST) ? $_POST['category'] : [];

            if ( isset($id_article, $title, $title_eng, $chapter, $category, $description) ) {
                $title = $this->sanitizeString($title);
                $title_eng = $this->sanitizeString($title_eng);
                $id_author = UserController::getDataField('id_user');
                $description = $this->sanitizeString($description);

                $id_article = $this->sanitizeInt($id_article);
                $chapter = $chapter == '' ? 0 : $this->sanitizeInt($chapter);
                $category = implode(',', $category);

                if ( mb_strlen($title) < 1 OR mb_strlen($title) > 100 ) {
                    $answer['text'] = 'Введите Название';
                }
                elseif ( mb_strlen($title_eng) < 1 OR mb_strlen($title_eng) > 100 ) {
                    $answer['text'] = 'Введите Оригинальное название';
                }
                elseif ( !is_numeric($chapter) ) {
                    $answer['text'] = 'Выберите Раздел';
                }
                elseif ( $category == '' ) {
                    $answer['text'] = 'Выберите Жанр';
                }
                elseif ( mb_strlen($description) > 4000 ) {
                    $answer['text'] = 'Описание не должно превышать 4000 символов.';
                }
                else {
                    $dataSet = [
                        'title' => $title,
                        'title_eng' => $title_eng,
                        'id_author' => $id_author,
                        'chapter' => $chapter,
                        'category' => $category,
                        'description' => $description,
                        'date' => date('Y-m-d h:i:s'),
                    ];

                    if (!is_uploaded_file($_FILES['image']['tmp_name'])) {
                        ArticleModel::updateWithoutImage($dataSet, ['id_article' => $id_article]);
                        $answer = ['success' => 'Yes', 'text' => 'Статья успешно обновлена!'];
                        return json_encode($answer);
                    }
                    elseif ($_FILES['image']['size'] > App::getConfigSite('image_size')) {
                        $answer['text'] = 'Изображение должно весить меньше 1Мб.';
                        return json_encode($answer);
                    }
                    elseif (!in_array($_FILES['image']['type'], ['image/png', 'image/jpeg'])) {
                        $answer['text'] = 'Изображение должно иметь расширение .png, .jpeg, .jpg';
                        return json_encode($answer);
                    }
                    else {
                        $dataArticle = ArticleModel::getDataArticle($id_article);
                        $Image = new Image();
                        $PathFileBD = $Image->updateForArticle($dataArticle['image']);

                        ArticleModel::updateWithImage($dataSet + ['image' => $PathFileBD], ['id_article' => $id_article]);
                        $answer = ['success' => 'Yes', 'text' => 'Статья успешно обновлена!'];
                    }
                }
            }
            else {
                $answer['text'] = 'Проблемы с отправленными данными.';
            }
        }
        else {
            $answer['text'] = 'Проблемы работы AJAX.';
        }
        return json_encode($answer);
    }

    public function actionArticle_Delete(): string
    {
        $this->CheckAccess();
        $answer = [ 'success' => 'No'];

        if (!empty($_POST)) {
            extract($_POST, EXTR_SKIP);

            if ( isset($id_article) ) {
                $id_article = $this->sanitizeInt($id_article);
                $dataArticle = ArticleModel::getDataArticle($id_article);
                if ( $dataArticle ) {
                    ArticleModel::delete($id_article);
                    $Image = new Image();
                    $Image->deleteForArticle($dataArticle['image']);
                    $answer = ['success' => 'Yes', 'text' => 'Статья успешно удалена!'];
                }
                else {
                    $answer['text'] = 'Такой статьи не существует!';
                }
            }
            else {
                $answer['text'] = 'Проблемы с отправленными данными.';
            }
        }
        else {
            $answer['text'] = 'Проблемы работы AJAX.';
        }
        return json_encode($answer);
    }

}
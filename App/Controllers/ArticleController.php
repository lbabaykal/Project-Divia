<?php

namespace App\Controllers;

use App\Cdb;
use App\Controller;
use App\View;
use App\Models\CommentsModel;
use App\Models\ArticleModel;

class ArticleController extends Controller
{
    public function actionIndex()
    {
        $id_article = $this->route['slug'];

        if (ArticleModel::checkIdBook($id_article)) {

            $viewMain = new View();
            $TemplateMain = $viewMain->display(TEMPLATES_DIR . 'Main.php');

            $viewBook = new View();
            $dataBook = ArticleModel::showOne($id_article);

            $TemplateBook = $viewBook->render(TEMPLATES_DIR . 'Full_Article.php', $dataBook);

            $dataRating = RatingController::showRating($id_article);
            $InsertRating = str_replace( '{RATING_ARTICLE}', $dataRating, $TemplateBook );

            $My_Favorites = new My_FavoritesController();
            $InsertMy_List = str_replace( '{MY_LIST}', $My_Favorites::checkFavourite($id_article), $InsertRating );

            $InsertContent = str_replace( '{CONTENT}', $InsertMy_List, $TemplateMain );

            $viewComments = new View();
            $dataComments = CommentsModel::showComments($id_article);
            $TemplateComments = $viewComments->render(TEMPLATES_DIR . 'Comment.php', $dataComments);


            $Answer = str_replace( '{COMMENTS}', $TemplateComments, $InsertContent );

            $viewAdd_Comment = new View();
            $dataAdd_Comment = $viewAdd_Comment->display( TEMPLATES_DIR . 'Add_Comment.php');

            if ( !isset($_SESSION['sessionUserData']) ) {
                $Answer = str_replace( '{ADD_COMMENT}', '', $Answer );
            }
            else {
                $Answer = str_replace( '{ADD_COMMENT}', $dataAdd_Comment, $Answer );
            }

            $Login = new LoginController();
            $InsertLogin = str_replace( '{LOGIN}', $Login::login(), $Answer );

            return $InsertLogin;

        } else {
            return $this->Not_Found_404();
        }
    }

    public function actionTemplate_Article_Add(): string
    {
        $this->CheckAccess();
        $viewBA = new View();
        $templateBA =  $viewBA->display(ADMIN_TEMPLATES_DIR . '/AJAX/Article_Add.php');

        $select = '';
        $allChapter = ArticleModel::showChapters();
        foreach ($allChapter as $key => $value) {
            $select  .= '<option value="' . $value['id_chapter'] . '">' . $value['chapter_name'] . '</option>';
        }

        $checkbox = '';
        $allCategory = ArticleModel::showCategories();
        foreach ($allCategory as $key => $value) {
            $checkbox   .= '<option value="' . $value['id_category'] . '">' . $value['category_name'] . '</option>';
        }

        $InsertSelect = str_replace( '{SELECT}', $select, $templateBA );
        $InsertCheckbox = str_replace( '{CHECKBOX}', $checkbox, $InsertSelect );

        return $InsertCheckbox;
    }

    public function actionArticle_Add(): string
    {
        $this->CheckAccess();

        $answer['success'] = $success = 'No';

        if ( !empty($_POST) ) {
            extract($_POST, EXTR_SKIP);

            if (array_key_exists( 'category', $_POST) ) {
                $category = $_POST['category'];
            }
            else {
                $category = [];
            }

            if ( isset($title, $title_eng, $author, $chapter, $category, $description) ) {
                $title = $this->sanitizeString($title);
                $title_eng = $this->sanitizeString($title_eng);
                $id_author = $_SESSION['sessionUserData']['id_user'];
                $description = $this->sanitizeString($description);

                $chapter = preg_replace('/[+-]/u', '', filter_var($chapter,  FILTER_SANITIZE_NUMBER_INT));
                $category = implode(',', $category);

                if ( mb_strlen($title) < 1 OR mb_strlen($title) > 100 ) {
                    $textData = 'Введите Название';
                }
                elseif ( mb_strlen($title_eng) < 1 OR mb_strlen($title_eng) > 100 ) {
                    $textData = 'Введите Оригинальное название';
                }
                elseif ( !is_numeric($chapter) ) {
                    $textData = 'Выберите Раздел';
                }
                elseif ( $category == '' ) {
                    $textData = 'Выберите Жанр';
                }
                elseif ( mb_strlen($description) < 1 ) {
                    $textData = 'Введите Описание';
                }
                elseif ( mb_strlen($description) > 2000 ) {
                    $textData = 'Описание не должно превышать 2000 символов';
                }
                else {
                    if ( empty($_FILES['image']['tmp_name']) === true ) {
                        $FinalFileName = 'no_image.png';
                    }
                    else {
                        if ( !is_uploaded_file($_FILES['image']['tmp_name']) ) {
                            $textData = 'Изображение не загруженно';
                        }
                        elseif ( $_FILES['image']['size'] == 0 ) {
                            $textData = 'Изображение не выбрано';
                        }
                        elseif ( $_FILES['image']['size'] > 1024000 ) {
                            $textData = 'Изображение должно весить меньше 1Мб';
                        }                elseif ( !in_array($_FILES['image']['type'], ['image/png', 'image/jpeg']) ) {
                            $textData = 'Изображение должно иметь расширение .png, .jpeg, .jpg';
                        }
                        else {
                            $fileName = pathinfo(basename($_FILES['image']['name']));
                            $expansionFile = $fileName['extension'];

                            if (!is_dir($_SERVER["DOCUMENT_ROOT"] . '/images/articles_images/' . date('Y-m') )) {
                                mkdir( $_SERVER["DOCUMENT_ROOT"] . '/images/articles_images/' . date('Y-m'), 0700);
                            }
                            if (!is_dir($_SERVER["DOCUMENT_ROOT"] . '/images/articles_images_medium/' . date('Y-m') )) {
                                mkdir( $_SERVER["DOCUMENT_ROOT"] . '/images/articles_images_medium/' . date('Y-m'), 0700);
                            }

                            $newFileName = bin2hex(random_bytes(5)) . '.' . $expansionFile;
                            $FinalFileName = date('Y-m') . '/' . $newFileName;
                            $uploadDIR = $_SERVER["DOCUMENT_ROOT"] . '/images/articles_images/' . $FinalFileName;
                            $uploadDIRMedium = $_SERVER["DOCUMENT_ROOT"] . '/images/articles_images_medium/'  . $FinalFileName;

                            switch ($_FILES['image']['type']) {
                                case 'image/png':
                                    $image = imageCreateFromPng( $_FILES['image']['tmp_name'] );
                                    imagePng( imagescale( $image, 280 ), $uploadDIRMedium, 1 );
                                    break;
                                case 'image/jpeg':
                                    $image = imageCreateFromJpeg( $_FILES['image']['tmp_name'] );
                                    imageJpeg( imagescale( $image, 280 ), $uploadDIRMedium, 80 );
                                    break;
                            }
                            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDIR);
                        }
                    }

                    $dateNow = date('Y-m-d h:i:s');
                    $sql1 = "INSERT INTO articles
                    (`image`, `title`, `title_eng`, `author`, `chapter`, `category`, `description`, `date`)
                    VALUES
                    ( '$FinalFileName', '$title', '$title_eng', '$id_author', '$chapter', '$category', '$description', '$dateNow')
                    ";
                    $sql2 = "INSERT INTO rating
                    (`id_article`, `rating`, `count_assessments`)
                    VALUES
                    ( LAST_INSERT_ID(), '0', '0')";
                    $db = new Cdb();
                    $db->transact([$sql1, $sql2]);

                    $success = 'Yes';
                    $textData = 'Книга успешно добавлена!';
                }
            }
            else {
                $textData = 'Проблемы с отправленными данными';
            }
        }
        else {
            $textData = 'Проблемы работы AJAX';
        }
        $answer = [ "success" => $success, "text" => $textData ];

        return json_encode($answer);
    }

    public function actionTemplate_Article_Delete()
    {
        $this->CheckAccess();
        $id_BE = filter_var($_POST['id_article'], FILTER_SANITIZE_NUMBER_INT);
        if (!is_numeric($id_BE)) {
            $this->Not_Found_404();
        }
        $viewBE = new View();
        $dataBE = ArticleModel::showOne($id_BE);
        return $viewBE->render(ADMIN_TEMPLATES_DIR . 'AJAX/Article_Delete.php', $dataBE);
    }

    public function actionArticle_Delete(): string
    {
        $this->CheckAccess();

        $answer['success'] = $success = 'No';

        if (!empty($_POST)) {
            extract($_POST, EXTR_SKIP);

            if ( !isset($id_article) ) {
                $textData = 'Проблемы с отправленными данными';
            }
            else {
                $id_article = preg_replace('/[+-]/u', '', filter_var($id_article, FILTER_SANITIZE_NUMBER_INT));
                $dataArticle = ArticleModel::showOne($id_article);
                if ( $dataArticle ) {
                    $sql1 = "DELETE FROM articles WHERE id_article=" . $id_article;
                    $sql2 = "DELETE FROM rating WHERE id_article=" . $id_article;
                    $sql3 = "DELETE FROM rating_assessment WHERE id_article=" . $id_article;
                    $db = new Cdb();
                    $db->transact( [$sql1, $sql2, $sql3] );

                    if ($dataArticle['image'] != 'no_image.png') {
                        unlink( $_SERVER["DOCUMENT_ROOT"] . '/images/articles_images/' .  $dataArticle['image']);
                        unlink( $_SERVER["DOCUMENT_ROOT"] . '/images/articles_images_medium/' .  $dataArticle['image']);
                    }
                    $success = 'Yes';
                    $textData = 'Книга успешно удалена!';
                }
                else {
                    $textData = 'Такой Книги не существует!';
                }
            }
        }
        else {
            $textData = 'Проблемы работы AJAX';
        }
        $answer = ["success" => $success, "text" => $textData];
        return json_encode($answer);
    }

    public function actionTemplate_Article_Edit(): string
    {
        $this->CheckAccess();
        $id_BE = filter_var($_POST['id_book'], FILTER_SANITIZE_NUMBER_INT);
        if (!is_numeric($id_BE)) {
            $this->Not_Found_404();
        }
        $viewBE = new View();
        $dataBE = ArticleModel::showOne($id_BE);
        $templateBA =  $viewBE->render(ADMIN_TEMPLATES_DIR . '/AJAX/Article_Edit.php', $dataBE);

        $select = '';
        $allChapter = ArticleModel::showChapters();
        foreach ($allChapter as $key => $value) {
            $select  .= '<option value="' . $value->id_chapter . '" ';
            if ( $value->id_chapter == $dataBE[0]->chapter ) {
                $select .= 'selected';
            }
            $select  .= ' >' . $value->chapter_name . '</option>';
        }

        $CategoryBook = explode(',', $dataBE[0]->category);
        $checkbox = '';
        $allCategory = ArticleModel::showCategories();
        foreach ($allCategory as $key => $value) {
            $checkbox   .= '<option value="' . $value->id_category . '" ';
            if ( in_array($value->id_category,$CategoryBook) ) {
                $checkbox .= 'selected';
            }
            $checkbox .= '>' . $value->category_name . '</option>';
        }

        $InsertSelect = str_replace( '{SELECT}', $select, $templateBA );
        $InsertCheckbox = str_replace( '{CHECKBOX}', $checkbox, $InsertSelect );

        return $InsertCheckbox;
    }

    public function actionArticle_Edit(): string
    {
        $this->CheckAccess();

        $answer['success'] = $success = 'No';

        if ( !empty($_POST) ) {
            extract($_POST, EXTR_SKIP);

            if (array_key_exists( 'category', $_POST) ) {
                $category = $_POST['category'];
            }
            else {
                $category = [];
            }

            if ( isset($id_book, $title, $title_eng, $id_author, $chapter, $category, $description) ) {
                $title = $this->sanitizeString($title);
                $title_eng = $this->sanitizeString($title_eng);
                $id_author = $_SESSION['sessionUserData']['id_user'];
                $description = $this->sanitizeString($description);

                $id_book = preg_replace('/[+-]/u', '', filter_var($id_book,  FILTER_SANITIZE_NUMBER_INT));
                $chapter = preg_replace('/[+-]/u', '', filter_var($chapter,  FILTER_SANITIZE_NUMBER_INT));
                $category = implode(',', $category);

                if ( mb_strlen($title) < 1 OR mb_strlen($title) > 100 ) {
                    $textData = 'Введите Название';
                }
                elseif ( mb_strlen($title_eng) < 1 OR mb_strlen($title_eng) > 100 ) {
                    $textData = 'Введите Оригинальное название';
                }
                elseif ( !is_numeric($chapter) ) {
                    $textData = 'Выберите Раздел';
                }
                elseif ( $category == '' ) {
                    $textData = 'Выберите Жанр';
                }
                elseif ( mb_strlen($description) < 1 ) {
                    $textData = 'Введите Описание';
                }
                elseif ( mb_strlen($description) > 2000 ) {
                    $textData = 'Описание не должно превышать 2000 символов';
                }
                else {
                    $dateNow = date('Y-m-d h:i:s');
                    $data = [
                        'id_article' => $id_book,
                        'title' => $title,
                        'title_eng' => $title_eng,
                        'id_author' => $id_author,
                        'chapter' => $chapter,
                        'category' => $category,
                        'description' => $description,
                        'date' => $dateNow
                    ];

                    if ( empty($_FILES['image']['tmp_name']) === false ) {
                        if ( !is_uploaded_file($_FILES['image']['tmp_name']) ) {
                            $textData = 'Изображение не загруженно';
                        }
                        elseif ( $_FILES['image']['size'] == 0 ) {
                            $textData = 'Изображение не выбрано';
                        }
                        elseif ( $_FILES['image']['size'] > 1024000 ) {
                            $textData = 'Изображение должно весить меньше 1Мб';
                        }                elseif ( !in_array($_FILES['image']['type'], ['image/png', 'image/jpeg']) ) {
                            $textData = 'Изображение должно иметь расширение .png, .jpeg, .jpg';
                        }
                        else {
                            $dataBook = ArticleModel::showOne($id_book);
                            if ( $dataBook[0]->image != 'no_image.png') {
                                if ( file_exists($_SERVER["DOCUMENT_ROOT"] . '/images/articles_images/' .  $dataBook[0]->image) ) {
                                    unlink( $_SERVER["DOCUMENT_ROOT"] . '/images/articles_images/' .  $dataBook[0]->image);
                                }
                                if ( file_exists($_SERVER["DOCUMENT_ROOT"] . '/images/articles_images_medium/' .  $dataBook[0]->image) ) {
                                    unlink( $_SERVER["DOCUMENT_ROOT"] . '/images/articles_images_medium/' .  $dataBook[0]->image);
                                }
                            }

                            $fileName = pathinfo(basename($_FILES['image']['name']));
                            $expansionFile = $fileName['extension'];

                            if (!is_dir($_SERVER["DOCUMENT_ROOT"] . '/images/articles_images/' . date('Y-m') )) {
                                mkdir( $_SERVER["DOCUMENT_ROOT"] . '/images/articles_images/' . date('Y-m'), 0700);
                            }
                            if (!is_dir($_SERVER["DOCUMENT_ROOT"] . '/images/articles_images_medium/' . date('Y-m') )) {
                                mkdir( $_SERVER["DOCUMENT_ROOT"] . '/images/articles_images_medium/' . date('Y-m'), 0700);
                            }

                            $newFileName = bin2hex(random_bytes(5)) . '.' . $expansionFile;
                            $FinalFileName = date('Y-m') . '/' . $newFileName;
                            $uploadDIR = $_SERVER["DOCUMENT_ROOT"] . '/images/articles_images/' . $FinalFileName;
                            $uploadDIRMedium = $_SERVER["DOCUMENT_ROOT"] . '/images/articles_images_medium/'  . $FinalFileName;

                            switch ($_FILES['image']['type']) {
                                case 'image/png':
                                    $image = imageCreateFromPng( $_FILES['image']['tmp_name'] );
                                    imagePng( imagescale( $image, 280 ), $uploadDIRMedium, 1 );
                                    break;
                                case 'image/jpeg':
                                    $image = imageCreateFromJpeg( $_FILES['image']['tmp_name'] );
                                    imageJpeg( imagescale( $image, 280 ), $uploadDIRMedium, 80 );
                                    break;
                            }
                            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDIR);

                            $data += [ 'image' => $FinalFileName ];
                            $sql = "UPDATE articles
                                    SET image=:image, title=:title, title_eng=:title_eng, id_author=:id_author, chapter=:chapter,
                                category=:category, description=:description, date=:date
                                    WHERE id_article=:id_article";
                            $db = new Cdb();
                            $db->execute($sql, $data);

                            $success = 'Yes';
                            $textData = 'Книга успешно обновлена!';
                        }
                    }
                    else {
                        $sql = "UPDATE articles
                                SET title=:title, title_eng=:title_eng, id_author=:id_author, chapter=:chapter,
                                category=:category, description=:description, date=:date
                                WHERE id_article=:id_article";
                        $db = new Cdb();
                        $db->execute($sql, $data);

                        $success = 'Yes';
                        $textData = 'Книга успешно обновлена!';
                    };
                }
            }
            else {
                $textData = 'Проблемы с отправленными данными';
            }
        }
        else {
            $textData = 'Проблемы работы AJAX';
        }
        $answer = [ "success" => $success, "text" => $textData ];

        return json_encode($answer);
    }

}
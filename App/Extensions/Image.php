<?php

namespace App\Extensions;

class Image
{

    private string $pathArticlesImages;
    private string $pathArticlesImagesMedium;

    public function setPathArticlesImages(string $pathArticlesImages): void
    {
        $this->pathArticlesImages = $pathArticlesImages;
    }

    public function setPathArticlesImagesMedium(string $pathArticlesImagesMedium): void
    {
        $this->pathArticlesImagesMedium = $pathArticlesImagesMedium;
    }

    public function __construct()
    {
        $this->setPathArticlesImages($_SERVER["DOCUMENT_ROOT"] . '/images/articles_images/' . date('Y-m'));
        $this->setPathArticlesImagesMedium($_SERVER["DOCUMENT_ROOT"] . '/images/articles_images_medium/' . date('Y-m'));
    }

    public function saveForArticle(): string|false
    {
        //Check Exist Directories
        $this->dirCheckAndCreate($this->pathArticlesImages);
        $this->dirCheckAndCreate($this->pathArticlesImagesMedium);

        $FileName = pathinfo(basename($_FILES['image']['name'])); //Get Name File
        $FileExtension = $FileName['extension']; //Get Extension File
        $NewFileName = bin2hex(random_bytes(6)) . '.' . $FileExtension; //New Name File

        $this->scalingForArticle($this->pathArticlesImagesMedium . '/' . $NewFileName); //Scaling File

        move_uploaded_file($_FILES['image']['tmp_name'], $this->pathArticlesImages . '/' . $NewFileName); //Move Final File
        return date('Y-m') . '/' . $NewFileName;
    }

    public function updateForArticle(string $image): false|string
    {
        $this->deleteForArticle($image);
        return $this->saveForArticle();
    }

    public function deleteForArticle(string $image): void
    {
        if ($image != 'no_image.png') {
            unlink( $_SERVER["DOCUMENT_ROOT"] . '/images/articles_images/' .  $image);
            unlink( $_SERVER["DOCUMENT_ROOT"] . '/images/articles_images_medium/' .  $image);
        }
    }

    public function scalingForArticle(string $path): void
    {
        switch ($_FILES['image']['type']) {
            case 'image/png':
                $image = imageCreateFromPng( $_FILES['image']['tmp_name'] );
                imagePng( imagescale( $image, 280 ), $path, 1 );
                break;
            case 'image/jpeg':
                $image = imageCreateFromJpeg( $_FILES['image']['tmp_name'] );
                imageJpeg( imagescale( $image, 280 ), $path, 80 );
                break;
        }
    }

    public function dirCheckAndCreate(string $path): void
    {
        if (!is_dir($path)) {
            mkdir($path, 0700);
        }
    }

}
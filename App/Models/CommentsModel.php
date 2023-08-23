<?php

namespace App\Models;

use App\Cdb;

class CommentsModel
{
    public const TABLE = 'comments';

    public static function commentAdd(array $data) {

        Cdb::getInstance();



        $db = Cdb::getInstance();
        $db->insert(self::TABLE, $data);
    }


    public static function showComments($id_article)
    {
        $Comments = Cdb::getInstance();
        $sql = "
            SELECT comments.*, user_group.*, users.id_user, users.nickname, users.user_group, users.avatar
            FROM comments
                INNER JOIN users
                ON comments.id_user = users.id_user
                INNER JOIN user_group
                ON user_group.id_group = users.user_group
                WHERE id_article={$id_article}
                ORDER BY id_comments ASC
        ";
        return $Comments->query($sql);
    }

}
<?php

namespace App\Models;

use App\Cdb;

class CommentsModel
{

    public static function getComments(int $id_article): array
    {
        $Cdb = Cdb::getInstance();
        $sql = "SELECT comments.*, user_group.*, users.id_user, users.nickname, users.user_group, users.avatar
                FROM comments
                INNER JOIN users
                ON comments.id_user = users.id_user
                INNER JOIN user_group
                ON user_group.id_group = users.user_group
                WHERE id_article={$id_article}
                ORDER BY id_comments ASC";
        return $Cdb->queryFetchAll($sql);
    }

    public static function commentAdd(array $data): void
    {
        $Cdb = Cdb::getInstance();
        $Cdb->insert('comments', $data);
    }

}
<?php

namespace Tgu\Perminova\Blog\Repositories\CommentsRepository;


use Tgu\Perminova\Blog\Comments;
use Tgu\Perminova\Blog\UUID;

interface CommentsRepositoryInterface
{
    public function saveComment(Comments $comment):void;
    public function getByUuidComment(UUID $uuid_comment): Comments;
}
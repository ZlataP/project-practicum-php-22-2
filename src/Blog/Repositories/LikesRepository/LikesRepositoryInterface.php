<?php

namespace Tgu\Perminova\Blog\Repositories\LikesRepository;

use Tgu\Perminova\Blog\Likes;
use Tgu\Perminova\Blog\UUID;

interface LikesRepositoryInterface
{
    public function saveLike(Likes $comment):void;
    public function getByPostUuid(string $uuid_post): Likes;
}

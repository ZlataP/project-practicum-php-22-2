<?php

namespace Tgu\Perminova\Blog\Repositories\PostRepositories;

use Tgu\Perminova\Blog\Post;
use Tgu\Perminova\Blog\UUID;

interface PostsRepositoryInterface
{
    public function savePost(Post $post):void;
    public function getByUuidPost(UUID $uuidPost): Post;
}
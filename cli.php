<?php

use Tgu\Perminova\Blog\Comments;
use Tgu\Perminova\Blog\Post;
use Tgu\Perminova\Blog\Repositories\PostRepositories\SqlitePostsRepository;
use Tgu\Perminova\Blog\UUID;

require_once __DIR__.'/vendor/autoload.php';
$connection=new PDO('sqlite:'.__DIR__.'/bloq.sqlite');
$CommentsRepository = new \Tgu\Perminova\Blog\Repositories\CommentsRepository\SqliteCommentsRepository($connection);
$CommentsRepository->saveComment(new Comments(UUID::random(),'edb10650-3b52-4a8e-b05c-c5a1f167bed0', 'f76cfc25-f8b2-4d15-9775-944db6648a82','ofc'));
$CommentsRepository->saveComment(new Comments(UUID::random(), '5b78178a-eda3-4e85-9a62-90f5a0320c4e', 'cd6a4d34-3d65-44a5-bb52-90a0ce3efcb3','cringe'));
echo $CommentsRepository->getByUuidComment(new \Tgu\Perminova\Blog\UUID('f165d492-bffe-448f-a499-b72d16a40f1b'));

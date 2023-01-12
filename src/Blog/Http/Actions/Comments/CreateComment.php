<?php

namespace Tgu\Perminova\Blog\Http\Actions\Comments;

use Tgu\Perminova\Blog\Comments;
use Tgu\Perminova\Blog\Http\Actions\ActionInterface;
use Tgu\Perminova\Blog\Http\ErrorResponse;
use Tgu\Perminova\Blog\Http\Request;
use Tgu\Perminova\Blog\Http\Response;
use Tgu\Perminova\Blog\Http\SuccessResponse;
use Tgu\Perminova\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Tgu\Perminova\Blog\UUID;
use Tgu\Perminova\Exceptions\HttpException;

class CreateComment implements ActionInterface
{
    public function __construct(
        private CommentsRepositoryInterface $commentsRepository
    )
    {

    }

    public function handle(Request $request): Response
    {
        try {
            $newCommentUuid = UUID::random();
            $comment = new Comments($newCommentUuid, $request->jsonBodyFind('uuid_post'), $request->jsonBodyFind('uuid_author'), $request->jsonBodyFind('textCom'));
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->commentsRepository->saveComment($comment);
        return new SuccessResponse(['uuid'=>(string)$newCommentUuid]);
    }
}
<?php

namespace Tgu\Perminova\Blog\Http\Actions\Likes;

use Tgu\Perminova\Blog\Exceptions\HttpException;
use Tgu\Perminova\Blog\Http\Actions\ActionInterface;
use Tgu\Perminova\Blog\Http\Request;
use Tgu\Perminova\Blog\Http\Response;
use Tgu\Perminova\Blog\Likes;
use Tgu\Perminova\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use Tgu\Perminova\Blog\UUID;
use Tgu\Perminova\Blog\Http\ErrorResponse;
use Tgu\Perminova\Blog\Http\SuccessResponse;

class CreateLikes implements ActionInterface
{
    public function __construct(
        private LikesRepositoryInterface $likesRepository
    )
    {
    }
    public function handle(Request $request): Response
    {
        try {
            $newLikeUuid = UUID::random();
            $like= new Likes($newLikeUuid, $request->jsonBodyFind('uuid_post'), $request->jsonBodyFind('uuid_user'));
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->likesRepository->saveLike($like);
        return new SuccessResponse(['uuid_like'=>(string)$newLikeUuid]);
    }
}

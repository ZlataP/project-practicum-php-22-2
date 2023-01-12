<?php

namespace Tgu\Perminova\Blog\Http\Actions\Posts;

use Tgu\Perminova\Blog\Http\Actions\ActionInterface;
use Tgu\Perminova\Blog\Http\ErrorResponse;
use Tgu\Perminova\Blog\Http\Request;
use Tgu\Perminova\Blog\Http\Response;
use Tgu\Perminova\Blog\Http\SuccessResponse;
use Tgu\Perminova\Blog\Repositories\PostRepositories\PostsRepositoryInterface;
use Tgu\Perminova\Exceptions\HttpException;
use Tgu\Perminova\Exceptions\PostNotFoundException;

class DeletePost implements ActionInterface
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository
    )
    {
    }
    public function handle(Request $request): Response
    {
        try {
            $uuid = $request->query('uuid_post');
            //$post = $this->postsRepository->getByUuidPost($uuid);
        }
        catch (HttpException | PostNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->postsRepository->getByUuidPost($uuid);
        return new SuccessResponse(['uuid_post'=>$uuid]);
    }
}

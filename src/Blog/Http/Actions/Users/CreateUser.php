<?php

namespace Tgu\Perminova\Blog\Http\Actions\Users;

use Tgu\Perminova\Blog\Http\Actions\ActionInterface;
use Tgu\Perminova\Blog\Http\ErrorResponse;
use Tgu\Perminova\Blog\Http\Request;
use Tgu\Perminova\Blog\Http\Response;
use Tgu\Perminova\Blog\Http\SuccessResponse;
use Tgu\Perminova\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Tgu\Perminova\Blog\User;
use Tgu\Perminova\Blog\UUID;
use Tgu\Perminova\Exceptions\HttpException;

class CreateUser implements ActionInterface
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $newUserUuid = UUID::random();
            $user = new User($newUserUuid,new Name($request->jsonBodyFind('first_name'), $request->jsonBodyFind('last_name')), $request->jsonBodyFind('username'));
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->usersRepository->save($user);
        return new SuccessResponse(['uuid'=>(string)$newUserUuid]);
    }

}

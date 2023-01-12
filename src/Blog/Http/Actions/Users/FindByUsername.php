<?php

namespace Tgu\Perminova\Blog\Http\Actions\Users;

use Tgu\Perminova\Blog\Http\Actions\ActionInterface;
use Tgu\Perminova\Blog\Http\ErrorResponse;
use Tgu\Perminova\Blog\Http\Request;
use Tgu\Perminova\Blog\Http\Response;
use Tgu\Perminova\Blog\Http\SuccessResponse;
use Tgu\Perminova\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Tgu\Perminova\Exceptions\HttpException;
use Tgu\Perminova\Exceptions\UserNotFoundException;

class FindByUsername implements ActionInterface
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $username = $request->query('username');
            $user =$this->usersRepository->getByUsername($username);
        }
        catch (HttpException | UserNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        return new SuccessResponse(['username'=>$user->getUserName(),'name'=>$user->getName()->getFirstName().' '.$user->getName()->getLastName()]);
    }
}
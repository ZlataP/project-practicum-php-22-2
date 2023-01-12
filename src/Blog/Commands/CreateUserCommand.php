<?php

namespace Tgu\Perminova\Blog\Commands;

use Psr\Log\LoggerInterface;
use Tgu\Perminova\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Tgu\Perminova\Blog\User;
use Tgu\Perminova\Blog\UUID;
use Tgu\Perminova\Exceptions\UserNotFoundException;
use Tgu\Perminova\Person\Name;

class CreateUserCommand
{
    public function __construct(private UsersRepositoryInterface $usersRepository,
                                private LoggerInterface $logger,
    )
    {
    }

    public function handle(Arguments $arguments):void{
        $this->logger->info('Create command started');
        $username = $arguments->get('username');
        if($this->userExist($username)){
            //  throw new CommandException("User already exists: $username");
            $this->logger->warning("User already exists: $username");
        }
        $uuid= UUID::random();
        $this->usersRepository->save(
            new User($uuid,
                new Name($arguments->get('first_name'), $arguments->get('last_name')),$username));

        $this->logger->info("User created: $uuid" );
    }
    public function userExist(string $username):bool{
        try{
            $this->usersRepository->getByUsername($username);
        }
        catch (UserNotFoundException $exception){
            return false;
        }
        return true;
    }
}
<?php

namespace Tgu\Perminova\PhpUnit\Blog\Http\Actions\Users;

use PHPUnit\Framework\TestCase;
use Tgu\Perminova\Blog\Http\Actions\Users\FindByUsername;
use Tgu\Perminova\Blog\Http\ErrorResponse;
use Tgu\Perminova\Blog\Http\Request;
use Tgu\Perminova\Blog\Http\SuccessResponse;
use Tgu\Perminova\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Tgu\Perminova\Blog\User;
use Tgu\Perminova\Blog\UUID;
use Tgu\Perminova\Exceptions\UserNotFoundException;
use Tgu\Perminova\Person\Name;

class FindByUsernameActionTest extends TestCase
{
    private function userRepository(array $users):UsersRepositoryInterface{
        return new class($users) implements UsersRepositoryInterface{
            public function __construct(
                private array $users
            )
            {
            }

            public function save(User $user): void
            {
                // TODO: Implement save() method.
            }

            public function getByUsername(string $username): User
            {
                foreach ($this->users as $user){
                    if($user instanceof User && $username===$user->getUserName()){
                        return $user;
                    }
                }
                throw new UserNotFoundException('Not found');
            }

            public function getByUuid(UUID $uuid): User
            {
                throw new UserNotFoundException('Not found');
            }
        };
    }


    /**
     * @throws \JsonException
     */
    public function testItReturnErrorResponceIdNoUsernameProvided(): void
    {
        $request = new Request([], [], '');
        $userRepository = $this->userRepository([]);
        $action = new FindByUsername($userRepository);
        $responce = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $responce);
        $this->expectOutputString('{"success":false,"reason":"No such query param in the request username"}');
        $responce->send();
    }


    /**
     * @throws \JsonException
     */
    public function testItReturnErrorResponceIdUserNotFound(): void{
        $request = new Request(['username'=>'Petya'], [], '');
        $userRepository = $this->userRepository([]);
        $action = new FindByUsername($userRepository);
        $responce = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $responce);
        $this->expectOutputString('{"success":false,"reason":"Not found"}');
        $responce->send();
    }

    /**
     * @throws \JsonException
     */
    public function testItReturnSuccessfulResponse(): void{
        $request = new Request(['username'=>'ivan'], [],'');
        $userRepository = $this->userRepository([new User(UUID::random(),new Name('Petya','Petrow'),'admin')]);
        $action = new FindByUsername($userRepository);
        $responce = $action->handle($request);
        $this->assertInstanceOf(SuccessResponse::class, $responce);
        $this->expectOutputString('{"success":true,"data":{"username":"admin","name":"Petya Petrow"}}');
        $responce->send();
    }
}

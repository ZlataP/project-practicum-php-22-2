<?php

namespace TGU\Perminova\PhpUnit\Repositories\UsersRepository;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Tgu\Perminova\Blog\Exceptions\UserNotFoundException;
use Tgu\Perminova\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use Tgu\Perminova\Blog\User;
use Tgu\Perminova\Blog\UUID;
use Tgu\Perminova\Person\Name;
use Tgu\Perminova\PhpUnit\Blog\DummyLogger;

class SqliteUsersRepositoryTest extends TestCase
{
    public function testItTrowsAnExceptionWhenUserNotFound():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub,  new DummyLogger());

        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Cannot get user: user1');

        $repository->getByUsername('user1');
    }

    public function testItSaveUserToDB():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createMock(PDOStatement::class);

        $statementStub
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':first_name'=>'Ivan',
                ':last_name'=>'Nikitin',
                ':uuid' =>'7fba16a0-ca95-440d-b09a-94648029f2cc',
                ':username'=>'user1'
            ]);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub,  new DummyLogger());

        $repository->save(new User(
            new UUID('7fba16a0-ca95-440d-b09a-94648029f2cc'),
            new Name('Evgeniy', 'Ohman'), 'user1'
        ));
    }

    /**
     * @throws UserNotFoundException
     */
    public function testItUUidUser ():User
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub);
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage(' UUID: 7fba16a0-ca95-440d-b09a-94648029f2cc');

        $repository->getByUuid('7fba16a0-ca95-440d-b09a-94648029f2cc');
    }
}

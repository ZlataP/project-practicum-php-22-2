<?php

namespace tgu\Perminova\PhpUnit\Repositories\CommentsRepository;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Tgu\Perminova\Blog\Comments;
use Tgu\Perminova\Blog\Exceptions\CommentNotFoundException;
use Tgu\Perminova\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Tgu\Perminova\Blog\UUID;
use Tgu\Perminova\PhpUnit\Blog\DummyLogger;

class SqliteCommentsRepositoryTest extends TestCase
{
    public function testItTrowsAnExceptionWhenCommentNotFound():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub, new DummyLogger());

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage('Cannot get comment: ofc');

        $repository->getTextComment('ofc');
    }

    public function testItSaveCommentsToDB():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createMock(PDOStatement::class);

        $statementStub
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':uuid_comment' =>'5daad388-e5ed-4bc4-82a5-cea3e5544238',
                ':uuid_post'=>'937b59c7-e000-4eb6-acc7-850417c66010',
                ':uuid_author'=>'7fba16a0-ca95-440d-b09a-94648029f2cc',
                ':textCom'=>'cringe'
            ]);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub,
            new DummyLogger());

        $repository->saveComment(new Comments(
            new UUID('5daad388-e5ed-4bc4-82a5-cea3e5544238'), '937b59c7-e000-4eb6-acc7-850417c66010','7fba16a0-ca95-440d-b09a-94648029f2cc','cringe'
        ));
    }

    public function testItUUidComments():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);


        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub);

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage('Cannot get comment:f165d492-bffe-448f-a499-b72d16a40f1b');

        $repository->getByUuidComment('f165d492-bffe-448f-a499-b72d16a40f1b');
    }
}

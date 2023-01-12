<?php

namespace tgu\Perminova\PhpUnit\Commands;

use PHPUnit\Framework\TestCase;
use Tgu\Perminova\Blog\Commands\Arguments;
use Tgu\Perminova\Blog\Exceptions\Argumentsexception;

class ArgumentsTest extends TestCase
{
    public function testItReturnsArgumentsByName():void
    {
        $arguments = new Arguments(['some_key' => 'some_value']);
        //Act
        $value = $arguments->get('some_key');
        //Assert
        $this->assertEquals( 'some_value', $value);
    }

    /**
     * @throws Argumentsexception
     */
    public function testItReturnsValueAsString():void
    {
        $arguments = new Arguments(['some_key' => 123]);
        //Act
        $value = $arguments->get('some_key');
        //Assert
        $this->assertEquals( '123', $value);
    }

    public function testItThrowAnExceptionWhenArgumentsAbsent():void
    {
        //Arrange
        $arguments = new Arguments([]);
        //Assert
        $this->expectException(Argumentsexception::class);
        $this->expectExceptionMessage('No such argument: some_key');
        //Act
        $arguments->get('some_key');

    }
}

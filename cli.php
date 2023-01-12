<?php

use Psr\Log\LoggerInterface;
use Tgu\Perminova\Blog\Commands\Arguments;
use Tgu\Perminova\Blog\Commands\CreateUserCommand;
use Tgu\Perminova\Exceptions\Argumentsexception;
use Tgu\Perminova\Exceptions\CommandException;

$conteiner = require __DIR__ .'/bootstrap.php';


$command = $conteiner->get(CreateUserCommand::class);

$logger= $conteiner-> get(LoggerInterface::class);
try{$command->handle(Arguments::fromArgv($argv));}
catch (Argumentsexception|CommandException $exception){
    $logger->error($exception->getMessage(),['exceptoin'=>$exception]);
}
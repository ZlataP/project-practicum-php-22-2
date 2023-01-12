<?php

namespace Tgu\Perminova\Blog\Repositories\UserRepository;

use Tgu\Perminova\Blog\User;
use Tgu\Perminova\Blog\UUID;

interface UsersRepositoryInterface
{
    public function save(User $user):void;
    public function getByUsername(string $username):User;
    public function getByUuid(UUID $uuid): User;
}
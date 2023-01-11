<?php

namespace Tgu\Perminova\Blog;
use Tgu\Perminova\Person\Person;
class Post
{
    public function __construct(
        public int $id,
        private string $header,
        private string $text,
    )
    {
    }

    public function __toString(): string
    {
        return $this->id . ' - статья, ' .$this->header . ' - заголовок, текст: ' . $this->text;
    }


}
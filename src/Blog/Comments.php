<?php
namespace Tgu\Perminova\Blog;

class Comments
{
    public function __construct(
        private int $id,
        private int $id_post,
        private string $text,
)
{
}

    public function __toString(): string
    {
        return $this->id . ' - код комментария, ' .$this->id_post . ' - статья, а далее комментарий: ' . $this->text;
    }

}
<?php
require_once  __DIR__ . '/vendor/autoload.php';

/* use Tgu\Perminova\Blog\Comments;
use Tgu\Perminova\Blog\Post;
use Tgu\Perminova\Person\Name;

spl_autoload_register(function ($class){
    $result ='';
    $array = explode('\\', $class);
    for ($i=0; $i<count($array);$i++){
        if ($i=count($array)-1){
            $array[$i]=str_replace('_','/', $array[$i]).'.php';
        }
    }
    $result= implode('/', $array);
    if(file_exists($result)){
        require $result;
    }
});

$user = new Name(2,'Evgeniy', 'Ohman');
$post = new Post(1, $user->id, 'HEADER', "заголовок");
$comment = new Comments(1, $user->id, $post->id, 'комментарий');

print $user;
print $post;
print $comment; */
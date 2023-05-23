<?php declare(strict_types=1);

namespace NewsSite\Services\Articles\Show;

use NewsSite\Models\Post;

class ShowArticleServiceResponse
{
    private Post $article;
    private array $comments;

    public function __construct(Post $article, array $comments)
    {
        $this->article = $article;
        $this->comments = $comments;
    }
    public function getComments(): array
    {
        return $this->comments;
    }

    public function getPost(): Post
    {
        return $this->article;
    }

}

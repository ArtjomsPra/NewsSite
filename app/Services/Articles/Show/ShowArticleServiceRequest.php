<?php declare(strict_types=1);

namespace NewsSite\Services\Articles\Show;

class ShowArticleServiceRequest
{
    private int $articleId;

    public function __construct(int $articleId)
    {
        $this->articleId = $articleId;
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

}
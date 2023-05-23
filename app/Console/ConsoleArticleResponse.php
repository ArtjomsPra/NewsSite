<?php declare(strict_types=1);

namespace NewsSite\Console;

use NewsSite\Models\Post;


class ConsoleArticleResponse
{
    private Post $article;

    public function __construct(Post $article)
    {
        $this->article = $article;
    }

    public function getArticleContent(): void
    {
        echo '**************************************************' . PHP_EOL;
        echo "Article id: {$this->article->getId()}" . PHP_EOL;
        echo "Author of article: {$this->article->getUser()->getName()}" . PHP_EOL;
        echo "The title is: {$this->article->getTitle()}." . PHP_EOL;
        echo "The article: " . PHP_EOL;
        echo $this->article->getBody() . PHP_EOL;
        echo PHP_EOL;
    }
}
<?php declare(strict_types=1);

namespace NewsSite\Controllers;

use NewsSite\Core\View;
use NewsSite\Services\Articles\IndexArticleService;
use NewsSite\Services\Articles\Show\ShowArticleServiceRequest;
use NewsSite\Services\Articles\Show\ShowArticleService;

class PostController
{
    public function index(): View
    {
        $service = new IndexArticleService();
        $articles = $service->execute();

        return new View('articles', [
            'articles' => $articles
        ]);
    }

    public function show(): View
    {
        $articleId = (int)$_GET['articleId'];
        $service = new ShowArticleService();
        $response = $service->execute(new ShowArticleServiceRequest($articleId));

        return new View('article', [
            'article' => $response->getPost(),
            'comments' => $response->getComments()
        ]);
    }
}
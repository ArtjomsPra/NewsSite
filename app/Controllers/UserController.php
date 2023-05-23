<?php declare(strict_types=1);

namespace NewsSite\Controllers;

use NewsSite\Core\View;
use NewsSite\Services\Users\IndexUserService;
use NewsSite\Services\Users\Show\ShowUserServiceRequest;
use NewsSite\Services\Users\Show\ShowUserService;

class UserController
{
    public function index(): View
    {
        $service = new IndexUserService();
        $authors = $service->execute();

        return new View('authors', [
            'authors' => $authors
        ]);
    }

    public function show(): View
    {
            $authorId = (int)$_GET['authorId'];
            $service = new ShowUserService();
            $response = $service->execute(new ShowUserServiceRequest($authorId));

            return new View('author', [
                'author' => $response->getUser(),
                'articles' => $response->getArticles()
            ]);
    }
}
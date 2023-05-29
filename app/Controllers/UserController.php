<?php declare(strict_types=1);

namespace NewsSite\Controllers;

use NewsSite\Core\View;
use NewsSite\Services\Users\IndexUserService;
use NewsSite\Services\Users\Show\ShowUserServiceRequest;
use NewsSite\Services\Users\Show\ShowUserService;

class UserController
{
    private IndexUserService $indexUserService;
    private ShowUserService $showUserService;

    public function __construct
    (
        IndexUserService $indexUserService,
        ShowUserService $showUserService
    )
    {
        $this->indexUserService = $indexUserService;
        $this->showUserService = $showUserService;
    }
    public function index(): View
    {
        $authors = $this->indexUserService->execute();

        return new View('authors', [
            'authors' => $authors
        ]);
    }

    public function show(): View
    {
            $authorId = (int)$_GET['authorId'];
            $response = $this->showUserService->execute(new ShowUserServiceRequest($authorId));

            return new View('author', [
                'author' => $response->getUser(),
                'articles' => $response->getArticles()
            ]);
    }
}
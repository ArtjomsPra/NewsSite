<?php declare(strict_types=1);

namespace NewsSite\Console;

use NewsSite\Services\Articles\Show\ShowArticleService;
use NewsSite\Services\Articles\Show\ShowArticleServiceRequest;
use NewsSite\Services\Articles\IndexArticleService;
use NewsSite\Services\Users\Show\ShowUserService;
use NewsSite\Services\Users\Show\ShowUserServiceRequest;
use NewsSite\Services\Users\IndexUserService;
use NewsSite\Models\Post;
use NewsSite\Models\User;

class ConsoleMakeRequest
{
    protected array $response;

    public function __construct()
    {
        $this->response = [];
    }

    public function allPosts(): array
    {
        return (new IndexArticleService())->execute();

    }

    public function allUsers(): array
    {
        return (new IndexUserService())->execute();
    }

    public function postById($postId): ?Post
    {
        $service = new ShowArticleService();
        $request = new ShowArticleServiceRequest($postId);
        $response = $service->execute($request);

        return $response->getPost();
    }

    public function userById($userId): ?User
    {
        $service = new ShowUserService();
        $request = new ShowUserServiceRequest($userId);
        $response = $service->execute($request);

        return $response->getUser();
    }
}


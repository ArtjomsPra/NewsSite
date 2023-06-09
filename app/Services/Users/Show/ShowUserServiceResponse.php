<?php declare(strict_types=1);

namespace NewsSite\Services\Users\Show;

use NewsSite\Models\User;

class ShowUserServiceResponse
{
    private User $user;
    private array $articles;

    public function __construct(User $user, array $articles)
    {
        $this->user = $user;
        $this->articles = $articles;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getArticles(): array
    {
        return $this->articles;
    }
}
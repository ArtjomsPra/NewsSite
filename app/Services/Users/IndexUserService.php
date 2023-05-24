<?php declare(strict_types=1);

namespace NewsSite\Services\Users;

use NewsSite\Repositories\Author\AuthorRepository;
use NewsSite\Repositories\Author\JsonPlaceholderAuthorRepository;


class IndexUserService
{
    private AuthorRepository $authorRepository;

    public function __construct()
    {
        $this->authorRepository = new JsonPlaceholderAuthorRepository();
    }

    public function execute(): array
    {
        return $this->authorRepository->fetchAll();
    }
}


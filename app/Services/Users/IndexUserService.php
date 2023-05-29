<?php declare(strict_types=1);

namespace NewsSite\Services\Users;

use NewsSite\Repositories\Author\AuthorRepository;


class IndexUserService
{
    private AuthorRepository $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function execute(): array
    {
        return $this->authorRepository->fetchAll();
    }
}


<?php declare(strict_types=1);

namespace NewsSite\Repositories\Author;

use NewsSite\Models\User;

interface AuthorRepository
{
    public function fetchAll(): array;
    public function fetchSingleUser(int $id): ?User;
}

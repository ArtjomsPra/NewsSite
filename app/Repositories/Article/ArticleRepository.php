<?php declare(strict_types=1);

namespace NewsSite\Repositories\Article;

use NewsSite\Models\Post;

interface ArticleRepository
{
    public function fetchAll(): array;
    public function fetchAllByAuthorId(int $authorId): array;
    public function fetchSinglePost(int $id): ?Post;
}
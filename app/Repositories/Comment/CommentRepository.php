<?php declare(strict_types=1);

namespace NewsSite\Repositories\Comment;

interface CommentRepository
{
    public function fetchCommentsByArticleId(int $articleId): array;
}

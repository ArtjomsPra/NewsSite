<?php declare(strict_types=1);

namespace NewsSite\Services\Users\Show;

class ShowUserServiceRequest
{
    private int $authorId;

    public function __construct(int $authorId)
    {
        $this->authorId = $authorId;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }
}
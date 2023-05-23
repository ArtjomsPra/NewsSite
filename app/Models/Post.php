<?php declare(strict_types=1);

namespace NewsSite\Models;

class Post
{
    private int $id;
    private string $title;
    private string $body;
    private User $user;

    public function __construct(
        int    $id,
        string $title,
        string $body,
        User   $user
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->user = $user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
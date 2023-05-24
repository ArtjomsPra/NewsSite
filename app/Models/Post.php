<?php declare(strict_types=1);

namespace NewsSite\Models;

class Post
{
    private int $id;
    private int $userId;
    private string $title;
    private string $body;
    private ?User $user = null;

    public function __construct(
        int    $id,
        int    $userId,
        string $title,
        string $body
    )
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->body = $body;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }
}
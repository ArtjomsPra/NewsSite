<?php declare(strict_types=1);

namespace NewsSite\Services\Articles;

use NewsSite\ApiClient;

class IndexArticleService
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function execute(): array
    {
        return $this->client->fetchPosts();
    }
}
<?php declare(strict_types=1);

namespace NewsSite\Services\Users;

use NewsSite\ApiClient;
class IndexUserService
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function execute(): array
    {
        return $this->client->fetchUsers();
    }
}


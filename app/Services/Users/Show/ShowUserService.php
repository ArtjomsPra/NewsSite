<?php declare(strict_types=1);

namespace NewsSite\Services\Users\Show;

use NewsSite\ApiClient;

class ShowUserService
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function execute(ShowUserServiceRequest $request): ShowUserServiceResponse
    {
        $authorId = $request->getAuthorId();

        $author = $this->client->fetchSingleUser($authorId);

        $articles = $this->client->fetchPostsByAuthorId($authorId);

        return new ShowUserServiceResponse($author, $articles);
    }
}
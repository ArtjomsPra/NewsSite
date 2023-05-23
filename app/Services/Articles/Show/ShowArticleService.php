<?php declare(strict_types=1);

namespace NewsSite\Services\Articles\Show;

use NewsSite\ApiClient;

class ShowArticleService
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function execute(ShowArticleServiceRequest $request): ShowArticleServiceResponse
    {
        $articleId = $request->getArticleId();

        $article = $this->client->fetchSinglePost($articleId);

        $comments = $this->client->fetchCommentsByArticleId($articleId);

        return new ShowArticleServiceResponse($article, $comments);
    }
}
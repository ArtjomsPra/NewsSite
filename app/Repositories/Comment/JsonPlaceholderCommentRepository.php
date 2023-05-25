<?php declare(strict_types=1);

namespace NewsSite\Repositories\Comment;

use NewsSite\Models\Comment;
use GuzzleHttp\Client;

class JsonPlaceholderCommentRepository implements CommentRepository
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(['verify' => false]);
    }

    public function ensureCacheDirectoryExists(): void
    {
        if (!file_exists('cache')) {
            mkdir('cache', 0777, true);
        }
    }

    public function fetchCommentsByArticleId(int $articleId): array
    {
        $this->ensureCacheDirectoryExists();
        $cacheFile = "cache/comments{$articleId}.json";
        $currentTime = time();
        if (file_exists($cacheFile) && ($currentTime - filemtime($cacheFile)) < 300) {
            $responseJson = file_get_contents($cacheFile);
        } else {
            $response = $this->client->get("https://jsonplaceholder.typicode.com/posts/$articleId/comments");
            $responseJson = $response->getBody()->getContents();
            file_put_contents($cacheFile, $responseJson);
        }
        $commentsCollection = json_decode($responseJson);
        return $this->createCommentsCollection($commentsCollection);
    }

    public function createCommentsCollection($commentsCollection): array
    {
        $collection = [];
        foreach ($commentsCollection as $comment) {
            $collection [] = new Comment(
                $comment->id,
                $comment->postId,
                $comment->name,
                $comment->email,
                $comment->body
            );
        }
        return $collection;
    }
}
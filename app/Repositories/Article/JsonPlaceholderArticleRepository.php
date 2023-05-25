<?php declare(strict_types=1);

namespace NewsSite\Repositories\Article;

use GuzzleHttp\Client;
use NewsSite\Models\Post;
use stdClass;

class JsonPlaceholderArticleRepository implements ArticleRepository
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

    public function fetchAll(): array
    {
        $this->ensureCacheDirectoryExists();
        $cacheFile = "cache/posts.json";
        $currentTime = time();
        if (file_exists($cacheFile) && ($currentTime - filemtime($cacheFile)) < 300) {
            $postsCollection = json_decode(file_get_contents($cacheFile));
        } else {
            $url = "https://jsonplaceholder.typicode.com/posts";
            $response = $this->client->get($url);
            $postsCollection = json_decode($response->getBody()->getContents());
            file_put_contents($cacheFile, json_encode($postsCollection));
        }
        return $this->createPostsCollection($postsCollection);
    }

    public function fetchAllByAuthorId(int $authorId): array
    {
        $this->ensureCacheDirectoryExists();
        $cacheFile = "cache/comments{$authorId}.json";
        $currentTime = time();
        if (file_exists($cacheFile) && ($currentTime - filemtime($cacheFile)) < 300) {
            $responseJson = file_get_contents($cacheFile);
        } else {
            $response = $this->client->get("https://jsonplaceholder.typicode.com/users/$authorId/posts");
            $responseJson = $response->getBody()->getContents();
            file_put_contents($cacheFile, $responseJson);
        }
        $postsCollection = json_decode($responseJson);
        return $this->createPostsCollection($postsCollection);
    }

    public function createPostsCollection($postsCollection): array
    {
        $collection = [];
        foreach ($postsCollection as $post) {
            $collection [] = new Post(
                $post->id,
                $post->userId,
                $post->title,
                $post->body,
            );
        }
        return $collection;
    }

    public function fetchSinglePost(int $id): ?Post
    {
        $this->ensureCacheDirectoryExists();
        $cacheFile = "cache/post{$id}.json";
        $currentTime = time();
        if (file_exists($cacheFile) && ($currentTime - filemtime($cacheFile)) < 300) {
            $responseJson = file_get_contents($cacheFile);
        } else {
            $response = $this->client->get("https://jsonplaceholder.typicode.com/posts/$id");
            $responseJson = $response->getBody()->getContents();
            file_put_contents($cacheFile, $responseJson);
        }
        $post = json_decode($responseJson);
        return $this->postCreation($post);
    }

    public function postCreation(stdClass $post): Post
    {
        return new Post (
            $post->id,
            $post->userId,
            $post->title,
            $post->body,
        );
    }
}
<?php declare(strict_types=1);

namespace NewsSite;

use GuzzleHttp\Client;
use NewsSite\Models\Comment;
use NewsSite\Models\Post;
use NewsSite\Models\User;
use stdClass;

class ApiClient
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

    public function fetchPosts(): array
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

    public function fetchPostsByAuthorId(int $authorId): array
    {
        $this->ensureCacheDirectoryExists();
        $cacheFile = "cache/comments{$authorId}.json";
        $currentTime = time();
        if (file_exists($cacheFile) && ($currentTime - filemtime($cacheFile)) < 300) {
            $responseJson = json_decode(file_get_contents($cacheFile));
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
                $post->title,
                $post->body,
                $this->fetchSingleUser($post->userId)
            );
        }
        return $collection;
    }

    public function fetchUsers(): array
    {
        $this->ensureCacheDirectoryExists();
        $cacheFile = "cache/users.json";
        $currentTime = time();
        if (file_exists($cacheFile) && ($currentTime - filemtime($cacheFile)) < 300) {
            $usersCollection = json_decode(file_get_contents($cacheFile));
        } else {
            $url = "https://jsonplaceholder.typicode.com/users";
            $response = $this->client->get($url);
            $usersCollection = json_decode($response->getBody()->getContents());
            file_put_contents($cacheFile, json_encode($usersCollection));
        }
        return $this->createUsersCollection($usersCollection);
    }

    public function createUsersCollection($usersCollection): array
    {
        $collection = [];
        foreach ($usersCollection as $user) {
            $collection [] = new User(
                $user->id,
                $user->name,
                $user->username,
                $user->email,
                $user->address->city,
                $user->company->name
            );
        }
        return $collection;
    }

    public function fetchCommentsByArticleId(int $articleId): array
    {
        $this->ensureCacheDirectoryExists();
        $cacheFile = "cache/comments{$articleId}.json";
        $currentTime = time();
        if (file_exists($cacheFile) && ($currentTime - filemtime($cacheFile)) < 300) {
            $responseJson = json_decode(file_get_contents($cacheFile));
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



    public function fetchSingleUser(int $id): ?User
{
    $this->ensureCacheDirectoryExists();
    $cacheFile = "cache/user{$id}.json";
    $currentTime = time();
    if (file_exists($cacheFile) && ($currentTime - filemtime($cacheFile)) < 300) {
        $responseJson = file_get_contents($cacheFile);
    } else {
        $response = $this->client->get("https://jsonplaceholder.typicode.com/users/$id");
        $responseJson = $response->getBody()->getContents();
        file_put_contents($cacheFile, $responseJson);
    }
    $user = json_decode($responseJson);
    return $this->userCreation($user);
    }

    public function userCreation(stdClass $user): User
    {
        return new User (
            $user->id,
            $user->name,
            $user->username,
            $user->email,
            $user->address->city,
            $user->company->name
        );
    }

    public function fetchSinglePost(int $id): ?Post
    {
        $this->ensureCacheDirectoryExists();
        $cacheFile = "cache/post{$id}.json";
        $currentTime = time();
        if (file_exists($cacheFile) && ($currentTime - filemtime($cacheFile)) < 300) {
            $responseJson = json_decode(file_get_contents($cacheFile));
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
            $post->title,
            $post->body,
            $this->fetchSingleUser($post->userId)
        );
    }

}
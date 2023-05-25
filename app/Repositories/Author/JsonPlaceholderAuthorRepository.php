<?php declare(strict_types=1);

namespace NewsSite\Repositories\Author;

use NewsSite\Models\User;
use GuzzleHttp\Client;
use stdClass;

class JsonPlaceholderAuthorRepository implements AuthorRepository
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
}

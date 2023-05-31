<?php declare(strict_types=1);

namespace NewsSite\Repositories\Article;

use GuzzleHttp\Client;
use Medoo\Medoo;
use NewsSite\Models\Post;

class PdoArticleRepository implements ArticleRepository
{
    private Medoo $db;
    private Client $client;

    public function __construct()
    {
        $this->db = new Medoo([
            'type' => $_ENV['DB_TYPE'],
            'host' => $_ENV['DB_HOST'],
            'database' => $_ENV['DB_NAME'],
            'username' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASS']
        ]);

        $this->client = new Client(['verify' => false]);
        $this->fillTable();
    }

    public function fetchAll(): array
    {
        $postsCollection = $this->db->select("posts", [
            'id',
            'userid',
            'title',
            'body'
        ]);
        return $this->createCollection($postsCollection);
    }

    public function fetchAllByAuthorId(int $userId): array
    {
        $postsCollection = $this->db->select("posts", [
            'id',
            'userid',
            'title',
            'body'
        ], ['userid' => $userId]);
        return $this->createCollection($postsCollection);
    }

    public function fetchSinglePost(int $id): ?Post
    {
        $post = $this->db->select("posts", [
            'id',
            'userid',
            'title',
            'body'
        ], ['id' => $id]);

        return $this->createArticle($post[0]);
    }

    public function delete (int $id): void
    {
        $this->db->delete("posts", [
            'AND' =>
                ['id' => $id]
        ]);
    }

        public function create (string $title, string $body): void
        {
            $userId = 10;
            $postId = ($this->db->max('posts', 'id')) + 1;

            $post = new Post($postId, $userId, $title, $body);

            $this->db->insert('posts', [
                'userid' => $post->getUserId(),
                'title' => $post->getTitle(),
                'body' => $post->getBody()
            ]);
        }

    public function update(int $id, string $title, string $body)
    {
        $this->db->update('posts', [
            'title' => $title,
            'body' => $body
            ],
            ['id' => $id]
        );
    }

    public function createCollection(array $postsCollection): array
    {
        $collection = [];
        foreach ($postsCollection as $post) {
            $collection[] = $this->createArticle($post);
        }
        return $collection;
    }

    private function createArticle(array $postContent): Post
    {
        return new Post(
            (int) $postContent['id'],
            (int) $postContent['userid'],
            $postContent['title'],
            $postContent['body']
        );
    }

    private function fillTable()
    {
        $count = $this->db->count('posts', "*");
        if ($count == 0) {
            $response = $this->client->get("https://jsonplaceholder.typicode.com/posts");
            $responseJson = $response->getBody()->getContents();
            $posts = json_decode($responseJson);

            foreach ($posts as $post) {
                $this->db->insert('posts', [
                    'userid' => $post->userId,
                    'title' => $post->title,
                    'body' => $post->body
                ]);
            }
        }
    }
}